@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 1200px; margin: 0 auto;">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-mortarboard-fill text-primary me-2"></i>Data Tracer Alumni (Kuliah & Karir Kerja)
            </h2>
            <p class="text-muted mb-0">Laporan jejak karir dan studi lanjut lulusan siswa sekolah.</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Summary Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-gradient bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50 fw-bold d-block">TOTAL SISWA LULUS</small>
                        <h3 class="fw-bold mb-0">{{ $totalAlumni }}</h3>
                    </div>
                    <i class="bi bi-mortarboard fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-gradient bg-success text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50 fw-bold d-block">MELANJUTKAN KULIAH</small>
                        <h3 class="fw-bold mb-0">{{ $totalKuliah }}</h3>
                    </div>
                    <i class="bi bi-bank fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-gradient bg-info text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50 fw-bold d-block">BEKERJA / KARIR</small>
                        <h3 class="fw-bold mb-0">{{ $totalBekerja }}</h3>
                    </div>
                    <i class="bi bi-briefcase fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-gradient bg-warning text-dark">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-dark-50 fw-bold d-block">WIRAUSAHA</small>
                        <h3 class="fw-bold mb-0">{{ $totalWirausaha }}</h3>
                    </div>
                    <i class="bi bi-shop fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.alumni.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-6">
                    <select name="status" class="form-select fw-semibold" onchange="this.form.submit()">
                        <option value="">-- Semua Status Alumni --</option>
                        <option value="Kuliah" {{ $statusFilter === 'Kuliah' ? 'selected' : '' }}>🎓 Kuliah / Perguruan Tinggi</option>
                        <option value="Bekerja" {{ $statusFilter === 'Bekerja' ? 'selected' : '' }}>💼 Bekerja / Karir Company</option>
                        <option value="Kuliah & Bekerja" {{ $statusFilter === 'Kuliah & Bekerja' ? 'selected' : '' }}>🌟 Kuliah & Bekerja</option>
                        <option value="Wirausaha" {{ $statusFilter === 'Wirausaha' ? 'selected' : '' }}>🏪 Wirausaha / Bisnis Mandiri</option>
                        <option value="Mencari Kerja" {{ $statusFilter === 'Mencari Kerja' ? 'selected' : '' }}>🔍 Mencari Kerja</option>
                    </select>
                </div>
                <div class="col-md-6 text-end">
                    <span class="badge bg-secondary px-3 py-2 fs-6">Menampilkan {{ count($tracers) }} Data Tracer</span>
                </div>
            </form>
        </div>
    </div>

    <!-- Table List -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Siswa Alumni</th>
                            <th>Status Alumni</th>
                            <th>Universitas / Perusahaan</th>
                            <th>Jurusan / Posisi</th>
                            <th>Tahun & Lokasi</th>
                            <th class="pe-4 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tracers as $idx => $t)
                            <tr>
                                <td class="ps-4 fw-bold text-muted">{{ $idx + 1 }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $t->siswa->nama ?? 'Siswa' }}</div>
                                    <small class="text-muted font-monospace">NIS: {{ $t->siswa->nis ?? '-' }} | Lulus {{ $t->siswa->tahun_lulus ?? '-' }}</small>
                                </td>
                                <td>
                                    @if(str_contains($t->status_alumni, 'Kuliah'))
                                        <span class="badge bg-success fs-6"><i class="bi bi-bank me-1"></i>{{ $t->status_alumni }}</span>
                                    @elseif($t->status_alumni === 'Bekerja')
                                        <span class="badge bg-info text-dark fs-6"><i class="bi bi-briefcase me-1"></i>Bekerja</span>
                                    @elseif($t->status_alumni === 'Wirausaha')
                                        <span class="badge bg-warning text-dark fs-6"><i class="bi bi-shop me-1"></i>Wirausaha</span>
                                    @else
                                        <span class="badge bg-secondary fs-6">{{ $t->status_alumni }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-primary">{{ $t->nama_instansi }}</div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $t->jurusan_atau_jabatan ?? '-' }}</div>
                                </td>
                                <td>
                                    <div class="small fw-semibold text-dark">Thn: {{ $t->tahun_masuk ?? '-' }}</div>
                                    <small class="text-muted">{{ $t->lokasi ?? '-' }}</small>
                                </td>
                                <td class="pe-4 text-end">
                                    <form action="{{ route('admin.alumni.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Hapus data alumni ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    Belum ada data tracer alumni yang diisi oleh siswa lulus.
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
