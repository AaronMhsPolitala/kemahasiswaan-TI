@extends('layouts.user')

@section('title','Kotak Aspirasi')

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



    .aspirasi-wrapper {
        display: flex;
        justify-content: center;
    }

    .aspirasi-card {
        background: #fff;
        width: 100%;
        max-width: 850px;
        padding: 2rem 2rem;
        border-radius: 1.4rem;
        border: 1px solid var(--border-soft);
        box-shadow: 0 18px 40px rgba(0,0,0,0.06);
        position: relative;
    }

    .corner-icon {
        position: absolute;
        right: 22px;
        top: 22px;
        font-size: 2.6rem;
        color: rgba(37, 99, 235, .12);
    }

    .aspirasi-title {
        font-size: 1.8rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: .6rem;
        color: var(--text-main);
    }

    .aspirasi-title i {
        color: var(--primary);
    }

    .subtitle {
        font-size: .95rem;
        color: var(--text-muted);
        margin-top: .4rem;
        max-width: 32rem;
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
    textarea.form-control {
        border-radius: .8rem;
        padding: .75rem .9rem;
        border: 1px solid #d1d5db;
    }

    .form-control:focus,
    textarea.form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(37,99,235,0.25);
    }

    textarea.form-control {
        min-height: 230px; /* DIPANJANGKAN */
    }

    .btn-submit {
        background: var(--primary);
        border: none;
        color: #fff;
        padding: .9rem 2rem;
        border-radius: 999px;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: .6rem;
        box-shadow: 0 12px 28px rgba(37,99,235,.35);
    }

    .btn-submit:hover {
        background: var(--primary-dark);
    }

    .alert-box {
        padding: 12px 14px;
        border-radius: 10px;
        margin-bottom: 15px;
    }


</style>
@endpush

@section('content')
<div class="aspirasi-wrapper">
    <div class="aspirasi-card">

        <!-- ICON POJOK -->
        <i class="fa-solid fa-lightbulb corner-icon"></i>

        <!-- HEADER -->
        <h1 class="aspirasi-title">
            <i class="fa-solid fa-comment-dots"></i>
            Kotak Aspirasi
        </h1>

        <p class="subtitle">
            Sampaikan aspirasi, kritik, atau saran Anda untuk meningkatkan kualitas pelayanan HIMA TI.
        </p>

        <hr class="my-4">

        <!-- ALERT -->
        @if(session('ok'))
            <div class="alert-box" style="background:#e6fcf1; color:#046c4e;">
                {{ session('ok') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert-box" style="background:#fde2e2; color:#922c2c;">
                <strong>Oops! Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM -->
        <form action="{{ route('user.aspirasi.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="nama">
                    <i class="fa-solid fa-user"></i> Nama Lengkap
                </label>
                <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama Anda" value="{{ old('nama') }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="email">
                    <i class="fa-solid fa-envelope"></i> Email
                </label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan email Anda" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="perihal">
                    <i class="fa-solid fa-tag"></i> Perihal Aspirasi
                </label>
                <input type="text" id="perihal" name="perihal" class="form-control @error('perihal') is-invalid @enderror" placeholder="Subjek aspirasi Anda" value="{{ old('perihal') }}" required>
                @error('perihal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="pesan">
                    <i class="fa-solid fa-pen-to-square"></i> Aspirasi Anda
                </label>
                <textarea id="pesan" name="pesan" class="form-control @error('pesan') is-invalid @enderror"
                          placeholder="Tuliskan aspirasi, kritik, atau saran Anda dengan lebih lengkap..."
                          required>{{ old('pesan') }}</textarea>
                @error('pesan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Aspirasi
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
