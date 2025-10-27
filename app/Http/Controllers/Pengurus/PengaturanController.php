<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function waSetting()
    {
        $pesan_diterima = Storage::disk('local')->get('wa_template_diterima.txt');
        $pesan_ditolak = Storage::disk('local')->get('wa_template_ditolak.txt');
        $pesan_lolos_wawancara = Storage::disk('local')->get('wa_template_lolos_wawancara.txt');
        $pesan_gagal_wawancara = Storage::disk('local')->get('wa_template_gagal_wawancara.txt');

        return view('pengurus.pengaturan.wa-setting', compact('pesan_diterima', 'pesan_ditolak', 'pesan_lolos_wawancara', 'pesan_gagal_wawancara'));
    }

    public function waUpdate(Request $request)
    {
        $request->validate([
            'pesan_diterima' => 'required|string',
            'pesan_ditolak' => 'required|string',
            'pesan_lolos_wawancara' => 'required|string',
            'pesan_gagal_wawancara' => 'required|string',
        ]);

        Storage::disk('local')->put('wa_template_diterima.txt', $request->pesan_diterima);
        Storage::disk('local')->put('wa_template_ditolak.txt', $request->pesan_ditolak);
        Storage::disk('local')->put('wa_template_lolos_wawancara.txt', $request->pesan_lolos_wawancara);
        Storage::disk('local')->put('wa_template_gagal_wawancara.txt', $request->pesan_gagal_wawancara);

        return redirect()->route('pengurus.pengaturan.wa.setting')->with('success', 'Pengaturan WhatsApp berhasil diperbarui.');
    }
}
