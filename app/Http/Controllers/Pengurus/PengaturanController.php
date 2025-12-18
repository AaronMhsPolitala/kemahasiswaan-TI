<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function waSetting()
    {
        // Kunci-kunci pengaturan yang akan diambil
        $keys = [
            'pesan_diterima',
            'pesan_ditolak',
            'pesan_lolos_wawancara',
            'pesan_gagal_wawancara',
        ];

        // Ambil semua pengaturan dari database
        $settings = Setting::whereIn('key', $keys)->pluck('value', 'key');

        // Siapkan variabel untuk view, dengan nilai default jika tidak ada di DB
        $data = [];
        foreach ($keys as $key) {
            $data[$key] = $settings->get($key, ''); // Default string kosong
        }

        return view('pengurus.pengaturan.wa-setting', $data);
    }

    public function waUpdate(Request $request)
    {
        $request->validate([
            'pesan_diterima' => 'required|string',
            'pesan_ditolak' => 'required|string',
            'pesan_lolos_wawancara' => 'required|string',
            'pesan_gagal_wawancara' => 'required|string',
        ]);

        foreach ($request->all() as $key => $value) {
            if ($key === '_token' || $key === '_method') {
                continue;
            }
            // Gunakan updateOrCreate untuk membuat atau memperbarui setting
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('pengurus.pengaturan.wa.setting')->with('success', 'Pengaturan WhatsApp berhasil diperbarui.');
    }
}
