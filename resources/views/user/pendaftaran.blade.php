@extends('layouts.user')

@section('title', 'Pendaftaran Pengurus HIMA TI')

@push('styles')
<style>
    :root {
        --primary: #2563eb;
        --primary-dark: #1d4ed8;
        --bg-body: #f3f4f6;
        --text-main: #111827;
        --text-muted: #6b7280;
        --border-soft: #e5e7eb;
    }

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI",
            sans-serif;
        background-color: var(--bg-body);
        color: var(--text-main);
    }

    .page-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-pendaftaran {
        position: relative;
        max-width: 960px;
        width: 100%;
        background-color: #ffffff;
        border-radius: 1.4rem;
        padding: 2.3rem 2rem;
        border: 1px solid var(--border-soft);
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.07);
    }

    /* Icon dekoratif di pojok kanan atas */
    .corner-icon {
        position: absolute;
        right: 22px;
        top: 20px;
        font-size: 2.6rem;
        color: rgba(37, 99, 235, 0.12);
    }

    .header-main {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 1.25rem;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.75rem;
        padding: 0.4rem 0.75rem;
        border-radius: 999px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1d4ed8;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 600;
    }

    .badge-status i {
        font-size: 0.9rem;
    }

    .title-main {
        font-size: 1.65rem;
        font-weight: 700;
        color: var(--text-main);
        margin-top: 0.6rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .title-main i {
        color: var(--primary);
    }

    .subtitle-main {
        font-size: 0.95rem;
        color: var(--text-muted);
        max-width: 32rem;
        margin-top: 0.25rem;
    }

    .meta-info {
        text-align: right;
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .meta-info i {
        margin-right: 0.35rem;
        color: var(--primary);
    }

    .meta-info strong {
        color: var(--text-main);
    }

    .divider-soft {
        border: none;
        border-top: 1px solid var(--border-soft);
        margin: 1.25rem 0 1.5rem;
    }

    .form-label {
        font-size: 0.86rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.35rem;
        display: flex;
        align-items: center;
        gap: 0.45rem;
    }

    .form-label i {
        color: var(--primary);
    }

    .form-label span.required {
        color: #ef4444;
        margin-left: 0.15rem;
    }

    .form-control,
    .form-select,
    textarea.form-control {
        background-color: #ffffff;
        border-radius: 0.8rem;
        border: 1px solid #d1d5db;
        color: var(--text-main);
        font-size: 0.9rem;
        padding: 0.75rem 0.9rem;
        transition: all 0.15s ease;
    }

    .form-control:focus,
    .form-select:focus,
    textarea.form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
    }

    .form-control::placeholder,
    textarea.form-control::placeholder {
        color: #9ca3af;
        font-size: 0.88rem;
    }

    .alert {
        border-radius: 0.75rem;
        padding: 0.7rem 0.9rem;
        font-size: 0.85rem;
        margin-bottom: 0.75rem;
    }

    .alert i {
        margin-right: 0.45rem;
    }

    .text-muted.small {
        font-size: 0.78rem !important;
    }

    .btn-submit-modern {
        border-radius: 999px;
        padding: 0.85rem 2rem;
        font-size: 0.9rem;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        border: none;
        outline: none;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        background-color: var(--primary);
        color: #ffffff;
        box-shadow: 0 12px 25px rgba(37, 99, 235, 0.35);
        cursor: pointer;
        transition: transform 0.12s ease, box-shadow 0.12s ease, background-color 0.12s ease;
    }

    .btn-submit-modern:hover {
        background-color: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 16px 30px rgba(37, 99, 235, 0.45);
    }

    .btn-submit-modern:active {
        transform: translateY(1px) scale(0.99);
        box-shadow: 0 8px 18px rgba(37, 99, 235, 0.35);
    }

    .note-footer {
        font-size: 0.78rem;
        color: var(--text-muted);
        margin-top: 0.8rem;
    }

    @media (max-width: 768px) {
        .card-pendaftaran {
            padding: 1.8rem 1.3rem;
        }

        .header-main {
            flex-direction: column;
        }

        .meta-info {
            text-align: left;
        }
    }

    /* CSS untuk overlay */
    .registration-closed-overlay,
    .login-required-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(5px);
        z-index: 10;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 2rem;
        border-radius: 1.4rem; /* Sesuaikan dengan border-radius card */
    }
    .registration-closed-message h4,
    .login-required-message h4 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #111827;
    }
    .registration-closed-message p,
    .login-required-message p {
        font-size: 1rem;
        color: #6b7280;
        margin-bottom: 1rem;
    }
    .login-required-message .btn-login {
        background-color: #3b82f6;
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s;
        text-decoration: none;
    }
    .login-required-message .btn-login:hover {
        background-color: #2563eb;
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
    <div class="card-pendaftaran">

        {{-- Logika Overlay Baru --}}
        @auth
            {{-- Prioritas 1: Jika pengguna adalah admin atau pengurus --}}
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'pengurus')
                <div class="login-required-overlay">
                    <div class="login-required-message">
                        <h4>Anda sudah menjadi {{ Auth::user()->role }}</h4>
                        <p>Anda tidak perlu mendaftar lagi.</p>
                    </div>
                </div>
            {{-- Prioritas 2: Jika pendaftaran ditutup (untuk pengguna biasa yang sudah login) --}}
            @elseif(!$registrationStatus || $registrationStatus->value == 'closed')
                <div class="registration-closed-overlay">
                    <div class="registration-closed-message">
                        <h4>Pendaftaran Belum Dibuka</h4>
                        <p>Pendaftaran belum dibuka pada saat ini. Tunggu info selanjutnya dari website kami.</p>
                    </div>
                </div>
            @endif
        @else
            {{-- Pengguna belum login (@guest) --}}
            {{-- Prioritas 3: Jika pendaftaran ditutup DAN belum login --}}
            @if (!$registrationStatus || $registrationStatus->value == 'closed')
                <div class="login-required-overlay">
                    <div class="login-required-message">
                        <h4>Pendaftaran Belum Dibuka</h4>
                        <p>Silakan login dulu dan tunggu pemberitahuan selanjutnya.</p>
                        <a href="{{ route('login') }}" class="btn-login">Login Sekarang</a>
                    </div>
                </div>
            @else
                {{-- Prioritas 4: Jika pendaftaran dibuka TAPI belum login --}}
                <div class="login-required-overlay">
                    <div class="login-required-message">
                        <h4>Anda Belum Login</h4>
                        <p>Silakan login terlebih dahulu untuk mengakses halaman pendaftaran.</p>
                        <a href="{{ route('login') }}" class="btn-login">Login Sekarang</a>
                    </div>
                </div>
            @endif
        @endguest

        <!-- Icon dekoratif pojok kanan -->
        <i class="fa-solid fa-layer-group corner-icon"></i>

        <!-- HEADER -->
        <div class="header-main">
            <div>
                <span class="badge-status">
                    <i class="fa-solid fa-user-gear"></i>
                    Pendaftaran Pengurus
                </span>

                <h1 class="title-main">
                    <i class="fa-solid fa-clipboard-list"></i>
                    Formulir Pendaftaran Pengurus HIMA TI
                </h1>

                <p class="subtitle-main">
                    Isi data diri kamu untuk bergabung menjadi bagian dari kepengurusan HIMA TI.
                    Form ini adalah contoh tampilan statis, tanpa proses simpan ke server.
                </p>
            </div>

            <div class="meta-info">
                @if($activePeriod)
                    <p>
                        <i class="fa-solid fa-calendar"></i>
                        Periode <strong>{{ $activePeriod }}</strong>
                    </p>
                @endif
                @if($registrationStatus && $registrationStatus->value == 'open')
                    <p>
                        <i class="fa-solid fa-circle-check" style="color: #16a34a;"></i>
                        Status:
                        <span style="color:#16a34a; font-weight:600;">Dibuka</span>
                    </p>
                @else
                    <p>
                        <i class="fa-solid fa-circle-xmark" style="color: #ef4444;"></i>
                        Status:
                        <span style="color:#ef4444; font-weight:600;">Ditutup</span>
                    </p>
                @endif
            </div>
        </div>



        <hr class="divider-soft" />

        <!-- FORM -->
        <form action="{{ route('user.pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row g-3">

                <div class="col-md-6">
                    <label for="nama" class="form-label">
                        <i class="fa-solid fa-user"></i>
                        Nama Lengkap <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        class="form-control @error('nama') is-invalid @enderror"
                        placeholder="Masukkan nama lengkap"
                        value="{{ old('nama') }}"
                        required
                    />
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="nim" class="form-label">
                        <i class="fa-solid fa-id-card"></i>
                        NIM <span class="required">*</span>
                    </label>
                    <input
                        type="number"
                        id="nim"
                        name="nim"
                        class="form-control @error('nim') is-invalid @enderror"
                        placeholder="Nomor Induk Mahasiswa"
                        value="{{ old('nim') }}"
                        required
                    />
                    @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="hp" class="form-label">
                        <i class="fa-solid fa-phone"></i>
                        Nomor WhatsApp Aktif <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="hp"
                        name="hp"
                        class="form-control @error('hp') is-invalid @enderror"
                        placeholder="08xxxxxxxxxx"
                        value="{{ old('hp') }}"
                        required
                    />
                    @error('hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="divisi" class="form-label">
                        <i class="fa-solid fa-users"></i>
                        Divisi Tujuan <span class="required">*</span>
                    </label>
                    <select
                        id="divisi"
                        name="divisi_id"
                        class="form-select @error('divisi_id') is-invalid @enderror"
                        required
                    >
                        <option value="" selected disabled>Pilih Divisi...</option>
                        @foreach($divisis as $div)
                            <option value="{{ $div->id }}" {{ old('divisi_id') == $div->id ? 'selected' : '' }}>{{ $div->nama_divisi }}</option>
                        @endforeach
                    </select>
                    @error('divisi_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="gambar" class="form-label">
                        <i class="fa-solid fa-image"></i>
                        Upload Foto Diri <span class="required">*</span>
                    </label>
                    <input
                        type="file"
                        id="gambar"
                        name="gambar"
                        class="form-control @error('gambar') is-invalid @enderror"
                        accept="image/*"
                        required
                    />
                    <div class="text-muted small mt-1">
                        Gunakan foto formal/rapi dengan latar jelas (maksimal 2 MB).
                    </div>
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Alasan Bergabung dipindah ke bawah dan dibuat full width -->
                <div class="col-12">
                    <label for="alasan" class="form-label">
                        <i class="fa-solid fa-pen"></i>
                        Alasan Bergabung <span class="required">*</span>
                    </label>
                    <textarea
                        id="alasan"
                        name="alasan"
                        class="form-control @error('alasan') is-invalid @enderror"
                        rows="6"
                        placeholder="Ceritakan motivasi, pengalaman organisasi, atau kontribusi yang ingin kamu berikan di HIMA TI..."
                        required
                    >{{ old('alasan') }}</textarea>
                    @error('alasan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn-submit-modern">
                    <i class="fa-solid fa-paper-plane"></i>
                    Kirim Pendaftaran
                </button>
                <div class="note-footer">
                    Dengan mengirimkan formulir, kamu menyatakan bahwa data yang diisi adalah benar
                    dan bersedia mengikuti seluruh rangkaian seleksi pengurus HIMA TI.
                </div>
            </div>
        </form>
    </div>
</div>
@endsection