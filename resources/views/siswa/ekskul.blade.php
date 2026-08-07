@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 1200px; margin: 0 auto;">
    <!-- Title -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-palette-fill text-primary me-2"></i>Ekstrakurikuler & Kegiatan Siswa
            </h2>
            <p class="text-muted mb-0">Informasi jadwal latihan, pelatih, serta pendaftaran ekstrakurikuler sekolah.</p>
        </div>
        <span class="badge bg-primary px-3 py-2 fs-6">Kelas Anda: {{ $siswa->kelas }}</span>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Registration Status Banners -->
    @if($activeApproved)
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center p-3 mb-4 rounded-3">
            <div class="bg-success text-white rounded-circle p-2 me-3 fs-3">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div>
                <h5 class="fw-bold text-dark mb-1">Status Ekskul Aktif: DISETUJUI (ACC) Admin!</h5>
                <p class="mb-0 small text-dark">
                    Selamat! Anda resmi terdaftar di ekstrakurikuler <strong>{{ $activeApproved->ekstrakurikuler->nama_ekskul }}</strong>. 
                    Jadwal latihan: <strong>{{ $activeApproved->ekstrakurikuler->hari_latihan ?? '-' }} ({{ $activeApproved->ekstrakurikuler->jam_latihan ?? '-' }})</strong> | 
                    Pembina: <strong>{{ $activeApproved->ekstrakurikuler->pembina ?? '-' }}</strong>.
                </p>
            </div>
        </div>
    @elseif($activePending)
        <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center p-3 mb-4 rounded-3">
            <div class="bg-warning text-dark rounded-circle p-2 me-3 fs-3">
                <i class="bi bi-clock-history"></i>
            </div>
            <div>
                <h5 class="fw-bold text-dark mb-1">Pendaftaran Ekskul Sedang Menunggu Persetujuan (ACC) Admin</h5>
                <p class="mb-0 small text-dark">
                    Pendaftaran Anda untuk ekskul <strong>{{ $activePending->ekstrakurikuler->nama_ekskul }}</strong> telah dikirim. Mohon menunggu peninjauan dari Admin Utama.
                </p>
            </div>
        </div>
    @elseif($lastRejected)
        <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center p-3 mb-4 rounded-3">
            <div class="bg-danger text-white rounded-circle p-2 me-3 fs-3">
                <i class="bi bi-x-circle-fill"></i>
            </div>
            <div>
                <h5 class="fw-bold text-white mb-1">Pendaftaran Ekskul Sebelumnya DITOLAK oleh Admin</h5>
                <p class="mb-0 small text-white-50">
                    Alasan Admin: <strong>"{{ $lastRejected->catatan_admin ?? 'Tidak ada alasan khusus' }}"</strong>. 
                    @if($isKelas10)
                        Jangan berkecil hati! Sebagai siswa Kelas 10, Anda dipersilakan untuk <strong>mendaftar dan memilih ekstrakurikuler lain</strong> di bawah ini.
                    @endif
                </p>
            </div>
        </div>
    @endif

    <!-- Registration Form for Grade 10 Students -->
    @if($isKelas10 && !$activeApproved && !$activePending)
        <div class="card border-0 shadow-sm rounded-3 mb-4 border-start border-5 border-primary">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="bi bi-pencil-square me-2"></i>Formulir Pendaftaran Ekstrakurikuler (Khusus Siswa Kelas 10)
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('siswa.ekskul.register') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="ekstrakurikuler_id" class="form-label fw-bold small">Pilih Ekstrakurikuler Minat Anda <span class="text-danger">*</span></label>
                            <select name="ekstrakurikuler_id" id="ekstrakurikuler_id" class="form-select fw-bold" required>
                                <option value="">-- Pilih Ekstrakurikuler --</option>
                                @foreach($ekskuls as $e)
                                    <option value="{{ $e->id }}">
                                        {{ $e->nama_ekskul }} ({{ $e->kategori }}) - Pembina: {{ $e->pembina ?? 'Guru Pembina' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="alasan_bergabung" class="form-label fw-bold small">Alasan Ingin Bergabung (Opsional)</label>
                            <input type="text" name="alasan_bergabung" id="alasan_bergabung" class="form-control" placeholder="Tuliskan motivasi atau pengalaman Anda...">
                        </div>
                    </div>
                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-primary fw-bold px-4 py-2">
                            <i class="bi bi-send-fill me-1"></i> Kirim Pendaftaran Ekskul (Menunggu ACC Admin)
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @elseif(!$isKelas10)
        <div class="alert alert-info border-0 shadow-sm mb-4">
            <i class="bi bi-info-circle-fill me-2 fs-5"></i>
            Pendaftaran ekstrakurikuler baru khusus diperuntukkan bagi siswa **Kelas 10 (Tingkat X)**. Anda dapat melihat informasi dan jadwal latihan ekskul sekolah di bawah ini.
        </div>
    @endif

    <!-- Available Extracurricular Cards -->
    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-grid-fill text-primary me-2"></i>Daftar Ekstrakurikuler Sekolah</h5>
    <div class="row g-4 mb-4">
        @forelse($ekskuls as $e)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 h-100 overflow-hidden bg-white">
                    @if($e->foto)
                        <img src="{{ asset('storage/'.$e->foto) }}" class="card-img-top object-fit-cover" style="height: 150px;">
                    @else
                        <div class="bg-primary bg-gradient text-white d-flex align-items-center justify-content-center p-4" style="height: 150px;">
                            <i class="bi bi-palette fs-1"></i>
                        </div>
                    @endif
                    <div class="card-body p-3">
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary small mb-2">{{ $e->kategori }}</span>
                        <h5 class="fw-bold text-dark mb-1">{{ $e->nama_ekskul }}</h5>
                        <p class="small text-muted mb-2"><i class="bi bi-person-badge text-primary me-1"></i>Guru Pembina / Pelatih: <strong>{{ $e->pembina ?? '-' }}</strong></p>
                        
                        <div class="bg-light p-2.5 rounded-3 mb-2 small">
                            <div class="mb-1">
                                <i class="bi bi-clock me-1 text-warning"></i><strong>Jadwal:</strong> {{ $e->hari_latihan ?? '-' }} ({{ $e->jam_latihan ?? '-' }})
                            </div>
                            <div>
                                <i class="bi bi-geo-alt me-1 text-danger"></i><strong>Lokasi:</strong> {{ $e->lokasi ?? '-' }}
                            </div>
                        </div>

                        @if($e->deskripsi)
                            <p class="small text-secondary mb-0">{{ Str::limit($e->deskripsi, 90) }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm p-4 text-center text-muted">
                    Belum ada data ekstrakurikuler terdaftar.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
