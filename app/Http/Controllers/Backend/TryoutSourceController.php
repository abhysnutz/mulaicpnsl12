<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TryoutSource;
use Illuminate\Http\Request;

class TryoutSourceController extends Controller
{
    public function index()
    {
        $sources = TryoutSource::withCount('tryouts')->orderBy('name')->get();
        return view('backend.tryout_source.index', compact('sources'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tryout_sources,name',
        ]);

        TryoutSource::create(['name' => $request->name]);

        return redirect()->route('console.tryout-source.index')
            ->with('success', 'Source berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $source = TryoutSource::findOrFail($id);
        return view('backend.tryout_source.edit', compact('source'));
    }

    public function update(Request $request, $id)
    {
        $source = TryoutSource::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:tryout_sources,name,' . $source->id,
        ]);

        $source->update(['name' => $request->name]);

        return redirect()->route('console.tryout-source.index')
            ->with('success', 'Source berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $source = TryoutSource::findOrFail($id);

        // Prevent deleting a source that is still used by any tryout
        if ($source->tryouts()->exists()) {
            return back()->with('error', 'Source masih dipakai oleh tryout, tidak bisa dihapus.');
        }

        $source->delete();

        return redirect()->route('console.tryout-source.index')
            ->with('success', 'Source berhasil dihapus!');
    }
}