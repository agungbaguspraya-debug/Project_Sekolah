@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1"><i class="bi bi-building-fill text-primary me-2"></i>Kelola & Data Kelas</h2>
            <p class="text-muted mb-0">Daftar kelas terkelompok berdasarkan Jurusan, serta arsip khusus siswa yang telah lulus.</p>
        </div>
        @if(Auth::user()->isAdmin())
            <button type="button" class="btn btn-primary shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#tambahKelasModal">
                <i class="bi bi-plus-circle-fill me-1"></i> Tambah Kelas Baru
            </button>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Nav Filter Tabs: Kelas Aktif vs Arsip Kelulusan -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <ul class="nav nav-pills gap-2" id="kelasTab">
                <li class="nav-item">
                    <a href="{{ route('kelas.index', ['tab' => 'aktif']) }}" class="nav-link fw-bold px-4 rounded-3 {{ $tab === 'aktif' ? 'active' : 'bg-light text-dark' }}">
                        <i class="bi bi-building me-1"></i> Data Kelas Aktif
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kelas.index', ['tab' => 'alumni']) }}" class="nav-link fw-bold px-4 rounded-3 {{ $tab === 'alumni' ? 'active' : 'bg-light text-dark' }}">
                        <i class="bi bi-mortarboard-fill me-1"></i> Arsip Kelulusan (Siswa Lulus)
                    </a>
                </li>
            </ul>
        </div>
    </div>

    @if($tab === 'aktif')
        <!-- TAB 1: KELOLA & DATA KELAS AKTIF -->
        <div class="accordion shadow-sm border-0 rounded-3 overflow-hidden" id="accordionJurusanKelas">
            @forelse($groupedKelas as $groupName => $kelasList)
                @php
                    $collapseId = 'collapse_' . Str::slug($groupName);
                    $headingId = 'heading_' . Str::slug($groupName);
                    $totalSiswaGroup = collect($kelasList)->sum('total_siswa');
                @endphp
                <div class="accordion-item border-0 border-bottom">
                    <h2 class="accordion-header" id="{{ $headingId }}">
                        <button class="accordion-button bg-white text-dark py-3 px-4 shadow-none border-0 d-flex justify-content-between align-items-center" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#{{ $collapseId }}" 
                                aria-expanded="true" 
                                aria-controls="{{ $collapseId }}">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3">
                                    <i class="bi bi-folder-fill fs-5"></i>
                                </div>
                                <div>
                                    <span class="fw-bold text-dark fs-5">{{ $groupName }}</span>
                                    <span class="badge bg-secondary ms-2 fw-normal">{{ count($kelasList) }} Kelas</span>
                                </div>
                            </div>
                            <div class="me-3">
                                <span class="badge bg-info bg-opacity-10 text-info border border-info px-3 py-2">
                                    <i class="bi bi-people-fill me-1"></i> Total {{ $totalSiswaGroup }} Siswa Aktif
                                </span>
                            </div>
                        </button>
                    </h2>
                    <div id="{{ $collapseId }}" class="accordion-collapse collapse show" aria-labelledby="{{ $headingId }}" data-bs-parent="#accordionJurusanKelas">
                        <div class="accordion-body p-4 bg-light bg-opacity-50">
                            @php
                                $byLevel = [
                                    'Tingkat X (Kelas 10)' => collect($kelasList)->filter(fn($k) => str_starts_with($k->nama_kelas, 'X ') || str_starts_with($k->nama_kelas, '10 ')),
                                    'Tingkat XI (Kelas 11)' => collect($kelasList)->filter(fn($k) => str_starts_with($k->nama_kelas, 'XI ') || str_starts_with($k->nama_kelas, '11 ')),
                                    'Tingkat XII (Kelas 12)' => collect($kelasList)->filter(fn($k) => str_starts_with($k->nama_kelas, 'XII ') || str_starts_with($k->nama_kelas, '12 ')),
                                    'Lainnya' => collect($kelasList)->reject(fn($k) => 
                                        str_starts_with($k->nama_kelas, 'X ') || str_starts_with($k->nama_kelas, '10 ') ||
                                        str_starts_with($k->nama_kelas, 'XI ') || str_starts_with($k->nama_kelas, '11 ') ||
                                        str_starts_with($k->nama_kelas, 'XII ') || str_starts_with($k->nama_kelas, '12 ')
                                    )
                                ];
                            @endphp

                            @foreach($byLevel as $levelTitle => $levelItems)
                                @if(count($levelItems) > 0)
                                    <div class="mb-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <span class="badge bg-white text-primary border border-primary border-opacity-25 px-3 py-2 fw-bold me-2 shadow-sm" style="font-size: 0.85rem;">
                                                <i class="bi bi-layers-fill me-1 text-primary"></i> {{ $levelTitle }}
                                            </span>
                                            <div class="flex-grow-1 border-bottom border-secondary border-opacity-25"></div>
                                        </div>

                                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
                                            @foreach($levelItems as $k)
                                                <div class="col">
                                                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-all bg-white rounded-3">
                                                        <div class="card-body p-3">
                                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                                <span class="badge bg-secondary bg-opacity-10 text-dark fw-bold px-2 py-1 small border">Kelas</span>
                                                                @if(Auth::user()->isAdmin())
                                                                    <div class="d-flex gap-2">
                                                                        <a href="{{ route('kelas.edit', $k->id) }}" class="btn btn-link text-warning p-0 border-0" title="Edit Nama Kelas">
                                                                            <i class="bi bi-pencil-square fs-6"></i>
                                                                        </a>
                                                                        <form action="{{ route('kelas.destroy', $k->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kelas {{ $k->nama_kelas }} beserta siswa aktif di dalamnya?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-link text-danger p-0 border-0" title="Hapus Kelas">
                                                                                <i class="bi bi-trash fs-6"></i>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            
                                                            <!-- Clickable Class Title -->
                                                            <a href="{{ route('kelas.show', $k->id) }}" class="text-decoration-none">
                                                                <h5 class="fw-bold text-dark mb-2 hover-primary">{{ $k->nama_kelas }}</h5>
                                                                <div class="d-flex align-items-center text-muted small bg-light p-2 rounded-2 border border-light">
                                                                    <i class="bi bi-people-fill text-info me-2 fs-6"></i>
                                                                    <span>Siswa Aktif: <strong>{{ $k->total_siswa }}</strong></span>
                                                                    <i class="bi bi-chevron-right ms-auto text-primary"></i>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="card border-0 p-5 text-center text-muted">
                    <i class="bi bi-building-dash fs-1 mb-2 text-secondary"></i>
                    Belum ada data kelas yang terdaftar.
                </div>
            @endforelse
        </div>

    @else
        <!-- TAB 2: ARSIP SISWA LULUS / KELULUSAN (Grouped by Tahun & Kelas) -->
        @forelse($groupedAlumni as $tahun => $kelasListAlumni)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-mortarboard-fill me-2 text-warning"></i>Arsip Kelulusan Tahun {{ $tahun }}</h5>
                    <span class="badge bg-warning text-dark fw-bold fs-6">
                        Total {{ collect($kelasListAlumni)->flatten(1)->count() }} Alumni
                    </span>
                </div>
                <div class="card-body p-4 bg-light">
                    <div class="row g-4">
                        @foreach($kelasListAlumni as $namaKelas => $siswaAlumniList)
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100 bg-white">
                                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold mb-0 text-dark">
                                            <i class="bi bi-building me-1 text-primary"></i> Kelas Terakhir: <strong>{{ $namaKelas }}</strong>
                                        </h6>
                                        <span class="badge bg-success">{{ count($siswaAlumniList) }} Lulusan</span>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0 small">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="ps-3">NIS</th>
                                                        <th>Nama Alumni</th>
                                                        <th>Total Nilai</th>
                                                        <th class="pe-3 text-end">Foto Kenangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($siswaAlumniList as $alumni)
                                                    <tr>
                                                        <td class="ps-3 font-monospace text-muted">{{ $alumni->nis }}</td>
                                                        <td class="fw-bold text-dark">{{ $alumni->nama }}</td>
                                                        <td><span class="badge bg-info text-dark">{{ number_format($alumni->total_nilai ?? 85.00, 2) }}</span></td>
                                                        <td class="pe-3 text-end">
                                                            @if($alumni->foto_kenangan)
                                                                <a href="{{ asset('storage/'.$alumni->foto_kenangan) }}" target="_blank" class="badge bg-success text-decoration-none">
                                                                    <i class="bi bi-camera me-1"></i> Lihat Foto
                                                                </a>
                                                            @else
                                                                <span class="text-muted text-italic">Belum ada</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="card border-0 shadow-sm p-5 text-center text-muted">
                <i class="bi bi-mortarboard fs-1 d-block mb-2 text-secondary"></i>
                Belum ada data siswa yang diluluskan.
            </div>
        @endforelse
    @endif
</div>

@if(Auth::user()->isAdmin())
<!-- Modal Tambah Kelas -->
<div class="modal fade" id="tambahKelasModal" tabindex="-1" aria-labelledby="tambahKelasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-header-title mb-0 fw-bold" id="tambahKelasModalLabel"><i class="bi bi-plus-circle-fill me-2"></i>Tambah Kelas Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('kelas.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="nama_kelas" class="form-label fw-bold">Nama / Suffix Kelas</label>
                        <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" placeholder="Contoh: DKV 2, RPL 3, TKJ 1" required>
                        <small class="text-muted mt-2 d-block bg-light p-2 rounded border">
                            <i class="bi bi-magic text-primary me-1"></i> Cukup ketik nama/suffix (misal <strong>DKV 2</strong>), sistem otomatis akan membuatkan 3 tingkat kelas: <strong>X DKV 2</strong>, <strong>XI DKV 2</strong>, dan <strong>XII DKV 2</strong>!
                        </small>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-save me-1"></i> Simpan Kelas</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<style>
    .accordion-button:not(.collapsed) {
        background-color: #f8fafc !important;
        color: #0f172a !important;
    }
    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
        transition: all 0.2s ease-in-out;
    }
    .hover-primary:hover {
        color: #2563eb !important;
    }
</style>
@endsection
