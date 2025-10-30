<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PDF;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengaduan::query();

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nim', 'like', '%'.$request->search.'%')
                    ->orWhere('nama', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->has('jenis_masalah') && $request->jenis_masalah != '') {
            $query->where('jenis_masalah', $request->jenis_masalah);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $pengaduans = $query->latest()->paginate(10);

        return view('admin.bermasalah.index', compact('pengaduans'));
    }

    public function exportPdf()
    {
        $pengaduans = Pengaduan::all();
        $pdf = PDF::loadView('admin.bermasalah.pdf', compact('pengaduans'));
        return $pdf->download('laporan-mahasiswa-bermasalah.pdf');
    }

    public function exportCsv()
    {
        $pengaduans = Pengaduan::all();
        $fileName = 'pengaduan.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('NIM', 'Nama', 'Jenis Masalah', 'Keterangan', 'Status');

        $callback = function() use($pengaduans, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($pengaduans as $pengaduan) {
                $row['NIM']  = $pengaduan->nim;
                $row['Nama']    = $pengaduan->nama;
                $row['Jenis Masalah']    = $pengaduan->jenis_masalah;
                $row['Keterangan']  = $pengaduan->keterangan;
                $row['Status']  = $pengaduan->status;

                fputcsv($file, array($row['NIM'], $row['Nama'], $row['Jenis Masalah'], $row['Keterangan'], $row['Status']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    public function create()
    {
        return view('admin.bermasalah.create');
    }

    public function destroy(Pengaduan $mahasiswa_bermasalah)
    {
        $mahasiswa_bermasalah->delete();

        return redirect()->route('admin.mahasiswa-bermasalah.index')->with('success', 'Pengaduan berhasil dihapus.');
    }

    public function edit(Pengaduan $mahasiswa_bermasalah)
    {
        return view('admin.bermasalah.edit', ['pengaduan' => $mahasiswa_bermasalah]);
    }

    public function update(Request $request, Pengaduan $mahasiswa_bermasalah)
    {
        $request->validate([
            'nim' => 'required_if:anonim,false|string|max:255',
            'nama' => 'required_if:anonim,false|string|max:255',
            'semester' => 'required_if:anonim,false|integer|min:1',
            'jenis_masalah' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'kontak_pengadu' => 'nullable|string|max:255',
            'status' => 'required|string|in:pending,ditanggapi,selesai',
        ]);

        $mahasiswa_bermasalah->update($request->all());

        return redirect()->route('admin.mahasiswa-bermasalah.index')->with('success', 'Data pengaduan berhasil diperbarui.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required_if:anonim,false|numeric',
            'nama' => 'required_if:anonim,false|string|max:255',
            'semester' => 'required_if:anonim,false|integer|min:1',
            'jenis_masalah' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'kontak_pengadu' => 'nullable|string|max:255',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'anonim' => 'nullable|boolean',
        ]);

        $data = $request->all();

        if ($request->hasFile('lampiran')) {
            $path = $request->file('lampiran')->store('lampiran-pengaduan', 'public');
            $data['lampiran'] = $path;
        }

        $data['kode_tiket'] = Str::random(10);

        if ($request->has('anonim')) {
            $data['nim'] = null;
            $data['nama'] = null;
            $data['semester'] = null;
        }

        Pengaduan::create($data);

        return redirect()->route('admin.mahasiswa-bermasalah.index')->with('success', 'Pengaduan berhasil ditambahkan.');
    }
}