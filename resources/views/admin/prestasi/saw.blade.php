@extends('layouts.admin')

@section('title', 'Edit Bobot SAW')

@push('styles')
<style>
    #saw-weights-page {
        max-width: 800px;
        margin: auto;
        background-color: #fff;
        padding: 2rem;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,.1), 0 2px 4px -1px rgba(0,0,0,.06);
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #374151;
    }
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    .form-control:focus {
        outline: 0;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
    }
    .btn-base {
        padding: 1rem 2rem;
        border: none;
        border-radius: 0.375rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color .15s ease-in-out;
        box-sizing: border-box; /* Ensure consistent box model */
        line-height: normal; /* Override browser defaults */
        text-decoration: none; /* For anchor tags */
        display: inline-block; /* For consistent behavior */
        font-size: 1rem; /* Explicit font size */
        font-family: inherit; /* Inherit font from parent */
        vertical-align: middle; /* Align vertically */
        white-space: nowrap; /* Prevent text wrapping */
    }
    .btn-primary {
        background-color: #2563eb;
        color: #fff;
    }
    .btn-primary:hover {
        background-color: #1d4ed8;
    }
    .btn-secondary {
        background-color: #6b7280;
        color: #fff;
    }
    .btn-secondary:hover {
        background-color: #4b5563;
    }
    .total-weight {
        font-weight: 700;
        font-size: 1.125rem;
        color: #1f2937;
    }
    .alert-danger {
        background-color: #fee2e2;
        color: #b91c1c;
        padding: 1rem;
        border-radius: 0.375rem;
        margin-bottom: 1.5rem;
    }
</style>
@endpush

@section('content')
<div id="saw-weights-page">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Edit Bobot Kriteria SAW</h1>
    </div>

    <p class="mb-4 text-secondary">
        Sesuaikan bobot untuk setiap kriteria. Pastikan total bobot dari semua kriteria adalah 1 (atau 100%).
    </p>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.prestasi.saw.update') }}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="c1">C1 - IPK (Indeks Prestasi Kumulatif)</label>
                    <input type="number" name="weights[C1]" id="c1" class="form-control weight-input" value="{{ old('weights.C1', $weights['C1'] ?? '') }}" step="0.01">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="c2">C2 - Tingkat Kegiatan</label>
                    <input type="number" name="weights[C2]" id="c2" class="form-control weight-input" value="{{ old('weights.C2', $weights['C2'] ?? '') }}" step="0.01">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="c3">C3 - Prestasi yang Dicapai</label>
                    <input type="number" name="weights[C3]" id="c3" class="form-control weight-input" value="{{ old('weights.C3', $weights['C3'] ?? '') }}" step="0.01">
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="total-weight">
                Total Bobot: <span id="total-weight-display">0</span>
            </div>
            <div class="d-flex gap-3">
                <button type="submit" class="btn-base btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.prestasi.index') }}" class="btn-base btn-secondary">Kembali</a>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const weightInputs = document.querySelectorAll('.weight-input');
    const totalWeightDisplay = document.getElementById('total-weight-display');

    function calculateTotalWeight() {
        let total = 0;
        weightInputs.forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        totalWeightDisplay.textContent = total.toFixed(2);
        
        if (total.toFixed(2) != 1.00) {
            totalWeightDisplay.style.color = '#ef4444'; // Danger color
        } else {
            totalWeightDisplay.style.color = '#22c55e'; // Success color
        }
    }

    weightInputs.forEach(input => {
        input.addEventListener('input', calculateTotalWeight);
    });

    calculateTotalWeight(); // Initial calculation
});
</script>
@endpush
