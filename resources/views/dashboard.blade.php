@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">

    @if(Auth::user()->isSiswa() && Auth::user()->siswa && Auth::user()->siswa->status === 'Lulus')
        <!-- ========================================== -->
        <!-- DEDICATED ALUMNI GRADUATION DASHBOARD      -->
        <!-- ========================================== -->

        <!-- Confetti Animation Library -->
        <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Fire celebratory confetti on page load
                var count = 200;
                var defaults = {
                    origin: { y: 0.7 }
                };

                function fire(particleRatio, opts) {
                    confetti(Object.assign({}, defaults, opts, {
                        particleCount: Math.floor(count * particleRatio)
                    }));
                }

                fire(0.25, {
                    spread: 26,
                    startVelocity: 55,
                });
                fire(0.2, {
                    spread: 60,
                });
                fire(0.35, {
                    spread: 100,
                    decay: 0.91,
                    scalar: 0.8
                });
                fire(0.1, {
                    spread: 120,
                    startVelocity: 25,
                    decay: 0.92,
                    scalar: 1.2
                });
                fire(0.1, {
                    spread: 120,
                    startVelocity: 45,
                });
            });
        </script>

        <!-- Graduation Hero Banner -->
        <div class="card border-0 shadow-lg mb-4 rounded-4 overflow-hidden text-white position-relative" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #f12711 100%);">
            <div class="card-body p-4 p-lg-5 position-relative z-1">
                <div class="row align-items-center g-4">
                    <div class="col-lg-8">
                        <span class="badge bg-warning text-dark fw-bold px-3 py-2 fs-6 rounded-pill mb-3 text-uppercase shadow-sm">
                            🎓 SELAMAT & SUKSES ALUMNI TAHUN {{ $siswa->tahun_lulus ?? date('Y') }}
                        </span>
                        <h1 class="fw-extrabold text-white display-5 mb-2">
                            Selamat atas Kelulusan Anda, {{ $siswa->nama }}! 🎉
                        </h1>
                        <p class="fs-5 text-white-50 mb-4" style="line-height: 1.6;">
                            Selamat telah menyelesaikan masa studi di <strong>{{ $profilSekolah->nama_sekolah ?? 'Sekolah' }}</strong> dengan hasil yang membanggakan! 
                            Tetap semangat, pantang menyerah, dan capai cita-cita setinggi langit untuk masa depan Anda yang cerah! 🚀✨
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-white text-dark fw-bold px-3 py-2 shadow-sm">
                                <i class="bi bi-mortarboard-fill me-1 text-warning"></i> Status: LULUS RESMI
                            </span>
                            <span class="badge bg-white text-dark fw-bold px-3 py-2 shadow-sm">
                                <i class="bi bi-building me-1 text-primary"></i> Kelas Terakhir: {{ $siswa->kelas }}
                            </span>
                            <span class="badge bg-white text-dark fw-bold px-3 py-2 shadow-sm">
                                <i class="bi bi-journal-bookmark me-1 text-success"></i> Jurusan: {{ $siswa->jurusan }}
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center">
                        <div class="position-relative d-inline-block">
                            @if($siswa->foto)
                                <img src="{{ asset('storage/'.$siswa->foto) }}" alt="{{ $siswa->nama }}" class="rounded-circle img-thumbnail shadow-lg object-fit-cover" style="width: 160px; height: 160px; border: 4px solid gold;">
                            @else
                                <div class="bg-warning text-dark rounded-circle d-inline-flex align-items-center justify-content-center fw-bold shadow-lg" style="width: 160px; height: 160px; font-size: 4rem; border: 4px solid gold;">
                                    🎓
                                </div>
                            @endif
                            <span class="position-absolute bottom-0 end-0 badge bg-danger text-white rounded-circle p-3 shadow">
                                <i class="bi bi-trophy-fill fs-5"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-3 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Alumni Summary Cards (Total Nilai, Total Pelanggaran, Total Media Kenangan) -->
        <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
            <!-- Card 1: Total Nilai Kelulusan -->
            <div class="col">
                <div class="card border-0 shadow-sm h-100 rounded-3 border-start border-5 border-warning bg-white p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <small class="text-muted fw-bold text-uppercase">Total Nilai Kelulusan</small>
                        <div class="bg-warning bg-opacity-10 text-warning p-2.5 rounded-circle">
                            <i class="bi bi-star-fill fs-4"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-dark mb-1">{{ number_format($siswa->total_nilai ?? 85.00, 2) }}</h2>
                    <small class="text-success fw-bold"><i class="bi bi-check-all me-1"></i>Predikat Kelulusan Baik</small>
                </div>
            </div>

            <!-- Card 2: Total Poin Pelanggaran -->
            <div class="col">
                <div class="card border-0 shadow-sm h-100 rounded-3 border-start border-5 border-danger bg-white p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <small class="text-muted fw-bold text-uppercase">Total Poin Pelanggaran</small>
                        <div class="bg-danger bg-opacity-10 text-danger p-2.5 rounded-circle">
                            <i class="bi bi-shield-exclamation fs-4"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold {{ $totalPoints > 0 ? 'text-danger' : 'text-success' }} mb-1">
                        {{ $totalPoints }} <span class="fs-6 text-muted">Poin</span>
                    </h2>
                    @if($totalPoints == 0)
                        <small class="text-success fw-bold"><i class="bi bi-shield-check me-1"></i>Sempurna: 0 Pelanggaran</small>
                    @else
                        <small class="text-muted"><i class="bi bi-exclamation-circle me-1"></i>Tercatat {{ count($pelanggarans) }} Pelanggaran</small>
                    @endif
                </div>
            </div>

            <!-- Card 3: Total Media Kenangan -->
            <div class="col">
                <div class="card border-0 shadow-sm h-100 rounded-3 border-start border-5 border-primary bg-white p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <small class="text-muted fw-bold text-uppercase">Album Media Kenangan</small>
                        <div class="bg-primary bg-opacity-10 text-primary p-2.5 rounded-circle">
                            <i class="bi bi-images fs-4"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-primary mb-1">{{ count($siswaMedia) }} <span class="fs-6 text-muted">Berkas</span></h2>
                    <small class="text-secondary"><i class="bi bi-cloud-upload me-1"></i>Foto & Video Album Kelulusan</small>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <!-- Section 1: Detailed Discipline Record (Pelanggaran Selama Sekolah) -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100 rounded-3">
                    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="bi bi-journal-x text-danger me-2"></i>Catatan Pelanggaran Selama Sekolah
                        </h5>
                        <span class="badge bg-danger px-3 py-1">{{ count($pelanggarans) }} Pelanggaran</span>
                    </div>
                    <div class="card-body p-0">
                        @if(count($pelanggarans) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">Tanggal</th>
                                            <th>Jenis Pelanggaran</th>
                                            <th>Poin</th>
                                            <th class="pe-4">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pelanggarans as $p)
                                            <tr>
                                                <td class="ps-4 text-nowrap small fw-bold text-secondary">
                                                    {{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') }}
                                                </td>
                                                <td class="fw-bold text-dark">{{ $p->nama_pelanggaran }}</td>
                                                <td><span class="badge bg-danger font-monospace">+{{ $p->point }}</span></td>
                                                <td class="pe-4 small text-muted">{{ $p->keterangan ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="p-5 text-center text-muted">
                                <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex p-4 mb-3">
                                    <i class="bi bi-shield-check fs-1"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-1">Catatan Disiplin 100% Bersih!</h5>
                                <p class="small text-secondary mb-0">
                                    Selamat! Anda tidak memiliki rekam jejak pelanggaran selama bersekolah di {{ $profilSekolah->nama_sekolah ?? 'Sekolah' }}.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Section 2: Upload Multiple Photos & Videos (>10 Files) -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100 rounded-3">
                    <div class="card-header bg-dark text-white py-3 border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-camera-reels-fill text-warning me-2"></i>Unggah Foto & Video Kenangan
                        </h5>
                        <span class="badge bg-warning text-dark font-monospace">Multi-Upload (&gt;10 Berkas)</span>
                    </div>
                    <div class="card-body p-4 bg-light bg-opacity-50">
                        <form action="{{ route('siswa.upload-media-kenangan') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="files" class="form-label fw-bold">Pilih Foto & Video (Bisa Upload Banyak Sekaligus)</label>
                                <input type="file" name="files[]" id="files" class="form-control form-control-lg border-2" accept="image/*,video/*" multiple required>
                                <small class="text-muted d-block mt-1">
                                    <i class="bi bi-info-circle me-1"></i>Format foto (JPG, PNG, WebP) atau video (MP4, MOV, WebM). Anda bisa memilih lebih dari 10 berkas sekaligus!
                                </small>
                            </div>
                            <div class="mb-3">
                                <label for="caption" class="form-label fw-bold">Catatan / Caption Album (Opsional)</label>
                                <input type="text" name="caption" id="caption" class="form-control" placeholder="Contoh: Kenangan Momen Kelulusan Bersama Teman & Guru">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary fw-bold py-2.5">
                                    <i class="bi bi-cloud-arrow-up-fill me-1 fs-5"></i> Unggah Album Foto & Video Kenangan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Media Gallery (Grid Display for Photos & Videos) -->
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-collection-play-fill text-primary me-2"></i>Galeri Media Kenangan Kelulusan Saya
                </h5>
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary px-3 py-2 fs-6">
                    Total {{ count($siswaMedia) }} Berkas Tersimpan
                </span>
            </div>
            <div class="card-body p-4">
                @if(count($siswaMedia) > 0)
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
                        @foreach($siswaMedia as $media)
                            <div class="col">
                                <div class="card border shadow-sm h-100 rounded-3 overflow-hidden position-relative group-hover">
                                    @if($media->file_type === 'video')
                                        <!-- Video Player -->
                                        <div class="ratio ratio-16x9 bg-black">
                                            <video controls preload="metadata" style="max-height: 200px; width: 100%;">
                                                <source src="{{ asset('storage/'.$media->file_path) }}">
                                                Browser Anda tidak mendukung pemutar video.
                                            </video>
                                        </div>
                                    @else
                                        <!-- Photo Thumbnail -->
                                        <a href="{{ asset('storage/'.$media->file_path) }}" target="_blank">
                                            <img src="{{ asset('storage/'.$media->file_path) }}" alt="Kenangan" class="card-img-top object-fit-cover" style="height: 180px;">
                                        </a>
                                    @endif

                                    <div class="card-body p-2 bg-light d-flex justify-content-between align-items-center">
                                        <div class="text-truncate me-2">
                                            @if($media->file_type === 'video')
                                                <span class="badge bg-danger me-1"><i class="bi bi-camera-video-fill me-1"></i>Video</span>
                                            @else
                                                <span class="badge bg-info text-dark me-1"><i class="bi bi-image me-1"></i>Foto</span>
                                            @endif
                                            <small class="text-dark fw-semibold text-truncate d-inline-block style='max-width: 120px;'">
                                                {{ $media->caption ?? 'Kenangan' }}
                                            </small>
                                        </div>
                                        <form action="{{ route('siswa.delete-media-kenangan', $media->id) }}" method="POST" onsubmit="return confirm('Hapus berkas kenangan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm p-1 px-2" title="Hapus Berkas">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-5 text-center text-muted border border-dashed rounded-3">
                        <i class="bi bi-images fs-1 d-block mb-2 text-secondary"></i>
                        Belum ada foto atau video kenangan yang diunggah. Silakan gunakan form unggah di atas untuk menambahkan kenangan Anda!
                    </div>
                @endif
            </div>
        </div>

    @else
        <!-- ========================================== -->
        <!-- REGULAR DASHBOARD FOR ADMIN, GURU & ACTIVE STUDENTS -->
        <!-- ========================================== -->

        <!-- Welcome Hero Banner -->
        <div class="card border-0 shadow-sm bg-primary bg-gradient text-white mb-4 rounded-3">
            <div class="card-body p-4 p-lg-5 d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <span class="badge bg-white text-primary fw-bold px-3 py-2 mb-2 text-uppercase tracking-wider">
                        <i class="bi bi-shield-check me-1"></i> 
                        @if(Auth::user()->isAdmin())
                            Panel Administrator
                        @elseif(Auth::user()->isGuru())
                            Portal Guru ({{ Auth::user()->guru->mata_pelajaran ?? 'Pengajar' }})
                        @else
                            Portal Siswa
                        @endif
                    </span>
                    <h2 class="fw-bold text-white mb-1">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
                    <p class="mb-0 text-white-50 fs-6">
                        Sistem Informasi Kelola Data Kelas, Guru, Tugas Piket, Jadwal Pelajaran, dan Tugas Sekolah.
                    </p>
                </div>
                <div class="text-lg-end bg-white bg-opacity-10 p-3 rounded-3 border border-white border-opacity-25">
                    <small class="text-white-50 d-block mb-1"><i class="bi bi-clock me-1"></i> Hari Ini</small>
                    <h5 class="fw-bold text-white mb-0">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</h5>
                </div>
            </div>
        </div>

        @if(Auth::user()->isGuru() && $myPiketDashboard->count() > 0)
            <!-- Teacher Duty Schedule Notice -->
            <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center p-3 mb-4 rounded-3">
                <div class="bg-warning text-white rounded-circle p-2 me-3 fs-4">
                    <i class="bi bi-calendar-check-fill"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-dark mb-1">Perhatian Jadwal Piket Guru Hari Ini / Minggu Ini</h6>
                    <p class="mb-0 small text-secondary">
                        Anda memiliki {{ $myPiketDashboard->count() }} tugas piket terdaftar. 
                        Hari piket: <strong>{{ $myPiketDashboard->pluck('hari')->implode(', ') }}</strong>. 
                        <a href="{{ route('piket.index') }}" class="fw-bold text-dark text-decoration-underline ms-1">Lihat Detail Jadwal Piket &rarr;</a>
                    </p>
                </div>
            </div>
        @endif

        <!-- Main Statistics Cards -->
        @if(Auth::user()->isGuru())
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3 mb-4">
                <!-- Jadwal Mengajar -->
                <div class="col">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                                    <i class="bi bi-calendar3 fs-3"></i>
                                </div>
                                <a href="{{ route('jadwal.index') }}" class="btn btn-sm btn-light text-warning rounded-circle p-2" title="Lihat Jadwal Mengajar">
                                    <i class="bi bi-arrow-right-short fs-5"></i>
                                </a>
                            </div>
                            <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Jadwal Mengajar</small>
                            <h2 class="fw-bold text-dark mb-0">{{ $totalJadwal }}</h2>
                            <small class="text-secondary">Jam Pelajaran Terdaftar</small>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 bg-warning" style="height: 4px;"></div>
                    </div>
                </div>

                <!-- Tambah & Kelola Tugas -->
                <div class="col">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                                    <i class="bi bi-file-earmark-plus-fill fs-3"></i>
                                </div>
                                <a href="{{ route('tugas.index') }}" class="btn btn-sm btn-light text-primary rounded-circle p-2" title="Buat & Kelola Tugas">
                                    <i class="bi bi-arrow-right-short fs-5"></i>
                                </a>
                            </div>
                            <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Tugas Mapel Saya</small>
                            <h2 class="fw-bold text-dark mb-0">{{ $myTugasCount }}</h2>
                            <small class="text-secondary">Tugas Berhasil Dibuat</small>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 bg-primary" style="height: 4px;"></div>
                    </div>
                </div>

                <!-- Tugas Piket Saya -->
                <div class="col">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-3">
                                    <i class="bi bi-calendar-check-fill fs-3"></i>
                                </div>
                                <a href="{{ route('piket.index') }}" class="btn btn-sm btn-light text-danger rounded-circle p-2" title="Lihat Tugas Piket Saya">
                                    <i class="bi bi-arrow-right-short fs-5"></i>
                                </a>
                            </div>
                            <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Jadwal Piket Saya</small>
                            <h2 class="fw-bold text-dark mb-0">{{ $myPiketCount }}</h2>
                            <small class="text-secondary">Tugas Piket Terdaftar</small>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 bg-danger" style="height: 4px;"></div>
                    </div>
                </div>
            </div>

        @elseif(Auth::user()->isSiswa())
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3 mb-4">
                <!-- Kelas Saya -->
                <div class="col">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                                    <i class="bi bi-building fs-3"></i>
                                </div>
                            </div>
                            <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Kelas Saya</small>
                            <h3 class="fw-bold text-dark mb-0">{{ Auth::user()->siswa->kelas ?? '-' }}</h3>
                            <small class="text-secondary">Jurusan: {{ Auth::user()->siswa->jurusan ?? '-' }}</small>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 bg-primary" style="height: 4px;"></div>
                    </div>
                </div>

                <!-- Jadwal Pelajaran -->
                <div class="col">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                                    <i class="bi bi-calendar3 fs-3"></i>
                                </div>
                                <a href="{{ route('jadwal.index') }}" class="btn btn-sm btn-light text-warning rounded-circle p-2" title="Lihat Jadwal Saya">
                                    <i class="bi bi-arrow-right-short fs-5"></i>
                                </a>
                            </div>
                            <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Jadwal Kelas</small>
                            <h2 class="fw-bold text-dark mb-0">{{ $totalJadwal }}</h2>
                            <small class="text-secondary">Jam Pelajaran Terdaftar</small>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 bg-warning" style="height: 4px;"></div>
                    </div>
                </div>

                <!-- Tugas Sekolah -->
                <div class="col">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-success bg-opacity-10 text-success p-3 rounded-3">
                                    <i class="bi bi-file-earmark-check fs-3"></i>
                                </div>
                                <a href="{{ route('tugas.index') }}" class="btn btn-sm btn-light text-success rounded-circle p-2" title="Lihat Tugas">
                                    <i class="bi bi-arrow-right-short fs-5"></i>
                                </a>
                            </div>
                            <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Tugas Sekolah</small>
                            <h2 class="fw-bold text-dark mb-0">{{ count($recentTugas) }}</h2>
                            <small class="text-secondary">Tugas Aktif Kelas</small>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 bg-success" style="height: 4px;"></div>
                    </div>
                </div>
            </div>

        @else
            <!-- Admin View Stats -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3 mb-4">
                <div class="col">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                                    <i class="bi bi-building fs-3"></i>
                                </div>
                                <a href="{{ route('kelas.index') }}" class="btn btn-sm btn-light text-primary rounded-circle p-2" title="Kelola Kelas">
                                    <i class="bi bi-arrow-right-short fs-5"></i>
                                </a>
                            </div>
                            <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Total Kelas</small>
                            <h2 class="fw-bold text-dark mb-0">{{ $totalKelas }}</h2>
                            <small class="text-secondary">Terdaftar dalam Sistem</small>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 bg-primary" style="height: 4px;"></div>
                    </div>
                </div>

                <div class="col">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-info bg-opacity-10 text-info p-3 rounded-3">
                                    <i class="bi bi-journal-bookmark fs-3"></i>
                                </div>
                                <a href="{{ route('jurusan.index') }}" class="btn btn-sm btn-light text-info rounded-circle p-2" title="Kelola Jurusan">
                                    <i class="bi bi-arrow-right-short fs-5"></i>
                                </a>
                            </div>
                            <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Total Jurusan</small>
                            <h2 class="fw-bold text-dark mb-0">{{ $totalJurusan }}</h2>
                            <small class="text-secondary">Program Keahlian</small>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 bg-info" style="height: 4px;"></div>
                    </div>
                </div>

                <div class="col">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-success bg-opacity-10 text-success p-3 rounded-3">
                                    <i class="bi bi-people fs-3"></i>
                                </div>
                                <a href="{{ route('siswa.index') }}" class="btn btn-sm btn-light text-success rounded-circle p-2" title="Kelola Siswa">
                                    <i class="bi bi-arrow-right-short fs-5"></i>
                                </a>
                            </div>
                            <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Total Siswa</small>
                            <h2 class="fw-bold text-dark mb-0">{{ $totalSiswa }}</h2>
                            <small class="text-secondary">Siswa Aktif & Alumni</small>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 bg-success" style="height: 4px;"></div>
                    </div>
                </div>

                <div class="col">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                                    <i class="bi bi-person-badge fs-3"></i>
                                </div>
                                <a href="{{ route('guru.index') }}" class="btn btn-sm btn-light text-warning rounded-circle p-2" title="Kelola Guru">
                                    <i class="bi bi-arrow-right-short fs-5"></i>
                                </a>
                            </div>
                            <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Total Guru</small>
                            <h2 class="fw-bold text-dark mb-0">{{ $totalGuru }}</h2>
                            <small class="text-secondary">Guru Pengajar Terdaftar</small>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 bg-warning" style="height: 4px;"></div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Recent Schedules & Tasks Overview -->
        <div class="row g-4 mb-4">
            <!-- Recent Schedules -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-calendar3 text-primary me-2"></i>Jadwal Pelajaran</h5>
                        <a href="{{ route('jadwal.index') }}" class="btn btn-outline-primary btn-sm px-3">Lihat Semua</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Hari</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Guru Pengajar</th>
                                        <th>Kelas</th>
                                        <th class="pe-4 text-end">Waktu KBM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentJadwal as $j)
                                        <tr>
                                            <td class="ps-4 fw-bold text-dark"><span class="badge bg-dark">{{ $j->hari }}</span></td>
                                            <td class="fw-bold text-primary">{{ $j->mata_pelajaran }}</td>
                                            <td><span class="badge bg-info text-dark small"><i class="bi bi-person-fill me-1"></i>{{ $j->guru->nama ?? '-' }}</span></td>
                                            <td><span class="badge bg-secondary">{{ $j->kelas }}</span></td>
                                            <td class="pe-4 text-end text-muted small">
                                                {{ date('H:i', strtotime($j->jam_mulai)) }} - {{ date('H:i', strtotime($j->jam_selesai)) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">Belum ada jadwal pelajaran.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Tasks -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-file-earmark-text text-danger me-2"></i>Tugas Sekolah Terbaru</h5>
                        <a href="{{ route('tugas.index') }}" class="btn btn-outline-danger btn-sm px-3">Lihat Semua</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Judul Tugas</th>
                                        <th>Kelas</th>
                                        <th class="pe-4 text-end">Deadline</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentTugas as $t)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bold text-dark">{{ $t->judul }}</div>
                                                @if($t->mata_pelajaran)
                                                    <small class="text-primary">{{ $t->mata_pelajaran }}</small>
                                                @endif
                                            </td>
                                            <td><span class="badge bg-secondary">{{ $t->kelas }}</span></td>
                                            <td class="pe-4 text-end">
                                                @if(\Carbon\Carbon::parse($t->deadline)->isPast())
                                                    <span class="text-danger fw-bold small">{{ \App\Helpers\WaktuHelper::formatShort($t->deadline) }}</span>
                                                @else
                                                    <span class="text-dark small">{{ \App\Helpers\WaktuHelper::formatShort($t->deadline) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-muted">Belum ada tugas sekolah.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif

</div>
@endsection
