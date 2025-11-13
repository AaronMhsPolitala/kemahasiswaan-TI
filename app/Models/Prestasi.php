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
        // 1. KONVERSI KE NILAI (x_ij)
        // =======================

        // C1 - Tingkatan
        $skorTingkatan = 0;
        switch ($this->tingkat_kegiatan) {
            case 'Internasional':
                $skorTingkatan = 30;
                break;
            case 'Nasional':
                $skorTingkatan = 24;
                break;
            case 'Provinsi/Wilayah':
            case 'Provinsi': // disesuaikan dengan pilihan di controller/form
                $skorTingkatan = 18;
                break;
            case 'Kabupaten/Kota':
                $skorTingkatan = 12;
                break;
            case 'Internal (Kampus)':
                $skorTingkatan = 6;
                break;
            default:
                $skorTingkatan = 0;
                break;
        }

        // C2 - Juara
        $skorJuara = 0;
        switch ($this->prestasi_yang_dicapai) {
            case 'Juara 1':
                $skorJuara = 20;
                break;
            case 'Juara 2':
                $skorJuara = 15;
                break;
            case 'Juara 3':
                $skorJuara = 10;
                break;
            default: // Lainnya / Partisipan
                $skorJuara = 5;
                break;
        }

        // C3 - IPK
        $skorIpk = (float) $this->ipk; // 0 – 4

        // C4 - Keterangan/Bukti
        $skorBukti = 0;
        if ($this->keterangan === 'Akademik') {
            $skorBukti = $this->bukti_prestasi ? 10 : 5;
        } elseif ($this->keterangan === 'Non-Akademik') {
            $skorBukti = $this->bukti_prestasi ? 8 : 3;
        }

        // =======================
        // 2. NORMALISASI (r_ij)
        //    r_ij = x_ij / max(x_j)
        // =======================

        $rTingkatan = $skorTingkatan > 0 ? $skorTingkatan / 30 : 0; // max 30
        $rJuara     = $skorJuara     > 0 ? $skorJuara     / 20 : 0; // max 20
        $rIpk       = $skorIpk       > 0 ? $skorIpk       / 4  : 0; // max 4.00
        $rBukti     = $skorBukti     > 0 ? $skorBukti     / 10 : 0; // max 10

        // =======================
        // 3. BOBOT SAW
        // =======================
        $wTingkatan = 0.25;
        $wJuara     = 0.44;
        $wIpk       = 0.17;
        $wBukti     = 0.12;

        // =======================
        // 4. NILAI PREFERENSI (V_i)
        // =======================

        $totalSkorSaw =
            ($rTingkatan * $wTingkatan) +
            ($rJuara     * $wJuara) +
            ($rIpk       * $wIpk) +
            ($rBukti     * $wBukti);

        // Kalau mau dinormalisasi ke 0–100, bisa pakai:
        // return $totalSkorSaw * 100;

        return $totalSkorSaw;
    }
}
