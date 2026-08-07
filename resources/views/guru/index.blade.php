@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1"><i class="bi bi-person-workspace text-primary me-2"></i>Kelola Data Guru</h2>
            <p class="text-muted mb-0">Manajemen data pengajar, mata pelajaran, serta akun login guru.</p>
        </div>
        <button type="button" class="btn btn-primary fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahGuruModal">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah Data Guru Baru
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <h6 class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Gagal Menambahkan / Memperbarui Data Guru:</h6>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search & Summary Bar -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 fs-6">
                        <i class="bi bi-people-fill me-1"></i> Total {{ count($gurus) }} Guru Terdaftar
                    </span>
                </div>

                <form action="{{ route('guru.index') }}" method="GET" class="d-flex" style="min-width: 280px;">
                    <input type="text" name="q" class="form-control form-control-sm me-2" placeholder="Cari NIP, Nama, Mapel..." value="{{ $q ?? '' }}">
                    <button type="submit" class="btn btn-primary btn-sm px-3"><i class="bi bi-search"></i></button>
                    @if(isset($q) && $q !== '')
                        <a href="{{ route('guru.index') }}" class="btn btn-outline-secondary btn-sm ms-2">Reset</a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4" style="width: 70px;">Foto</th>
                            <th>NIP</th>
                            <th>Nama Guru & Gelar</th>
                            <th>Mata Pelajaran</th>
                            <th>No. Telepon / WA</th>
                            <th>Akun Login Email</th>
                            <th class="pe-4 text-end" style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gurus as $g)
                            <tr>
                                <td class="ps-4">
                                    @if($g->foto)
                                        <img src="{{ asset('storage/'.$g->foto) }}" alt="{{ $g->nama }}" class="rounded-circle object-fit-cover border shadow-sm" style="width: 45px; height: 45px;">
                                    @else
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 45px; height: 45px; font-size: 1.1rem;">
                                            {{ strtoupper(substr($g->nama, 0, 1)) }}
                                        </div>
                                    @endif
                                </td>
                                <td><span class="badge bg-light text-dark border font-monospace">{{ $g->nip ?? '-' }}</span></td>
                                <td class="fw-bold text-dark">{{ $g->nama }}</td>
                                <td><span class="badge bg-info text-dark fs-6">{{ $g->mata_pelajaran }}</span></td>
                                <td>
                                    @if($g->no_hp)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $g->no_hp) }}" target="_blank" class="text-success fw-semibold text-decoration-none small">
                                            <i class="bi bi-whatsapp me-1"></i>{{ $g->no_hp }}
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($g->user)
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success">
                                            <i class="bi bi-check-circle-fill me-1"></i>{{ $g->user->email }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">Belum terhubung</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('guru.edit', $g->id) }}" class="btn btn-primary btn-sm" title="Edit Data Guru">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('guru.destroy', $g->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data guru {{ $g->nama }} beserta akun loginnya?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus Guru">
                                                <i class="bi bi-trash-fill"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-person-x fs-1 d-block mb-2 text-secondary"></i>
                                    Belum ada data guru terdaftar. Klik tombol <strong>Tambah Data Guru Baru</strong> di atas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Guru -->
<div class="modal fade" id="tambahGuruModal" tabindex="-1" aria-labelledby="tambahGuruModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-header-title mb-0 fw-bold" id="tambahGuruModalLabel"><i class="bi bi-person-plus-fill me-2"></i>Tambah Data & Akun Guru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-bold">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Contoh: Drs. Budi Santoso, M.Pd." value="{{ old('nama') }}" required>
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="nip" class="form-label fw-bold">NIP (Opsional)</label>
                            <input type="text" name="nip" id="nip" class="form-control @error('nip') is-invalid @enderror" placeholder="19850101..." value="{{ old('nip') }}">
                            @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="mata_pelajaran" class="form-label fw-bold">Mata Pelajaran</label>
                            <input type="text" name="mata_pelajaran" id="mata_pelajaran" class="form-control @error('mata_pelajaran') is-invalid @enderror" placeholder="Contoh: Desain Grafis / Matematika" value="{{ old('mata_pelajaran') }}" required>
                            @error('mata_pelajaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="no_hp" class="form-label fw-bold">No. Telepon / WhatsApp</label>
                        <input type="text" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror" placeholder="08123456789" value="{{ old('no_hp') }}">
                        @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <hr class="my-4">
                    <h6 class="fw-bold text-primary mb-3"><i class="bi bi-key-fill me-1"></i>Informasi Akun Login Guru</h6>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email Login</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="guru@smk.sch.id" value="{{ old('email') }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">Password Login</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 6 karakter" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password" title="Tampilkan / Sembunyikan Password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label fw-bold">Foto Profil (Opsional)</label>
                        <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                        @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-save me-1"></i> Simpan Data Guru</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('tambahGuruModal'));
            myModal.show();
        });
    </script>
@endif
@endsection
