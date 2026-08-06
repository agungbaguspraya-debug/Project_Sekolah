@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <!-- Success or Error Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Banner Kenaikan Kelas (Jika Siswa Dinyatakan Naik Kelas) -->
    @if($siswa->status_kenaikan === 'Naik Kelas')
        <div class="alert alert-success border-0 shadow-sm p-4 rounded-3 mb-4 d-flex align-items-center gap-3">
            <div class="bg-success text-white p-3 rounded-circle fs-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                <i class="bi bi-award-fill"></i>
            </div>
            <div>
                <span class="badge bg-success mb-1">PEMBERITAHUAN KENAIKAN KELAS</span>
                <h4 class="fw-bold text-dark mb-1">🎉 Selamat! Anda Dinyatakan NAIK KELAS!</h4>
                <p class="mb-0 text-secondary">
                    {{ $siswa->pesan_kenaikan ?? 'Selamat atas pencapaian prestasi Anda selama satu tahun ajaran!' }} Sekarang Anda resmi menjadi siswa di <strong>Kelas {{ $siswa->kelas }}</strong>.
                </p>
            </div>
        </div>
    @endif

    <!-- Banner Kelulusan & Upload Foto Kenangan (Jika Siswa Berstatus LULUS) -->
    @if($siswa->status === 'Lulus')
        <div class="card border-0 shadow-lg mb-4 bg-gradient bg-dark text-white rounded-3 overflow-hidden border-start border-5 border-warning">
            <div class="card-body p-4 p-lg-5">
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-3 mb-lg-0">
                        <span class="badge bg-warning text-dark fw-bold px-3 py-2 mb-3 fs-6">
                            <i class="bi bi-mortarboard-fill me-1"></i> STATUS KELULUSAN ALUMNI
                        </span>
                        <h2 class="fw-bold text-white mb-2">
                            🎓 Selamat! Anda Sudah Lulus dari Sekolah!
                        </h2>
                        <h5 class="text-warning mb-3">
                            Tahun Kelulusan: <strong>{{ $siswa->tahun_lulus ?? date('Y') }}</strong> | {{ $profilSekolah->nama_sekolah ?? 'Sekolah Kita' }}
                        </h5>
                        <p class="text-white-50 mb-0">
                            Selamat dan sukses atas kelulusan Anda! Rangkuman pencapaian prestasi dan total poin pelanggaran Anda tercatat secara resmi di bawah ini.
                        </p>
                    </div>
                    <div class="col-lg-4 text-center">
                        <div class="bg-white bg-opacity-10 p-4 rounded-3 border border-white border-opacity-25 shadow">
                            <small class="text-warning fw-bold text-uppercase d-block mb-2"><i class="bi bi-star-fill me-1"></i> Rangkuman Nilai & Poin</small>
                            <div class="d-flex justify-content-around text-center mt-2">
                                <div>
                                    <small class="text-white-50 d-block">Total Nilai</small>
                                    <h3 class="fw-bold text-white mb-0">{{ number_format($siswa->total_nilai ?? 85.00, 2) }}</h3>
                                </div>
                                <div class="border-end border-white border-opacity-25"></div>
                                <div>
                                    <small class="text-white-50 d-block">Total Poin Pelanggaran</small>
                                    <h3 class="fw-bold text-warning mb-0">{{ $totalPoints }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOTO KENANGAN KELULUSAN SECTION -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-camera-fill me-2 text-primary"></i>Foto Kenangan Kelulusan Anda</h5>
            </div>
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-5 text-center mb-3 mb-md-0">
                        @if($siswa->foto_kenangan)
                            <div class="p-3 bg-white shadow-sm border rounded text-center d-inline-block">
                                <img src="{{ asset('storage/'.$siswa->foto_kenangan) }}" alt="Foto Kenangan {{ $siswa->nama }}" class="img-fluid rounded" style="max-height: 260px; object-fit: cover;">
                                <div class="mt-2 fw-bold text-dark small"><i class="bi bi-heart-fill me-1 text-danger"></i> Kenangan Masa Sekolah</div>
                            </div>
                        @else
                            <div class="p-4 bg-light rounded text-center text-muted border border-dashed">
                                <i class="bi bi-images fs-1 d-block mb-2 text-secondary"></i>
                                Belum ada foto kenangan kelulusan yang diunggah.
                            </div>
                        @endif
                    </div>
                    <div class="col-md-7">
                        <h6 class="fw-bold mb-2">Unggah / Perbarui Foto Kenangan Kelulusan</h6>
                        <p class="text-muted small mb-3">Abadikan momen kelulusan atau foto kenangan terbaik Anda di album alumni ini.</p>
                        <form action="{{ route('siswa.upload-foto-kenangan') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <input type="file" name="foto_kenangan" class="form-control" accept="image/*" required>
                                <small class="text-muted">Format: JPG, PNG, WEBP (Max 5MB)</small>
                            </div>
                            <button type="submit" class="btn btn-primary fw-bold px-4">
                                <i class="bi bi-cloud-upload-fill me-1"></i> Simpan Foto Kenangan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- SECTION 1: Profil Saya & Catatan Pelanggaran -->
    <div id="section-profile" class="mb-5">
        <div class="card border-0 shadow-sm bg-primary bg-gradient text-white mb-4 rounded-3">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge bg-white text-primary fw-bold px-3 py-1 mb-2">PORTAL SISWA</span>
                    <h3 class="fw-bold mb-0 text-white"><i class="bi bi-person-circle me-2"></i>Profil Saya & Data Akademik</h3>
                </div>
                <span class="badge bg-light text-dark fw-bold fs-6"><i class="bi bi-building me-1"></i>Kelas {{ $siswa->kelas }}</span>
            </div>
        </div>

        <div class="row">
            <!-- Profile Card (Left) -->
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            @if($siswa->foto)
                                <img src="{{ asset('storage/'.$siswa->foto) }}" alt="Foto {{ $siswa->nama }}" class="rounded-circle object-fit-cover border border-3 border-primary shadow-sm" style="width: 130px; height: 130px;">
                            @else
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto shadow-sm" style="width: 130px; height: 130px;">
                                    <i class="bi bi-person-fill" style="font-size: 4rem;"></i>
                                </div>
                            @endif
                        </div>
                        <h4 class="fw-bold mb-1 text-dark">{{ $siswa->nama }}</h4>
                        <p class="text-muted mb-3">NIS: <strong>{{ $siswa->nis }}</strong></p>
                        <span class="badge bg-success px-3 py-2 mb-4"><i class="bi bi-check-circle-fill me-1"></i>{{ $siswa->status }}</span>

                        <div class="text-start border-top pt-3">
                            <div class="mb-3">
                                <small class="text-muted d-block fw-bold mb-1">{{ $siswa->status === 'Lulus' ? 'Kelas Terakhir' : 'Kelas Saat Ini' }}</small>
                                <span class="fw-bold text-dark fs-5"><i class="bi bi-building-fill text-primary me-2"></i>{{ $siswa->kelas }}</span>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block fw-bold mb-1">Jurusan / Keahlian</small>
                                <span class="fw-bold text-dark fs-5"><i class="bi bi-journal-text text-primary me-2"></i>{{ $siswa->jurusan }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Violations & Discipline Card (Right) -->
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm text-white mb-4 {{ $totalPoints > 0 ? 'bg-danger bg-gradient' : 'bg-success bg-gradient' }}">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 text-white-50">Status Kedisiplinan Siswa</h5>
                            <h2 class="fw-bold mb-0 text-white">
                                @if($totalPoints > 0)
                                    Butuh Pembinaan <i class="bi bi-exclamation-triangle-fill ms-1"></i>
                                @else
                                    Sangat Baik <i class="bi bi-shield-check ms-1"></i>
                                @endif
                            </h2>
                        </div>
                        <div class="text-end">
                            <h5 class="mb-1 text-white-50">Total Poin Pelanggaran</h5>
                            <h1 class="fw-bold mb-0 text-white" style="font-size: 3rem;">{{ $totalPoints }}</h1>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>Catatan Pelanggaran Siswa</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4" style="width: 80px;">No</th>
                                        <th>Nama Pelanggaran</th>
                                        <th style="width: 150px;">Tanggal</th>
                                        <th class="pe-4 text-end" style="width: 120px;">Poin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pelanggarans as $index => $item)
                                    <tr>
                                        <td class="ps-4 fw-bold text-secondary">{{ $index + 1 }}</td>
                                        <td class="fw-bold text-dark">{{ $item->nama_pelanggaran }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                                        <td class="pe-4 text-end">
                                            <span class="badge bg-danger fs-6">{{ $item->point }}</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            <i class="bi bi-emoji-smile fs-1 text-success d-block mb-2"></i>
                                            Selamat! Anda tidak memiliki catatan pelanggaran.
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

    <!-- SECTION 2 & 3: Jadwal Pelajaran & Tugas Sekolah (Hanya untuk Siswa Aktif) -->
    @if($siswa->status !== 'Lulus')
        <!-- SECTION 2: Jadwal Pelajaran (Ditaruh Dibawah Profile) -->
        <div id="section-schedule" class="mb-5 pt-3">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-warning bg-opacity-10 py-3 border-0 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-calendar3 text-warning me-2"></i>Jadwal Pelajaran Kelas {{ $siswa->kelas }}
                    </h4>
                    <span class="badge bg-warning text-dark fw-bold px-3 py-2">Senin - Jumat</span>
                </div>
                <div class="card-body p-4">
                    <div class="row row-cols-1 row-cols-md-5 g-3">
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                            <div class="col">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-header bg-dark text-white py-2 fw-bold text-center fs-6">{{ $day }}</div>
                                    <div class="card-body p-3">
                                        @if(isset($jadwals[$day]) && count($jadwals[$day]) > 0)
                                            <div class="list-group list-group-flush">
                                                @foreach($jadwals[$day] as $item)
                                                    <div class="list-group-item px-0 py-2 border-0 border-bottom">
                                                        <div class="fw-bold text-dark mb-1">{{ $item->mata_pelajaran }}</div>
                                                        @if($item->guru)
                                                            <div class="small text-primary fw-semibold mb-1">
                                                                <i class="bi bi-person-fill me-1"></i>{{ $item->guru->nama }}
                                                            </div>
                                                        @else
                                                            <div class="small text-muted mb-1">
                                                                <i class="bi bi-person-dash me-1"></i>Guru belum diatur
                                                            </div>
                                                        @endif
                                                        <span class="text-muted small"><i class="bi bi-clock me-1 text-secondary"></i>{{ date('H:i', strtotime($item->jam_mulai)) }} - {{ date('H:i', strtotime($item->jam_selesai)) }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center py-4 text-muted small">
                                                <i class="bi bi-calendar2-minus d-block fs-3 mb-2 text-secondary"></i>
                                                Tidak ada pelajaran
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 3: Tugas Sekolah (Ditaruh Dibawah Jadwal Pelajaran) -->
        <div id="section-tasks" class="mb-5 pt-3">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-danger bg-opacity-10 py-3 border-0 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-file-earmark-text-fill text-danger me-2"></i>Tugas Sekolah Kelas {{ $siswa->kelas }}
                    </h4>
                    <span class="badge bg-danger px-3 py-2">Daftar Tugas & Pengumpulan</span>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <!-- Left: Pending Assignments -->
                        <div class="col-md-6 mb-4">
                            <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
                                <i class="bi bi-clock-history text-danger me-2"></i>Belum Dikumpulkan
                            </h5>
                            @php $pendingCount = 0; @endphp
                            @foreach($tugas as $item)
                                @if(!$submissions->has($item->id))
                                    @php $pendingCount++; @endphp
                                    <div class="card border-0 shadow-sm mb-3 border-start border-4 border-warning">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h5 class="fw-bold text-dark mb-1">{{ $item->judul }}</h5>
                                                    @if($item->mata_pelajaran)
                                                        <span class="badge bg-primary mb-2">{{ $item->mata_pelajaran }}</span>
                                                    @endif
                                                </div>
                                                @if(\Carbon\Carbon::parse($item->deadline)->isPast())
                                                    <span class="badge bg-danger">Terlambat</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Aktif</span>
                                                @endif
                                            </div>
                                            <p class="text-secondary small mb-2">{{ $item->deskripsi }}</p>
                                            @if($item->foto)
                                                <div class="mb-3">
                                                    <a href="{{ asset('storage/'.$item->foto) }}" target="_blank">
                                                        <img src="{{ asset('storage/'.$item->foto) }}" alt="Foto Lampiran Tugas" class="img-thumbnail rounded" style="max-height: 150px;">
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="border-top pt-3 d-flex justify-content-between align-items-center">
                                                <span class="text-danger small fw-bold">
                                                    <i class="bi bi-calendar-event me-1"></i>Batas: {{ \App\Helpers\WaktuHelper::format($item->deadline) }}
                                                </span>
                                                <button class="btn btn-primary btn-sm px-3" type="button" data-bs-toggle="collapse" data-bs-target="#submitForm_{{ $item->id }}" aria-expanded="false" aria-controls="submitForm_{{ $item->id }}">
                                                    <i class="bi bi-send-fill me-1"></i> Kumpulkan
                                                </button>
                                            </div>

                                            <!-- Submit Form Collapse -->
                                            <div class="collapse" id="submitForm_{{ $item->id }}">
                                                <form action="{{ route('siswa.tugas.submit', $item->id) }}" method="POST" enctype="multipart/form-data" class="mt-3 p-3 bg-light rounded border border-secondary-subtle">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="catatan_{{ $item->id }}" class="form-label fw-bold small">Catatan Tugas</label>
                                                        <textarea name="catatan" id="catatan_{{ $item->id }}" class="form-control form-control-sm" rows="2" placeholder="Catatan jawaban atau keterangan tugas..."></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="file_{{ $item->id }}" class="form-label fw-bold small">Unggah Berkas (Opsional, Max 5MB)</label>
                                                        <input type="file" name="file" id="file_{{ $item->id }}" class="form-control form-control-sm">
                                                    </div>
                                                    <div class="d-grid">
                                                        <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check-circle-fill me-1"></i> Kirim Jawaban</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            @if($pendingCount === 0)
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body py-5 text-center text-muted">
                                        <i class="bi bi-clipboard2-check fs-1 text-success d-block mb-2"></i>
                                        Semua tugas telah dikumpulkan. Luar biasa!
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Right: Completed Assignments -->
                        <div class="col-md-6 mb-4">
                            <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>Sudah Dikumpulkan
                            </h5>
                            @php $completedCount = 0; @endphp
                            @foreach($tugas as $item)
                                @if($submissions->has($item->id))
                                    @php 
                                        $completedCount++; 
                                        $sub = $submissions->get($item->id);
                                    @endphp
                                    <div class="card border-0 shadow-sm mb-3 border-start border-4 border-success">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h5 class="fw-bold text-dark mb-1">{{ $item->judul }}</h5>
                                                    @if($item->mata_pelajaran)
                                                        <span class="badge bg-primary mb-2">{{ $item->mata_pelajaran }}</span>
                                                    @endif
                                                </div>
                                                <span class="badge bg-success"><i class="bi bi-check me-1"></i>Selesai</span>
                                            </div>
                                            <p class="text-secondary small mb-2">{{ $item->deskripsi }}</p>
                                            @if($item->foto)
                                                <div class="mb-3">
                                                    <a href="{{ asset('storage/'.$item->foto) }}" target="_blank">
                                                        <img src="{{ asset('storage/'.$item->foto) }}" alt="Foto Lampiran Tugas" class="img-thumbnail rounded" style="max-height: 150px;">
                                                    </a>
                                                </div>
                                            @endif
                                            
                                            <div class="bg-light p-3 rounded mb-3">
                                                <small class="text-muted d-block fw-bold mb-1"><i class="bi bi-chat-left-text-fill me-1"></i>Jawaban/Catatan Anda:</small>
                                                <p class="mb-2 text-dark small">{{ $sub->catatan ?? '-' }}</p>
                                                
                                                @if($sub->file_path)
                                                    <a href="{{ asset('storage/'.$sub->file_path) }}" class="btn btn-outline-primary btn-sm px-3 mb-2" target="_blank">
                                                        <i class="bi bi-download me-1"></i> Unduh Berkas Tugas
                                                    </a>
                                                @endif

                                                <!-- DISPLAY GRADE & TEACHER RESPONSE FOR STUDENT -->
                                                @if($sub->nilai !== null)
                                                    <div class="alert alert-success border border-success border-opacity-25 shadow-sm rounded-3 mt-3 p-3 mb-0">
                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                            <span class="fw-bold text-success"><i class="bi bi-star-fill me-1 text-warning"></i> Nilai Tugas Guru:</span>
                                                            <span class="badge bg-success fs-5 px-3 py-1">⭐ {{ $sub->nilai }} / 100</span>
                                                        </div>
                                                        @if($sub->respon_guru)
                                                            <div class="pt-2 border-top border-success border-opacity-25">
                                                                <small class="fw-bold text-dark d-block mb-1"><i class="bi bi-chat-left-quote-fill me-1 text-primary"></i> Respon & Catatan Guru:</small>
                                                                <p class="mb-0 text-dark small fst-italic">"{{ $sub->respon_guru }}"</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="alert alert-warning border-0 shadow-sm mt-3 p-2 text-center mb-0">
                                                        <small class="fw-bold text-dark"><i class="bi bi-clock-history me-1"></i> Menunggu penilaian guru</small>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted small">
                                                    Dikirim pada: {{ \App\Helpers\WaktuHelper::format($sub->dikumpulkan_pada) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            @if($completedCount === 0)
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body py-5 text-center text-muted">
                                        <i class="bi bi-card-text fs-1 text-secondary d-block mb-2"></i>
                                        Belum ada tugas yang dikumpulkan.
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
