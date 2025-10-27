<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::latest()->paginate(10);

        return view('pengurus.berita.index', compact('beritas'));
    }

    public function create()
    {
        return view('pengurus.berita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_berita' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto_berita' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $path = $request->file('foto_berita')->store('berita', 'public');

        Berita::create([
            'judul_berita' => $request->judul_berita,
            'deskripsi' => $request->deskripsi,
            'foto_berita' => $path,
        ]);

        return redirect()->route('pengurus.berita.index')->with('ok', 'Berita berhasil ditambahkan.');
    }

    public function show(Berita $beritum)
    {
        return view('pengurus.berita.show', ['berita' => $beritum]);
    }

    public function edit(Berita $beritum)
    {
        return view('pengurus.berita.edit', ['berita' => $beritum]);
    }

    public function update(Request $request, Berita $beritum)
    {
        $request->validate([
            'judul_berita' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto_berita' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = [
            'judul_berita' => $request->judul_berita,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('foto_berita')) {
            // Hapus foto lama
            Storage::disk('public')->delete($beritum->foto_berita);

            // Simpan foto baru
            $path = $request->file('foto_berita')->store('berita', 'public');
            $data['foto_berita'] = $path;
        }

        $beritum->update($data);

        return redirect()->route('pengurus.berita.index')->with('ok', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $beritum)
    {
        Storage::disk('public')->delete($beritum->foto_berita);
        $beritum->delete();

        return redirect()->route('pengurus.berita.index')->with('ok', 'Berita berhasil dihapus.');
    }
}
