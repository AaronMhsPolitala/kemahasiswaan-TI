<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use PDF;

class AspirasiController extends Controller
{
    public function index()
    {
        $aspirasis = Aspirasi::latest()->paginate(10);

        return view('pengurus.aspirasi.index', compact('aspirasis'));
    }

    public function show(Aspirasi $aspirasi)
    {
        return view('pengurus.aspirasi.show', compact('aspirasi'));
    }

    public function destroy(Aspirasi $aspirasi)
    {
        $aspirasi->delete();

        return back()->with('ok', 'Aspirasi berhasil dihapus');
    }

    public function printPdf()
    {
        $aspirasis = Aspirasi::latest()->get();
        $pdf = PDF::loadView('pengurus.aspirasi.pdf', ['aspirasis' => $aspirasis]);

        return $pdf->download('laporan-aspirasi.pdf');
    }
}
