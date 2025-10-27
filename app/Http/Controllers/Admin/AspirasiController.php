<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use PDF;

class AspirasiController extends Controller
{
    public function index()
    {
        $aspirasis = Aspirasi::latest()->paginate(10);

        return view('admin.aspirasi.index', compact('aspirasis'));
    }

    public function show(Aspirasi $aspirasi)
    {
        return view('admin.aspirasi.show', compact('aspirasi'));
    }

    public function destroy(Aspirasi $aspirasi)
    {
        $aspirasi->delete();

        return back()->with('ok', 'Aspirasi berhasil dihapus');
    }

    public function printPdf()
    {
        $aspirasis = Aspirasi::latest()->get();
        $pdf = PDF::loadView('admin.aspirasi.pdf', ['aspirasis' => $aspirasis]);

        return $pdf->download('laporan-aspirasi.pdf');
    }
}
