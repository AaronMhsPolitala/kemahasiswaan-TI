<?php

namespace Database\Seeders;

use App\Models\Divisi;
use Illuminate\Database\Seeder;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Divisi::create([
            'nama_divisi' => 'Kaderisasi',
            'deskripsi' => 'Divisi yang bertanggung jawab atas proses kaderisasi dan pengembangan anggota.',
        ]);

        Divisi::create([
            'nama_divisi' => 'Media Informasi',
            'deskripsi' => 'Divisi yang bertanggung jawab atas pengelolaan media dan penyebaran informasi.',
        ]);

        Divisi::create([
            'nama_divisi' => 'Technopreneurship',
            'deskripsi' => 'Divisi yang berfokus pada pengembangan kewirausahaan di bidang teknologi.',
        ]);

        Divisi::create([
            'nama_divisi' => 'Public Relation',
            'deskripsi' => 'Divisi yang menjalin hubungan dengan pihak eksternal.',
        ]);
    }
}
