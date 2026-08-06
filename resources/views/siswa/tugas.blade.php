@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <!-- Success or Error Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Hero Header Banner -->
    <div class="card border-0 shadow-sm bg-gradient bg-primary text-white mb-4 rounded-3">
        <div class="card-body p-4 p-lg-5 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <span class="badge bg-white text-primary fw-bold px-3 py-1 mb-2">PORTAL TUGAS SISWA</span>
                <h2 class="fw-bold text-white mb-1">
                    <i class="bi bi-file-earmark-text-fill me-2"></i>Tugas Sekolah Kelas {{ $siswa->kelas }}
                </h2>
                <p class="mb-0 text-white-50">
                    Daftar tugas yang telah diberikan guru untuk kelas Anda. Kumpulkan jawaban tepat waktu sebelum deadline.
                </p>
            </div>
            <div class="text-end bg-white bg-opacity-10 p-3 rounded-3 border border-white border-opacity-25">
                <small class="text-white-50 d-block mb-1"><i class="bi bi-person-circle me-1"></i> Siswa</small>
                <h5 class="fw-bold text-white mb-0">{{ $siswa->nama }}</h5>
                <small class="text-white-50">NIS: {{ $siswa->nis }}</small>
            </div>
        </div>
    </div>

    @php
        $totalTugasSiswa = $tugas->count();
        $completedCount = 0;
        $pendingCount = 0;
        $overdueCount = 0;
        $urgentCount = 0;

        foreach($tugas as $t) {
            if($submissions->has($t->id)) {
                $completedCount++;
            } else {
                $pendingCount++;
                $deadlineCarbon = \Carbon\Carbon::parse($t->deadline);
                if($deadlineCarbon->isPast()) {
                    $overdueCount++;
                } else if($deadlineCarbon->diffInHours(now()) <= 24) {
                    $urgentCount++;
                }
            }
        }
    @endphp

    <!-- NOTIFICATION ALERTS BANNER FOR STUDENT -->
    @if($pendingCount > 0 || $overdueCount > 0)
        <div class="row g-3 mb-4">
            @if($pendingCount > 0)
                <div class="col-md-{{ $overdueCount > 0 || $urgentCount > 0 ? '6' : '12' }}">
                    <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center mb-0 p-3 rounded-3 border-start border-5 border-warning">
                        <div class="bg-warning text-dark p-3 rounded-circle me-3">
                            <i class="bi bi-bell-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">🔔 Notifikasi Tugas Belum Dikumpulkan ({{ $pendingCount }} Tugas)</h6>
                            <p class="mb-0 small text-secondary">
                                Anda memiliki <strong>{{ $pendingCount }} tugas</strong> yang belum dikumpulkan. Mohon cek daftar di bawah dan segera selesaikan.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if($overdueCount > 0 || $urgentCount > 0)
                <div class="col-md-{{ $pendingCount > 0 ? '6' : '12' }}">
                    <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center mb-0 p-3 rounded-3 border-start border-5 border-danger">
                        <div class="bg-danger text-white p-3 rounded-circle me-3">
                            <i class="bi bi-alarm-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">⏰ Peringatan Batas Waktu Deadline!</h6>
                            <p class="mb-0 small text-secondary">
                                @if($overdueCount > 0)
                                    Ada <strong class="text-danger">{{ $overdueCount }} tugas lewat deadline</strong>.
                                @endif
                                @if($urgentCount > 0)
                                    Ada <strong class="text-warning">{{ $urgentCount }} tugas mendekati deadline (&lt; 24 Jam)</strong>.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <!-- Task Statistics Summary Cards -->
    <div class="col-12 mb-4">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
            <div class="col">
                <div class="card border-0 shadow-sm h-100 p-3 border-start border-4 border-primary">
                    <small class="text-muted fw-bold text-uppercase d-block mb-1">Total Tugas Kelas</small>
                    <h3 class="fw-bold text-dark mb-0">{{ $totalTugasSiswa }}</h3>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 shadow-sm h-100 p-3 border-start border-4 border-warning">
                    <small class="text-muted fw-bold text-uppercase d-block mb-1">Belum Dikumpulkan</small>
                    <h3 class="fw-bold text-warning mb-0">{{ $pendingCount }}</h3>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 shadow-sm h-100 p-3 border-start border-4 border-success">
                    <small class="text-muted fw-bold text-uppercase d-block mb-1">Sudah Dikumpulkan</small>
                    <h3 class="fw-bold text-success mb-0">{{ $completedCount }}</h3>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 shadow-sm h-100 p-3 border-start border-4 border-danger">
                    <small class="text-muted fw-bold text-uppercase d-block mb-1">Lewat Deadline</small>
                    <h3 class="fw-bold text-danger mb-0">{{ $overdueCount }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Nav Pills -->
    <div class="col-12 mb-4">
        <ul class="nav nav-pills gap-2 bg-white p-2 rounded-3 shadow-sm" id="tugasTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold px-4 rounded-3" id="all-tasks-tab" data-bs-toggle="pill" data-bs-target="#all-tasks" type="button" role="tab">
                    <i class="bi bi-collection-fill me-1"></i> Semua Tugas ({{ $totalTugasSiswa }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold px-4 rounded-3" id="pending-tasks-tab" data-bs-toggle="pill" data-bs-target="#pending-tasks" type="button" role="tab">
                    <i class="bi bi-clock-history me-1"></i> Belum Dikumpulkan ({{ $pendingCount }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold px-4 rounded-3" id="completed-tasks-tab" data-bs-toggle="pill" data-bs-target="#completed-tasks" type="button" role="tab">
                    <i class="bi bi-check-circle-fill me-1"></i> Sudah Dikumpulkan ({{ $completedCount }})
                </button>
            </li>
        </ul>
    </div>

    <!-- Tab Contents -->
    <div class="col-12">
        <div class="tab-content" id="tugasTabContent">
            
            <!-- Tab 1: All Tasks -->
            <div class="tab-pane fade show active" id="all-tasks" role="tabpanel">
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    @forelse($tugas as $item)
                        @php 
                            $isDone = $submissions->has($item->id); 
                            $deadline = \Carbon\Carbon::parse($item->deadline);
                            $isPast = $deadline->isPast();
                            $sub = $isDone ? $submissions->get($item->id) : null;
                        @endphp
                        <div class="col">
                            <div class="card border-0 shadow-sm h-100 border-start border-4 {{ $isDone ? 'border-success' : ($isPast ? 'border-danger' : 'border-primary') }}">
                                <div class="card-body p-4 d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <span class="badge bg-primary mb-2 fs-6">{{ $item->mata_pelajaran ?? 'Mata Pelajaran' }}</span>
                                                <h4 class="fw-bold text-dark mb-1">{{ $item->judul }}</h4>
                                            </div>
                                            @if($isDone)
                                                <span class="badge bg-success px-3 py-2 fs-6"><i class="bi bi-check-circle-fill me-1"></i>Selesai</span>
                                            @elseif($isPast)
                                                <span class="badge bg-danger px-3 py-2 fs-6"><i class="bi bi-exclamation-circle-fill me-1"></i>Lewat Deadline</span>
                                            @else
                                                <span class="badge bg-warning text-dark px-3 py-2 fs-6"><i class="bi bi-clock me-1"></i>Aktif</span>
                                            @endif
                                        </div>

                                        <p class="text-secondary small mb-3">{{ $item->deskripsi }}</p>

                                        @if($item->foto)
                                            <div class="mb-3">
                                                <small class="text-muted d-block fw-bold mb-1"><i class="bi bi-image me-1"></i>Lampiran Gambar Tugas:</small>
                                                <a href="{{ asset('storage/'.$item->foto) }}" target="_blank">
                                                    <img src="{{ asset('storage/'.$item->foto) }}" alt="Lampiran {{ $item->judul }}" class="img-thumbnail rounded" style="max-height: 160px; object-fit: cover;">
                                                </a>
                                            </div>
                                        @endif

                                        @if($item->guru)
                                            <div class="small text-muted mb-3">
                                                <i class="bi bi-person-fill text-primary me-1"></i>Guru Pengajar: <strong>{{ $item->guru->nama }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                    <div>
                                        @if($isDone && $sub)
                                            <div class="bg-light p-3 rounded mb-3 border">
                                                <small class="text-muted d-block fw-bold mb-1"><i class="bi bi-chat-left-text-fill me-1 text-success"></i>Jawaban Anda:</small>
                                                <p class="mb-2 text-dark small">{{ $sub->catatan ?? '-' }}</p>
                                                @if($sub->file_path)
                                                    <a href="{{ asset('storage/'.$sub->file_path) }}" class="btn btn-outline-primary btn-sm px-3 mb-2" target="_blank">
                                                        <i class="bi bi-download me-1"></i> Unduh Berkas Jawaban
                                                    </a>
                                                @endif
                                                <div class="text-muted small">
                                                    Dikumpulkan pada: {{ \App\Helpers\WaktuHelper::format($sub->dikumpulkan_pada) }}
                                                </div>

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
                                                        <small class="fw-bold text-dark"><i class="bi bi-clock-history me-1"></i> Tugas telah dikumpulkan & menunggu penilaian guru</small>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                        <div class="border-top pt-3 d-flex justify-content-between align-items-center">
                                            <span class="{{ $isPast && !$isDone ? 'text-danger' : 'text-primary' }} small fw-bold">
                                                <i class="bi bi-calendar-event me-1"></i>Deadline: {{ \App\Helpers\WaktuHelper::format($item->deadline) }}
                                            </span>
                                            @if(!$isDone)
                                                <button class="btn btn-primary btn-sm px-4 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#submitFormPage_{{ $item->id }}">
                                                    <i class="bi bi-send-fill me-1"></i> Kumpulkan Tugas
                                                </button>
                                            @endif
                                        </div>

                                        @if(!$isDone)
                                            <div class="collapse" id="submitFormPage_{{ $item->id }}">
                                                <form action="{{ route('siswa.tugas.submit', $item->id) }}" method="POST" enctype="multipart/form-data" class="mt-3 p-3 bg-light rounded border">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="catatan_p_{{ $item->id }}" class="form-label fw-bold small">Catatan Jawaban</label>
                                                        <textarea name="catatan" id="catatan_p_{{ $item->id }}" class="form-control form-control-sm" rows="2" placeholder="Tulis catatan atau jawaban tugas Anda..."></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="file_p_{{ $item->id }}" class="form-label fw-bold small">Unggah Berkas (Opsional, Max 5MB)</label>
                                                        <input type="file" name="file" id="file_p_{{ $item->id }}" class="form-control form-control-sm">
                                                    </div>
                                                    <div class="d-grid">
                                                        <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check-circle-fill me-1"></i> Kirim Tugas</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="card border-0 shadow-sm p-5 text-center text-muted">
                                    <i class="bi bi-clipboard-x fs-1 text-secondary mb-2 d-block"></i>
                                    Belum ada tugas sekolah yang diberikan untuk kelas Anda.
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Tab 2: Pending Tasks Only -->
                <div class="tab-pane fade" id="pending-tasks" role="tabpanel">
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        @forelse($tugas as $item)
                            @if(!$submissions->has($item->id))
                                @php $deadline = \Carbon\Carbon::parse($item->deadline); @endphp
                                <div class="col">
                                    <div class="card border-0 shadow-sm h-100 border-start border-4 border-warning">
                                        <div class="card-body p-4">
                                            <span class="badge bg-primary mb-2 fs-6">{{ $item->mata_pelajaran ?? 'Mata Pelajaran' }}</span>
                                            <h4 class="fw-bold text-dark mb-1">{{ $item->judul }}</h4>
                                            <p class="text-secondary small mb-3">{{ $item->deskripsi }}</p>

                                            @if($item->foto)
                                                <div class="mb-3">
                                                    <a href="{{ asset('storage/'.$item->foto) }}" target="_blank">
                                                        <img src="{{ asset('storage/'.$item->foto) }}" alt="Lampiran" class="img-thumbnail rounded" style="max-height: 150px;">
                                                    </a>
                                                </div>
                                            @endif

                                            <div class="border-top pt-3 d-flex justify-content-between align-items-center">
                                                <span class="text-danger small fw-bold">
                                                    <i class="bi bi-calendar-event me-1"></i>Deadline: {{ \App\Helpers\WaktuHelper::format($item->deadline) }}
                                                </span>
                                                <button class="btn btn-primary btn-sm px-4 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#submitFormPending_{{ $item->id }}">
                                                    <i class="bi bi-send-fill me-1"></i> Kumpulkan
                                                </button>
                                            </div>

                                            <div class="collapse" id="submitFormPending_{{ $item->id }}">
                                                <form action="{{ route('siswa.tugas.submit', $item->id) }}" method="POST" enctype="multipart/form-data" class="mt-3 p-3 bg-light rounded border">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold small">Catatan Jawaban</label>
                                                        <textarea name="catatan" class="form-control form-control-sm" rows="2" placeholder="Catatan jawaban..."></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold small">Unggah Berkas (Max 5MB)</label>
                                                        <input type="file" name="file" class="form-control form-control-sm">
                                                    </div>
                                                    <div class="d-grid">
                                                        <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check-circle-fill me-1"></i> Kirim</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="col-12">
                                <div class="card border-0 shadow-sm p-5 text-center text-muted">
                                    <i class="bi bi-emoji-smile fs-1 text-success mb-2 d-block"></i>
                                    Semua tugas kelas Anda telah dikumpulkan!
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Tab 3: Completed Tasks Only -->
                <div class="tab-pane fade" id="completed-tasks" role="tabpanel">
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        @forelse($tugas as $item)
                            @if($submissions->has($item->id))
                                @php $sub = $submissions->get($item->id); @endphp
                                <div class="col">
                                    <div class="card border-0 shadow-sm h-100 border-start border-4 border-success">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <span class="badge bg-primary mb-2 fs-6">{{ $item->mata_pelajaran ?? 'Mata Pelajaran' }}</span>
                                                    <h4 class="fw-bold text-dark mb-1">{{ $item->judul }}</h4>
                                                </div>
                                                <span class="badge bg-success px-3 py-2"><i class="bi bi-check me-1"></i>Selesai</span>
                                            </div>
                                            <p class="text-secondary small mb-3">{{ $item->deskripsi }}</p>

                                            <div class="bg-light p-3 rounded mb-3 border">
                                                <small class="text-muted d-block fw-bold mb-1"><i class="bi bi-chat-left-text-fill me-1 text-success"></i>Jawaban Anda:</small>
                                                <p class="mb-2 text-dark small">{{ $sub->catatan ?? '-' }}</p>
                                                @if($sub->file_path)
                                                    <a href="{{ asset('storage/'.$sub->file_path) }}" class="btn btn-outline-primary btn-sm px-3 mb-2" target="_blank">
                                                        <i class="bi bi-download me-1"></i> Unduh Berkas Jawaban
                                                    </a>
                                                @endif
                                                <div class="text-muted small">
                                                    Dikumpulkan pada: {{ \App\Helpers\WaktuHelper::format($sub->dikumpulkan_pada) }}
                                                </div>

                                                <!-- DISPLAY GRADE & TEACHER RESPONSE -->
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
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="col-12">
                                <div class="card border-0 shadow-sm p-5 text-center text-muted">
                                    <i class="bi bi-card-text fs-1 text-secondary mb-2 d-block"></i>
                                    Belum ada tugas yang selesai dikumpulkan.
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
