@extends('layouts.admin')

@section('title', 'Kelola Aspirasi')

@section('content')
<div id="aspirasi-admin-page">
    <h1>Kelola Aspirasi</h1>

    <section class="data-table-container" style="margin-top:12px">
        <div style="margin-bottom:12px;">
            <a href="{{ route('admin.aspirasi.printPdf') }}" class="btn-print" target="_blank">
    <i class="fas fa-print"></i> Cetak PDF
</a>
        </div>

        @if(session('ok'))
            <div style="padding:10px 12px;border-radius:8px;background:#ecfdf5;color:#065f46;margin-bottom:12px;">
                {{ session('ok') }}
            </div>
        @endif

        <table class="data-table">
            <thead>
                <tr>
                    <th>NAMA</th>
                    <th>EMAIL</th>
                    <th>PESAN</th>
                    <th>WAKTU</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aspirasis as $aspirasi)
                    <tr>
                        <td>{{ strtoupper($aspirasi->nama) }}</td>
                        <td>{{ $aspirasi->email }}</td>
                        <td style="max-width:320px">{{ Str::limit($aspirasi->pesan, 60) }}</td>
                        <td>{{ $aspirasi->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <button type="button" class="btn-blue btn-lihat"
                                data-nama="{{ $aspirasi->nama }}"
                                data-email="{{ $aspirasi->email }}"
                                data-pesan="{{ nl2br(e($aspirasi->pesan)) }}"
                                data-waktu="{{ $aspirasi->created_at->format('d F Y, H:i') }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <form action="{{ route('admin.aspirasi.destroy', $aspirasi) }}" method="POST" class="delete-form" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-red btn-hapus"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;color:#888;">Belum ada aspirasi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:12px;">
            {{ $aspirasis->links('vendor.pagination.simple-bootstrap-5') }}
        </div>
    </section>

    <!-- Custom Modals -->
    <div id="viewModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="custom-modal-close">&times;</span>
            <h2>Detail Aspirasi</h2>
            <div class="modal-body-content">
                <div class="aspirasi-info"><strong class="info-label">Dari:</strong> <span id="viewNama"></span></div>
                <div class="aspirasi-info"><strong class="info-label">Email:</strong> <span id="viewEmail"></span></div>
                <div class="aspirasi-info"><strong class="info-label">Waktu:</strong> <span id="viewWaktu"></span></div>
                <hr class="aspirasi-divider">
                <div class="aspirasi-pesan">
                    <strong class="info-label">Isi Pesan:</strong>
                    <p id="viewPesan"></p>
                </div>
            </div>
        </div>
    </div>

    <div id="deleteModal" class="custom-modal">
        <div class="custom-modal-content" style="max-width: 400px;">
            <span class="custom-modal-close">&times;</span>
            <h2>Konfirmasi Hapus</h2>
            <p>Apakah Anda yakin ingin menghapus aspirasi ini?</p>
            <div class="modal-footer-buttons">
                <button type="button" id="confirmDeleteBtn" class="btn-danger">Hapus</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
#aspirasi-admin-page .btn-print{background:#22c55e;color:#fff;padding:8px 14px;border-radius:8px;font-weight:600;text-decoration:none}
#aspirasi-admin-page .btn-blue{background:#3b82f6;color:#fff;padding:6px 10px;border-radius:6px;text-decoration:none;margin-right:6px;font-weight:600; border: none; cursor: pointer;}
#aspirasi-admin-page .btn-red{background:#ef4444;color:#fff;padding:6px 10px;border-radius:6px;border:0;font-weight:600;cursor:pointer}
#aspirasi-admin-page .data-table{width:100%;border-collapse:collapse}
#aspirasi-admin-page .data-table th,#aspirasi-admin-page .data-table td{border:1px solid #e5e7eb;padding:8px 12px}
#aspirasi-admin-page .data-table th{background:#f9fafb}

/* Custom Modal Styles with higher specificity */
#aspirasi-admin-page .custom-modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:rgba(0,0,0,0.5)}
#aspirasi-admin-page .custom-modal-content{background-color:#fefefe;margin:10% auto;padding:20px;border:1px solid #888;width:80%;max-width:600px;border-radius:8px;position:relative}
#aspirasi-admin-page .custom-modal-close{color:#aaa;float:right;font-size:28px;font-weight:bold;cursor:pointer} 
#aspirasi-admin-page .custom-modal-close:hover,#aspirasi-admin-page .custom-modal-close:focus{color:black;text-decoration:none}
#aspirasi-admin-page .modal-body-content{padding-top: 20px;}
#aspirasi-admin-page .aspirasi-info{display:flex;margin-bottom:12px}
#aspirasi-admin-page .info-label{width:80px;font-weight:600;color:#4b5563}
#aspirasi-admin-page .aspirasi-divider{margin:20px 0;border:0;border-top:1px solid #e5e7eb}
#aspirasi-admin-page .aspirasi-pesan p{margin-top:8px;line-height:1.6;color:#374151;white-space:pre-wrap;}
#aspirasi-admin-page .modal-footer-buttons{text-align:right;margin-top:20px;}
#aspirasi-admin-page .modal-footer-buttons button{margin-left:10px;padding:8px 15px;border-radius:6px;cursor:pointer;border:none;font-weight:500;}
#aspirasi-admin-page .btn-secondary{background-color:#6c757d;color:white;}
#aspirasi-admin-page .btn-danger{background-color:#dc3545;color:white;}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const pageContainer = document.getElementById('aspirasi-admin-page');
    if (!pageContainer) return;

    const viewModal = pageContainer.querySelector('#viewModal');
    const deleteModal = pageContainer.querySelector('#deleteModal');
    const closeButtons = pageContainer.querySelectorAll('.custom-modal-close');
    let formToSubmit = null;

    // Open View Modal
    pageContainer.querySelectorAll('.btn-lihat').forEach(button => {
        button.addEventListener('click', function() {
            pageContainer.querySelector('#viewNama').textContent = this.dataset.nama;
            pageContainer.querySelector('#viewEmail').innerHTML = `<a href="mailto:${this.dataset.email}">${this.dataset.email}</a>`;
            pageContainer.querySelector('#viewWaktu').textContent = this.dataset.waktu;
            pageContainer.querySelector('#viewPesan').innerHTML = this.dataset.pesan;
            viewModal.style.display = 'block';
        });
    });

    // Open Delete Modal
    pageContainer.querySelectorAll('.btn-hapus').forEach(button => {
        button.addEventListener('click', function() {
            formToSubmit = this.closest('.delete-form');
            deleteModal.style.display = 'block';
        });
    });

    // Confirm Delete
    pageContainer.querySelector('#confirmDeleteBtn').addEventListener('click', function() {
        if (formToSubmit) {
            formToSubmit.submit();
        }
    });

    // Close Modal Logic
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            viewModal.style.display = 'none';
            deleteModal.style.display = 'none';
        });
    });

    window.addEventListener('click', function(event) {
        if (event.target == viewModal) {
            viewModal.style.display = 'none';
        }
        if (event.target == deleteModal) {
            deleteModal.style.display = 'none';
        }
    });
});
</script>
@endpush
