<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Question;
use App\Models\QuestionTopic;
use App\Models\Tryout;
use DB;
use Illuminate\Support\Facades\Storage;

class TryoutQuestionController extends Controller
{
    public function index($tryout_id){
        $tryout = Tryout::with(['questions' => function ($query) {
            $query->orderBy('pivot_order', 'ASC');
        }])->findOrFail($tryout_id);

        $questions = $tryout->questions;

        return view('backend.tryout.question.index', compact('tryout', 'questions'));
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
            'topic_id' => 'required|exists:question_topics,id',
            'question' => 'required|string',
            'explanation' => 'nullable|string',
            'answers' => 'required|array|min:5|max:5',
            'answers.*' => 'required|string',
            'correct_answer' => 'nullable|string|in:A,B,C,D,E',
            'score_tkp' => 'nullable|array|min:5|max:5',
            'score_tkp.*' => 'nullable|integer|min:1|max:5',
        ]);

        DB::beginTransaction();

        try {
            $topic = QuestionTopic::findOrFail($request->topic_id);
            $category = $topic->category;

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

            $newQuestionContent    = str_replace($tmpUrl, $finalUrl, $request->question);
            $newExplanationContent = str_replace($tmpUrl, $finalUrl, $request->explanation);

            $question->update([
                'question'    => $newQuestionContent,
                'explanation' => $newExplanationContent,
            ]);

            // 📸 Pindahkan file gambar tmp → final folder
            $tmpFolder = "question/tmp/{$sessionId}";
            $finalFolder = "question/{$question->id}";

            if (Storage::disk('public')->exists($tmpFolder)) {
                Storage::disk('public')->makeDirectory($finalFolder);

                $files = Storage::disk('public')->files($tmpFolder);
                foreach ($files as $file) {
                    $filename = basename($file);
                    Storage::disk('public')->move($file, "{$finalFolder}/{$filename}");
                }

                Storage::disk('public')->deleteDirectory($tmpFolder);
            }

            // ✅ Attach ke tryout lewat pivot
            $tryout = Tryout::findOrFail($tryout_id);

            // 🛡️ Cek duplikasi nomor
            if ($tryout->questions()->wherePivot('order', $request->order)->exists()) {
                return redirect()->back()
                    // ->withInput()
                    ->with('error', "Nomor soal {$request->order} sudah digunakan. Silakan pilih nomor lain.");
            }


            $tryout->questions()->attach($question->id, [
                'order' => $request->order ?? 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // ✅ Simpan jawaban
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
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
            'topic_id' => 'required|exists:question_topics,id',
            'question' => 'required|string',
            'explanation' => 'nullable|string',
            'answers' => 'required|array|min:5|max:5',
            'answers.*' => 'required|string',
            'correct_answer' => 'nullable|string|in:A,B,C,D,E',
            'score_tkp' => 'nullable|array|min:5|max:5',
            'score_tkp.*' => 'nullable|integer|min:1|max:5',
        ]);

        DB::beginTransaction();

        try {
            $tryout = Tryout::findOrFail($tryout_id);

            // ✅ Ambil soal lewat relasi tryout supaya pivot ikut
            $question = $tryout->questions()
                ->where('questions.id', $question_id)
                ->firstOrFail();

            $topic = QuestionTopic::findOrFail($request->topic_id);
            $category = $topic->category;

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
            $tmpFolder = "question/tmp/{$sessionId}";
            $finalFolder = "question/{$question->id}";

            if (Storage::disk('public')->exists($tmpFolder)) {
                // (optional) Kalau mau replace gambar lama:
                // Storage::disk('public')->deleteDirectory($finalFolder);

                Storage::disk('public')->makeDirectory($finalFolder);

                $files = Storage::disk('public')->files($tmpFolder);
                foreach ($files as $file) {
                    $filename = basename($file);
                    Storage::disk('public')->move($file, "{$finalFolder}/{$filename}");
                }

                Storage::disk('public')->deleteDirectory($tmpFolder);
            }

            // 🛡️ Validasi: pastikan nomor tidak bentrok dengan soal lain
            if ($request->has('order') && $request->order != $question->pivot->order) {
                $exists = $tryout->questions()
                    ->wherePivot('order', $request->order)
                    ->where('questions.id', '!=', $question_id)
                    ->exists();

                if ($exists) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', "Nomor soal {$request->order} sudah digunakan oleh soal lain.");
                }
            }

            // ✅ Update order di pivot (jika ada perubahan urutan)
            $tryout->questions()->updateExistingPivot($question_id, [
                'order' => $request->order ?? $question->pivot->order,
                'updated_at' => now(),
            ]);

            // ✅ Update jawaban
            foreach (['A', 'B', 'C', 'D', 'E'] as $index => $option) {
                $answer = Answer::where('question_id', $question->id)
                    ->where('option', $option)
                    ->first();

                if ($answer) {
                    $answer->update([
                        'answer' => $request->answers[$index],
                        'score' => ($category === 'TKP')
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
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }



    public function destroy($tryout_id, $id){
        $tryout = Tryout::findOrFail($tryout_id);

        // ✅ Putuskan relasi soal dengan tryout
        $tryout->questions()->detach($id);

        return redirect()->route('console.tryout.question.index', $tryout_id)
            ->with('success', 'Soal berhasil dihapus dari tryout!');
    }
}
