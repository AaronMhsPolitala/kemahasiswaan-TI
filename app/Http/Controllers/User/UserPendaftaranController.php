<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\Pendaftaran;
use App\Models\Setting;
use Illuminate\Http\Request;

class UserPendaftaranController extends Controller
{
    public function showPendaftaranForm()
    {
        $divisis = Divisi::all();
        $registrationStatus = Setting::where('key', 'pendaftaran')->first();
        $activePeriodSetting = Setting::where('key', 'active_period')->first();
        $activePeriod = $activePeriodSetting ? $activePeriodSetting->value : '';

        return view('user.pendaftaran', compact('divisis', 'registrationStatus', 'activePeriod'));
    }

    public function store(Request $request)
    {
        $registrationStatus = Setting::where('key', 'pendaftaran')->first();
        if (! $registrationStatus || $registrationStatus->value == 'closed') {
            return back()->with('error', 'Pendaftaran saat ini sedang ditutup.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => [
                'required',
                'numeric',
                'unique:pendaftarans,nim',
                'regex:/^\d{2}01\d{6,}$/' // Example: 2401xxxxxx (10 digits total)
            ],
            'hp' => 'required|numeric|unique:pendaftarans,hp',
            'divisi_id' => 'required|exists:divisis,id',
            'alasan' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'berkas_pendaftaran' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120', // 5MB Max
        ], [
            'nim.numeric' => 'NIM harus berupa angka.',
            'nim.unique' => 'NIM ini sudah terdaftar.',
            'nim.regex' => 'Pendaftaran ini hanya untuk mahasiswa Teknik Informasi.',
            'hp.numeric' => 'Nomor HP harus berupa angka.',
            'hp.unique' => 'Nomor HP ini sudah terdaftar.',
            'berkas_pendaftaran.required' => 'Berkas pendaftaran wajib diunggah.',
            'berkas_pendaftaran.mimes' => 'Format berkas harus berupa gambar (JPEG, PNG, JPG, GIF, atau SVG).',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('pendaftaran-photos', 'public');
        }

        $berkasPath = null;
        if ($request->hasFile('berkas_pendaftaran')) {
            $berkasPath = $request->file('berkas_pendaftaran')->store('pendaftaran-files', 'public');
        }

        Pendaftaran::create([
            'name' => $request->nama,
            'nim' => $request->nim,
            'hp' => $request->hp,
            'divisi_id' => $request->divisi_id,
            'alasan_bergabung' => $request->alasan,
            'gambar' => $gambarPath,
            'berkas_pendaftaran' => $berkasPath,
        ]);

        return redirect()->route('user.pendaftaran')->with('success', 'Pendaftaran berhasil! Terima kasih telah mendaftar.')->withFragment('pendaftaran-form');
    }
}
