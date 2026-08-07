@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 1200px; margin: 0 auto;">
    <!-- Title -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-trophy-fill text-warning me-2"></i>Kelola Prestasi Siswa Berprestasi
            </h2>
            <p class="text-muted mb-0">Kelola dan tampilkan pencapaian serta prestasi kebanggaan siswa di halaman utama sekolah.</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Form Add Achievement (Left) -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-dark text-white py-3 border-0">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle-fill text-warning me-2"></i>Tambah Prestasi Siswa</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.prestasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Siswa Selection -->
                        <div class="mb-3">
                            <label for="siswa_id" class="form-label fw-bold small">Pilih Siswa (Opsional)</label>
                            <select name="siswa_id" id="siswa_id" class="form-select form-select-sm">
                                <option value="">-- Pilih dari Data Siswa --</option>
                                @foreach($siswas as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama }} (Kelas {{ $s->kelas }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Manual Name Fallback -->
                        <div class="mb-3">
                            <label for="nama_siswa" class="form-label fw-bold small">Atau Tulis Nama Siswa Manual</label>
                            <input type="text" name="nama_siswa" id="nama_siswa" class="form-control form-control-sm" placeholder="Nama lengkap siswa berprestasi...">
                        </div>

                        <!-- Judul Prestasi -->
                        <div class="mb-3">
                            <label for="judul_prestasi" class="form-label fw-bold small">Judul / Nama Kejuaraan <span class="text-danger">*</span></label>
                            <input type="text" name="judul_prestasi" id="judul_prestasi" class="form-control form-control-sm" placeholder="Contoh: Juara 1 Olimpiade Sains Nasional" required>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label for="kategori" class="form-label fw-bold small">Kategori</label>
                                <select name="kategori" id="kategori" class="form-select form-select-sm">
                                    <option value="Akademik">Akademik</option>
                                    <option value="Olahraga">Olahraga</option>
                                    <option value="Seni & Budaya">Seni & Budaya</option>
                                    <option value="Teknologi & IT">Teknologi & IT</option>
                                    <option value="Kepemimpinan">Kepemimpinan</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="tingkat" class="form-label fw-bold small">Tingkat</label>
                                <select name="tingkat" id="tingkat" class="form-select form-select-sm">
                                    <option value="Kota/Kabupaten">Kota / Kabupaten</option>
                                    <option value="Provinsi">Provinsi</option>
                                    <option value="Nasional" selected>Nasional</option>
                                    <option value="Internasional">Internasional</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label for="peringkat" class="form-label fw-bold small">Peringkat / Medali</label>
                                <input type="text" name="peringkat" id="peringkat" class="form-control form-control-sm" value="Juara 1" required>
                            </div>
                            <div class="col-6">
                                <label for="tahun" class="form-label fw-bold small">Tahun</label>
                                <input type="text" name="tahun" id="tahun" class="form-control form-control-sm" value="{{ date('Y') }}" required>
                            </div>
                        </div>

                        <!-- Foto Bukti -->
                        <div class="mb-3">
                            <label for="foto_bukti" class="form-label fw-bold small">Foto Siswa / Penyerahan Piala</label>
                            <input type="file" name="foto_bukti" id="foto_bukti" class="form-control form-control-sm" accept="image/*">
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="tampilkan_di_beranda" id="tampilkan_di_beranda" value="1" checked>
                            <label class="form-check-label small fw-semibold text-dark" for="tampilkan_di_beranda">
                                Tampilkan di Halaman Utama Sekolah (Showcase Showcase Beranda)
                            </label>
                        </div>

                        <button type="submit" class="btn btn-warning text-dark fw-bold w-100 py-2">
                            <i class="bi bi-save me-1"></i> Simpan Prestasi
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- List Table (Right) -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-list-stars text-warning me-2"></i>Daftar Prestasi Siswa ({{ count($prestasis) }})</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Siswa</th>
                                    <th>Judul Prestasi</th>
                                    <th>Tingkat & Peringkat</th>
                                    <th>Beranda</th>
                                    <th class="pe-4 text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($prestasis as $p)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center gap-2">
                                                @if($p->foto_bukti)
                                                    <img src="{{ asset('storage/'.$p->foto_bukti) }}" class="rounded-circle object-fit-cover border" style="width: 40px; height: 40px;">
                                                @else
                                                    <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                                        <i class="bi bi-trophy"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold text-dark mb-0">{{ $p->nama_siswa }}</div>
                                                    <small class="text-muted">{{ $p->kelas ? 'Kelas '.$p->kelas : '-' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-primary small mb-0">{{ $p->judul_prestasi }}</div>
                                            <small class="badge bg-secondary font-monospace">{{ $p->kategori }} ({{ $p->tahun }})</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning text-dark fw-bold mb-1 d-block w-fit">{{ $p->peringkat }}</span>
                                            <small class="text-muted">{{ $p->tingkat }}</small>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.prestasi.toggle-homepage', $p->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $p->tampilkan_di_beranda ? 'btn-success' : 'btn-outline-secondary' }}">
                                                    {{ $p->tampilkan_di_beranda ? 'Tampil' : 'Sembunyi' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <form action="{{ route('admin.prestasi.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus prestasi ini?')">
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
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            Belum ada data prestasi siswa terdaftar.
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
</div>
@endsection
