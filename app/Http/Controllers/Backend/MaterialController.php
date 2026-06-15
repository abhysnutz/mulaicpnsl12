<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\QuestionTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use DB;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::with('topic')->latest()->get();

        return view('backend.material.index', compact('materials'));
    }

    public function create()
    {
        // hanya topik yang BELUM punya materi (hasOne / unique)
        $topics = QuestionTopic::whereDoesntHave('material')
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        return view('backend.material.create', compact('topics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_topic_id' => 'required|exists:question_topics,id|unique:materials,question_topic_id',
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'file'              => 'required|file|mimes:pdf|max:51200', // 50MB
            'is_active'         => 'nullable|boolean',
        ], [
            'question_topic_id.unique' => 'Topik ini sudah punya materi. Edit yang sudah ada.',
            'file.mimes'               => 'File harus berformat PDF.',
            'file.max'                 => 'Ukuran file maksimal 50MB.',
        ]);

        DB::beginTransaction();
        try {
            $file         = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $fileName     = Str::uuid() . '.pdf';

            // simpan di disk PRIVATE: storage/app/material/
            $path = $file->storeAs('material', $fileName, 'local');

            Material::create([
                'question_topic_id' => $request->question_topic_id,
                'title'             => $request->title,
                'description'       => $request->description,
                'file_path'         => $path,           // material/uuid.pdf
                'original_name'     => $originalName,
                'file_size'         => $file->getSize(),
                'is_active'         => $request->boolean('is_active'),
            ]);

            DB::commit();

            return redirect()->route('console.material.index')
                ->with('success', 'Materi berhasil diunggah!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $material = Material::with('topic')->findOrFail($id);

        // topik yang belum punya materi + topik milik materi ini sendiri
        $topics = QuestionTopic::where(function ($q) use ($material) {
            $q->whereDoesntHave('material')
              ->orWhere('id', $material->question_topic_id);
        })->orderBy('category')->orderBy('name')->get();

        return view('backend.material.edit', compact('material', 'topics'));
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $request->validate([
            'question_topic_id' => 'required|exists:question_topics,id|unique:materials,question_topic_id,' . $material->id,
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'file'              => 'nullable|file|mimes:pdf|max:51200',
            'is_active'         => 'nullable|boolean',
        ], [
            'question_topic_id.unique' => 'Topik ini sudah punya materi lain.',
            'file.mimes'               => 'File harus berformat PDF.',
            'file.max'                 => 'Ukuran file maksimal 50MB.',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'question_topic_id' => $request->question_topic_id,
                'title'             => $request->title,
                'description'       => $request->description,
                'is_active'         => $request->boolean('is_active'),
            ];

            // ganti file hanya kalau ada upload baru
            if ($request->hasFile('file')) {
                // hapus file lama
                if ($material->file_path && Storage::disk('local')->exists($material->file_path)) {
                    Storage::disk('local')->delete($material->file_path);
                }

                $file                  = $request->file('file');
                $fileName              = Str::uuid() . '.pdf';
                $data['file_path']     = $file->storeAs('material', $fileName, 'local');
                $data['original_name'] = $file->getClientOriginalName();
                $data['file_size']     = $file->getSize();
            }

            $material->update($data);

            DB::commit();

            return redirect()->route('console.material.index')
                ->with('success', 'Materi berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);

        // hapus file fisik
        if ($material->file_path && Storage::disk('local')->exists($material->file_path)) {
            Storage::disk('local')->delete($material->file_path);
        }

        $material->delete();

        return redirect()->route('console.material.index')
            ->with('success', 'Materi berhasil dihapus!');
    }
}