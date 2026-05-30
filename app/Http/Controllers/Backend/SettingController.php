<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('key', 'ASC')->get();
        return view('backend.setting.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'key'   => 'required|string|max:191|unique:settings,key|regex:/^[a-z0-9_]+$/',
            'value' => 'nullable|string',
        ], [
            'key.regex'  => 'Key hanya boleh huruf kecil, angka, dan underscore (_).',
            'key.unique' => 'Key sudah ada, gunakan nama lain.',
        ]);

        Setting::set($request->key, $request->value);

        return redirect()->back()->with('success', 'Setting baru ditambahkan!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'    => 'required|exists:settings,id',
            'value' => 'nullable|string',
        ]);

        $setting = Setting::findOrFail($request->id);
        Setting::set($setting->key, $request->value); // pakai set() biar cache ke-clear

        return redirect()->back()->with('success', 'Setting diperbarui!');
    }

    public function destroy(Request $request)
    {
        $setting = Setting::findOrFail($request->id);
        $key = $setting->key;
        $setting->delete();

        // clear cache settings
        \Illuminate\Support\Facades\Cache::forget('settings.all');

        return redirect()->back()->with('success', "Setting '{$key}' dihapus.");
    }
}