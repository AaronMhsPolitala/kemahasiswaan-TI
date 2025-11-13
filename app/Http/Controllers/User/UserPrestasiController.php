<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class UserPrestasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Prestasi::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_mahasiswa', 'like', "%{$search}%")
                    ->orWhere('nim', 'like', "%{$search}%")
                    ->orWhere('nama_kegiatan', 'like', "%{$search}%");
            });
        }

        // Filter
        if ($request->filled('tingkat_kegiatan')) {
            $query->where('tingkat_kegiatan', $request->tingkat_kegiatan);
        }
        if ($request->filled('keterangan')) {
            $query->where('keterangan', $request->keterangan);
        }

        // Get all matching results, then sort by the accessor
        $allPrestasis = $query->get();
        $sortedPrestasis = $allPrestasis->sortByDesc('total_skor');

        // Manually create a paginator
        $page = Paginator::resolveCurrentPage('page');
        $perPage = 10;
        $currentPagePrestasis = $sortedPrestasis->slice(($page - 1) * $perPage, $perPage)->all();
        $prestasis = new LengthAwarePaginator($currentPagePrestasis, $sortedPrestasis->count(), $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);

        // Data for filters
        $tingkat_kegiatans = ['Internal (Kampus)', 'Kabupaten/Kota', 'Provinsi', 'Nasional', 'Internasional'];
        $keterangans = ['Akademik', 'Non-Akademik'];

        return view('user.prestasi', compact('prestasis', 'tingkat_kegiatans', 'keterangans'));
    }
}
