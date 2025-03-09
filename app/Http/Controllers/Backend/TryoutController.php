<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Tryout;
use App\Models\TryoutSource;
use Illuminate\Http\Request;

class TryoutController extends Controller
{
    public function index(){
        $tryouts = Tryout::with('source')->orderBy('id','DESC')->get();
        return view('backend.tryout.index',compact('tryouts'));
    }
    
    public function create(){
        $sources = TryoutSource::orderBy('name','ASC')->get();
        return view('backend.tryout.create',compact('sources'));
    }

    public function store(Request $request){
        $request->validate([
            'title'      => 'required|string|max:255',
            'category'  => 'required|string|in:Tryout,Latihan TWK, Latihan TIU,Latihan TKP',
            'tryout_source_id'    => 'required|integer',
            'duration'  => 'required|integer|min:1',
            'access_type'    => 'required|string|in:free,premium',
        ]);

        Tryout::create([
            'title'      => $request->title,
            'category'  => $request->category,
            'tryout_source_id' => $request->tryout_source_id, // Sesuai dengan relasi sumber tryout
            'duration'  => $request->duration,
            'access_type'    => $request->access_type,
            'status'    => $request->status ?? 'draft',
        ]);

        return redirect()->route('console.tryout.index')->with('success', 'Tryout berhasil ditambahkan!');
    }

    public function edit($id){
        $tryout = Tryout::findOrFail($id);
        $sources = TryoutSource::orderBy('name','ASC')->get();
        
        return view('backend.tryout.edit', compact('tryout', 'sources'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:Tryout,Latihan TWK,Latihan TIU,Latihan TKP',
            'tryout_source_id' => 'required|exists:tryout_sources,id',
            'duration' => 'required|integer|min:1',
            'access_type' => 'required|in:free,premium',
            'status' => 'required|in:draft,publish,archived',
        ]);

        $tryout = Tryout::findOrFail($id);
        $tryout->update($request->all());

        return redirect()->route('console.tryout.index')->with('success', 'Tryout berhasil diperbarui.');
    }

    public function destroy($id){
        $tryout = Tryout::findOrFail($id);
        $tryout->delete();

        return redirect()->route('console.tryout.index')->with('success', 'Tryout berhasil dihapus.');
    }
}
