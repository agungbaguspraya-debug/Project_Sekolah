@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 1200px; margin: 0 auto;">

    <!-- Navigation Header -->
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('tugas.submissions', $tuga->id) }}" class="btn btn-outline-secondary btn-sm me-3 shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Pengumpulan
        </a>
        <div>
            <h3 class="fw-bold mb-0 text-dark">
                <i class="bi bi-journal-check text-success me-2"></i>Pemeriksaan & Penilaian Tugas Siswa
            </h3>
            <small class="text-muted">Periksa pekerjaan siswa secara detail sebelum memberikan nilai dan saran.</small>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
            <h6 class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Gagal Menyimpan Penilaian:</h6>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- LEFT COLUMN: Student Profile & Submission Content Preview -->
        <div class="col-lg-7">
            
            <!-- Student Profile Summary -->
            <div class="card border-0 shadow-sm mb-4 rounded-3 overflow-hidden">
                <div class="card-header bg-primary bg-gradient text-white py-3 border-0">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-person-badge-fill me-2"></i>Identitas Siswa</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        @if($siswa->foto)
                            <img src="{{ asset('storage/'.$siswa->foto) }}" alt="{{ $siswa->nama }}" class="rounded-circle object-fit-cover border border-3 border-primary shadow-sm me-3" style="width: 75px; height: 75px;">
                        @else
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm me-3" style="width: 75px; height: 75px; font-size: 2rem;">
                                {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h4 class="fw-bold text-dark mb-1">{{ $siswa->nama }}</h4>
                            <p class="text-muted mb-1">NIS: <strong>{{ $siswa->nis }}</strong></p>
                            <div>
                                <span class="badge bg-primary me-1"><i class="bi bi-building me-1"></i>Kelas {{ $siswa->kelas }}</span>
                                <span class="badge bg-secondary"><i class="bi bi-journal-text me-1"></i>{{ $siswa->jurusan }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Task Assignment Details -->
            <div class="card border-0 shadow-sm mb-4 rounded-3">
                <div class="card-header bg-dark text-white py-3 border-0">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-file-earmark-text-fill me-2"></i>Informasi & Petunjuk Tugas</h5>
                </div>
                <div class="card-body p-4">
                    <h4 class="fw-bold text-dark mb-2">{{ $tuga->judul }}</h4>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @if($tuga->mata_pelajaran)
                            <span class="badge bg-primary px-3 py-2"><i class="bi bi-book me-1"></i>{{ $tuga->mata_pelajaran }}</span>
                        @endif
                        <span class="badge bg-secondary px-3 py-2"><i class="bi bi-people me-1"></i>Kelas {{ $tuga->kelas }}</span>
                        <span class="badge bg-danger px-3 py-2">
                            <i class="bi bi-clock me-1"></i>Deadline: {{ \App\Helpers\WaktuHelper::format($tuga->deadline) }}
                        </span>
                    </div>

                    <div class="bg-light p-3 rounded-3 text-dark border mb-3">
                        <small class="text-muted fw-bold d-block mb-1"><i class="bi bi-info-circle-fill text-primary me-1"></i>Deskripsi / Petunjuk Soal:</small>
                        <p class="mb-0 fs-6" style="line-height: 1.6;">{{ $tuga->deskripsi }}</p>
                    </div>

                    @if($tuga->foto)
                        <div class="pt-2">
                            <small class="text-muted fw-bold d-block mb-2"><i class="bi bi-image me-1"></i>Lampiran Foto Soal dari Guru/Admin:</small>
                            <a href="{{ asset('storage/'.$tuga->foto) }}" target="_blank">
                                <img src="{{ asset('storage/'.$tuga->foto) }}" alt="Lampiran Soal" class="img-thumbnail rounded shadow-sm" style="max-height: 180px;">
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Student Submission Work (Jawaban & Berkas Siswa) -->
            <div class="card border-0 shadow-sm mb-4 rounded-3 border-start border-5 border-success">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-clipboard-check-fill text-success me-2"></i>Hasil Pekerjaan / Jawaban Siswa</h5>
                    <span class="badge bg-success px-3 py-2"><i class="bi bi-check-circle-fill me-1"></i>Dikumpulkan</span>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3 pb-3 border-bottom d-flex justify-content-between align-items-center">
                        <small class="text-muted fw-bold"><i class="bi bi-calendar3 me-1"></i>Waktu Pengumpulan:</small>
                        <span class="fw-bold text-dark">
                            {{ \App\Helpers\WaktuHelper::format($submission->dikumpulkan_pada) }}
                        </span>
                    </div>

                    <!-- Student Answer Note -->
                    <div class="mb-4">
                        <small class="text-muted d-block fw-bold mb-2"><i class="bi bi-chat-left-text-fill text-primary me-1"></i>Catatan Jawaban Siswa:</small>
                        @if($submission->catatan)
                            <div class="p-3 bg-light rounded-3 border text-dark fs-6" style="line-height: 1.6;">
                                {{ $submission->catatan }}
                            </div>
                        @else
                            <div class="p-3 bg-light rounded-3 text-muted fst-italic border">
                                Siswa tidak menuliskan catatan tambahan.
                            </div>
                        @endif
                    </div>

                    <!-- Student Submitted File / Image Preview -->
                    <div>
                        <small class="text-muted d-block fw-bold mb-2"><i class="bi bi-paperclip text-primary me-1"></i>Berkas Jawaban Dikirim Siswa:</small>
                        @if($submission->file_path)
                            @php
                                $ext = strtolower(pathinfo($submission->file_path, PATHINFO_EXTENSION));
                                $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            @endphp

                            @if($isImage)
                                <div class="mb-3 text-center bg-dark p-3 rounded-3">
                                    <a href="{{ asset('storage/'.$submission->file_path) }}" target="_blank">
                                        <img src="{{ asset('storage/'.$submission->file_path) }}" alt="Jawaban Siswa" class="img-fluid rounded shadow" style="max-height: 450px; object-fit: contain;">
                                    </a>
                                    <small class="text-white-50 d-block mt-2"><i class="bi bi-zoom-in me-1"></i>Klik gambar untuk melihat dalam ukuran penuh</small>
                                </div>
                            @endif

                            <div class="d-flex align-items-center justify-content-between p-3 bg-primary bg-opacity-10 rounded-3 border border-primary border-opacity-25">
                                <div>
                                    <i class="bi bi-file-earmark-arrow-down-fill fs-3 text-primary me-2"></i>
                                    <span class="fw-bold text-dark">{{ basename($submission->file_path) }}</span>
                                </div>
                                <a href="{{ asset('storage/'.$submission->file_path) }}" class="btn btn-primary btn-sm px-3 fw-bold" target="_blank">
                                    <i class="bi bi-download me-1"></i> Unduh / Buka Berkas
                                </a>
                            </div>
                        @else
                            <div class="p-3 bg-light rounded-3 text-muted fst-italic border">
                                Siswa tidak melampirkan berkas file.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN: Grading Form & Teacher Feedback/Suggestions -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-lg rounded-3 position-sticky" style="top: 85px;">
                <div class="card-header bg-success bg-gradient text-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-star-fill text-warning me-2"></i>Form Penilaian & Saran Guru</h5>
                    @if($submission->nilai !== null)
                        <span class="badge bg-white text-success fw-bold px-3 py-1"><i class="bi bi-check-circle-fill me-1"></i>Sudah Dinilai</span>
                    @else
                        <span class="badge bg-warning text-dark fw-bold px-3 py-1"><i class="bi bi-clock-history me-1"></i>Belum Dinilai</span>
                    @endif
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('tugas.grade', $submission->id) }}" method="POST">
                        @csrf

                        <!-- Score Input -->
                        <div class="mb-4">
                            <label for="nilai" class="form-label fw-bold text-dark fs-5 mb-2">
                                <i class="bi bi-trophy-fill text-warning me-1"></i> Nilai Tugas (0 - 100) <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="nilai" id="nilai_input" class="form-control form-control-lg border-2 text-center fs-3 fw-bold text-success" min="0" max="100" placeholder="0 - 100" value="{{ old('nilai', $submission->nilai) }}" required>
                            
                            <!-- Quick Score Preset Buttons -->
                            <div class="d-flex flex-wrap gap-1 mt-2 justify-content-center">
                                <button type="button" class="btn btn-outline-success btn-sm fw-bold px-2 py-1" onclick="document.getElementById('nilai_input').value=100">100</button>
                                <button type="button" class="btn btn-outline-success btn-sm fw-bold px-2 py-1" onclick="document.getElementById('nilai_input').value=95">95</button>
                                <button type="button" class="btn btn-outline-success btn-sm fw-bold px-2 py-1" onclick="document.getElementById('nilai_input').value=90">90</button>
                                <button type="button" class="btn btn-outline-primary btn-sm fw-bold px-2 py-1" onclick="document.getElementById('nilai_input').value=85">85</button>
                                <button type="button" class="btn btn-outline-primary btn-sm fw-bold px-2 py-1" onclick="document.getElementById('nilai_input').value=80">80</button>
                                <button type="button" class="btn btn-outline-primary btn-sm fw-bold px-2 py-1" onclick="document.getElementById('nilai_input').value=75">75</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm fw-bold px-2 py-1" onclick="document.getElementById('nilai_input').value=70">70</button>
                            </div>
                        </div>

                        <!-- Teacher Suggestions / Feedback Input -->
                        <div class="mb-4">
                            <label for="respon_guru" class="form-label fw-bold text-dark mb-2">
                                <i class="bi bi-chat-left-quote-fill text-primary me-1"></i> Saran, Respon & Catatan Guru
                            </label>
                            <textarea name="respon_guru" id="respon_guru" class="form-control border-2" rows="5" placeholder="Tuliskan saran, respon, atau masukan untuk perbaikan tugas siswa ini... (Contoh: Jawaban sangat rapi dan lengkap! Pertahankan prestasimu.)">{{ old('respon_guru', $submission->respon_guru) }}</textarea>
                            <small class="text-muted d-block mt-1">Saran dan nilai ini akan langsung dikirim dan ditampilkan pada portal akun siswa.</small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg fw-bold shadow">
                                <i class="bi bi-check-circle-fill me-1"></i> Simpan Nilai & Saran Guru
                            </button>
                            <a href="{{ route('tugas.submissions', $tuga->id) }}" class="btn btn-light fw-bold text-secondary">
                                Batal / Kembali
                            </a>
                        </div>
                    </form>

                    @if($submission->nilai !== null)
                        <div class="mt-4 pt-3 border-top text-center">
                            <small class="text-muted d-block mb-1">Status Penilaian Saat Ini:</small>
                            <div class="p-3 bg-success bg-opacity-10 border border-success rounded-3">
                                <div class="fs-4 fw-bold text-success mb-1">⭐ {{ $submission->nilai }} / 100</div>
                                <small class="text-dark d-block fst-italic">"{{ $submission->respon_guru ?? 'Belum ada saran khusus' }}"</small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
