@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 1100px; margin: 0 auto;">

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i><strong>Terjadi kesalahan input:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Profile Hero Card Header -->
    <div class="card border-0 shadow-sm bg-gradient bg-dark text-white rounded-3 mb-4 overflow-hidden border-start border-5 border-primary">
        <div class="card-body p-4 p-lg-5">
            <div class="d-flex align-items-center flex-wrap gap-4">
                <div class="position-relative">
                    @if($user->foto)
                        <img src="{{ asset('storage/'.$user->foto) }}" alt="{{ $user->name }}" class="rounded-circle object-fit-cover border border-4 border-white shadow" style="width: 100px; height: 100px;">
                    @elseif($guru && $guru->foto)
                        <img src="{{ asset('storage/'.$guru->foto) }}" alt="{{ $guru->nama }}" class="rounded-circle object-fit-cover border border-4 border-white shadow" style="width: 100px; height: 100px;">
                    @else
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow border border-4 border-white" style="width: 100px; height: 100px; font-size: 2.8rem;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                    @endif
                    <span class="position-absolute bottom-0 end-0 badge bg-warning text-dark rounded-circle p-2 shadow" title="Status Akun Aktif">
                        <i class="bi bi-check-circle-fill"></i>
                    </span>
                </div>
                <div>
                    <span class="badge bg-primary text-white fw-bold px-3 py-1 mb-2 text-uppercase">
                        @if($user->isAdmin())
                            <i class="bi bi-shield-lock-fill me-1"></i> Administrator Sekolah
                        @elseif($user->isGuru())
                            <i class="bi bi-person-badge-fill me-1"></i> Akun Guru Pengajar
                        @else
                            <i class="bi bi-person-fill me-1"></i> Akun Siswa
                        @endif
                    </span>
                    <h2 class="fw-bold text-white mb-1">{{ $user->name }}</h2>
                    <p class="text-white-50 mb-0">
                        <i class="bi bi-envelope-fill me-1"></i> {{ $user->email }}
                        @if($guru)
                            | <i class="bi bi-journal-bookmark-fill me-1"></i> Mapel: <strong>{{ $guru->mata_pelajaran }}</strong>
                            | NIP: <strong>{{ $guru->nip ?? '-' }}</strong>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Profile Edit Form -->
    <div class="row g-4">
        <!-- Left Column: Personal Info & Avatar -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-person-gear text-primary me-2"></i>Edit Informasi Profil & Akun
                    </h5>
                    <span class="badge bg-light text-dark font-monospace">Tersimpan Otomatis ke Sistem</span>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- Photo Profile Upload -->
                        <div class="mb-4 p-3 bg-light rounded-3 border d-flex align-items-center gap-3">
                            <div>
                                @if($user->foto)
                                    <img src="{{ asset('storage/'.$user->foto) }}" alt="Preview" class="rounded-circle object-fit-cover border shadow-sm" style="width: 70px; height: 70px;">
                                @elseif($guru && $guru->foto)
                                    <img src="{{ asset('storage/'.$guru->foto) }}" alt="Preview" class="rounded-circle object-fit-cover border shadow-sm" style="width: 70px; height: 70px;">
                                @else
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 70px; height: 70px; font-size: 2rem;">
                                        <i class="bi bi-camera"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <label for="foto" class="form-label fw-bold mb-1">Unggah / Ubah Foto Profil</label>
                                <input type="file" name="foto" id="foto" class="form-control form-control-sm" accept="image/*">
                                <small class="text-muted">Format: JPG, PNG, WEBP (Maksimal 4MB). Foto akan tampil di jadwal, tugas, & daftar guru.</small>
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            <small class="text-muted">Nama ini akan digunakan pada seluruh data aplikasi.</small>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Alamat Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <!-- Teacher Specific Fields -->
                        @if($user->isGuru())
                            <div class="border-top pt-3 mt-4">
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="bi bi-journal-text me-1"></i> Data Spesifik Guru Pengajar
                                </h6>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="nip" class="form-label fw-bold">NIP (Nomor Induk Pegawai)</label>
                                        <input type="text" name="nip" id="nip" class="form-control" value="{{ old('nip', $guru->nip ?? '') }}" placeholder="Contoh: 19850315...">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="mata_pelajaran" class="form-label fw-bold">Mata Pelajaran <span class="text-danger">*</span></label>
                                        <input type="text" name="mata_pelajaran" id="mata_pelajaran" class="form-control" value="{{ old('mata_pelajaran', $guru->mata_pelajaran ?? '') }}" placeholder="Contoh: Matematika" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="no_hp" class="form-label fw-bold">Nomor Handphone / WhatsApp</label>
                                    <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ old('no_hp', $guru->no_hp ?? '') }}" placeholder="Contoh: 081234567890">
                                </div>
                            </div>
                        @endif

                        <!-- Password Change Section (Optional) -->
                        <div class="border-top pt-3 mt-4">
                            <h6 class="fw-bold text-dark mb-1">
                                <i class="bi bi-key-fill text-warning me-1"></i> Ubah Password / Kata Sandi (Opsional)
                            </h6>
                            <p class="text-muted small mb-3">Biarkan kosong jika Anda tidak ingin mengganti password akun.</p>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-bold">Password Baru</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 8 karakter">
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary fw-bold px-4 py-2">
                                <i class="bi bi-save-fill me-1"></i> Simpan Perubahan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column: Profile Summary & Preview Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-card-heading text-warning me-2"></i>Ringkasan Akun</h5>
                </div>
                <div class="card-body p-4 text-center">
                    <div class="mb-3">
                        @if($user->foto)
                            <img src="{{ asset('storage/'.$user->foto) }}" class="rounded-circle object-fit-cover border shadow-sm" style="width: 110px; height: 110px;">
                        @elseif($guru && $guru->foto)
                            <img src="{{ asset('storage/'.$guru->foto) }}" class="rounded-circle object-fit-cover border shadow-sm" style="width: 110px; height: 110px;">
                        @else
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 110px; height: 110px; font-size: 3rem;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        @endif
                    </div>
                    <h5 class="fw-bold text-dark mb-1">{{ $user->name }}</h5>
                    <p class="text-muted small mb-3">{{ $user->email }}</p>

                    <div class="text-start bg-light p-3 rounded-3 border">
                        <div class="mb-2">
                            <small class="text-muted d-block fw-bold">Role Akun:</small>
                            <span class="badge bg-dark">{{ strtoupper($user->role) }}</span>
                        </div>
                        @if($guru)
                            <div class="mb-2">
                                <small class="text-muted d-block fw-bold">Mata Pelajaran:</small>
                                <span class="fw-bold text-primary">{{ $guru->mata_pelajaran }}</span>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted d-block fw-bold">NIP:</small>
                                <span class="fw-semibold text-dark">{{ $guru->nip ?? '-' }}</span>
                            </div>
                            <div>
                                <small class="text-muted d-block fw-bold">No. WhatsApp:</small>
                                <span class="fw-semibold text-dark">{{ $guru->no_hp ?? '-' }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3 bg-info bg-opacity-10 border-start border-4 border-info">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark mb-2"><i class="bi bi-info-circle-fill text-info me-1"></i>Informasi Sinkronisasi</h6>
                    <p class="small text-secondary mb-0">
                        Setiap perubahan nama, foto, NIP, atau mata pelajaran yang Anda simpan akan secara otomatis langsung diperbarui dan terlihat oleh akun Admin, Guru, maupun Siswa di seluruh halaman aplikasi (Jadwal, Tugas, & Piket).
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
