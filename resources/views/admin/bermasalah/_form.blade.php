@csrf

<div class="form-group">
    <label for="nim">NIM Pelapor</label>
    <input type="text" id="nim" name="nim" class="form-control @error('nim') is-invalid @enderror" placeholder="Masukkan NIM Anda" value="{{ old('nim', $pengaduan->nim ?? '') }}" {{ isset($pengaduan) && $pengaduan->anonim ? 'disabled' : '' }} required>
    @error('nim')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="nama">Nama Pelapor</label>
    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama lengkap Anda" value="{{ old('nama', $pengaduan->nama ?? '') }}" required>
    @error('nama')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="col-12">
    <hr class="my-3">
    <h5 class="subtitle" style="font-size: 1.1rem; color: var(--text-main); font-weight: 600;">Pihak yang Dilaporkan</h5>
</div>

<div class="form-group">
    <label for="nama_terlapor">Nama Terlapor</label>
    <input type="text" id="nama_terlapor" name="nama_terlapor" class="form-control @error('nama_terlapor') is-invalid @enderror" placeholder="Nama Mahasiswa yang dilaporkan" value="{{ old('nama_terlapor', $pengaduan->nama_terlapor ?? '') }}" required>
    @error('nama_terlapor')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="nim_terlapor">NIM Terlapor</label>
    <input type="text" id="nim_terlapor" name="nim_terlapor" class="form-control @error('nim_terlapor') is-invalid @enderror" placeholder="NIM Mahasiswa yang dilaporkan" value="{{ old('nim_terlapor', $pengaduan->nim_terlapor ?? '') }}" required>
    @error('nim_terlapor')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<input type="hidden" name="status_terlapor" value="Mahasiswa">



<div class="form-group">
    <label for="jenis_masalah">Jenis Masalah</label>
    <select id="jenis_masalah" name="jenis_masalah" class="form-control @error('jenis_masalah') is-invalid @enderror" required>
        <option value="">-- Pilih Jenis Masalah --</option>
        <option value="Akademik" {{ old('jenis_masalah', $pengaduan->jenis_masalah ?? '') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
        <option value="Keuangan" {{ old('jenis_masalah', $pengaduan->jenis_masalah ?? '') == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
        <option value="Disiplin" {{ old('jenis_masalah', $pengaduan->jenis_masalah ?? '') == 'Disiplin' ? 'selected' : '' }}>Disiplin</option>
        <option value="Administrasi" {{ old('jenis_masalah', $pengaduan->jenis_masalah ?? '') == 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
        <option value="Lainnya" {{ old('jenis_masalah', $pengaduan->jenis_masalah ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
    </select>
    @error('jenis_masalah')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="keterangan">Jenis Pelanggaran / Keterangan Tambahan</label>
    <textarea id="keterangan" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="4" placeholder="Jelaskan masalah yang ingin Anda laporkan" required>{{ old('keterangan', $pengaduan->keterangan ?? '') }}</textarea>
    @error('keterangan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>



<div class="form-group">
    <label for="status">Status</label>
    <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
        <option value="pending" {{ old('status', $pengaduan->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="ditanggapi" {{ old('status', $pengaduan->status ?? '') == 'ditanggapi' ? 'selected' : '' }}>Ditanggapi</option>
        <option value="selesai" {{ old('status', $pengaduan->status ?? '') == 'selesai' ? 'selected' : '' }}>Selesai</option>
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-actions">
    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
</div>