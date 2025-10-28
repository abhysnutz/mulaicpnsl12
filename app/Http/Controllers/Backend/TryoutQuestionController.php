<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Question;
use App\Models\QuestionTopic;
use App\Models\Tryout;
use App\Services\QuestionImportService;
use DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TryoutQuestionController extends Controller
{
    protected $importService;

    public function __construct(QuestionImportService $importService)
    {
        $this->importService = $importService;
    }

    public function index($tryout_id){
        $tryout = Tryout::findOrFail($tryout_id);

        // Ambil soal yang sudah dipakai di tryout ini
        $usedIds = $tryout->questions()->pluck('questions.id');

        // Ambil soal bank (yang belum dipakai)
        $bankQuestions = Question::with('topic')
            ->whereNotIn('id', $usedIds)
            ->latest()
            ->get();

        $questions = $tryout->questions()->with('topic')->orderBy('question_tryout.order')->get();

        return view('backend.tryout.question.index', compact('tryout', 'questions', 'bankQuestions'));
    }

    public function create($tryout_id){
        $tryout = Tryout::findOrFail($tryout_id);
        $topics = QuestionTopic::all(); // Ambil semua topik soal

        // ✅ Ambil semua nomor order yang sudah terpakai
        $orders = $tryout->questions()
            ->orderBy('question_tryout.order')
            ->pluck('question_tryout.order')
            ->toArray();

        // ✅ Cari nomor terkecil yang belum dipakai
        $number = 1;
        foreach ($orders as $order) {
            if ($order != $number) {
                break; // ketemu nomor bolong
            }
            $number++;
        }

        return view('backend.tryout.question.create', compact('tryout', 'topics', 'number'));
    }

    public function store(Request $request, $tryout_id){
        $request->validate([
            'topic_id'       => 'required|exists:question_topics,id',
            'question'       => 'required|string',
            'explanation'    => 'nullable|string',
            'answers'        => 'required|array|min:5|max:5',
            'answers.*'      => 'required|string',
            'correct_answer' => 'nullable|string|in:A,B,C,D,E',
            'score_tkp'      => 'nullable|array|min:5|max:5',
            'score_tkp.*'    => 'nullable|integer|min:1|max:5',
        ]);

        // 🧪 VALIDASI SOAL TAMBAHAN
        $topic    = QuestionTopic::findOrFail($request->topic_id);
        $category = $topic->category;

        // Jika bukan TKP, jawaban benar wajib dipilih
        if ($category !== 'TKP' && empty($request->correct_answer)) {
            return back()
                ->withErrors(['correct_answer' => 'Jawaban benar wajib dipilih untuk kategori non-TKP.'])
                ->withInput();
        }

        // Jika TKP, semua skor wajib diisi
        if ($category === 'TKP') {
            foreach ($request->score_tkp as $idx => $score) {
                if (empty($score)) {
                    return back()
                        ->withErrors(['score_tkp.' . $idx => 'Semua skor TKP harus diisi (1–5).'])
                        ->withInput();
                }
            }
        }

        DB::beginTransaction();
        try {
            // ✅ Buat soal
            $question = Question::create([
                'topic_id'    => $request->topic_id,
                'question'    => $request->question,
                'explanation' => $request->explanation,
            ]);

            // 🪄 Ganti URL tmp → final
            $sessionId = session()->getId();
            $tmpUrl    = asset("storage/question/tmp/{$sessionId}");
            $finalUrl  = asset("storage/question/{$question->id}");

            $question->update([
                'question'    => str_replace($tmpUrl, $finalUrl, $request->question),
                'explanation' => str_replace($tmpUrl, $finalUrl, $request->explanation),
            ]);

            // 📸 Pindahkan file gambar tmp → final folder
            $tmpFolder   = "question/tmp/{$sessionId}";
            $finalFolder = "question/{$question->id}";

            if (Storage::disk('public')->exists($tmpFolder)) {
                Storage::disk('public')->makeDirectory($finalFolder);
                foreach (Storage::disk('public')->files($tmpFolder) as $file) {
                    Storage::disk('public')->move($file, "{$finalFolder}/" . basename($file));
                }
                Storage::disk('public')->deleteDirectory($tmpFolder);
            }

            // ✅ Attach ke tryout lewat pivot
            $tryout = Tryout::findOrFail($tryout_id);

            // 🛡️ Cek duplikasi nomor
            if ($tryout->questions()->wherePivot('order', $request->order)->exists()) {
                return back()
                    ->with('error', "Nomor soal {$request->order} sudah digunakan. Silakan pilih nomor lain.");
            }

            $tryout->questions()->attach($question->id, [
                'order'       => $request->order ?? 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            // ✅ Simpan jawaban A–E
            foreach (['A', 'B', 'C', 'D', 'E'] as $index => $option) {
                Answer::create([
                    'question_id' => $question->id,
                    'option'      => $option,
                    'answer'      => $request->answers[$index],
                    'score'       => ($category === 'TKP')
                        ? ($request->score_tkp[$index] ?? 1)
                        : (($request->correct_answer === $option) ? 5 : 0),
                ]);
            }

            DB::commit();

            return redirect()->route('console.tryout.question.index', $tryout_id)
                ->with('success', 'Soal berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function edit($tryout_id, $id) {
        $tryout = Tryout::findOrFail($tryout_id);
        $question = $tryout->questions()->with('answers')->where('questions.id', $id)->firstOrFail();
        $topics = QuestionTopic::all();

        return view('backend.tryout.question.edit', compact('tryout','question','topics'));
    }

    public function update(Request $request, $tryout_id, $question_id){
        $request->validate([
            'topic_id'       => 'required|exists:question_topics,id',
            'question'       => 'required|string',
            'explanation'    => 'nullable|string',
            'answers'        => 'required|array|min:5|max:5',
            'answers.*'      => 'required|string',
            'correct_answer' => 'nullable|string|in:A,B,C,D,E',
            'score_tkp'      => 'nullable|array|min:5|max:5',
            'score_tkp.*'    => 'nullable|integer|min:1|max:5',
        ]);

        // 🧪 VALIDASI SOAL TAMBAHAN
        $topic    = QuestionTopic::findOrFail($request->topic_id);
        $category = $topic->category;

        // Untuk non-TKP, jawaban benar wajib ada
        if ($category !== 'TKP' && empty($request->correct_answer)) {
            return back()
                ->withErrors(['correct_answer' => 'Jawaban benar wajib dipilih untuk kategori non-TKP.'])
                ->withInput();
        }

        // Untuk TKP, semua skor harus diisi
        if ($category === 'TKP') {
            foreach ($request->score_tkp as $idx => $score) {
                if (empty($score)) {
                    return back()
                        ->withErrors(['score_tkp.' . $idx => 'Semua skor TKP harus diisi (1–5).'])
                        ->withInput();
                }
            }
        }

        DB::beginTransaction();
        try {
            $tryout = Tryout::findOrFail($tryout_id);

            // ✅ Ambil soal lewat relasi tryout supaya pivot ikut
            $question = $tryout->questions()
                ->where('questions.id', $question_id)
                ->firstOrFail();

            // 🪄 Ganti URL tmp → final
            $sessionId = session()->getId();
            $tmpUrl    = asset("storage/question/tmp/{$sessionId}");
            $finalUrl  = asset("storage/question/{$question->id}");

            $newQuestionContent    = str_replace($tmpUrl, $finalUrl, $request->question);
            $newExplanationContent = str_replace($tmpUrl, $finalUrl, $request->explanation);

            // ✅ Update data soal (tabel questions)
            $question->update([
                'topic_id'    => $request->topic_id,
                'question'    => $newQuestionContent,
                'explanation' => $newExplanationContent,
            ]);

            // 📸 Pindahkan gambar dari tmp ke folder final
            $tmpFolder   = "question/tmp/{$sessionId}";
            $finalFolder = "question/{$question->id}";

            if (Storage::disk('public')->exists($tmpFolder)) {
                Storage::disk('public')->makeDirectory($finalFolder);
                foreach (Storage::disk('public')->files($tmpFolder) as $file) {
                    Storage::disk('public')->move($file, "{$finalFolder}/" . basename($file));
                }
                Storage::disk('public')->deleteDirectory($tmpFolder);
            }

            // 🛡️ Validasi order pivot tidak bentrok
            if ($request->has('order') && $request->order != $question->pivot->order) {
                $exists = $tryout->questions()
                    ->wherePivot('order', $request->order)
                    ->where('questions.id', '!=', $question_id)
                    ->exists();

                if ($exists) {
                    return back()
                        ->withInput()
                        ->with('error', "Nomor soal {$request->order} sudah digunakan oleh soal lain.");
                }
            }

            // ✅ Update order pivot jika ada perubahan urutan
            $tryout->questions()->updateExistingPivot($question_id, [
                'order'       => $request->order ?? $question->pivot->order,
                'updated_at'  => now(),
            ]);

            // ✅ Update jawaban A–E
            foreach (['A', 'B', 'C', 'D', 'E'] as $index => $option) {
                $answer = Answer::where('question_id', $question->id)
                    ->where('option', $option)
                    ->first();

                if ($answer) {
                    $answer->update([
                        'answer' => $request->answers[$index],
                        'score'  => ($category === 'TKP')
                            ? ($request->score_tkp[$index] ?? 1)
                            : (($request->correct_answer === $option) ? 5 : 0),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('console.tryout.question.index', $tryout_id)
                ->with('success', 'Soal berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function destroy($tryout_id, $id){
        $tryout = Tryout::findOrFail($tryout_id);

        // ✅ Putuskan relasi soal dengan tryout
        $tryout->questions()->detach($id);

        return redirect()->route('console.tryout.question.index', $tryout_id)
            ->with('success', 'Soal berhasil dihapus dari tryout!');
    }

    public function reorder(Request $request, $tryout_id){
        $order = $request->input('order', []);

        foreach ($order as $item) {
            DB::table('question_tryout')
                ->where('tryout_id', $tryout_id)
                ->where('question_id', $item['id'])
                ->update(['order' => $item['position']]);
        }

        return response()->json(['status' => 'success']);
    }

    public function attach(Request $request, $tryout_id){
        $request->validate([
            'question_ids' => 'required|array|min:1',
            'question_ids.*' => 'exists:questions,id',
        ]);

        $tryout = Tryout::findOrFail($tryout_id);
        $maxOrder = $tryout->questions()->max('question_tryout.order') ?? 0;

        foreach ($request->question_ids as $index => $questionId) {
            $tryout->questions()->attach($questionId, [
                'order' => $maxOrder + $index + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('console.tryout.question.index', $tryout_id)
            ->with('success', 'Soal berhasil ditambahkan dari bank soal!');
    }

    public function import(Request $request, $tryoutId)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:20480',
        ]);

        try {
            $result = $this->importService->importFromExcel(
                $request->file('file'),
                $tryoutId
            );

            return back()->with('success', "✅ {$result['success']} soal berhasil diimport ke tryout ini, {$result['failed']} gagal.");
        } catch (\Throwable $e) {
            return back()->withErrors(['error' => '❌ Gagal import: ' . $e->getMessage()]);
        }
    }

    public function export($tryoutId){
        $tryout = Tryout::with(['questions.answers', 'questions.topic'])
            ->findOrFail($tryoutId);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Export Soal Tryout');

        // Header kolom sama seperti export global
        $headers = [
            "No", "Kategori", "Topik", "Soal",
            "A", "B", "C", "D", "E",
            "Jawaban Benar", "Penjelasan",
            "Score A", "Score B", "Score C", "Score D", "Score E",
            "Gambar Soal", "Gambar Penjelasan",
            "Gambar A", "Gambar B", "Gambar C", "Gambar D", "Gambar E",
        ];

        foreach ($headers as $i => $header) {
            $col = $i + 1;
            $cell = Coordinate::stringFromColumnIndex($col) . '1';
            $sheet->setCellValue($cell, $header);
            $sheet->getStyle($cell)->getFont()->setBold(true);
            $sheet->getStyle($cell)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF0070C0');
            $sheet->getStyle($cell)->getFont()->getColor()->setARGB('FFFFFFFF');
        }

        // Isi soal tryout
        $rowIndex = 2;
        foreach ($tryout->questions as $no => $q) {
            $answers = $q->answers->sortBy('option')->values();
            $category = $q->topic->category ?? '';
            $topik = $q->topic->name ?? '';

            // Gambar
            $imagePath = "question/{$q->id}";
            $gambarSoal = Storage::disk('public')->exists("{$imagePath}/question.png") ? "question.png" : "";
            $gambarPenjelasan = Storage::disk('public')->exists("{$imagePath}/explanation.png") ? "explanation.png" : "";
            $gambarJawaban = [];
            foreach (['A','B','C','D','E'] as $opt) {
                $gambarJawaban[] = Storage::disk('public')->exists("{$imagePath}/{$opt}.png") ? "{$opt}.png" : "";
            }

            // Jawaban benar untuk TWK/TIU
            $jawabanBenar = '';
            if ($category !== 'TKP') {
                foreach ($answers as $ans) {
                    if ($ans->score == 5) {
                        $jawabanBenar = $ans->option;
                        break;
                    }
                }
            }

            // Skor TKP
            $score = [];
            foreach ($answers as $ans) {
                $score[] = ($category === 'TKP') ? $ans->score : 0;
            }

            // Data baris
            $data = [
                $no + 1,
                $category,
                $topik,
                strip_tags($q->question),
                strip_tags($answers[0]->answer ?? ''),
                strip_tags($answers[1]->answer ?? ''),
                strip_tags($answers[2]->answer ?? ''),
                strip_tags($answers[3]->answer ?? ''),
                strip_tags($answers[4]->answer ?? ''),
                $jawabanBenar,
                strip_tags($q->explanation ?? ''),
                $score[0] ?? 0,
                $score[1] ?? 0,
                $score[2] ?? 0,
                $score[3] ?? 0,
                $score[4] ?? 0,
                $gambarSoal,
                $gambarPenjelasan,
                $gambarJawaban[0] ?? '',
                $gambarJawaban[1] ?? '',
                $gambarJawaban[2] ?? '',
                $gambarJawaban[3] ?? '',
                $gambarJawaban[4] ?? '',
            ];

            foreach ($data as $i => $value) {
                $col = $i + 1;
                $cell = Coordinate::stringFromColumnIndex($col) . $rowIndex;
                $sheet->setCellValue($cell, $value);
            }

            $rowIndex++;
        }

        // Auto size kolom
        foreach (range(1, count($headers)) as $col) {
            $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($col))->setAutoSize(true);
        }

        $fileName = 'export_soal_tryout_' . $tryout->id . '.xlsx';

        return new StreamedResponse(function() use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
        ]);
    }
}