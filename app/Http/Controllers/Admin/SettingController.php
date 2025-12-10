<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('key');

        return view('admin.setting.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $status = $request->input('status_pendaftaran') ? 'open' : 'closed';

        Setting::updateOrCreate(
            ['key' => 'pendaftaran'],
            ['value' => $status]
        );

        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    public function updateProfile(Request $request)
    {
        // 1. Validasi (Semua opsional)
        $rules = [
            'site_name' => 'nullable|string|max:255',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'nama_ketua' => 'nullable|string|max:255',
            'nama_wakil' => 'nullable|string|max:255',
            'nama_sekretaris' => 'nullable|string|max:255',
            'nama_bendahara' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $request->validate($rules);

        // 2. Simpan pengaturan teks satu per satu jika ada di request
        $textSettings = ['site_name', 'visi', 'misi', 'deskripsi', 'nama_ketua', 'nama_wakil', 'nama_sekretaris', 'nama_bendahara'];
        foreach ($textSettings as $key) {
            if ($request->filled($key)) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $request->input($key)]
                );
            }
        }

        // 3. Handle upload logo
        if ($request->hasFile('logo')) {
            $currentLogo = Setting::where('key', 'logo')->first();
            // Hapus logo lama jika ada
            if ($currentLogo && $currentLogo->value) {
                Storage::disk('public')->delete($currentLogo->value);
            }
            // Simpan logo baru
            $path = $request->file('logo')->store('logos', 'public');
            Setting::updateOrCreate(
                ['key' => 'logo'],
                ['value' => $path]
            );
        }

        // 4. Kembalikan dengan pesan sukses
        return back()->with('success', 'Profil website berhasil diperbarui.');
    }
}
