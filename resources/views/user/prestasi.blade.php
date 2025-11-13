@extends('layouts.user')

@section('title', 'Data Prestasi Mahasiswa')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
    .card-header-custom {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        padding: 1rem 1.25rem;
        font-weight: 600;
    }
    .form-control, .form-select {
        border-radius: 0.5rem;
        transition: all 0.3s ease-in-out;
    }
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        border-color: #86b7fe;
    }
    .btn-primary {
        border-radius: 0.5rem;
    }
    .table th {
        white-space: nowrap;
    }
    .table td {
        vertical-align: middle;
    }
    .card {
        border-radius: 0.75rem;
    }
    .pagination .page-item.active .page-link {
        border-radius: 0.5rem;
    }
    .pagination .page-link {
        border-radius: 0.5rem;
        margin: 0 2px;
    }
    .bg-bronze-subtle {
        background-color: #fcefe6;
    }
    .text-bronze-emphasis {
        color: #8c5a2d;
    }
    .text-bronze {
        color: #cd7f32;
    }
    .bg-silver-subtle {
        background-color: #f0f0f0;
    }
    .text-silver-emphasis {
        color: #757575;
    }
    .bg-gold-subtle {
        background-color: #fff8e1;
    }
    .text-gold-emphasis {
        color: #a1887f;
    }
</style>
@endpush

@section('content')
<div class="container my-5">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold">Prestasi Mahasiswa</h1>
        <p class="lead text-muted">Daftar prestasi yang telah diraih oleh mahasiswa HMTI.</p>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header card-header-custom">
            <i class="bi bi-funnel-fill me-2"></i> Filter & Pencarian
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('user.prestasi') }}">
                <div class="row g-3">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Cari Nama, NIM, atau Kegiatan..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="tingkat_kegiatan" class="form-select">
                            <option value="">Semua Tingkat</option>
                            @foreach ($tingkat_kegiatans as $tingkat)
                                <option value="{{ $tingkat }}" {{ request('tingkat_kegiatan') == $tingkat ? 'selected' : '' }}>
                                    {{ $tingkat }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="keterangan" class="form-select">
                            <option value="">Keterangan</option>
                            @foreach ($keterangans as $keterangan)
                                <option value="{{ $keterangan }}" {{ request('keterangan') == $keterangan ? 'selected' : '' }}>
                                    {{ $keterangan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex">
                        <button type="submit" class="btn btn-primary w-100 me-2 d-flex align-items-center justify-content-center"><i class="bi bi-filter me-1"></i> Filter</button>
                        <a href="{{ route('user.prestasi') }}" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center"><i class="bi bi-arrow-counterclockwise"></i></a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>Peringkat</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>IPK</th>
                        <th>Skor Prestasi</th>
                        <th>Nama Kegiatan</th>
                        <th>Waktu</th>
                        <th>Tingkat</th>
                        <th>Capaian</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($prestasis as $prestasi)
                        <tr class="text-center">
                            <td class="fw-bold">
                                @if (($prestasis->currentPage() - 1) * $prestasis->perPage() + $loop->iteration == 1)
                                    <i class="bi bi-trophy-fill text-warning fs-4"></i>
                                @elseif (($prestasis->currentPage() - 1) * $prestasis->perPage() + $loop->iteration == 2)
                                    <i class="bi bi-trophy-fill text-secondary fs-4"></i>
                                @elseif (($prestasis->currentPage() - 1) * $prestasis->perPage() + $loop->iteration == 3)
                                    <i class="bi bi-trophy-fill text-bronze fs-4"></i>
                                @else
                                    {{ ($prestasis->currentPage() - 1) * $prestasis->perPage() + $loop->iteration }}
                                @endif
                            </td>
                            <td class="fw-bold">{{ $prestasi->nim }}</td>
                            <td class="text-start fw-bold">{{ $prestasi->nama_mahasiswa }}</td>
                            <td><i class="bi bi-star-fill text-warning me-1"></i> {{ number_format($prestasi->ipk, 2) }}</td>
                            <td>
                                <span class="badge bg-success-subtle text-success-emphasis rounded-pill fw-bold">
                                    {{ number_format($prestasi->total_skor * 100, 2) }}
                                </span>
                            </td>
                            <td class="text-start fw-bold">{{ $prestasi->nama_kegiatan }}</td>
                            <td>{{ \Carbon\Carbon::parse($prestasi->waktu_penyelenggaraan)->format('d/m/Y') }}</td>
                            <td>
                                @switch($prestasi->tingkat_kegiatan)
                                    @case('Internasional')
                                        <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">
                                            {{ $prestasi->tingkat_kegiatan }}
                                        </span>
                                        @break
                                    @case('Nasional')
                                        <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">
                                            {{ $prestasi->tingkat_kegiatan }}
                                        </span>
                                        @break
                                    @case('Provinsi')
                                    @case('Provinsi/Wilayah')
                                        <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill">
                                            {{ $prestasi->tingkat_kegiatan }}
                                        </span>
                                        @break
                                    @case('Kabupaten/Kota')
                                        <span class="badge bg-success-subtle text-success-emphasis rounded-pill">
                                            {{ $prestasi->tingkat_kegiatan }}
                                        </span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill">
                                            {{ $prestasi->tingkat_kegiatan }}
                                        </span>
                                @endswitch
                            </td>
                            <td>
                                @switch($prestasi->prestasi_yang_dicapai)
                                    @case('Juara 1')
                                        <span class="badge bg-gold-subtle text-gold-emphasis rounded-pill">
                                            <i class="bi bi-trophy-fill me-1"></i> {{ $prestasi->prestasi_yang_dicapai }}
                                        </span>
                                        @break
                                    @case('Juara 2')
                                        <span class="badge bg-silver-subtle text-silver-emphasis rounded-pill">
                                            <i class="bi bi-trophy-fill me-1"></i> {{ $prestasi->prestasi_yang_dicapai }}
                                        </span>
                                        @break
                                    @case('Juara 3')
                                        <span class="badge bg-bronze-subtle text-bronze-emphasis rounded-pill">
                                            <i class="bi bi-trophy-fill me-1"></i> {{ $prestasi->prestasi_yang_dicapai }}
                                        </span>
                                        @break
                                    @default
                                        <span class="badge bg-info-subtle text-info-emphasis rounded-pill">
                                            {{ $prestasi->prestasi_yang_dicapai }}
                                        </span>
                                @endswitch
                            </td>
                            <td>
                                @if($prestasi->keterangan == 'Akademik')
                                    <span class="badge bg-info-subtle text-info-emphasis rounded-pill">
                                        {{ $prestasi->keterangan }}
                                    </span>
                                @else
                                    <span class="badge bg-success-subtle text-success-emphasis rounded-pill">
                                        {{ $prestasi->keterangan }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <i class="bi bi-exclamation-triangle-fill display-4 text-warning"></i>
                                <h4 class="mt-3">Data Tidak Ditemukan</h4>
                                <p class="text-muted">Tidak ada data prestasi yang cocok dengan filter Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($prestasis->hasPages())
            <div class="card-footer bg-light d-flex justify-content-center">
                {{ $prestasis->links('vendor.pagination.bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
