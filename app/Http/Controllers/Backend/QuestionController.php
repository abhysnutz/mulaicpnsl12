<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\QuestionTopic;
use App\Models\Tryout;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    public function index(){
        $questions = Question::with('topic')->latest()->paginate(20);
        return view('backend.question.index', compact('questions'));
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

        DB::beginTransaction();
        try {
            $topic    = QuestionTopic::findOrFail($request->topic_id);
            $category = $topic->category;

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

            $newQuestionContent    = str_replace($tmpUrl, $finalUrl, $request->question);
            $newExplanationContent = str_replace($tmpUrl, $finalUrl, $request->explanation);

            $question->update([
                'question'    => $newQuestionContent,
                'explanation' => $newExplanationContent,
            ]);

            // 📂 pindahkan semua file dari tmp ke folder final
            $tmpPath    = "question/tmp/{$sessionId}";
            $finalPath  = "question/{$question->id}";

            if (Storage::disk('public')->exists($tmpPath)) {
                if (!Storage::disk('public')->exists($finalPath)) {
                    Storage::disk('public')->makeDirectory($finalPath);
                }

                foreach (Storage::disk('public')->files($tmpPath) as $file) {
                    $name = basename($file);
                    Storage::disk('public')->move($file, "{$finalPath}/{$name}");
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
            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
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

        DB::beginTransaction();
        try {
            $question = Question::with('answers')->findOrFail($id);
            $topic    = QuestionTopic::findOrFail($request->topic_id);
            $category = $topic->category;

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

            // 📂 pindahkan file dari tmp ke folder final (overwrite jika ada file sama)
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
            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
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

    public function image(Request $request){
        $request->validate([
            'file' => 'required|image|max:2048',
            'type' => 'required|in:question,explanation', // bisa diperluas nanti: answer_A, answer_B, dst.
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
}