@extends('layouts.user')

@section('title', 'Form Pengaduan Mahasiswa')

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



    .pengaduan-wrapper {
        display: flex;
        justify-content: center;
    }

    .pengaduan-card {
        background: #fff;
        width: 100%;
        max-width: 960px;
        border-radius: 1.4rem;
        padding: 2rem 2.2rem;
        border: 1px solid var(--border-soft);
        box-shadow: 0 18px 40px rgba(0,0,0,0.06);
        position: relative;
    }

    .corner-icon {
        position: absolute;
        top: 22px;
        right: 22px;
        font-size: 2.6rem;
        color: rgba(37,99,235,0.12);
    }

    .badge-info-custom {
        background: #e0edff;
        border: 1px solid #bfd7ff;
        padding: .45rem .8rem;
        border-radius: 999px;
        font-size: .78rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        color: var(--primary-dark);
    }

    .title-main {
        font-size: 1.7rem;
        font-weight: 700;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: .6rem;
        margin-top: .6rem;
    }

    .title-main i { color: var(--primary); }

    .subtitle {
        font-size: .95rem;
        color: var(--text-muted);
        margin-top: .2rem;
        max-width: 31rem;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .form-label i {
        color: var(--primary);
    }

    .form-control,
    .form-select {
        border-radius: .8rem;
        padding: .75rem .9rem;
        border: 1px solid #d1d5db;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(37,99,235,0.25);
    }

    .btn-submit {
        background: var(--primary);
        color: #fff;
        border-radius: 999px;
        padding: .9rem 2rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: .6rem;
        box-shadow: 0 10px 24px rgba(37,99,235,0.35);
        border: none;
        text-transform: uppercase;
    }

    .btn-submit:hover {
        background: var(--primary-dark);
    }

    .note {
        color: var(--text-muted);
        font-size: .78rem;
    }


</style>
@endpush

@section('content')
<div class="pengaduan-wrapper">
    <div class="pengaduan-card">

        <!-- ICON POJOK -->
        <i class="fa-solid fa-message-exclamation corner-icon"></i>

        <!-- HEADER -->
        <div>
            <span class="badge-info-custom">
                <i class="fa-solid fa-bullhorn"></i> Layanan Pengaduan
            </span>

            <h1 class="title-main">
                <i class="fa-solid fa-envelope-open-text"></i>
                Form Pengaduan Mahasiswa
            </h1>

            <p class="subtitle">
                Isi form berikut untuk menyampaikan masalah Anda. Sistem akan membuat kode tiket untuk melacak proses pengaduan.
            </p>
        </div>

        <hr class="my-4">

        <!-- FORM -->
        <form action="{{ route('user.bermasalah.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row g-3">

                <!-- 1. Nama -->
                <div class="col-md-6">
                    <label class="form-label" for="nama">
                        <i class="fa-solid fa-user"></i> Nama Lengkap
                    </label>
                    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama lengkap Anda" value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 2. NIM -->
                <div class="col-md-6">
                    <label class="form-label" for="nim">
                        <i class="fa-solid fa-id-card-clip"></i> NIM
                    </label>
                    <input type="text" id="nim" name="nim" class="form-control @error('nim') is-invalid @enderror" placeholder="Masukkan NIM Anda" value="{{ old('nim') }}" required>
                    @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 3. Semester -->
                <div class="col-md-6">
                    <label class="form-label" for="semester">
                        <i class="fa-solid fa-graduation-cap"></i> Semester
                    </label>
                    <input type="number" id="semester" name="semester" class="form-control @error('semester') is-invalid @enderror" placeholder="Contoh: 5" min="1" value="{{ old('semester') }}" required>
                    @error('semester')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 4. Jenis Masalah -->
                <div class="col-md-6">
                    <label class="form-label" for="jenis_masalah">
                        <i class="fa-solid fa-triangle-exclamation"></i> Jenis Masalah
                    </label>
                    <select id="jenis_masalah" name="jenis_masalah" class="form-select @error('jenis_masalah') is-invalid @enderror" required>
                        <option value="">-- Pilih Jenis Masalah --</option>
                        <option value="Akademik" {{ old('jenis_masalah') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                        <option value="Keuangan" {{ old('jenis_masalah') == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                        <option value="Disiplin" {{ old('jenis_masalah') == 'Disiplin' ? 'selected' : '' }}>Disiplin</option>
                        <option value="Administrasi" {{ old('jenis_masalah') == 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
                        <option value="Lainnya" {{ old('jenis_masalah') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('jenis_masalah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 5. Keterangan -->
                <div class="col-12">
                    <label class="form-label" for="keterangan">
                        <i class="fa-solid fa-file-pen"></i> Keterangan Masalah
                    </label>
                    <textarea id="keterangan" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="5"
                        placeholder="Jelaskan secara rinci masalah yang ingin Anda laporkan"
                        required>{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 6. Kontak -->
                <div class="col-12">
                    <label class="form-label" for="kontak_pengadu">
                        <i class="fa-solid fa-at"></i> Kontak (Email / No HP)
                    </label>
                    <input type="text" id="kontak_pengadu" name="kontak_pengadu" class="form-control @error('kontak_pengadu') is-invalid @enderror" placeholder="Opsional - untuk dihubungi admin" value="{{ old('kontak_pengadu') }}">
                    @error('kontak_pengadu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 7. Lampiran -->
                <div class="col-12">
                    <label class="form-label" for="lampiran">
                        <i class="fa-solid fa-paperclip"></i> Lampiran Bukti (opsional)
                    </label>
                    <input type="file" id="lampiran" name="lampiran" class="form-control @error('lampiran') is-invalid @enderror">
                    @error('lampiran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 8. Anonim -->
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="anonim" name="anonim" value="1" {{ old('anonim') ? 'checked' : '' }}>
                        <label class="form-check-label" for="anonim">
                            <i class="fa-solid fa-user-ninja"></i> Kirim sebagai anonim
                        </label>
                    </div>
                </div>

                <!-- 9. Persetujuan -->
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="persetujuan" name="persetujuan" value="1" {{ old('persetujuan') ? 'checked' : '' }} required>
                        <label class="form-check-label" for="persetujuan">
                            <i class="fa-solid fa-circle-check"></i> Saya menyetujui bahwa data yang saya kirim adalah benar.
                        </label>
                        @error('persetujuan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Pengaduan
                </button>
            </div>

        </form>

    </div>
</div>
@endsection