<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{

    public function index()
    {
        $isPaid = Auth::user()->subscription_status === 'premium';

        $materials = Material::with('topic')
            ->where('is_active', true)
            ->whereHas('topic')
            ->get()
            ->sortBy(fn ($m) => $m->topic->category . ' - ' . $m->topic->name)
            ->values();

        return view('frontend.material.index', compact('materials', 'isPaid'));
    }

    public function download($id)
    {
        // hanya user berbayar
        if (Auth::user()->subscription_status !== 'premium') {
            abort(403, 'Materi hanya untuk pengguna premium.');
        }

        $material = Material::where('is_active', true)->findOrFail($id);

        // pastikan file fisik ada di disk privat
        if (! $material->file_path || ! Storage::disk('local')->exists($material->file_path)) {
            abort(404, 'File materi tidak ditemukan.');
        }

        // catat unduhan
        $material->increment('download_count');

        // nama file saat diunduh user (pakai nama asli + judul biar rapi)
        $downloadName = $material->original_name;

        // stream dari disk privat (bukan link publik)
        return Storage::disk('local')->download($material->file_path, $downloadName);
    }
}