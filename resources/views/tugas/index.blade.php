@extends('layouts.app')

@section('content')
<div class="row">
    @if(session('success'))
        <div class="col-md-12 mb-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="col-md-12 mb-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if(Auth::user()->isSiswa())
        <!-- DEDICATED STUDENT TASKS DASHBOARD -->
        <div class="col-md-12 mb-4">
            <div class="card border-0 shadow-sm bg-gradient bg-primary text-white rounded-3">
                <div class="card-body p-4 p-lg-5 d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <span class="badge bg-white text-primary fw-bold px-3 py-1 mb-2">DASHBOARD TUGAS SISWA</span>
                        <h2 class="fw-bold text-white mb-1">
                            <i class="bi bi-file-earmark-text-fill me-2"></i>Tugas Sekolah Kelas {{ Auth::user()->siswa->kelas ?? '' }}
                        </h2>
                        <p class="mb-0 text-white-50">
                            Pantau daftar tugas aktif, unduh materi lampiran, dan kumpulkan jawaban Anda secara cepat.
                        </p>
                    </div>
                    <div class="text-end bg-white bg-opacity-10 p-3 rounded-3 border border-white border-opacity-25">
                        <small class="text-white-50 d-block mb-1"><i class="bi bi-mortarboard me-1"></i> Kelas & Jurusan</small>
                        <h5 class="fw-bold text-white mb-0">{{ Auth::user()->siswa->kelas ?? '-' }} | {{ Auth::user()->siswa->jurusan ?? '-' }}</h5>
                    </div>
                </div>
            </div>
        </div>

        @php
            $totalTugasSiswa = $tugas->count();
            $completedCount = 0;
            $pendingCount = 0;
            $overdueCount = 0;

            foreach($tugas as $t) {
                if($submissions->has($t->id)) {
                    $completedCount++;
                } else {
                    $pendingCount++;
                    if(\Carbon\Carbon::parse($t->deadline)->isPast()) {
                        $overdueCount++;
                    }
                }
            }
        @endphp

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
                        <small class="text-muted fw-bold text-uppercase d-block mb-1">Lewat Batas Deadline</small>
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
                            @php $isDone = $submissions->has($item->id); @endphp
                            <div class="col">
                                <div class="card border-0 shadow-sm h-100 border-start border-4 {{ $isDone ? 'border-success' : (\Carbon\Carbon::parse($item->deadline)->isPast() ? 'border-danger' : 'border-primary') }}">
                                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                                        <div>
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <span class="badge bg-primary mb-2 fs-6">{{ $item->mata_pelajaran ?? 'Mata Pelajaran' }}</span>
                                                    <h4 class="fw-bold text-dark mb-1">{{ $item->judul }}</h4>
                                                </div>
                                                @if($isDone)
                                                    <span class="badge bg-success px-3 py-2"><i class="bi bi-check-circle-fill me-1"></i>Selesai</span>
                                                @elseif(\Carbon\Carbon::parse($item->deadline)->isPast())
                                                    <span class="badge bg-danger px-3 py-2"><i class="bi bi-exclamation-circle-fill me-1"></i>Terlambat</span>
                                                @else
                                                    <span class="badge bg-warning text-dark px-3 py-2"><i class="bi bi-clock me-1"></i>Aktif</span>
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
                                                    <i class="bi bi-person-fill text-primary me-1"></i>Diberikan oleh Guru: <strong>{{ $item->guru->nama }}</strong>
                                                </div>
                                            @endif
                                        </div>

                                        <div>
                                            @if($isDone)
                                                @php $sub = $submissions->get($item->id); @endphp
                                                <div class="bg-light p-3 rounded mb-3 border">
                                                    <small class="text-muted d-block fw-bold mb-1"><i class="bi bi-chat-left-text-fill me-1 text-success"></i>Jawaban Anda:</small>
                                                    <p class="mb-2 text-dark small">{{ $sub->catatan ?? '-' }}</p>
                                                    @if($sub->file_path)
                                                        <a href="{{ asset('storage/'.$sub->file_path) }}" class="btn btn-outline-primary btn-sm px-3" target="_blank">
                                                            <i class="bi bi-download me-1"></i> Unduh Berkas Dikirim
                                                        </a>
                                                    @endif
                                                    <div class="text-muted small mt-2">
                                                        Dikumpulkan pada: {{ \Carbon\Carbon::parse($sub->dikumpulkan_pada)->translatedFormat('d F Y (H:i)') }}
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="border-top pt-3 d-flex justify-content-between align-items-center">
                                                <span class="text-danger small fw-bold">
                                                    <i class="bi bi-calendar-event me-1"></i>Deadline: {{ \Carbon\Carbon::parse($item->deadline)->translatedFormat('d F Y') }}
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
                                                    <i class="bi bi-calendar-event me-1"></i>Deadline: {{ \Carbon\Carbon::parse($item->deadline)->translatedFormat('d F Y') }}
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
                                                    <a href="{{ asset('storage/'.$sub->file_path) }}" class="btn btn-outline-primary btn-sm px-3" target="_blank">
                                                        <i class="bi bi-download me-1"></i> Unduh Berkas Jawaban
                                                    </a>
                                                @endif
                                            </div>
                                            <small class="text-muted d-block">
                                                Dikumpulkan pada: {{ \Carbon\Carbon::parse($sub->dikumpulkan_pada)->translatedFormat('d F Y (H:i)') }}
                                            </small>
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

    @else
        <!-- ADMIN & GURU VIEW FOR ASSIGNMENT MANAGEMENT -->
        <div class="col-md-12 mb-4">
            <h2 class="fw-bold"><i class="bi bi-file-earmark-text-fill me-2"></i>Kelola Tugas Sekolah & Mapel</h2>
            <p class="text-muted">Buat tugas mata pelajaran dan kirimkan langsung ke kelas tujuan.</p>
        </div>

        <!-- Create Assignment Form -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle-fill me-2"></i>Buat & Kirim Tugas</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('tugas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="kelas" class="form-label fw-bold">Kelas Tujuan Pengiriman</label>
                            <select name="kelas" id="kelas" class="form-select border-2" required>
                                <option value="">-- Pilih Kelas Tujuan --</option>
                                @if(count($kelasX) > 0)
                                    <optgroup label="🏫 Tingkat X (Kelas 10)">
                                        @foreach($kelasX as $k)
                                            <option value="{{ $k->nama_kelas }}">{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </optgroup>
                                @endif
                                @if(count($kelasXI) > 0)
                                    <optgroup label="🏫 Tingkat XI (Kelas 11)">
                                        @foreach($kelasXI as $k)
                                            <option value="{{ $k->nama_kelas }}">{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </optgroup>
                                @endif
                                @if(count($kelasXII) > 0)
                                    <optgroup label="🏫 Tingkat XII (Kelas 12)">
                                        @foreach($kelasXII as $k)
                                            <option value="{{ $k->nama_kelas }}">{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </optgroup>
                                @endif
                                @if(count($kelasOther) > 0)
                                    <optgroup label="🏫 Kelas Lainnya">
                                        @foreach($kelasOther as $k)
                                            <option value="{{ $k->nama_kelas }}">{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </optgroup>
                                @endif
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="mata_pelajaran" class="form-label fw-bold">Mata Pelajaran</label>
                            @if(Auth::user()->isGuru() && Auth::user()->guru)
                                <input type="text" name="mata_pelajaran" id="mata_pelajaran" class="form-control bg-light" value="{{ Auth::user()->guru->mata_pelajaran }}" readonly required>
                                <small class="text-muted">Otomatis terisi mata pelajaran pengampu Anda.</small>
                            @else
                                <input type="text" name="mata_pelajaran" id="mata_pelajaran" class="form-control" placeholder="Contoh: Pemrograman Web / Desain Grafis" required>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="judul" class="form-label fw-bold">Judul Tugas</label>
                            <input type="text" name="judul" id="judul" class="form-control" placeholder="Contoh: Latihan Form Laravel" required>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-bold">Deskripsi / Petunjuk</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" placeholder="Jelaskan petunjuk pengumpulan tugas..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label fw-bold">Foto / Lampiran Gambar <span class="badge bg-secondary">Opsional</span></label>
                            <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                            <small class="text-muted d-block mt-1">Format: JPG, PNG, GIF, WEBP (Maks 5MB)</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold"><i class="bi bi-calendar-check text-primary me-1"></i> Batas Pengumpulan Tugas (Deadline)</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <small class="text-muted fw-bold d-block mb-1">Tanggal Deadline</small>
                                    <input type="date" name="deadline_date" id="deadline_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted fw-bold d-block mb-1">Waktu / Jam</small>
                                    <input type="time" name="deadline_time" id="deadline_time" class="form-control" value="23:59" required>
                                </div>
                            </div>
                            <!-- Quick Time Presets -->
                            <div class="d-flex flex-wrap gap-1 mt-2 align-items-center">
                                <small class="text-muted fw-bold me-1" style="font-size: 0.75rem;">Pintas Jam:</small>
                                <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-2" style="font-size: 0.75rem;" onclick="document.getElementById('deadline_time').value='07:30'">07:30 Pagi</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-2" style="font-size: 0.75rem;" onclick="document.getElementById('deadline_time').value='12:00'">12:00 Pagi</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-2" style="font-size: 0.75rem;" onclick="document.getElementById('deadline_time').value='13:15'">13:15 Siang</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-2" style="font-size: 0.75rem;" onclick="document.getElementById('deadline_time').value='15:10'">15:10 Siang</button>
                                <button type="button" class="btn btn-outline-primary btn-sm py-0 px-2 fw-bold" style="font-size: 0.75rem;" onclick="document.getElementById('deadline_time').value='23:59'">23:59 Malam</button>
                            </div>
                        </div>

                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-primary py-2 fw-bold"><i class="bi bi-send-fill me-1"></i> Buat & Kirim Tugas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Assignments List Table -->
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold text-dark">Daftar Tugas Dibuat</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Tugas & Guru</th>
                                    <th>Mata Pelajaran & Kelas</th>
                                    <th>Foto</th>
                                    <th>Deadline (Tanggal & Waktu)</th>
                                    <th>Pengumpulan</th>
                                    <th class="pe-4 text-end" style="width: 180px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tugas as $item)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark mb-1">{{ $item->judul }}</div>
                                        <small class="text-muted text-truncate d-block mb-1" style="max-width: 220px;">{{ $item->deskripsi }}</small>
                                        @if($item->guru)
                                            <small class="text-primary fw-semibold"><i class="bi bi-person-badge me-1"></i>{{ $item->guru->nama }}</small>
                                        @else
                                            <small class="text-secondary"><i class="bi bi-shield-check me-1"></i>Admin</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->mata_pelajaran)
                                            <span class="badge bg-primary d-block mb-1 text-wrap" style="max-width: 150px;">{{ $item->mata_pelajaran }}</span>
                                        @endif
                                        <span class="badge bg-secondary">Tujuan: {{ $item->kelas }}</span>
                                    </td>
                                    <td>
                                        @if($item->foto)
                                            <a href="{{ asset('storage/'.$item->foto) }}" target="_blank" class="d-inline-block position-relative rounded overflow-hidden border" style="width: 45px; height: 45px;">
                                                <img src="{{ asset('storage/'.$item->foto) }}" alt="Foto Tugas" class="w-100 h-100 object-fit-cover">
                                            </a>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(\Carbon\Carbon::parse($item->deadline)->isPast())
                                            <span class="text-danger fw-bold"><i class="bi bi-exclamation-circle-fill me-1"></i>{{ \App\Helpers\WaktuHelper::formatShort($item->deadline) }}</span>
                                        @else
                                            <span class="text-dark fw-semibold"><i class="bi bi-clock me-1 text-primary"></i>{{ \App\Helpers\WaktuHelper::formatShort($item->deadline) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $totalSiswa = \App\Models\Siswa::where('kelas', $item->kelas)->count();
                                            $totalSubmissions = $item->submissions->count();
                                        @endphp
                                        <span class="badge bg-info text-dark fs-6">{{ $totalSubmissions }} / {{ $totalSiswa }} Siswa</span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <div class="d-inline-flex gap-1">
                                            <a href="{{ route('tugas.submissions', $item->id) }}" class="btn btn-warning btn-sm text-dark fw-semibold" title="Cek Submissions Siswa">
                                                <i class="bi bi-clipboard2-check-fill me-1"></i> Hasil
                                            </a>
                                            <form action="{{ route('tugas.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus Tugas">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-file-earmark-x fs-1 text-secondary mb-2 d-block"></i>
                                        Belum ada tugas sekolah yang dibuat.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
