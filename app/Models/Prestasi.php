<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim',
        'nama_mahasiswa',
        'ipk',
        'nama_kegiatan',
        'waktu_penyelenggaraan',
        'tingkat_kegiatan',
        'prestasi_yang_dicapai',
        'keterangan',
        'bukti_prestasi',
        'pembimbing',
    ];

    /**
     * Accessor: total_skor (menggunakan metode SAW)
     */
    public function getTotalSkorAttribute()
    {
        // =======================
        // 1. Dapatkan Bobot dari file JSON
        // =======================
        $weightsPath = storage_path('app/saw_weights.json');
        if (file_exists($weightsPath)) {
            $weights = json_decode(file_get_contents($weightsPath), true);
        } else {
            // Fallback default weights jika file tidak ada
            $weights = [
                'C1' => 0.40, // IPK
                'C2' => 0.30, // Tingkat Kegiatan
                'C3' => 0.30, // Prestasi
            ];
        }

        // =======================
        // 2. KONVERSI KE NILAI (x_ij)
        // =======================

        // C1 - IPK
        $skorIpk = (float) $this->ipk; // Range: 0 – 4

        // C2 - Tingkat Kegiatan
        $skorTingkatan = 0;
        switch ($this->tingkat_kegiatan) {
            case 'Internasional': $skorTingkatan = 5; break;
            case 'Nasional': $skorTingkatan = 4; break;
            case 'Provinsi': $skorTingkatan = 3; break;
            case 'Kabupaten/Kota': $skorTingkatan = 2; break;
            case 'Internal (Kampus)': $skorTingkatan = 1; break;
        }

        // C3 - Prestasi yang Dicapai
        $skorPrestasi = 0;
        switch ($this->prestasi_yang_dicapai) {
            case 'Juara 1': $skorPrestasi = 4; break;
            case 'Juara 2': $skorPrestasi = 3; break;
            case 'Juara 3': $skorPrestasi = 2; break;
            default: $skorPrestasi = 1; break; // Lainnya / Partisipan
        }

        // =======================
        // 3. NORMALISASI (r_ij) - r_ij = x_ij / max(x_j)
        // =======================

        $rIpk        = $skorIpk > 0 ? $skorIpk / 4 : 0;          // max IPK adalah 4
        $rTingkatan  = $skorTingkatan > 0 ? $skorTingkatan / 5 : 0; // max skor tingkatan adalah 5
        $rPrestasi   = $skorPrestasi > 0 ? $skorPrestasi / 4 : 0;   // max skor prestasi adalah 4

        // =======================
        // 4. NILAI PREFERENSI (V_i) - V_i = Σ(w_j * r_ij)
        // =======================

        $totalSkorSaw =
            ($rIpk * $weights['C1']) +
            ($rTingkatan * $weights['C2']) +
            ($rPrestasi * $weights['C3']);

        return $totalSkorSaw;
    }
}
