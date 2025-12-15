<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DivisiController extends Controller
{
    public function index()
    {
        $divisis = Divisi::latest()->paginate(10);

        return view('admin.divisi.index', compact('divisis'));
    }

    public function create()
    {
        return view('admin.divisi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_divisi' => 'required|string|max:255|unique:divisis,nama_divisi',
            'deskripsi' => 'required|string',
            'photo_divisi' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'nama_divisi.unique' => 'Nama divisi ini sudah ada. Mohon gunakan nama lain.',
        ]);

        $data = [
            'nama_divisi' => $request->nama_divisi,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('photo_divisi')) {
            $data['photo_divisi'] = $request->file('photo_divisi')->store('divisi', 'public');
        }

        Divisi::create($data);

        return redirect()->route('admin.divisi.index')->with('success', 'Divisi berhasil ditambahkan.');
    }

    public function show(Divisi $divisi)
    {
        return view('admin.divisi.show', compact('divisi'));
    }

    public function edit(Divisi $divisi)
    {
        return view('admin.divisi.edit', compact('divisi'));
    }

    public function update(Request $request, Divisi $divisi)
    {
        $request->validate([
            'nama_divisi' => ['required', 'string', 'max:255', Rule::unique('divisis')->ignore($divisi->id)],
            'deskripsi' => 'required|string',
            'photo_divisi' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'nama_divisi.unique' => 'Nama divisi ini sudah ada. Mohon gunakan nama lain.',
        ]);

        $data = [
            'nama_divisi' => $request->nama_divisi,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('photo_divisi')) {
            if ($divisi->photo_divisi) {
                Storage::disk('public')->delete($divisi->photo_divisi);
            }
            $data['photo_divisi'] = $request->file('photo_divisi')->store('divisi', 'public');
        }

        $divisi->update($data);

        return redirect()->route('admin.divisi.index')->with('success', 'Divisi berhasil diperbarui.');
    }

    public function destroy(Divisi $divisi)
    {
        if ($divisi->photo_divisi) {
            Storage::disk('public')->delete($divisi->photo_divisi);
        }
        $divisi->delete();

        return redirect()->route('admin.divisi.index')->with('success', 'Divisi berhasil dihapus.');
    }
}

