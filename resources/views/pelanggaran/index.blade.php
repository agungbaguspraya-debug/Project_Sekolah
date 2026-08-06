@extends('layouts.app')

@section('content')
<div class="row" style="max-width: 1000px; margin: 0 auto;">
    <div class="col-md-12 mb-4 d-flex align-items-center">
        <a href="{{ route('siswa.index') }}" class="btn btn-outline-secondary btn-sm me-3">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Siswa
        </a>
        <h2 class="fw-bold mb-0"><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>Catatan Pelanggaran Siswa</h2>
    </div>

    <!-- Student Summary Widget -->
    <div class="col-md-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 d-flex align-items-center">
                @if($siswa->foto)
                    <img src="{{ asset('storage/'.$siswa->foto) }}" alt="Foto {{ $siswa->nama }}" class="rounded-circle object-cover border me-4" style="width: 80px; height: 80px;">
                @else
                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-4" style="width: 80px; height: 80px;">
                        <i class="bi bi-person-fill fs-2"></i>
                    </div>
                @endif
                <div>
                    <h4 class="fw-bold mb-1 text-dark">{{ $siswa->nama }}</h4>
                    <p class="text-muted mb-2">NIS: <span class="fw-bold">{{ $siswa->nis }}</span> | Kelas: <span class="fw-bold">{{ $siswa->kelas }}</span> | Jurusan: <span class="fw-bold">{{ $siswa->jurusan }}</span></p>
                    <span class="badge bg-danger fs-6">Akumulasi: {{ $totalPoints }} Poin Pelanggaran</span>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="col-md-12 mb-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- Add Violation Form -->
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-dark text-white py-3">
                <h5 class="mb-0 fw-bold">Catat Pelanggaran Baru</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('siswa.pelanggaran.store', $siswa->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_pelanggaran" class="form-label fw-bold">Nama Pelanggaran</label>
                        <input type="text" name="nama_pelanggaran" id="nama_pelanggaran" class="form-control" placeholder="Contoh: Terlambat masuk sekolah" required>
                    </div>

                    <div class="mb-3">
                        <label for="point" class="form-label fw-bold">Poin Pelanggaran</label>
                        <input type="number" name="point" id="point" class="form-control" placeholder="Contoh: 10" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label fw-bold">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle-fill me-1"></i> Catat Pelanggaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Violation Records List -->
    <div class="col-md-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-bold text-dark">Daftar Pelanggaran</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 60px;">No</th>
                                <th>Nama Pelanggaran</th>
                                <th style="width: 150px;">Tanggal</th>
                                <th style="width: 100px;">Poin</th>
                                <th class="pe-4 text-end" style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pelanggarans as $index => $item)
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">{{ $index + 1 }}</td>
                                <td class="fw-bold text-dark">{{ $item->nama_pelanggaran }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                                <td>
                                    <span class="badge bg-danger fs-6">{{ $item->point }}</span>
                                </td>
                                <td class="pe-4 text-end">
                                    <form action="{{ route('siswa.pelanggaran.destroy', [$siswa->id, $item->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan pelanggaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash-fill"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-emoji-smile text-success fs-1 mb-2 d-block"></i>
                                    Siswa ini tidak memiliki catatan pelanggaran.
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
