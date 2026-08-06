@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('kelas.index') }}" class="btn btn-outline-secondary btn-sm me-3"><i class="bi bi-arrow-left"></i> Kembali ke Data Kelas</a>
        <div>
            <h2 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-building-fill text-primary"></i> Detail Kelas: {{ $kelas->nama_kelas }}
            </h2>
        <div class="ms-auto">
            @if(Auth::user()->isAdmin())
                <a href="{{ route('kelas.edit', $kelas->id) }}" class="btn btn-warning text-dark fw-semibold shadow-sm">
                    <i class="bi bi-pencil-square me-1"></i> Edit Nama Kelas
                </a>
            @endif
        </div>
    </div>

    <!-- Overview Stat Card for Class -->
    <div class="card border-0 shadow-sm bg-primary bg-gradient text-white mb-4">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <span class="badge bg-white text-primary fw-bold px-3 py-2 mb-2 text-uppercase">
                    <i class="bi bi-info-circle-fill me-1"></i> Informasi Kelas
                </span>
                <h3 class="fw-bold text-white mb-1">Kelas {{ $kelas->nama_kelas }}</h3>
                <p class="mb-0 text-white-50">Menampilkan seluruh data siswa aktif di dalam kelas ini.</p>
            </div>
            <div class="bg-white bg-opacity-20 px-4 py-3 rounded-3 text-center border border-white border-opacity-25">
                <small class="text-white-50 d-block text-uppercase fw-bold mb-1">Total Siswa</small>
                <h2 class="fw-bold text-white mb-0">{{ $totalSiswa }}</h2>
            </div>
        </div>
    </div>

    <!-- Student Name List Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-people-fill text-primary me-2"></i>Daftar Nama Siswa ({{ $totalSiswa }})</h5>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('siswa.create') }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-person-plus-fill me-1"></i> Tambah Siswa</a>
            @endif
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 60px;">No</th>
                            <th style="width: 70px;">Foto</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Jurusan</th>
                            <th>Status</th>
                            @if(Auth::user()->isAdmin())
                                <th class="pe-4 text-end">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswaList as $index => $s)
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">{{ $index + 1 }}</td>
                                <td>
                                    @if($s->foto)
                                        <img src="{{ asset('storage/'.$s->foto) }}" alt="{{ $s->nama }}" class="rounded-circle object-fit-cover" style="width: 40px; height: 40px;">
                                    @else
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($s->nama, 0, 1)) }}
                                        </div>
                                    @endif
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $s->nis }}</span></td>
                                <td class="fw-bold text-dark">{{ $s->nama }}</td>
                                <td><span class="badge bg-secondary">{{ $s->jurusan }}</span></td>
                                <td>
                                    @if($s->status === 'Aktif')
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger">{{ $s->status }}</span>
                                    @endif
                                </td>
                                @if(Auth::user()->isAdmin())
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('siswa.edit', $s->id) }}" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ Auth::user()->isAdmin() ? '7' : '6' }}" class="text-center py-5 text-muted">
                                    <i class="bi bi-people fs-1 d-block mb-2 text-secondary"></i>
                                    Belum ada siswa yang terdaftar di kelas {{ $kelas->nama_kelas }}.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
