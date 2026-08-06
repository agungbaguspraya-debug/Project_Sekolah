@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('kelas.index') }}" class="btn btn-outline-secondary btn-sm me-3"><i class="bi bi-arrow-left"></i> Kembali</a>
            <h3 class="fw-bold mb-0 text-dark">Edit Data Kelas</h3>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama_kelas" class="form-label fw-bold">Nama Kelas</label>
                        <input type="text" name="nama_kelas" id="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required>
                        @error('nama_kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-info-circle me-1"></i> Mengubah nama kelas akan secara otomatis memperbarui data kelas pada seluruh Siswa, Tugas, dan Jadwal terkait.
                        </small>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('kelas.index') }}" class="btn btn-light px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-circle me-1"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
