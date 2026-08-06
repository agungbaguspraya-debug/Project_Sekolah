@extends('layouts.app')

@section('content')
<div class="row" style="max-width: 950px; margin: 0 auto;">
    <div class="col-md-12 mb-4">
        <h2 class="fw-bold"><i class="bi bi-journal-text me-2"></i>Kelola Jurusan</h2>
        <p class="text-muted">Tambah, edit, dan hapus data jurusan sekolah.</p>
    </div>

    @if(session('success'))
        <div class="col-md-12 mb-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- Add Major Form -->
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-dark text-white py-3">
                <h5 class="mb-0 fw-bold">Tambah Jurusan</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('jurusan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_jurusan" class="form-label fw-bold">Nama Jurusan</label>
                        <input type="text" name="nama_jurusan" id="nama_jurusan" class="form-control @error('nama_jurusan') is-invalid @enderror" placeholder="Contoh: Rekayasa Perangkat Lunak" required>
                        @error('nama_jurusan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle-fill me-1"></i> Tambah Jurusan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Major List Table -->
    <div class="col-md-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-bold text-dark">Daftar Jurusan</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 80px;">No</th>
                                <th>Nama Jurusan</th>
                                <th class="pe-4 text-end" style="width: 180px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jurusans as $index => $item)
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">{{ $index + 1 }}</td>
                                <td class="fw-bold text-dark">{{ $item->nama_jurusan }}</td>
                                <td class="pe-4 text-end">
                                    <div class="d-inline-flex gap-1">
                                        <button type="button" class="btn btn-warning btn-sm text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#editJurusanModal_{{ $item->id }}" title="Edit Jurusan">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>
                                        <form action="{{ route('jurusan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurusan ini?')" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus Jurusan">
                                                <i class="bi bi-trash-fill"></i> Hapus
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Modal Edit Jurusan -->
                                    <div class="modal fade text-start" id="editJurusanModal_{{ $item->id }}" tabindex="-1" aria-labelledby="editJurusanModalLabel_{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-warning text-dark">
                                                    <h5 class="modal-header-title fw-bold mb-0" id="editJurusanModalLabel_{{ $item->id }}">
                                                        <i class="bi bi-pencil-square me-2"></i>Edit Data Jurusan
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('jurusan.update', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body p-4">
                                                        <div class="mb-3">
                                                            <label for="nama_jurusan_{{ $item->id }}" class="form-label fw-bold">Nama Jurusan</label>
                                                            <input type="text" name="nama_jurusan" id="nama_jurusan_{{ $item->id }}" class="form-control" value="{{ $item->nama_jurusan }}" required>
                                                            <small class="text-muted mt-1 d-block">Nama jurusan pada data siswa yang terkait akan diperbarui secara otomatis.</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">
                                    Belum ada data jurusan. Silakan tambahkan terlebih dahulu.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
