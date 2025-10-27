<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Komentar;
use Illuminate\Http\Request;

class UserBeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::latest()->get();

        return view('user.berita', compact('beritas'));
    }

    public function show(Berita $berita)
    {
        return view('user.berita-show', compact('berita'));
    }

    public function storeKomentar(Request $request, Berita $berita)
    {
        $request->validate([
            'nama' => 'required',
            'isi_komentar' => 'required',
        ]);

        $komentar = new Komentar;
        $komentar->nama = $request->nama;
        $komentar->isi_komentar = $request->isi_komentar;
        $komentar->berita_id = $berita->id;
        $komentar->save();

        return back()->with('success', 'Komentar berhasil ditambahkan.')->withFragment('komentar-section');
    }
}
