@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-building-gear me-2 text-primary"></i>Kelola Informasi & Profil Sekolah
        </h2>
        <p class="text-muted">
            Perbarui identitas, kontak, visi, dan misi sekolah. Perubahan akan otomatis diperbarui pada portal Guru dan Siswa.
        </p>
    </div>

    @if(session('success'))
        <div class="col-md-12 mb-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-dark text-white py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Form Pengaturan Profil Sekolah</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('profil-sekolah.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">
                        <i class="bi bi-info-circle me-2"></i>Identitas Utama Sekolah
                    </h5>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="nama_sekolah" class="form-label fw-bold">Nama Sekolah</label>
                            <input type="text" name="nama_sekolah" id="nama_sekolah" class="form-control" value="{{ old('nama_sekolah', $profil->nama_sekolah) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="npsn_status" class="form-label fw-bold">NPSN & Status</label>
                            <input type="text" name="npsn_status" id="npsn_status" class="form-control" value="{{ old('npsn_status', $profil->npsn_status) }}" required placeholder="Contoh: 10802999 | Negeri">
                        </div>

                        <div class="col-md-6">
                            <label for="kepala_sekolah" class="form-label fw-bold">Nama Kepala Sekolah</label>
                            <input type="text" name="kepala_sekolah" id="kepala_sekolah" class="form-control" value="{{ old('kepala_sekolah', $profil->kepala_sekolah) }}" required>
                        </div>

                        <div class="col-md-3">
                            <label for="akreditasi" class="form-label fw-bold">Akreditasi</label>
                            <input type="text" name="akreditasi" id="akreditasi" class="form-control" value="{{ old('akreditasi', $profil->akreditasi) }}" required placeholder="Contoh: A">
                        </div>

                        <div class="col-md-3">
                            <label for="jam_operasional" class="form-label fw-bold">Jam Operasional</label>
                            <input type="text" name="jam_operasional" id="jam_operasional" class="form-control" value="{{ old('jam_operasional', $profil->jam_operasional) }}" required placeholder="Senin - Jumat (07:00 - 15:30 WIB)">
                        </div>
                    </div>

                    <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">
                        <i class="bi bi-geo-alt me-2"></i>Alamat & Kontak Sekolah
                    </h5>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="alamat" class="form-label fw-bold">Alamat Lengkap</label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="Alamat jalan, nomor, dan kota">{{ old('alamat', $profil->alamat) }}</textarea>
                        </div>

                        <div class="col-md-3">
                            <label for="email" class="form-label fw-bold">Email Sekolah</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $profil->email) }}">
                        </div>

                        <div class="col-md-3">
                            <label for="telepon" class="form-label fw-bold">Telepon / Fax</label>
                            <input type="text" name="telepon" id="telepon" class="form-control" value="{{ old('telepon', $profil->telepon) }}">
                        </div>
                    </div>

                    <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">
                        <i class="bi bi-compass me-2"></i>Visi & Misi Sekolah
                    </h5>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="visi" class="form-label fw-bold">Visi Sekolah</label>
                            <textarea name="visi" id="visi" class="form-control" rows="4" placeholder="Tuliskan Visi Sekolah">{{ old('visi', $profil->visi) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="misi" class="form-label fw-bold">Misi Sekolah</label>
                            <textarea name="misi" id="misi" class="form-control" rows="4" placeholder="Tuliskan Misi Sekolah (bisa per poin)">{{ old('misi', $profil->misi) }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
