<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the table to start fresh
        Berita::truncate();

        // Create a placeholder image on the public disk
        $directory = 'berita';
        $path = $directory.'/placeholder.svg';
        Storage::disk('public')->makeDirectory($directory);
        $svgContent = '<svg width="600" height="400" xmlns="http://www.w3.org/2000/svg"><rect width="600" height="400" style="fill: #e9ecef;" /><text x="50%" y="50%" font-family="Arial" font-size="30" fill="#6c757d" text-anchor="middle" dy=".3em">600x400</text></svg>';
        Storage::disk('public')->put($path, $svgContent);

        // Now, run the factory
        Berita::factory()->count(5)->create();
    }
}
