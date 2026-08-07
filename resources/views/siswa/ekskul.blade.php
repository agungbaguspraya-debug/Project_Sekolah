@extends('layouts.app')

@section('content')
<style>
    .ekskul-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0, 0, 0, 0.08);
    }
    .ekskul-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12) !important;
    }
    .ekskul-img-wrapper {
        position: relative;
        overflow: hidden;
        height: 170px;
    }
    .ekskul-img-wrapper img {
        transition: transform 0.5s ease;
    }
    .ekskul-card:hover .ekskul-img-wrapper img {
        transform: scale(1.08);
    }
    .join-now-overlay-btn {
        position: absolute;
        bottom: 12px;
        right: 12px;
        z-index: 5;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        background: rgba(13, 110, 253, 0.85);
        color: #ffffff;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 6px 16px;
        border-radius: 50px;
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        transition: all 0.3s ease;
    }
    .join-now-overlay-btn:hover {
        background: #0d6efd;
        color: #ffffff;
        transform: scale(1.05);
        box-shadow: 0 6px 18px rgba(13, 110, 253, 0.5);
    }
    .quota-badge {
        font-size: 0.9rem;
        padding: 8px 16px;
        border-radius: 12px;
    }
</style>

<div class="container-fluid px-0" style="max-width: 1200px; margin: 0 auto;">
    <!-- Page Header & Quota Overview -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-gradient bg-primary text-white overflow-hidden">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <span class="badge bg-warning text-dark fw-bold px-3 py-1 mb-2 fs-6">
                        <i class="bi bi-star-fill me-1"></i> PORTAL EKSKUL SISWA
                    </span>
                    <h2 class="fw-bold mb-1">🎨 Ekstrakurikuler & Minat Siswa</h2>
                    <p class="text-white-50 mb-0">Pilih dan bergabunglah dengan hingga maksimal <strong>2 Ekstrakurikuler</strong> pilihan Anda!</p>
                </div>
                <div class="text-end bg-white bg-opacity-10 p-3 rounded-3 border border-white border-opacity-25">
                    <small class="text-warning fw-bold d-block text-uppercase mb-1"><i class="bi bi-pie-chart-fill me-1"></i> Kuota Pendaftaran Anda</small>
                    <h3 class="fw-bold text-white mb-0">
                        {{ $activeCount }} <span class="fs-6 text-white-50">/ 2 Terpakai</span>
                    </h3>
                    @if($activeCount >= 2)
                        <small class="badge bg-warning text-dark mt-1">🔒 Batas Maksimal 2 Ekskul</small>
                    @else
                        <small class="badge bg-success mt-1">✨ Sisa Kuota: {{ 2 - $activeCount }} Ekskul</small>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4 rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4 rounded-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Active Registration Badges Overview -->
    @if($myRegistrations->count() > 0)
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-journal-check text-primary me-2"></i>Status Pendaftaran Ekstrakurikuler Saya</h5>
            </div>
            <div class="card-body p-4 pt-0">
                <div class="row g-3">
                    @foreach($myRegistrations as $reg)
                        <div class="col-md-6">
                            <div class="card border border-opacity-25 shadow-sm p-3 rounded-3 {{ $reg->status === 'Disetujui' ? 'border-success bg-success bg-opacity-10' : ($reg->status === 'Pending' ? 'border-warning bg-warning bg-opacity-10' : 'border-danger bg-danger bg-opacity-10') }}">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="fw-bold text-dark mb-0">{{ $reg->ekstrakurikuler->nama_ekskul ?? 'Ekskul' }}</h6>
                                    @if($reg->status === 'Disetujui')
                                        <span class="badge bg-success px-3 py-1 fs-6"><i class="bi bi-check-circle-fill me-1"></i>DISETUJUI (ACC)</span>
                                    @elseif($reg->status === 'Pending')
                                        <span class="badge bg-warning text-dark px-3 py-1 fs-6"><i class="bi bi-clock me-1"></i>MENUNGGU ACC</span>
                                    @else
                                        <span class="badge bg-danger px-3 py-1 fs-6"><i class="bi bi-x-circle-fill me-1"></i>DITOLAK</span>
                                    @endif
                                </div>
                                <div class="small text-secondary mb-1">
                                    <i class="bi bi-person-badge text-primary me-1"></i>Pembina: <strong>{{ $reg->ekstrakurikuler->pembina ?? '-' }}</strong>
                                </div>
                                <div class="small text-secondary mb-1">
                                    <i class="bi bi-clock text-warning me-1"></i>Jadwal: {{ $reg->ekstrakurikuler->hari_latihan ?? '-' }} ({{ $reg->ekstrakurikuler->jam_latihan ?? '-' }})
                                </div>
                                @if($reg->status === 'Ditolak')
                                    <div class="alert alert-danger mb-0 mt-2 p-2 small">
                                        <strong>Catatan Admin:</strong> "{{ $reg->catatan_admin ?? 'Pendaftaran ditolak' }}". 
                                        @if($canRegisterMore)
                                            <br><span class="fw-bold text-white">✨ Anda dipersilakan memilih dan mendaftar ke ekstrakurikuler lain di bawah!</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Registration Notice for Grade 11/12 -->
    @if(!$isKelas10)
        <div class="alert alert-info border-0 shadow-sm mb-4 rounded-3">
            <i class="bi bi-info-circle-fill me-2 fs-5"></i>
            Pendaftaran ekstrakurikuler baru khusus dibuka untuk siswa **Kelas 10 (Tingkat X)**. Siswa kelas 11 & 12 dapat melihat informasi jadwal latihan dan guru pembina ekstrakurikuler di bawah ini.
        </div>
    @endif

    <!-- AVAILABLE EXTRACURRICULAR CARDS GRID -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-grid-fill text-primary me-2"></i>Pilihan Ekstrakurikuler Sekolah</h5>
        <span class="badge bg-secondary px-3 py-2 fs-6">Maksimal 2 Ekskul</span>
    </div>

    <div class="row g-4 mb-4">
        @forelse($ekskuls as $e)
            @php
                $existingReg = $myRegByEkskul->get($e->id);
            @endphp
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden bg-white ekskul-card position-relative">
                    <!-- Photo Banner Wrapper -->
                    <div class="ekskul-img-wrapper">
                        @if($e->foto)
                            <img src="{{ asset('storage/'.$e->foto) }}" class="w-100 h-100 object-fit-cover">
                        @else
                            <div class="w-100 h-100 bg-primary bg-gradient text-white d-flex align-items-center justify-content-center">
                                <i class="bi bi-palette display-4"></i>
                            </div>
                        @endif

                        <!-- JOIN NOW OVERLAY BUTTON ON PHOTO -->
                        @if(!$existingReg || $existingReg->status === 'Ditolak')
                            @if($canRegisterMore)
                                <button type="button" class="btn join-now-overlay-btn shadow" data-bs-toggle="modal" data-bs-target="#joinModalEkskul{{ $e->id }}">
                                    <i class="bi bi-plus-circle-fill me-1"></i> Join Now ✨
                                </button>
                            @endif
                        @endif
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-3.5 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary small px-3 py-1 rounded-pill fw-semibold">
                                    {{ $e->kategori }}
                                </span>
                                @if($existingReg)
                                    @if($existingReg->status === 'Disetujui')
                                        <span class="badge bg-success small px-2 py-1"><i class="bi bi-check-circle-fill me-1"></i>Diterima</span>
                                    @elseif($existingReg->status === 'Pending')
                                        <span class="badge bg-warning text-dark small px-2 py-1"><i class="bi bi-clock me-1"></i>Pending</span>
                                    @elseif($existingReg->status === 'Ditolak')
                                        <span class="badge bg-danger small px-2 py-1"><i class="bi bi-x-circle me-1"></i>Ditolak</span>
                                    @endif
                                @endif
                            </div>

                            <h4 class="fw-bold text-dark mb-2">{{ $e->nama_ekskul }}</h4>

                            <div class="mb-2 text-dark small">
                                <i class="bi bi-person-badge text-primary me-2 fs-6"></i>Guru Pembina / Pelatih: <strong>{{ $e->pembina ?? '-' }}</strong>
                            </div>

                            <div class="bg-light p-3 rounded-3 mb-3 small">
                                <div class="mb-2">
                                    <i class="bi bi-clock-fill text-warning me-2 fs-6"></i><strong>Jadwal:</strong> {{ $e->hari_latihan ?? '-' }} ({{ $e->jam_latihan ?? '-' }})
                                </div>
                                <div>
                                    <i class="bi bi-geo-alt-fill text-danger me-2 fs-6"></i><strong>Lokasi:</strong> {{ $e->lokasi ?? '-' }}
                                </div>
                            </div>

                            @if($e->deskripsi)
                                <p class="small text-secondary mb-3 fst-italic">{{ Str::limit($e->deskripsi, 90) }}</p>
                            @endif
                        </div>

                        <!-- Card Action Button -->
                        <div class="pt-2 border-top">
                            @if($existingReg && $existingReg->status === 'Disetujui')
                                <button class="btn btn-success disabled w-100 fw-bold py-2 rounded-3">
                                    <i class="bi bi-check-circle-fill me-1"></i> Anda Sudah Terdaftar (ACC)
                                </button>
                            @elseif($existingReg && $existingReg->status === 'Pending')
                                <button class="btn btn-warning text-dark disabled w-100 fw-bold py-2 rounded-3">
                                    <i class="bi bi-clock-history me-1"></i> Sedang Diproses (Pending)
                                </button>
                            @elseif($canRegisterMore)
                                <button type="button" class="btn btn-primary fw-bold w-100 py-2 rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#joinModalEkskul{{ $e->id }}">
                                    <i class="bi bi-rocket-takeoff-fill me-1"></i> Join Now (Gabung Ekskul)
                                </button>
                            @elseif($activeCount >= 2)
                                <button class="btn btn-secondary disabled w-100 fw-bold py-2 rounded-3">
                                    <i class="bi bi-lock-fill me-1"></i> Kuota 2 Ekskul Terpakai
                                </button>
                            @else
                                <button class="btn btn-outline-secondary disabled w-100 fw-bold py-2 rounded-3">
                                    Khusus Kelas 10
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL FORM JOIN EKSKUL (POPUP KECIL UNTUK JOIN) -->
            @if($canRegisterMore && (!$existingReg || $existingReg->status === 'Ditolak'))
                <div class="modal fade" id="joinModalEkskul{{ $e->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                            <div class="modal-header bg-gradient bg-primary text-white py-3">
                                <h5 class="modal-title fw-bold text-white mb-0">
                                    <i class="bi bi-rocket-takeoff-fill me-2 text-warning"></i>Form Pendaftaran: {{ $e->nama_ekskul }}
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('siswa.ekskul.register') }}" method="POST">
                                @csrf
                                <input type="hidden" name="ekstrakurikuler_id" value="{{ $e->id }}">

                                <div class="modal-body p-4">
                                    <!-- Ekskul Info Preview Box -->
                                    <div class="d-flex align-items-center gap-3 bg-light p-3 rounded-3 mb-3 border">
                                        @if($e->foto)
                                            <img src="{{ asset('storage/'.$e->foto) }}" class="rounded-3 object-fit-cover" style="width: 60px; height: 60px;">
                                        @else
                                            <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center fw-bold fs-3" style="width: 60px; height: 60px;">
                                                🎨
                                            </div>
                                        @endif
                                        <div>
                                            <span class="badge bg-primary small mb-1">{{ $e->kategori }}</span>
                                            <h5 class="fw-bold text-dark mb-0">{{ $e->nama_ekskul }}</h5>
                                            <small class="text-muted d-block"><i class="bi bi-person-badge me-1"></i>Pembina: {{ $e->pembina ?? '-' }}</small>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center bg-primary bg-opacity-10 p-2 rounded text-primary mb-3 small fw-bold">
                                            <span><i class="bi bi-person-circle me-1"></i>Pendaftar: {{ $siswa->nama }} ({{ $siswa->kelas }})</span>
                                            <span>Sisa Kuota: {{ 2 - $activeCount }} Ekskul</span>
                                        </div>
                                    </div>

                                    <!-- Motivasi & Alasan -->
                                    <div class="mb-3">
                                        <label for="alasan_bergabung_{{ $e->id }}" class="form-label fw-bold small">Alasan & Motivasi Ingin Bergabung</label>
                                        <textarea name="alasan_bergabung" id="alasan_bergabung_{{ $e->id }}" class="form-control" rows="3" placeholder="Contoh: Saya berminat mengasah bakat olahraga basket dan ingin mengikuti kejuaraan sekolah..."></textarea>
                                    </div>

                                    <div class="alert alert-warning p-2 small mb-0">
                                        <i class="bi bi-info-circle-fill me-1"></i>Pendaftaran Anda akan dikirim ke <strong>Admin Utama</strong> untuk disetujui (ACC).
                                    </div>
                                </div>

                                <div class="modal-footer bg-light p-3">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary fw-bold px-4">
                                        <i class="bi bi-send-fill me-1"></i> Kirim Join Now
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm p-5 text-center text-muted">
                    <i class="bi bi-palette fs-1 d-block mb-2 text-secondary"></i>
                    Belum ada data ekstrakurikuler terdaftar.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
