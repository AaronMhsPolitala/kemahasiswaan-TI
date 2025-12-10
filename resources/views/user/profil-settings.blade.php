@extends('layouts.user')

@section('title', 'Pengaturan Profil')

@section('content')
<div class="container py-4" id="profil-page">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="profile-header d-flex align-items-center mb-4">
                <div class="profile-header-icon me-3">
                    <i class="fas fa-user-cog"></i>
                </div>
                <div>
                    <h1 class="h3 mb-1">Pengaturan Profil</h1>
                    <p class="text-muted mb-0">Perbarui informasi akun Anda.</p>
                </div>
            </div>

            <div class="card profile-card shadow-sm border-0 p-4">
                <div class="card-body">
                    <form action="{{ route('user.profil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-5">

                            <!-- Foto -->
                            <div class="col-md-3 text-center">
                                <div class="avatar-wrapper mb-3">
                                    @if ($user->photo_url)
                                        <img src="{{ $user->photo_url }}" class="avatar-image">
                                    @else
                                        <div class="avatar-placeholder">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                </div>

                                <label for="photo" class="form-label fw-semibold">Foto Profil</label>
                                <input type="file" id="photo" name="photo" class="form-control form-control-sm">
                                <small class="text-muted">Max 2MB · JPG / PNG</small>
                            </div>

                            <!-- FORM -->
                            <div class="col-md-9">

                                {{-- Nama --}}
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Nama Pengguna</label>
                                    <div class="input-icon">
                                        <i class="fas fa-user"></i>
                                        <input type="text" name="name" class="form-control form-control-lg"
                                               value="{{ $user->name }}">
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Email</label>
                                    <div class="input-icon">
                                        <i class="fas fa-envelope"></i>
                                        <input type="email" name="email" class="form-control form-control-lg"
                                               value="{{ $user->email }}">
                                    </div>
                                </div>

                                {{-- Nomor HP --}}
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Nomor HP</label>
                                    <div class="input-icon">
                                        <i class="fas fa-phone"></i>
                                        <input type="text" name="no_wa" class="form-control form-control-lg"
                                               value="{{ $user->no_wa }}">
                                    </div>
                                </div>

                                {{-- Role --}}
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Peran</label>
                                    <div class="input-icon">
                                        <i class="fas fa-shield-alt"></i>
                                        <input type="text" class="form-control form-control-lg"
                                               value="{{ $user->role }}" disabled>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('user.beranda') }}" class="btn btn-outline-secondary btn-lg me-2">Kembali</a>
                                    <button type="submit" class="btn btn-primary btn-lg">Simpan Perubahan</button>
                                </div>

                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    #profil-page { max-width: 1100px; }

    /* Header icon */
    .profile-header-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background-color: #e5edff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
        font-size: 20px;
    }

    /* Avatar */
    .avatar-image, .avatar-placeholder {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
    }
    .avatar-placeholder {
        background: #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        color: #9ca3af;
    }

    /* Input With Icon */
    .input-icon {
        position: relative;
    }
    .input-icon i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        font-size: 17px;
    }
    .input-icon input {
        padding-left: 45px !important;
    }

    .form-control-lg {
        padding: 14px 16px;
        font-size: 16px;
        border-radius: 12px;
    }

    .btn-lg {
        padding: 10px 26px;
        border-radius: 12px;
    }

    .btn-primary {
        background-color: #2563eb;
        border: none;
    }
    .btn-primary:hover {
        background-color: #1d4ed8;
    }
</style>
@endpush
