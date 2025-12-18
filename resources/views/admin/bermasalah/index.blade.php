@extends('layouts.admin')

@section('title', 'Data Mahasiswa Bermasalah')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    #bermasalah-page {
        --primary-color: #2563eb;
        --danger-color: #ef4444;
        --success-color: #22c55e;
        --light-gray: #f3f4f6;
        --border-color: #e5e7eb;
        --text-dark: #1f2937;
        --text-light: #6b7280;
    }
    .table-container { background-color: #fff; border-radius: 0.75rem; box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06); overflow: hidden; }
    .table { width: 100%; border-collapse: collapse; }
    .table th, .table td { padding: 1rem; text-align: left; border-bottom: 1px solid var(--border-color); font-size: 0.875rem; }
    .table thead th { background-color: var(--light-gray); font-weight: 600; color: var(--text-light); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; }
    .table tbody tr:hover { background-color: #f9fafb; }
    .action-btns { display: flex; gap: 0.5rem; }
    .btn { padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; border: none; cursor: pointer; }
    .btn-primary { background-color: var(--primary-color); color: #fff; }
    .btn-edit { background-color: #eab308; color: #fff; }
    .btn-danger { background-color: var(--danger-color); color: #fff; }
    .btn-success { background-color: var(--success-color); color: #fff; }
    .btn-warning { background-color: #eab308; color: #fff; }
    .filter-bar { display: flex; gap: 1rem; margin-bottom: 2.5rem; align-items: center; }
    .filter-bar input, .filter-bar select { padding: 0.5rem 1rem; border-radius: 0.375rem; border: 1px solid var(--border-color); }
    .alert { padding: 1rem; margin-bottom: 1.5rem; border-radius: 0.375rem; }
    .alert-success { background-color: #dcfce7; color: #166534; }
    .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); }
    .modal-content { background-color: #fefefe; margin: 10% auto; padding: 24px; border-radius: 0.75rem; width: 80%; max-width: 600px; }
    .modal-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 1rem; margin-bottom: 1rem; }
    .modal-title { font-size: 1.25rem; font-weight: 600; }
    .modal-close { font-size: 1.5rem; font-weight: 700; color: #000; cursor: pointer; border: none; background: none; }
    .modal-body { font-size: 1rem; }
    .modal-footer { margin-top: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem; }
    .info-grid { display: grid; grid-template-columns: 150px auto; gap: 0.5rem; }
    .badge {
        display: inline-block;
        padding: 0.35em 0.65em;
        font-size: .75em;
        font-weight: 700;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
    }
    .badge-danger { background-color: var(--danger-color); }
    .badge-success { background-color: var(--success-color); }
    .badge-warning { background-color: #f59e0b; }
</style>
@endpush

@section('content')
<div id="bermasalah-page">
    <div class="d-flex justify-content-between align-items-center my-4" style="margin-bottom: 1.5rem;">
        <h1>Data Mahasiswa Bermasalah</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.mahasiswa-bermasalah.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Data</a>
            <a href="{{ route('admin.mahasiswa-bermasalah.exportPdf') }}" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Export PDF</a>
            <a href="{{ route('admin.mahasiswa-bermasalah.exportCsv') }}" class="btn btn-success"><i class="fas fa-file-csv"></i> Export CSV</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="filter-bar">
        <form action="{{ route('admin.mahasiswa-bermasalah.index') }}" method="GET" class="d-flex gap-3">
            <input type="text" name="search" placeholder="Cari NIM/Nama Pelapor & Terlapor..." value="{{ request('search') }}">
            <select name="jenis_masalah">
                <option value="">Semua Jenis Masalah</option>
                <option value="Akademik" {{ request('jenis_masalah') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                <option value="Disiplin" {{ request('jenis_masalah') == 'Disiplin' ? 'selected' : '' }}>Disiplin</option>
                <option value="Etika & Perilaku" {{ request('jenis_masalah') == 'Etika & Perilaku' ? 'selected' : '' }}>Etika & Perilaku</option>
                <option value="Tata Tertib Kampus" {{ request('jenis_masalah') == 'Tata Tertib Kampus' ? 'selected' : '' }}>Tata Tertib Kampus</option>
            </select>
            <select name="status">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="ditanggapi" {{ request('status') == 'ditanggapi' ? 'selected' : '' }}>Ditanggapi</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
        </form>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>NIM Pelapor</th>
                    <th>Nama Pelapor</th>
                    <th>NIM Terlapor</th>
                    <th>Nama Terlapor</th>
                    <th>Jenis Masalah</th>
                    <th>Jenis Pelanggaran / Keterangan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengaduans as $pengaduan)
                    <tr>
                        <td>{{ $pengaduan->nim ?? 'Anonim' }}</td>
                        <td>{{ $pengaduan->nama ?? 'Anonim' }}</td>
                        <td>{{ $pengaduan->nim_terlapor ?? 'N/A' }}</td>
                        <td>{{ $pengaduan->nama_terlapor ?? 'N/A' }}</td>
                        <td>{{ $pengaduan->jenis_masalah }}</td>
                        <td>{{ Str::limit($pengaduan->keterangan, 50) }}</td>
                        <td>
    @if($pengaduan->status == 'selesai')
        <span class="badge badge-danger">Dinyatakan Bermasalah</span>
    @elseif($pengaduan->status == 'ditanggapi')
        <span class="badge badge-success">Dinyatakan Tidak Bermasalah</span>
    @else
        <span class="badge badge-warning">{{ ucfirst($pengaduan->status) }}</span>
    @endif
</td>
                        <td class="action-btns">
                            <button type="button" class="btn btn-primary view-btn" data-id="{{ $pengaduan->id }}" data-pengaduan='{{ json_encode($pengaduan) }}'>
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-danger delete-btn" data-id="{{ $pengaduan->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="delete-form-{{ $pengaduan->id }}" action="{{ route('admin.mahasiswa-bermasalah.destroy', $pengaduan->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">Tidak ada data pengaduan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $pengaduans->links('vendor.pagination.simple-bootstrap-5') }}
    </div>



    <!-- View Modal -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pengaduan</h5>
                <button type="button" class="modal-close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="info-grid">
                    <strong>NIM Pelapor:</strong> <span id="view_nim"></span>
                    <strong>Nama Pelapor:</strong> <span id="view_nama"></span>
                    <strong>NIM Terlapor:</strong> <span id="view_nim_terlapor"></span>
                    <strong>Nama Terlapor:</strong> <span id="view_nama_terlapor"></span>
                    <strong>Status Terlapor:</strong> <span id="view_status_terlapor"></span>
                    <strong>Jenis Masalah:</strong> <span id="view_jenis_masalah"></span>
                    <strong>Jenis Pelanggaran / Keterangan:</strong> <span id="view_keterangan"></span>
                    <strong>Status:</strong> <span id="view_status"></span>
                </div>
            </div>
            <div class="modal-footer">
                <form id="updateStatusForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" id="new_status">
                    <button type="submit" class="btn btn-danger" onclick="document.getElementById('new_status').value = 'selesai';">Dinyatakan Bermasalah</button>
                    <button type="submit" class="btn btn-success" onclick="document.getElementById('new_status').value = 'ditanggapi';">Dinyatakan Tidak Bermasalah</button>
                    
                </form>
            </div>            
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content" style="max-width: 400px; text-align: center;">
            <h3>Konfirmasi Hapus</h3>
            <p>Apakah Anda yakin ingin menghapus data ini?</p>
            <div class="modal-footer">
                <button type="button" id="cancelDelete" class="btn" style="background-color: #ccc;">Batal</button>
                <button type="button" id="confirmDelete" class="btn btn-danger">Hapus</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const viewModal = document.getElementById('viewModal');
        const deleteModal = document.getElementById('deleteModal');
        const confirmDelete = document.getElementById('confirmDelete');
        const cancelDelete = document.getElementById('cancelDelete');
        const updateStatusForm = document.getElementById('updateStatusForm');
        let formToSubmit;
        let pengaduanId;

        document.querySelectorAll('.view-btn').forEach(button => {
            button.addEventListener('click', function() {
                pengaduanId = this.dataset.id;
                const pengaduan = JSON.parse(this.dataset.pengaduan);
                document.getElementById('view_nim').textContent = pengaduan.nim ?? 'Anonim';
                document.getElementById('view_nama').textContent = pengaduan.nama ?? 'Anonim';
                document.getElementById('view_nim_terlapor').textContent = pengaduan.nim_terlapor ?? 'N/A';
                document.getElementById('view_nama_terlapor').textContent = pengaduan.nama_terlapor ?? 'N/A';
                document.getElementById('view_status_terlapor').textContent = pengaduan.status_terlapor ?? 'N/A';
                document.getElementById('view_jenis_masalah').textContent = pengaduan.jenis_masalah;
                document.getElementById('view_keterangan').textContent = pengaduan.keterangan;
                document.getElementById('view_status').textContent = pengaduan.status;

                let updateUrl = "{{ route('admin.mahasiswa-bermasalah.update', ':id') }}";
                updateUrl = updateUrl.replace(':id', pengaduanId);
                updateStatusForm.action = updateUrl;

                viewModal.style.display = 'block';
            });
        });

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const pengaduanId = this.dataset.id;
                formToSubmit = document.getElementById(`delete-form-${pengaduanId}`);
                deleteModal.style.display = 'block';
            });
        });

        cancelDelete.addEventListener('click', () => {
            deleteModal.style.display = 'none';
        });

        confirmDelete.addEventListener('click', () => {
            if (formToSubmit) {
                formToSubmit.submit();
            }
        });

        document.querySelectorAll('.modal-close').forEach(button => {
            button.addEventListener('click', () => {
                viewModal.style.display = 'none';
            });
        });

        window.addEventListener('click', (event) => {
            if (event.target == viewModal) {
                viewModal.style.display = 'none';
            }
            if (event.target == deleteModal) {
                deleteModal.style.display = 'none';
            }
        });

        // Close modal with the "Tutup" button
        document.querySelector('.modal-footer .btn[data-dismiss="modal"]').addEventListener('click', () => {
            viewModal.style.display = 'none';
        });
    });
</script>
@endpush