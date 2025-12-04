@extends('layouts.pengurus')

@section('title', 'Detail Divisi')

@section('content')
<div class="divisi-card">
    <div class="card-header">
        <h1 class="card-title">Detail Divisi</h1>
    </div>
    <div class="card-body">
        @if($divisi->photo_divisi)
            <div class="divisi-photo">
                <img src="{{ Storage::url($divisi->photo_divisi) }}" alt="{{ $divisi->nama_divisi }}">
            </div>
        @endif
        <div class="divisi-info">
            <strong class="info-label">Nama Divisi:</strong>
            <span class="info-value">{{ $divisi->nama_divisi }}</span>
        </div>
        <hr class="divisi-divider">
        <div class="divisi-deskripsi">
            <strong class="info-label">Deskripsi:</strong>
            {!! $divisi->deskripsi !!}
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('pengurus.divisi.index') }}" class="btn-back">Kembali ke Daftar</a>
    </div>
</div>
@endsection

@push('styles')
<style>
.divisi-card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    margin-top: 20px;
    overflow: hidden;
}
.divisi-card .card-header {
    padding: 20px 24px;
    background-color: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
}
.divisi-card .card-title {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
}
.divisi-card .card-body {
    padding: 24px;
}
.divisi-card .divisi-photo {
    text-align: center;
    margin-bottom: 20px;
}
.divisi-card .divisi-photo img {
    max-width: 100%;
    height: auto;
    max-height: 300px;
    border-radius: 8px;
}
.divisi-card .divisi-info {
    display: flex;
    margin-bottom: 12px;
}
.divisi-card .info-label {
    width: 120px;
    font-weight: 600;
    color: #4b5563;
}
.divisi-card .info-value {
    color: #1f2937;
}
.divisi-card .divisi-divider {
    margin: 20px 0;
    border: 0;
    border-top: 1px solid #e5e7eb;
}
.divisi-card .divisi-deskripsi p {
    margin-top: 8px;
    line-height: 1.6;
    color: #374151;
}
.divisi-card .card-footer {
    padding: 16px 24px;
    background-color: #f9fafb;
    text-align: right;
    border-top: 1px solid #e5e7eb;
}
.divisi-card .btn-back {
    background-color: #6b7280;
    color: #fff;
    padding: 10px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: background-color 0.2s;
}
.divisi-card .btn-back:hover {
    background-color: #4b5563;
}
</style>
@endpush
