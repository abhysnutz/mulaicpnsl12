<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\QuestionTopic;
use App\Models\Tryout;
use App\Services\QuestionImportService;
use App\Traits\ExportsQuestions; 
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    protected $importService;
    use ExportsQuestions;

    public function __construct(QuestionImportService $importService)
    {
        $this->importService = $importService;
    }
    
    public function index(Request $request){
        $categories = QuestionTopic::select('category')->distinct()->orderBy('category')->pluck('category');
        $topics     = QuestionTopic::orderBy('category')->orderBy('name')->get();

        $isFiltered = $request->filled('category') || $request->filled('topic_id');

        // sorting (default: terbaru). Hanya izinkan kolom yang valid.
        $sort = $request->input('sort');
        $dir  = $request->input('dir') === 'asc' ? 'asc' : 'desc';

        $query = Question::with(['topic', 'tryouts:id,title'])
            ->withCount('tryouts')
            ->when($request->filled('category'), function ($q) use ($request) {
                $q->whereHas('topic', fn ($t) => $t->where('category', $request->category));
            })
            ->when($request->filled('topic_id'), function ($q) use ($request) {
                $q->where('topic_id', $request->topic_id);
            });

        if ($sort === 'tryout_count') {
            $query->orderBy('tryouts_count', $dir);
        } else {
            $query->latest();
        }

        // Pagination HANYA saat tidak difilter. Saat difilter -> tampilkan semua.
        if ($isFiltered) {
            $questions = $query->get();
        } else {
            $questions = $query->paginate(100)->withQueryString();
        }

        return view('backend.question.index', compact('questions', 'categories', 'topics', 'isFiltered', 'sort', 'dir'));
    }

    public function create(){
        $topics = QuestionTopic::all();  // ambil topik untuk dropdown kategori
        return view('backend.question.create', compact('topics'));
    }

    public function store(Request $request){
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

        // Untuk soal non-TKP, wajib punya jawaban benar
        if ($category !== 'TKP' && empty($request->correct_answer)) {
            return back()
                ->withErrors(['correct_answer' => 'Jawaban benar wajib dipilih untuk kategori non-TKP.'])
                ->withInput();
        }

        // Untuk TKP, semua skor wajib diisi
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
            // 📝 buat soal
            $question = Question::create([
                'topic_id'    => $request->topic_id,
                'question'    => $request->question,
                'explanation' => $request->explanation,
            ]);

            // 🪄 ganti prefix URL tmp ke final
            $sessionId = session()->getId();
            $tmpUrl    = asset("storage/question/tmp/{$sessionId}");
            $finalUrl  = asset("storage/question/{$question->id}");

            $question->update([
                'question'    => str_replace($tmpUrl, $finalUrl, $request->question),
                'explanation' => str_replace($tmpUrl, $finalUrl, $request->explanation),
            ]);

            // 📂 pindahkan file dari tmp ke final
            $tmpPath    = "question/tmp/{$sessionId}";
            $finalPath  = "question/{$question->id}";
            if (Storage::disk('public')->exists($tmpPath)) {
                Storage::disk('public')->makeDirectory($finalPath);
                foreach (Storage::disk('public')->files($tmpPath) as $file) {
                    Storage::disk('public')->move($file, "{$finalPath}/" . basename($file));
                }
                Storage::disk('public')->deleteDirectory($tmpPath);
            }

            // 📝 simpan jawaban A–E
            foreach (['A', 'B', 'C', 'D', 'E'] as $i => $opt) {
                Answer::create([
                    'question_id' => $question->id,
                    'option'      => $opt,
                    'answer'      => $request->answers[$i],
                    'score'       => ($category === 'TKP')
                                    ? ($request->score_tkp[$i] ?? 1)
                                    : (($request->correct_answer === $opt) ? 5 : 0),
                ]);
            }

            DB::commit();

            return redirect()->route('console.question.index')
                ->with('success', 'Soal berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function edit($id){
        $question = Question::with('answers', 'topic')->findOrFail($id);
        $topics = QuestionTopic::all();

        return view('backend.question.edit', compact('question', 'topics'));
    }
    
    public function update(Request $request, $id){
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

        // Jika bukan TKP, jawaban benar harus ada
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
            $question = Question::with('answers')->findOrFail($id);

            // 🪄 ganti prefix tmp ke final
            $sessionId = session()->getId();
            $tmpUrl    = asset("storage/question/tmp/{$sessionId}");
            $finalUrl  = asset("storage/question/{$question->id}");

            $newQuestionContent    = str_replace($tmpUrl, $finalUrl, $request->question);
            $newExplanationContent = str_replace($tmpUrl, $finalUrl, $request->explanation);

            $question->update([
                'topic_id'    => $request->topic_id,
                'question'    => $newQuestionContent,
                'explanation' => $newExplanationContent,
            ]);

            // 📂 pindahkan file dari tmp ke folder final (jika ada)
            $tmpPath   = "question/tmp/{$sessionId}";
            $finalPath = "question/{$question->id}";

            if (Storage::disk('public')->exists($tmpPath)) {
                $files = Storage::disk('public')->files($tmpPath);

                if (count($files) > 0) {
                    if (!Storage::disk('public')->exists($finalPath)) {
                        Storage::disk('public')->makeDirectory($finalPath);
                    }

                    foreach ($files as $file) {
                        $name = basename($file);
                        Storage::disk('public')->move($file, "{$finalPath}/{$name}");
                    }

                    Storage::disk('public')->deleteDirectory($tmpPath);
                }
            }

            // 📝 update jawaban A–E
            foreach (['A', 'B', 'C', 'D', 'E'] as $i => $opt) {
                $ans = $question->answers->firstWhere('option', $opt);
                if ($ans) {
                    $ans->update([
                        'answer' => $request->answers[$i],
                        'score'  => ($category === 'TKP')
                                    ? ($request->score_tkp[$i] ?? 1)
                                    : (($request->correct_answer === $opt) ? 5 : 0),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('console.question.index')
                ->with('success', 'Soal berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function destroy($id){
        $question = Question::findOrFail($id);

        // 🧼 Hapus folder gambar jika ada
        $folderPath = "question/{$id}";
        if (Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->deleteDirectory($folderPath);
        }

        // 🧾 Hapus soal (jawaban ikut terhapus jika pakai cascade)
        $question->delete();

        return redirect()->route('console.question.index')
            ->with('success', 'Soal berhasil dihapus dari bank soal!');
    }

    /**
     * 🗑️ Hapus banyak soal sekaligus berdasarkan pilihan checkbox.
     * Menerima array ids[]. Menghapus folder gambar tiap soal juga.
     */
    public function bulkDestroy(Request $request){
        $validated = $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:questions,id',
        ]);

        $ids = $validated['ids'];

        DB::beginTransaction();
        try {
            foreach ($ids as $id) {
                $folderPath = "question/{$id}";
                if (Storage::disk('public')->exists($folderPath)) {
                    Storage::disk('public')->deleteDirectory($folderPath);
                }
            }

            // hapus dalam satu query (jawaban ikut terhapus jika pakai cascade)
            $deleted = Question::whereIn('id', $ids)->delete();

            DB::commit();

            return redirect()->route('console.question.index')
                ->with('success', "{$deleted} soal berhasil dihapus dari bank soal!");
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus soal terpilih: ' . $e->getMessage());
        }
    }

    public function image(Request $request){
        $request->validate([
            'file' => 'required|image|max:2048',
            'type' => ['required', 'regex:/^(question|explanation|answer_[A-E])$/'],
        ]);

        $type = $request->type;
        $sessionId  = session()->getId();
        $folderPath = "question/tmp/{$sessionId}";

        // nama file fix per type
        $ext = $request->file('file')->getClientOriginalExtension();
        $filename = "{$type}.{$ext}";

        // upload file (overwrite kalau ada nama sama)
        $path = $request->file('file')->storeAs($folderPath, $filename, 'public');

        return response()->json([
            'imageUrl' => asset(Storage::url($path)),
            'type' => $type
        ]);
    }

    public function clone($id){
        DB::beginTransaction();

        try {
            $original = Question::with('answers')->findOrFail($id);

            // 🆕 Buat soal baru
            $newQuestion = Question::create([
                'topic_id'    => $original->topic_id,
                'question'    => $original->question,
                'explanation' => $original->explanation,
            ]);

            // 🔁 Duplikasi jawaban
            foreach ($original->answers as $answer) {
                Answer::create([
                    'question_id' => $newQuestion->id,
                    'option'      => $answer->option,
                    'answer'      => $answer->answer,
                    'score'       => $answer->score,
                ]);
            }

            // 📸 Duplikasi folder gambar
            $oldFolder = "question/{$original->id}";
            $newFolder = "question/{$newQuestion->id}";

            if (Storage::disk('public')->exists($oldFolder)) {
                // Buat folder baru
                Storage::disk('public')->makeDirectory($newFolder);

                $files = Storage::disk('public')->files($oldFolder);
                foreach ($files as $file) {
                    $filename = basename($file);
                    Storage::disk('public')->copy($file, "{$newFolder}/{$filename}");
                }
            }

            DB::commit();

            return redirect()->route('console.question.index')
                ->with('success', 'Soal berhasil di-kloning!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal cloning soal: '.$e->getMessage());
        }
    }

    public function preview($id){
        $question = Question::with('answers')->findOrFail($id);
        // pakai tampilan frontend ujian, bukan tampilan admin
        return view('backend.question.preview', compact('question'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:zip,xlsx,xls|max:51200',
        ]);

        try {
            $result = $this->importService->importFromUpload($request->file('file'));

            return back()->with('success', "✅ Import selesai: {$result['success']} berhasil, {$result['failed']} gagal.")
                         ->with('log', $result['log_file']);
        } catch (\Throwable $e) {
            return back()->withErrors(['error' => '❌ Gagal import: ' . $e->getMessage()]);
        }
    }

    /**
     * TAHAP 1 — Analisa file import (dry-run). Return JSON. Tidak menyimpan apa pun.
     */
    public function analyzeImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:zip,xlsx,xls|max:51200',
        ]);

        try {
            $result = $this->importService->analyze($request->file('file'), null);
            return response()->json(['ok' => true] + $result);
        } catch (\Throwable $e) {
            return response()->json([
                'ok'      => false,
                'message' => 'Gagal menganalisa file: ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * TAHAP 2 — Commit import dari token. All-or-nothing.
     */
    public function commitImport(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'ext'   => 'required|string|in:zip,xlsx,xls',
        ]);

        try {
            $result = $this->importService->commitFromToken(
                $request->input('token'),
                $request->input('ext'),
                null
            );

            return response()->json([
                'ok'      => true,
                'success' => $result['success'],
                'message' => "✅ Import selesai: {$result['success']} soal berhasil ditambahkan ke bank soal.",
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'ok'      => false,
                'message' => '❌ Import dibatalkan: ' . $e->getMessage(),
            ], 422);
        }
    }

    public function export()
    {
        $questions = Question::with(['topic', 'answers'])->orderBy('id')->get();
        return $this->buildExportZip($questions, 'export_soal_cpns_' . date('Ymd_His') . '.zip');
    }
}