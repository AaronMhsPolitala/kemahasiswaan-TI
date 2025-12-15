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

                <!-- 1. Nama Pelapor -->
                <div class="col-md-6">
                    <label class="form-label" for="nama">
                        <i class="fa-solid fa-user"></i> Nama Pelapor
                    </label>
                    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama lengkap Anda" value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 2. NIM Pelapor -->
                <div class="col-md-6">
                    <label class="form-label" for="nim">
                        <i class="fa-solid fa-id-card-clip"></i> NIM Pelapor
                    </label>
                    <input type="number" id="nim" name="nim" class="form-control @error('nim') is-invalid @enderror" placeholder="Masukkan NIM Pelapor Anda" value="{{ old('nim') }}" required>
                    @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Divider for Pihak yang Dilaporkan -->
                <div class="col-12">
                    <hr class="my-3">
                    <h5 class="subtitle" style="font-size: 1.1rem; color: var(--text-main); font-weight: 600;">Pihak yang Dilaporkan</h5>
                </div>

                <!-- Nama Terlapor -->
                <div class="col-md-6">
                    <label class="form-label" for="nama_terlapor">
                        <i class="fa-solid fa-user-shield"></i> Nama Terlapor
                    </label>
                    <input type="text" id="nama_terlapor" name="nama_terlapor" class="form-control @error('nama_terlapor') is-invalid @enderror" placeholder="Nama Mahasiswa yang dilaporkan" value="{{ old('nama_terlapor') }}" required>
                    @error('nama_terlapor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- NIM Terlapor -->
                <div class="col-md-6">
                    <label class="form-label" for="nim_terlapor">
                        <i class="fa-solid fa-id-card-clip"></i> NIM Terlapor
                    </label>
                    <input type="number" id="nim_terlapor" name="nim_terlapor" class="form-control @error('nim_terlapor') is-invalid @enderror" placeholder="Masukkan NIM Mahasiswa yang dilaporkan" value="{{ old('nim_terlapor') }}" required>
                    @error('nim_terlapor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Hidden Status Terlapor -->
                <input type="hidden" name="status_terlapor" value="Mahasiswa">

                <!-- 3. Jenis Masalah -->
                <div class="col-md-6">
                    <label class="form-label" for="jenis_masalah">
                        <i class="fa-solid fa-triangle-exclamation"></i> Jenis Masalah
                    </label>
                    <select id="jenis_masalah" name="jenis_masalah" class="form-select @error('jenis_masalah') is-invalid @enderror" required>
                        <option value="">-- Pilih Jenis Masalah --</option>
                        <option value="Akademik">Akademik</option>
                        <option value="Disiplin">Disiplin</option>
                        <option value="Etika & Perilaku">Etika & Perilaku</option>
                        <option value="Tata Tertib Kampus">Tata Tertib Kampus</option>
                    </select>
                    @error('jenis_masalah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 4. Jenis Pelanggaran -->
                <div class="col-md-6">
                    <label class="form-label" for="jenis_pelanggaran">
                        <i class="fa-solid fa-shield-halved"></i> Jenis Pelanggaran
                    </label>
                    <select id="jenis_pelanggaran" name="jenis_pelanggaran" class="form-select @error('jenis_pelanggaran') is-invalid @enderror" required disabled>
                        <option value="">-- Pilih Jenis Pelanggaran --</option>
                    </select>
                    @error('jenis_pelanggaran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 5. Keterangan Tambahan -->
                <div class="col-12" id="keterangan-tambahan-wrapper" style="display: none;">
                    <label class="form-label" for="keterangan_tambahan">
                        <i class="fa-solid fa-file-pen"></i> Keterangan Tambahan
                    </label>
                    <textarea id="keterangan_tambahan" name="keterangan_tambahan" class="form-control" rows="4" placeholder="Jelaskan secara rinci."></textarea>
                </div>

                <!-- Checkbox Persetujuan -->
                <div class="col-12 mt-4">
                    <div class="form-check">
                        <input class="form-check-input @error('persetujuan') is-invalid @enderror" type="checkbox" id="persetujuan" name="persetujuan" value="1" required>
                        <label class="form-check-label" for="persetujuan">
                            <i class="fa-solid fa-circle-check"></i> Saya menyatakan bahwa data yang saya kirim adalah benar dan dapat dipertanggung jawabkan
                        </label>
                        @error('persetujuan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

            @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const jenisMasalah = document.getElementById('jenis_masalah');
                    const jenisPelanggaran = document.getElementById('jenis_pelanggaran');
                    const keteranganTambahanWrapper = document.getElementById('keterangan-tambahan-wrapper');

                    const pelanggaranOptions = {
                        'Akademik': [
                            'Mencontek saat ujian',
                            'Plagiarisme tugas / skripsi',
                            'Pemalsuan data akademik',
                            'Titip absen',
                            'Lainnya'
                        ],
                        'Disiplin': [
                            'Terlambat masuk kelas',
                            'Tidak mengikuti kegiatan wajib',
                            'Merokok di area terlarang',
                            'Lainnya'
                        ],
                        'Etika & Perilaku': [
                            'Berkata tidak sopan',
                            'Mengganggu ketertiban umum',
                            'Cyberbullying',
                            'Lainnya'
                        ],
                        'Tata Tertib Kampus': [
                            'Tidak memakai almamater pada hari yang ditentukan',
                            'Parkir sembarangan',
                            'Merusak fasilitas kampus',
                            'Lainnya'
                        ]
                    };

                    jenisMasalah.addEventListener('change', function () {
                        const selectedMasalah = this.value;
                        jenisPelanggaran.innerHTML = '<option value="">-- Pilih Jenis Pelanggaran --</option>';
                        jenisPelanggaran.disabled = true;
                        keteranganTambahanWrapper.style.display = 'none';

                        if (selectedMasalah && pelanggaranOptions[selectedMasalah]) {
                            pelanggaranOptions[selectedMasalah].forEach(function (option) {
                                const newOption = new Option(option, option);
                                jenisPelanggaran.add(newOption);
                            });
                            jenisPelanggaran.disabled = false;
                        }
                    });

                    jenisPelanggaran.addEventListener('change', function () {
                        if (this.value === 'Lainnya') {
                            keteranganTambahanWrapper.style.display = 'block';
                        } else {
                            keteranganTambahanWrapper.style.display = 'none';
                        }
                    });
                });
            </script>
            @endpush


            <div class="text-center mt-4">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Pengaduan
                </button>
            </div>

        </form>

    </div>
</div>
@endsection