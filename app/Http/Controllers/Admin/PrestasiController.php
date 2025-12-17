<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use PDF;

class PrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        // Get all matching results
        $allPrestasis = $query->get();

        // Sort by SAW score (accessor total_skor di Model)
        $sortedPrestasis = $allPrestasis->sortByDesc('total_skor');

        // Manual Pagination
        $page = $request->get('page', 1);
        $perPage = 10;
        $offset = ($page * $perPage) - $perPage;

        $prestasis = new LengthAwarePaginator(
            $sortedPrestasis->slice($offset, $perPage),
            $sortedPrestasis->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Data for filters
        $tingkat_kegiatans = ['Internal (Kampus)', 'Kabupaten/Kota', 'Provinsi', 'Nasional', 'Internasional'];
        $keterangans = ['Akademik', 'Non-Akademik'];

        return view('admin.prestasi.index', compact('prestasis', 'tingkat_kegiatans', 'keterangans'));
    }

    public function saw()
    {
        $weightsPath = storage_path('app/saw_weights.json');
        if (file_exists($weightsPath)) {
            $weights = json_decode(file_get_contents($weightsPath), true);
        } else {
            // Default weights
            $weights = [
                'C1' => 0.40, // IPK
                'C2' => 0.30, // Tingkat Kegiatan
                'C3' => 0.30, // Prestasi
            ];
        }

        return view('admin.prestasi.saw', compact('weights'));
    }

    public function updateSaw(Request $request)
    {
        $validated = $request->validate([
            'weights' => 'required|array',
            'weights.*' => 'required|numeric|min:0|max:1',
        ]);

        $totalWeight = array_sum($validated['weights']);

        if (round($totalWeight, 2) != 1.00) {
            return back()->withErrors(['weights' => 'Total bobot harus sama dengan 1.'])->withInput();
        }

        $weightsPath = storage_path('app/saw_weights.json');
        file_put_contents($weightsPath, json_encode($validated['weights'], JSON_PRETTY_PRINT));

        return redirect()->route('admin.prestasi.saw')->with('success', 'Bobot SAW berhasil diperbarui.');
    }

    public function exportPdf()
    {
        // Urutkan juga berdasarkan SAW
        $prestasis = Prestasi::all()->sortByDesc('total_skor');

        $pdf = PDF::loadView('admin.prestasi.pdf', compact('prestasis'))->setPaper('a4', 'landscape');
        return $pdf->download('laporan-prestasi.pdf');
    }

    public function exportCsv()
    {
        // Urutkan juga berdasarkan SAW
        $prestasis = Prestasi::all()->sortByDesc('total_skor');

        $fileName = 'prestasi.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array(
            'NIM',
            'Nama Mahasiswa',
            'IPK',
            'Nama Kegiatan',
            'Waktu Penyelenggaraan',
            'Tingkat Kegiatan',
            'Prestasi yang Dicapai',
            'Keterangan'
            // Kalau mau tambah: 'Total Skor SAW'
        );

        $callback = function() use ($prestasis, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($prestasis as $prestasi) {
                $row['NIM']                    = $prestasi->nim;
                $row['Nama Mahasiswa']         = $prestasi->nama_mahasiswa;
                $row['IPK']                    = $prestasi->ipk;
                $row['Nama Kegiatan']          = $prestasi->nama_kegiatan;
                $row['Waktu Penyelenggaraan']  = $prestasi->waktu_penyelenggaraan;
                $row['Tingkat Kegiatan']       = $prestasi->tingkat_kegiatan;
                $row['Prestasi yang Dicapai']  = $prestasi->prestasi_yang_dicapai;
                $row['Keterangan']             = $prestasi->keterangan;

                fputcsv($file, [
                    $row['NIM'],
                    $row['Nama Mahasiswa'],
                    $row['IPK'],
                    $row['Nama Kegiatan'],
                    $row['Waktu Penyelenggaraan'],
                    $row['Tingkat Kegiatan'],
                    $row['Prestasi yang Dicapai'],
                    $row['Keterangan'],
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tingkat_kegiatans = ['Internal (Kampus)', 'Kabupaten/Kota', 'Provinsi', 'Nasional', 'Internasional'];
        $keterangans = ['Akademik', 'Non-Akademik'];

        return view('admin.prestasi.create', compact('tingkat_kegiatans', 'keterangans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nim' => 'required|numeric',
            'nama_mahasiswa' => 'required|string|max:255',
            'ipk' => 'required|numeric|between:0,4.00',
            'nama_kegiatan' => 'required|string|max:255',
            'waktu_penyelenggaraan' => 'required|date',
            'tingkat_kegiatan' => [
                'required',
                Rule::in(['Internal (Kampus)', 'Kabupaten/Kota', 'Provinsi', 'Nasional', 'Internasional'])
            ],
            'prestasi_yang_dicapai' => 'required|string|max:255',
            'keterangan' => ['required', Rule::in(['Akademik', 'Non-Akademik'])],
            'bukti_prestasi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'pembimbing' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('bukti_prestasi')) {
            $path = $request->file('bukti_prestasi')->store('prestasi', 'public');
            $validatedData['bukti_prestasi'] = $path;
        }

        $newPrestasi = Prestasi::create($validatedData);

        // --- Logic to find the page of the new record ---
        $allPrestasis = Prestasi::all()->sortByDesc('total_skor')->values();
        $position = $allPrestasis->search(function ($prestasi) use ($newPrestasi) {
            return $prestasi->id === $newPrestasi->id;
        });

        $perPage = 10; // Same as in index method
        $page = floor($position / $perPage) + 1;

        return redirect()->route('admin.prestasi.index', ['page' => $page])
                         ->with('success', 'Data prestasi berhasil ditambahkan.')
                         ->with('spotlight', $newPrestasi->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Prestasi $prestasi)
    {
        return view('admin.prestasi.show', compact('prestasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prestasi $prestasi)
    {
        $tingkat_kegiatans = ['Internal (Kampus)', 'Kabupaten/Kota', 'Provinsi', 'Nasional', 'Internasional'];
        $keterangans = ['Akademik', 'Non-Akademik'];

        return view('admin.prestasi.edit', compact('prestasi', 'tingkat_kegiatans', 'keterangans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prestasi $prestasi)
    {
        $validatedData = $request->validate([
            'nim' => 'required|numeric',
            'nama_mahasiswa' => 'required|string|max:255',
            'ipk' => 'required|numeric|between:0,4.00',
            'nama_kegiatan' => 'required|string|max:255',
            'waktu_penyelenggaraan' => 'required|date',
            'tingkat_kegiatan' => [
                'required',
                Rule::in(['Internal (Kampus)', 'Kabupaten/Kota', 'Provinsi', 'Nasional', 'Internasional'])
            ],
            'prestasi_yang_dicapai' => 'required|string|max:255',
            'keterangan' => ['required', Rule::in(['Akademik', 'Non-Akademik'])],
            'bukti_prestasi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'pembimbing' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('bukti_prestasi')) {
            // Delete old file
            if ($prestasi->bukti_prestasi) {
                Storage::disk('public')->delete($prestasi->bukti_prestasi);
            }
            // Store new file
            $path = $request->file('bukti_prestasi')->store('prestasi', 'public');
            $validatedData['bukti_prestasi'] = $path;
        }

        $prestasi->update($validatedData);

        return redirect()->route('admin.prestasi.index')->with('success', 'Data prestasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prestasi $prestasi)
    {
        // Delete file
        if ($prestasi->bukti_prestasi) {
            Storage::disk('public')->delete($prestasi->bukti_prestasi);
        }

        $prestasi->delete();

        return redirect()->route('admin.prestasi.index')->with('success', 'Data prestasi berhasil dihapus.');
    }
}
