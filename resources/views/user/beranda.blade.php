@extends('layouts.user')

@section('title', 'Beranda')

@section('content')
        <!-- HERO -->
        <div class="hero-wrapper">
            <section class="hero-bg">
                        <div class="hero-content-wrapper">
                            <div>
                                <div class="hero-badge">
                                    <span class="hero-badge-dot"></span>
                                    HMTI • TEKNOLOGI INFORMASI D3 • POLITALA
                                </div>
            
                                <h1 class="hero-title">
                                    HIMPUNAN MAHASISWA<br>
                                    <span>TEKNOLOGI INFORMASI D3</span>
                                </h1>
            
                                <p class="hero-desc">
                                    HMTI Politeknik Negeri Tanah Laut (POLITALA) adalah organisasi kemahasiswaan yang bergerak di bidang
                                    teknologi informasi, berlandaskan semangat kolaborasi, inovasi, dan profesionalisme.
                                </p>
            
                                <div class="hero-actions">
                                    <a href="{{ route('user.divisi') }}" class="btn-cta">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M5 12h14M13 5l7 7-7 7"/>
                                        </svg>
                                        Jelajahi Divisi Kami
                                    </a>
                                    <span class="hero-subinfo">
                                        Kenali struktur, divisi, dan agenda kegiatan HMTI secara terpusat.
                                    </span>
                                </div>
            
                                <div class="hero-stats">
                                    <div class="hero-stat">
                                        <div class="hero-stat-label">Acara Terpantau</div>
                                        <div class="hero-stat-value">Event HMTI &amp; Prodi TI</div>
                                    </div>
                                    <div class="hero-stat">
                                        <div class="hero-stat-label">Informasi Akademik</div>
                                        <div class="hero-stat-value">Program Studi TI D3</div>
                                    </div>
                                    <div class="hero-stat">
                                        <div class="hero-stat-label">Aspirasi Online</div>
                                        <div class="hero-stat-value">Satu pintu pengaduan</div>
                                    </div>
                                </div>
                            </div>
                            <div class="hero-logo-wrapper">
                                <img src="{{ asset('assets/image/Logo_Politala_segi_lima.png') }}" alt="Logo Politala" class="hero-logo">
                            </div>
                        </div>
                    </section>
            <!-- Divider wave -->
            <div class="hero-divider">
                <svg preserveAspectRatio="none" viewBox="0 0 1200 120">
                    <path d="M0,0V46.29c47.29,22.24,103.78,29.58,158,23.39
                             C230,61.56,284,39.77,339,28c54-11.44,108-11.78,162,1.29
                             C556,44.21,610,72.08,664,80c54,8.39,108-1.31,162-14.15
                             C880,52,934,35.24,988,33.78c70-1.91,140,16.54,212,35.84V0Z"
                          opacity=".25" fill="#ffffff"></path>
                    <path d="M0,0V16.81C47.29,35,103.78,47.12,158,45.2
                             C230,42.65,284,24.7,339,16.81c54-7.95,108-9,162,1.29
                             C556,30.44,610,52,664,58.39c54,6.63,108-.74,162-8.39
                             C880,42,934,30.09,988,27.24c70-3.84,140,4.32,212,13.12V0Z"
                          opacity=".5" fill="#ffffff"></path>
                    <path d="M0,0V5.63C47.29,19.89,103.78,31,158,33.49
                             C230,36.61,284,31.17,339,25.8c54-5.16,108-10,162-3.56
                             C556,28.64,610,44.66,664,49.35c54,4.77,108-.41,162-7.12
                             C880,35,934,23.24,988,19.92c70-4.87,140-2.18,212,7V0Z"
                          fill="#ffffff"></path>
                </svg>
            </div>
        </div>

        <!-- INFO SECTION -->
        <section class="info" id="informasi">
            <div class="info-inner">
                <h2>Pusat <span class="highlight-yellow">Informasi</span> Seputar Program</h2>
                <h3>Studi Teknologi Informasi</h3>
                <p>
                    Dengan website ini, kalian bisa memantau acara mendatang ataupun yang sedang berlangsung di HMTI.
                    Kalian juga dapat mencari informasi mengenai program studi Teknologi Informasi, termasuk peminatan,
                    kurikulum, dan prospek karir yang bisa ditempuh setelah lulus.
                </p>

                <div class="info-cards">
                    <div class="info-card">
                        <div class="info-card-content">
                            <div class="info-card-icon-wrapper">
                                <svg class="info-card-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 
                                          2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 
                                          0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0h18M12 
                                          12.75h.008v.008H12v-.008Z" />
                                </svg>
                            </div>
                            <h4>Kegiatan &amp; Acara</h4>
                            <p>
                                Pantau semua kegiatan dan acara yang akan datang dari HMTI. Jangan lewatkan kesempatan untuk
                                berpartisipasi, memperluas relasi, dan mendapatkan pengalaman baru di lingkungan TI.
                            </p>
                            <div class="info-card-tag">
                                <span class="info-card-tag-dot"></span> Jadwal event, seminar, &amp; pelatihan
                            </div>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-card-content">
                            <div class="info-card-icon-wrapper">
                                <svg class="info-card-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path
                                        d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.627 48.627 
                                        0 0 1 12 20.904a48.627 48.627 0 0 1 8.232-4.41 60.46 60.46 
                                        0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 
                                        59.906 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 
                                        0A50.697 50.697 0 0 1 12 13.489a50.702 50.702 0 0 1 
                                        7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 
                                        1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 
                                        11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                                </svg>
                            </div>
                            <h4>Informasi Program Studi</h4>
                            <p>
                                Dapatkan informasi lengkap mengenai program studi Teknologi Informasi: kurikulum,
                                peminatan yang tersedia, hingga gambaran skill yang dikembangkan selama perkuliahan.
                            </p>
                            <div class="info-card-tag">
                                <span class="info-card-tag-dot"></span> Kurikulum &amp; peminatan TI
                            </div>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-card-content">
                            <div class="info-card-icon-wrapper">
                                <svg class="info-card-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M20.25 8.511c.884.284 1.5 1.128 1.5 
                                          2.097v4.286c0 1.136-.847 2.1-1.98 
                                          2.193l-3.722.28c-.428.032-.85.174-1.227.387-.5.284-1.096.464-1.723.464H8.25c-.627 
                                          0-1.223-.18-1.723-.464-.377-.213-.8-.355-1.227-.387l-3.722-.28A2.25 
                                          2.25 0 0 1 .75 15.182V10.9c0-.97.616-1.813 
                                          1.5-2.097L6 7.5l.6-2.251.815-.306a2.25 2.25 0 0 1 
                                          2.25 0l.815.306.6 2.251 3.15-.945ZM8.25 
                                          9.75h7.5M8.25 12h7.5M8.25 14.25h7.5M12 
                                          16.5h.008v.008H12v-.008Z" />
                                </svg>
                            </div>
                            <h4>Aspirasi &amp; Pengaduan</h4>
                            <p>
                                Sampaikan aspirasi, kritik, dan saran Anda untuk HMTI yang lebih baik melalui kanal aspirasi
                                dan pengaduan yang terintegrasi dengan sistem ini.
                            </p>
                            <div class="info-card-tag">
                                <span class="info-card-tag-dot"></span> Suara mahasiswa TI D3
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-footer">
                    <div class="info-steps">
                        <div class="info-step">
                            <span class="info-step-number">1</span>
                            <span>Buka event &amp; info prodi yang kamu butuhkan.</span>
                        </div>
                        <div class="info-step">
                            <span class="info-step-number">2</span>
                            <span>Ikuti kegiatan atau baca detail program.</span>
                        </div>
                        <div class="info-step">
                            <span class="info-step-number">3</span>
                            <span>Sampaikan aspirasi untuk perbaikan HMTI.</span>
                        </div>
                    </div>
                    <span>
                        Portal ini dirancang untuk menjadi satu pintu informasi teknologi informasi di lingkungan HMTI POLITALA.
                    </span>
                </div>
            </div>
        </section>
@endsection
