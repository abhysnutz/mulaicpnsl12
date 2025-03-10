<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\QuestionTopic;
use App\Models\Tryout;
use Illuminate\Http\Request;
use DB;

class QuestionController extends Controller
{
    public function index($tryout_id){
        $tryout = Tryout::findOrFail($tryout_id);
        $questions = Question::where('tryout_id', $tryout_id)->orderBy('order','ASC')->get();

        return view('backend.question.index', compact('tryout', 'questions'));
    }

    public function create($tryout_id)
    {
        $tryout = Tryout::findOrFail($tryout_id);
        $topics = QuestionTopic::all(); // Ambil semua topik soal
        $number = Question::where('tryout_id', $tryout_id )->max('order') ?? 0;
        $number += 1;
        
        return view('backend.question.create', compact('tryout', 'topics', 'number'));
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

        // Gunakan database transaction
        DB::beginTransaction();
        
        try {
            // Dapatkan kategori berdasarkan topic_id
            $topic = QuestionTopic::findOrFail($request->topic_id);
            $category = $topic->category; // TWK, TIU, atau TKP

            // Cari order terakhir dalam tryout ini
            $question = Question::create([
                'tryout_id' => $tryout_id,
                'topic_id' => $request?->topic_id ?? 1,
                'question' => $request?->question ?? '-',
                'explanation' => $request->explanation,
                'order' => $request?->order ?? 1,
            ]);

            // Simpan jawaban
            foreach (['A', 'B', 'C', 'D', 'E'] as $index => $option) {
                Answer::create([
                    'question_id' => $question->id,
                    'option' => $option,
                    'answer' => $request->answers[$index],
                    'score' => ($category === 'TKP') 
                        ? ($request->score_tkp[$index] ?? 1) // TKP: skor 1-5
                        : (($request->correct_answer === $option) ? 5 : 0), // TWK & TIU: benar 5, salah 0
                ]);
            }

            // Jika semua berhasil, commit transaction
            DB::commit();

            return redirect()->route('console.tryout.question.index', $tryout_id)
                ->with('success', 'Soal berhasil ditambahkan!');

        } catch (\Exception $e) {
            // Jika ada error, rollback semua perubahan
            DB::rollBack();
            
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());

        }
    }

    public function edit($tryout_id, $id) {
        $tryout = Tryout::findOrFail($tryout_id);
        $question = Question::with('answers')->findOrFail($id);
        $topics = QuestionTopic::all();

        return view('backend.question.edit', compact('tryout','question','topics'));
    }

    public function update(Request $request, $tryout_id, $question_id) {
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
            $question = Question::where('tryout_id', $tryout_id)->findOrFail($question_id);
            
            $topic = QuestionTopic::findOrFail($request->topic_id);
            $category = $topic->category; // TWK, TIU, atau TKP
    
            // Update soal
            $question->update([
                'topic_id' => $request->topic_id,
                'question' => $request->question,
                'explanation' => $request->explanation,
                'order' => $request->order,
            ]);
    
            // Update jawaban
            foreach (['A', 'B', 'C', 'D', 'E'] as $index => $option) {
                $answer = Answer::where('question_id', $question->id)->where('option', $option)->first();
                if ($answer) {
                    $answer->update([
                        'answer' => $request->answers[$index],
                        'score' => ($category === 'TKP') 
                            ? ($request->score_tkp[$index] ?? 1) // TKP: skor 1-5
                            : (($request->correct_answer === $option) ? 5 : 0), // TWK & TIU: benar 5, salah 0
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

    public function destroy($tryout_id, $id) {
        $question = Question::findOrFail($id);
        $question->delete();

        return redirect()->route('console.tryout.question.index',[$tryout_id,$id])->with('success', 'Soal berhasil dihapus!');
    }
}
