@php
    use App\Models\Setting;
    use Illuminate\Support\Facades\Storage;

    $settings = Setting::all()->keyBy('key');

    // Default values if settings are not found
    $siteName = $settings['site_name']->value ?? 'HIMPUNAN MAHASISWA TEKNOLOGI INFORMASI D3';
    $tagline = $settings['deskripsi']->value ?? 'Wadah penggerak inovasi, kreativitas, dan solidaritas mahasiswa TI yang futuristik.';
    $logoUrl = ($settings['logo']->value ?? null) ? Storage::url($settings['logo']->value) : asset('assets/image/logo_hima.png');
    $visi = $settings['visi']->value ?? 'Menjadikan HIMA-TI sebagai wadah yang aktif, inovatif, dan berkarakter dalam pengembangan potensi mahasiswa Teknologi Informasi.';
    $misi = $settings['misi']->value ?? 'Meningkatkan solidaritas dan profesionalisme antaranggota.||Mengembangkan kemampuan teknis dan non-teknis mahasiswa TI.||Menjalin hubungan sinergis dengan berbagai pihak internal dan eksternal.||Mengadakan kegiatan yang mendukung perkembangan ilmu pengetahuan dan teknologi.';
    
    // Data Pengurus
    $namaKetua = $settings['nama_ketua']->value ?? 'Rizky Ramadhan';
    $fotoKetua = ($settings['foto_ketua']->value ?? null) ? Storage::url($settings['foto_ketua']->value) : asset('assets/image/profil.png');
    $namaWakil = $settings['nama_wakil']->value ?? 'Siti Aisyah';
    $fotoWakil = ($settings['foto_wakil']->value ?? null) ? Storage::url($settings['foto_wakil']->value) : asset('assets/image/profil.png');
    $namaSekretaris = $settings['nama_sekretaris']->value ?? 'Ahmad Zaki';
    $fotoSekretaris = ($settings['foto_sekretaris']->value ?? null) ? Storage::url($settings['foto_sekretaris']->value) : asset('assets/image/profil.png');
    $namaBendahara = $settings['nama_bendahara']->value ?? 'Nurul Huda';
    $fotoBendahara = ($settings['foto_bendahara']->value ?? null) ? Storage::url($settings['foto_bendahara']->value) : asset('assets/image/profil.png');
@endphp

@extends('layouts.user')

@section('title', $siteName)

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* CSS Variabel */
        :root {
            --primary-color: #0d6efd; /* Biru Baru */
            --primary-light: #408cfd; /* Varian lebih terang dari biru baru */
            --primary-dark: #0558d4;  /* Biru lebih gelap */
            --text-dark: #0f172a;
            --text-secondary: #64748b;
            --bg-page: #f0f8ff; /* Disesuaikan agar cocok dengan biru */
            --card-bg: #ffffff;
            --shadow-float: 0 10px 30px rgba(0, 0, 0, 0.04);
            --shadow-hero: 0 25px 60px rgba(13, 110, 253, 0.4); /* Bayangan Hero disesuaikan */
            --accent-bg: #e7f1ff; /* Aksen disesuaikan */
            --font-family: 'Inter', sans-serif; 
        }

        /* Gaya Umum - pastikan tidak menimpa layout utama */
        #main-content { /* Gunakan ID atau class dari layout utama jika ada */
            background-color: var(--bg-page);
            color: var(--text-dark);
            -webkit-font-smoothing: antialiased;
        }
    .profil-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 5rem 2rem;
        position: relative;
        z-index: 1;
    }

    /* Latar Belakang Geometris (Aero Effect) */
    .profil-container::before {
        content: '';
        position: absolute;
        top: 5%;
        left: 5%;
        width: 300px;
        height: 300px;
        background: var(--primary-light);
        filter: blur(100px);
        opacity: 0.3;
        border-radius: 50%;
        z-index: -1;
    }
    .profil-container::after {
        content: '';
        position: absolute;
        bottom: 10%;
        right: 10%;
        width: 400px;
        height: 400px;
        background: #fde047; /* Kuning Aksen */
        filter: blur(120px);
        opacity: 0.2;
        border-radius: 50%;
        z-index: -1;
    }
    
    /* Header dan Logo */
    .header-section {
        text-align: center;
        margin-bottom: 6rem;
    }

    .header-section h1 {
        color: var(--text-dark);
        font-weight: 900;
        font-size: 3.5rem; /* Ukuran disesuaikan */
        letter-spacing: -0.05em;
        line-height: 1.1;
        margin-bottom: 0.5rem;
    }
    
    .header-section .tagline {
        font-size: 1.25rem; /* Ukuran disesuaikan */
        color: var(--text-secondary);
        font-weight: 500;
        max-width: 700px;
        margin: 0 auto;
    }

    .profil-container .logo {
        display: block;
        margin: 0 auto 2rem;
        width: 200px; /* Diperbesar */
        height: 200px; /* Diperbesar */
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--card-bg); 
        box-shadow: 0 0 0 10px var(--accent-bg); /* Ring Aksen Luar */
    }

    /* Hero Section - Visi & Misi (Glass Effect) */
    .profil-container .hero {
        width: min(100%, 1150px);
        margin: 0 auto 6rem;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        color: var(--text-dark); 
        border-radius: 2rem; 
        padding: 4rem;
        box-shadow: var(--shadow-hero);
        position: relative;
    }
    
    .hero-content {
        z-index: 2;
        position: relative;
    }

    .hero-content h3 {
        font-size: 2rem;
        font-weight: 800;
        margin-top: 2rem;
        margin-bottom: 1rem;
        padding-left: 0.5rem;
        border-left: 5px solid var(--primary-color); 
        color: var(--primary-color);
    }
    
    .hero-content > p:first-of-type {
        font-size: 1.15rem;
        font-weight: 500;
        margin-bottom: 3rem;
    }
    
    /* Daftar Misi */
    .mission-list {
        list-style: none;
        padding: 0;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        margin-top: 1.5rem;
    }
    
    .mission-list li {
        position: relative;
        padding-left: 30px;
        font-size: 1rem;
        font-weight: 500;
    }

    .mission-list li::before {
        content: "💡"; 
        position: absolute;
        left: 0;
        font-size: 1em;
    }

    /* Grid Pengurus Inti */
    .section-title {
        text-align: center;
        font-size: 2.25rem; /* Ukuran disesuaikan */
        font-weight: 900;
        margin-bottom: 4rem;
        color: var(--text-dark);
        letter-spacing: -0.04em;
    }
    
    .profil-container .grid {
        display: grid;
        gap: 2.5rem;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    }

    /* Kartu Anggota */
    .profil-container .card {
        background: var(--card-bg);
        border-radius: 1.5rem; 
        padding: 2rem 1.5rem;
        text-align: center;
        transition: transform 0.4s cubic-bezier(0.19, 1, 0.22, 1), box-shadow 0.4s;
        box-shadow: var(--shadow-float);
        border: 1px solid #f1f5f9;
    }

    .profil-container .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(13, 110, 253, 0.2); /* Bayangan hover disesuaikan */
    }

    .pengurus-foto {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 1.5rem;
        border: 4px solid var(--accent-bg);
    }

    .profil-container .card .name {
        font-weight: 900;
        font-size: 1.2rem; /* Ukuran disesuaikan */
        margin-bottom: 0.5rem;
        color: var(--text-dark);
    }

    .profil-container .card .role {
        color: var(--primary-color); /* Warna utama */
        font-weight: 700;
        font-size: 1.05rem;
    }
    
    /* Media Query Responsif */
    @media(max-width: 768px) {
        .profil-container { padding: 3rem 1rem; }
        .header-section h1 { font-size: 3rem; }
        .profil-container .hero { padding: 2.5rem; }
        .mission-list { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="profil-container">

    <div class="header-section">
        <img class="logo" src="{{ $logoUrl }}" alt="Logo HIMA-TI">
        <h1>{{ $siteName }}</h1>
    </div>

    <div class="hero">
        <div class="hero-content">
            <p>
                {!! $tagline !!}
            </p>

            <h3>Visi</h3>
            <p>{{ $visi }}</p>

            <h3>Misi</h3>
            <ul class="mission-list">
                @foreach (explode('||', $misi) as $item)
                    <li>{{ trim($item) }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <h2 class="section-title">Struktur Kepengurusan Inti</h2>
    <div class="grid">
        <div class="card">
            <img class="pengurus-foto" src="{{ $fotoKetua }}" alt="Foto {{ $namaKetua }}">
            <div class="name">{{ $namaKetua }}</div>
            <div class="role">Ketua Umum</div>
        </div>

        <div class="card">
            <img class="pengurus-foto" src="{{ $fotoWakil }}" alt="Foto {{ $namaWakil }}">
            <div class="name">{{ $namaWakil }}</div>
            <div class="role">Wakil Ketua</div>
        </div>

        <div class="card">
            <img class="pengurus-foto" src="{{ $fotoSekretaris }}" alt="Foto {{ $namaSekretaris }}">
            <div class="name">{{ $namaSekretaris }}</div>
            <div class="role">Sekretaris Umum</div>
        </div>

        <div class="card">
            <img class="pengurus-foto" src="{{ $fotoBendahara }}" alt="Foto {{ $namaBendahara }}">
            <div class="name">{{ $namaBendahara }}</div>
            <div class="role">Bendahara Umum</div>
        </div>
    </div>
</div>
@endsection