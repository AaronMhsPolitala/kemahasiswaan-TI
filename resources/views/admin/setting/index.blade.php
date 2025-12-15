@extends('layouts.admin')

@section('title', 'Pengaturan Website & Status Pendaftaran')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .settings-container {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .settings-card {
        background-color: #fff;
        border-radius: 0.75rem;
        padding: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .settings-card h1, .settings-card h2 {
        font-weight: 600;
        color: #111827;
    }

    .settings-card h1 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .settings-card h2 {
        font-size: 1.25rem;
        margin-top: 0;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .settings-card .form-group {
        margin-bottom: 1.5rem;
    }

    .settings-card .form-label {
        display: block;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .settings-card .form-input, .settings-card .form-textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .settings-card .form-input:focus, .settings-card .form-textarea:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
    }

    .settings-card .form-hint {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.5rem;
    }

    .grid-cols-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .toggle-switch {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .toggle-switch .toggle-label {
        font-weight: 500;
    }

    .toggle-switch .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .toggle-switch .switch input { 
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-switch .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .toggle-switch .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    .toggle-switch input:checked + .slider {
        background-color: #28a745;
    }

    .toggle-switch input:checked + .slider:before {
        transform: translateX(26px);
    }

    .logo-upload {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .logo-preview {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e5e7eb;
    }

    .btn-primary {
        background-color: #3b82f6;
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #2563eb;
    }

    .hidden {
        display: none;
    }

    @media (max-width: 768px) {
        .grid-cols-2 {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="settings-container">
        <!-- Card 1: Status Pendaftaran -->
        <form class="settings-card" action="{{ route('admin.setting.store') }}" method="POST">
            @csrf
            <h2>Status Pendaftaran</h2>
            <div class="form-group">
                <p class="form-hint">Atur apakah pendaftaran anggota baru sedang dibuka atau ditutup.</p>
                <div class="toggle-switch">
                    <span class="toggle-label">Ditutup</span>
                    <label class="switch">
                        <input type="checkbox" name="status_pendaftaran"
                            {{ ($settings['pendaftaran'] ?? null) && $settings['pendaftaran']->value == 'open' ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                    <span class="toggle-label">Dibuka</span>
                </div>
            </div>
            <div style="text-align: right;">
                <button class="btn-primary" type="submit"><i class="fas fa-save"></i> Simpan Status</button>
            </div>
        </form>

        <!-- Card 2: Pengaturan Profil Website -->
        <form class="settings-card" action="{{ route('admin.setting.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h2>Pengaturan Profil Website</h2>
            
            <div class="form-group">
                <label class="form-label" for="site_name">Nama Website</label>
                <input class="form-input" id="site_name" name="site_name" type="text" placeholder="Contoh: HIMA TI Politala" value="{{ $settings['site_name']->value ?? '' }}" required>
            </div>

            <div class="grid-cols-2">
                <div class="form-group">
                    <label class="form-label" for="visi">Visi</label>
                    <textarea class="form-textarea" id="visi" name="visi" rows="4">{{ $settings['visi']->value ?? '' }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label" for="misi">Misi</label>
                    <textarea class="form-textarea" id="misi" name="misi" rows="4">{{ $settings['misi']->value ?? '' }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="deskripsi">Deskripsi</label>
                <textarea class="form-textarea" id="deskripsi" name="deskripsi" placeholder="Gambaran singkat organisasi/website" rows="6">{{ $settings['deskripsi']->value ?? '' }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="nama_ketua">Ketua Umum</label>
                <div class="logo-upload">
                    <img id="fotoKetuaPreview" class="logo-preview" alt="Foto Ketua" src="{{ isset($settings['foto_ketua']) && $settings['foto_ketua']->value ? Storage::url($settings['foto_ketua']->value) : 'https://via.placeholder.com/80x80.png?text=Foto' }}">
                    <div style="width: 100%;">
                        <input class="form-input" id="nama_ketua" name="nama_ketua" type="text" value="{{ $settings['nama_ketua']->value ?? '' }}" placeholder="Nama Ketua Umum">
                        <input id="fotoKetuaInput" type="file" name="foto_ketua" accept="image/*" class="form-input" style="margin-top: 0.5rem;">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="nama_wakil">Wakil Ketua</label>
                <div class="logo-upload">
                    <img id="fotoWakilPreview" class="logo-preview" alt="Foto Wakil" src="{{ isset($settings['foto_wakil']) && $settings['foto_wakil']->value ? Storage::url($settings['foto_wakil']->value) : 'https://via.placeholder.com/80x80.png?text=Foto' }}">
                    <div style="width: 100%;">
                        <input class="form-input" id="nama_wakil" name="nama_wakil" type="text" value="{{ $settings['nama_wakil']->value ?? '' }}" placeholder="Nama Wakil Ketua">
                        <input id="fotoWakilInput" type="file" name="foto_wakil" accept="image/*" class="form-input" style="margin-top: 0.5rem;">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="nama_sekretaris">Sekretaris Umum</label>
                <div class="logo-upload">
                    <img id="fotoSekretarisPreview" class="logo-preview" alt="Foto Sekretaris" src="{{ isset($settings['foto_sekretaris']) && $settings['foto_sekretaris']->value ? Storage::url($settings['foto_sekretaris']->value) : 'https://via.placeholder.com/80x80.png?text=Foto' }}">
                    <div style="width: 100%;">
                        <input class="form-input" id="nama_sekretaris" name="nama_sekretaris" type="text" value="{{ $settings['nama_sekretaris']->value ?? '' }}" placeholder="Nama Sekretaris Umum">
                        <input id="fotoSekretarisInput" type="file" name="foto_sekretaris" accept="image/*" class="form-input" style="margin-top: 0.5rem;">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="nama_bendahara">Bendahara Umum</label>
                <div class="logo-upload">
                    <img id="fotoBendaharaPreview" class="logo-preview" alt="Foto Bendahara" src="{{ isset($settings['foto_bendahara']) && $settings['foto_bendahara']->value ? Storage::url($settings['foto_bendahara']->value) : 'https://via.placeholder.com/80x80.png?text=Foto' }}">
                    <div style="width: 100%;">
                        <input class="form-input" id="nama_bendahara" name="nama_bendahara" type="text" value="{{ $settings['nama_bendahara']->value ?? '' }}" placeholder="Nama Bendahara Umum">
                        <input id="fotoBendaharaInput" type="file" name="foto_bendahara" accept="image/*" class="form-input" style="margin-top: 0.5rem;">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Logo/Foto <span style="color: red;">*</span></label>
                <div class="logo-upload">
                    <img id="logoPreview" class="logo-preview" alt="Logo saat ini" src="{{ isset($settings['logo']) && $settings['logo']->value ? Storage::url($settings['logo']->value) : 'https://via.placeholder.com/120x120.png?text=Logo' }}">
                    <div>
                        <label for="logoInput" class="btn-primary"><i class="fas fa-upload"></i> Ubah Logo</label>
                        <input id="logoInput" type="file" name="logo" accept="image/*" class="hidden">
                        <p class="form-hint" id="fileName">Pilih file gambar (PNG/JPG, maks 2MB)</p>
                    </div>
                </div>
            </div>

            <div style="text-align: right;">
                <button class="btn-primary" type="submit"><i class="fas fa-save"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    CKEDITOR.replace('deskripsi');

    // Helper function to set up image preview
    function setupImagePreview(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);

        if (input) {
            input.addEventListener('change', () => {
                const file = input.files && input.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            });
        }
    }

    // Logo preview
    setupImagePreview('logoInput', 'logoPreview');

    // Pengurus photo previews
    setupImagePreview('fotoKetuaInput', 'fotoKetuaPreview');
    setupImagePreview('fotoWakilInput', 'fotoWakilPreview');
    setupImagePreview('fotoSekretarisInput', 'fotoSekretarisPreview');
    setupImagePreview('fotoBendaharaInput', 'fotoBendaharaPreview');

    const logoInput = document.getElementById('logoInput');
    const fileName = document.getElementById('fileName');

    if (logoInput) {
        logoInput.addEventListener('change', () => {
            const file = logoInput.files && logoInput.files[0];
            if (!file) return;
            fileName.textContent = file.name;
        });
    }
</script>
@endpush