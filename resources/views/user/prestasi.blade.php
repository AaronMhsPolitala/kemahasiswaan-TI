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
    /* Custom style for selected filter buttons */
    .btn-check:checked + .btn-outline-secondary {
        background-color: var(--bs-primary); /* Bootstrap's primary blue */
        border-color: var(--bs-primary);
        color: #fff; /* White text */
    }
    .btn-check:checked + .btn-outline-secondary:hover,
    .btn-check:checked + .btn-outline-secondary:focus {
        background-color: var(--bs-primary); /* Ensure it stays primary on hover/focus */
        border-color: var(--bs-primary);
        color: #fff;
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
        <div class="card-body">
            <form method="GET" action="{{ route('user.prestasi') }}" id="searchForm">
                <div class="row g-3">
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Cari Nama, NIM, atau Kegiatan..."
                                   value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit" id="button-addon2">Search</button>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex">
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#filterModal">
                            <i class="bi bi-funnel-fill me-2"></i> Filter
                        </button>
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
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
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
                            <td class="fw-bold">{{ $prestasi->nim }}</td>
                            <td class="text-start fw-bold">{{ $prestasi->nama_mahasiswa }}</td>
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
                            <td colspan="7" class="text-center py-5">
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

@push('scripts')
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="filterModalLabel">
            <i class="bi bi-funnel me-2"></i> Filter Prestasi
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        {{-- TINGKAT --}}
        <div class="mb-4">
          <h6 class="mb-3">Tingkat Kegiatan</h6>
            @php
                $tingkats = ['Internasional','Nasional','Provinsi/Wilayah','Kabupaten/Kota','Internal (Kampus)'];
            @endphp
            @foreach($tingkats as $tingkat)
                @php $id = 'btn_tingkat_'.Str::slug($tingkat,'_'); @endphp
                <input type="radio" class="btn-check tingkat-option"
                       name="tingkat_option" id="{{ $id }}"
                       value="{{ $tingkat }}"
                        {{ request('tingkat_kegiatan') == $tingkat ? 'checked' : '' }}>
                <label class="btn btn-outline-secondary me-2 mb-2" for="{{ $id }}">
                    {{ $tingkat }}
                </label>
            @endforeach

        </div>

        <hr>

        {{-- JUARA --}}
        <div class="mb-4">
          <h6 class="mb-3">Capaian / Juara</h6>
            @php
                $juaras = ['Juara 1','Juara 2','Juara 3','Partisipan'];
            @endphp
            @foreach($juaras as $juara)
                @php $id = 'btn_juara_'.Str::slug($juara,'_'); @endphp
                <input type="radio" class="btn-check juara-option"
                       name="juara_option" id="{{ $id }}"
                       value="{{ $juara }}"
                        {{ request('prestasi_yang_dicapai') == $juara ? 'checked' : '' }}>
                <label class="btn btn-outline-secondary me-2 mb-2" for="{{ $id }}">
                    {{ $juara }}
                </label>
            @endforeach

        </div>

        <hr>

        {{-- KETERANGAN --}}
        <div class="mb-4">
          <h6 class="mb-3">Keterangan</h6>
            @php $kets = ['Akademik','Non-Akademik']; @endphp
            @foreach($kets as $ket)
                @php $id = 'btn_ket_'.Str::slug($ket,'_'); @endphp
                <input type="radio" class="btn-check ket-option"
                       name="ket_option" id="{{ $id }}"
                       value="{{ $ket }}"
                        {{ request('keterangan') == $ket ? 'checked' : '' }}>
                <label class="btn btn-outline-secondary me-2 mb-2" for="{{ $id }}">
                    {{ $ket }}
                </label>
            @endforeach
        </div>

        <hr>

        {{-- WAKTU --}}
        <div class="mb-4">
            <h6 class="mb-3">Tahun</h6>
            @foreach($tahuns as $tahun)
                @php $id = 'btn_tahun_'.$tahun; @endphp
                <input type="radio" class="btn-check tahun-option"
                       name="tahun_option" id="{{ $id }}"
                       value="{{ $tahun }}"
                        {{ request('tahun') == $tahun ? 'checked' : '' }}>
                <label class="btn btn-outline-secondary me-2 mb-2" for="{{ $id }}">
                    {{ $tahun }}
                </label>
            @endforeach
        </div>
      </div>

      {{-- footer modal: atur ulang & terapkan --}}
      <div class="modal-footer">
        <a href="{{ route('user.prestasi') }}" class="btn btn-outline-secondary">Atur Ulang</a>
        <button type="button" class="btn btn-primary" id="applyFilter">Pakai</button>
      </div>
    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchForm = document.getElementById('searchForm');
        const applyFilterBtn = document.getElementById('applyFilter');

        // Function to allow deselecting radio buttons
        function setupRadioDeselect(radioGroupName) {
            const radios = document.querySelectorAll(`input[name="${radioGroupName}"]`);
            let lastChecked = document.querySelector(`input[name="${radioGroupName}"]:checked`);

            radios.forEach(radio => {
                radio.addEventListener('click', function() {
                    if (this === lastChecked) {
                        this.checked = false;
                        lastChecked = null;
                    } else {
                        lastChecked = this;
                    }
                });
            });
        }

        setupRadioDeselect('tingkat_option');
        setupRadioDeselect('juara_option');
        setupRadioDeselect('ket_option');
        setupRadioDeselect('tahun_option');

        // Handle Apply Filter button click
        applyFilterBtn.addEventListener('click', function () {
            const selectedTingkat = document.querySelector('input[name="tingkat_option"]:checked');
            const selectedJuara = document.querySelector('input[name="juara_option"]:checked');
            const selectedKet = document.querySelector('input[name="ket_option"]:checked');
            const selectedTahun = document.querySelector('input[name="tahun_option"]:checked');

            const searchInput = document.querySelector('input[name="search"]');

            // Build the URL
            let url = new URL(searchForm.action);
            if (searchInput.value) {
                url.searchParams.set('search', searchInput.value);
            }
            if (selectedTingkat) {
                url.searchParams.set('tingkat_kegiatan', selectedTingkat.value);
            }
            if (selectedJuara) {
                url.searchParams.set('prestasi_yang_dicapai', selectedJuara.value);
            }
            if (selectedKet) {
                url.searchParams.set('keterangan', selectedKet.value);
            }
            if (selectedTahun) {
                url.searchParams.set('tahun', selectedTahun.value);
            }

            window.location.href = url.toString();
        });

    });
</script>
@endpush

