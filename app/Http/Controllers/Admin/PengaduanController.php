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
                    ->orWhere('nama', 'like', '%'.$request->search.'%')
                    ->orWhere('nim_terlapor', 'like', '%'.$request->search.'%')
                    ->orWhere('nama_terlapor', 'like', '%'.$request->search.'%');
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
        $pdf = PDF::loadView('admin.bermasalah.pdf', compact('pengaduans'))->setPaper('a4', 'landscape');
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

        $columns = array('NIM Pelapor', 'Nama Pelapor', 'NIM Terlapor', 'Nama Terlapor', 'Status Terlapor', 'Jenis Masalah', 'Jenis Pelanggaran / Keterangan', 'Status');

        $callback = function() use($pengaduans, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($pengaduans as $pengaduan) {
                fputcsv($file, [
                    $pengaduan->nim ?? 'Anonim',
                    $pengaduan->nama ?? 'Anonim',
                    $pengaduan->nim_terlapor ?? 'N/A',
                    $pengaduan->nama_terlapor ?? 'N/A',
                    $pengaduan->status_terlapor ?? 'N/A',
                    $pengaduan->jenis_masalah,
                    $pengaduan->keterangan,
                    $pengaduan->status
                ]);
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
            'status' => 'required|string|in:pending,ditanggapi,selesai',
        ]);

        $mahasiswa_bermasalah->update(['status' => $request->status]);

        return redirect()->route('admin.mahasiswa-bermasalah.index')->with('success', 'Status pengaduan berhasil diperbarui.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|numeric',
            'nama_terlapor' => 'required|string|max:255',
            'nim_terlapor' => 'required|numeric',
            'status_terlapor' => 'required|string|max:255',
            'jenis_masalah' => 'required|string|max:255',
            'jenis_pelanggaran' => 'required|string|max:255',
            'keterangan_tambahan' => 'nullable|string',
            'persetujuan' => 'required|accepted',
        ]);

        $data = $request->only(['nama', 'nim', 'nama_terlapor', 'nim_terlapor', 'status_terlapor', 'jenis_masalah']);
        
        $keterangan = $request->jenis_pelanggaran;
        if ($request->jenis_pelanggaran === 'Lainnya' && $request->filled('keterangan_tambahan')) {
            $keterangan .= ' - ' . $request->keterangan_tambahan;
        }
        $data['keterangan'] = $keterangan;

        $data['kode_tiket'] = Str::random(10);
        $data['status'] = 'pending';

        Pengaduan::create($data);

        return redirect()->back()->with('success', 'Pengaduan Anda telah berhasil dikirim.');
    }
}