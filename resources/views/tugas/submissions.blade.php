@extends('layouts.app')

@section('content')
<div class="row" style="max-width: 1100px; margin: 0 auto;">
    <div class="col-md-12 mb-4 d-flex align-items-center">
        <a href="{{ route('tugas.index') }}" class="btn btn-outline-secondary btn-sm me-3">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Tugas
        </a>
        <h2 class="fw-bold mb-0"><i class="bi bi-clipboard2-check-fill text-warning me-2"></i>Status & Penilaian Pengumpulan Tugas</h2>
    </div>

    @if(session('success'))
        <div class="col-md-12 mb-3">
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="col-md-12 mb-3">
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>Gagal Menyimpan Nilai:
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- Assignment Summary Card -->
    <div class="col-md-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-dark text-white py-3">
                <h5 class="mb-0 fw-bold">Detail Tugas</h5>
            </div>
            <div class="card-body p-4">
                <h4 class="fw-bold text-dark mb-1">{{ $tuga->judul }}</h4>
                <p class="text-secondary mb-3">
                    @if($tuga->mata_pelajaran)
                        Mata Pelajaran: <span class="badge bg-primary me-2">{{ $tuga->mata_pelajaran }}</span>
                    @endif
                    Kelas Sasaran: <span class="badge bg-secondary me-2">{{ $tuga->kelas }}</span> | 
                    Deadline: <span class="fw-bold text-danger"><i class="bi bi-clock me-1"></i>{{ \App\Helpers\WaktuHelper::format($tuga->deadline) }}</span>
                </p>
                <div class="bg-light p-3 rounded text-dark">
                    <h6 class="fw-bold"><i class="bi bi-info-circle-fill text-primary me-1"></i>Petunjuk Tugas:</h6>
                    <p class="mb-2 fs-6">{{ $tuga->deskripsi }}</p>
                    @if($tuga->foto)
                        <div class="mt-3 pt-2 border-top">
                            <small class="text-muted fw-bold d-block mb-2"><i class="bi bi-image me-1"></i>Lampiran Foto dari Guru/Admin:</small>
                            <a href="{{ asset('storage/'.$tuga->foto) }}" target="_blank">
                                <img src="{{ asset('storage/'.$tuga->foto) }}" alt="Foto Lampiran Tugas" class="img-thumbnail" style="max-height: 200px;">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Submissions Status & Grading List -->
    <div class="col-md-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-people-fill text-primary me-2"></i>Daftar Pengumpulkan & Penilaian Siswa</h5>
                <span class="badge bg-info text-dark fs-6">{{ $submissions->count() }} / {{ $students->count() }} Mengumpulkan</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Siswa</th>
                                <th>Status</th>
                                <th>Tanggal Dikumpulkan</th>
                                <th>Jawaban / Berkas Siswa</th>
                                <th>Nilai & Respon Guru</th>
                                <th class="pe-4 text-end" style="width: 140px;">Aksi Guru</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                @php
                                    $sub = $submissions->get($student->id);
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            @if($student->foto)
                                                <img src="{{ asset('storage/'.$student->foto) }}" width="40" height="40" class="rounded-circle object-fit-cover border me-3">
                                            @else
                                                <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="bi bi-person-fill"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark">{{ $student->nama }}</div>
                                                <small class="text-muted">NIS: {{ $student->nis }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($sub)
                                            <span class="badge bg-success fs-6"><i class="bi bi-check-circle-fill me-1"></i>Sudah Mengumpulkan</span>
                                        @else
                                            <span class="badge bg-danger fs-6"><i class="bi bi-x-circle-fill me-1"></i>Belum Mengumpulkan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($sub)
                                            <small class="fw-bold text-dark d-block"><i class="bi bi-clock me-1 text-primary"></i>{{ \App\Helpers\WaktuHelper::format($sub->dikumpulkan_pada) }}</small>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($sub)
                                            @if($sub->catatan)
                                                <small class="d-block text-secondary mb-1 text-truncate" style="max-width: 200px;" title="{{ $sub->catatan }}"><i class="bi bi-chat-text me-1"></i>{{ $sub->catatan }}</small>
                                            @endif
                                            @if($sub->file_path)
                                                <a href="{{ asset('storage/'.$sub->file_path) }}" class="btn btn-outline-primary btn-sm px-2 py-0" target="_blank">
                                                    <i class="bi bi-download me-1"></i> Unduh Berkas
                                                </a>
                                            @elseif(!$sub->catatan)
                                                <span class="text-muted small">Tanpa berkas</span>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($sub)
                                            @if($sub->nilai !== null)
                                                <span class="badge bg-success fs-6 mb-1 d-inline-block">
                                                    ⭐ Nilai: {{ $sub->nilai }} / 100
                                                </span>
                                            @else
                                                <span class="badge bg-warning text-dark mb-1 d-inline-block">
                                                    <i class="bi bi-clock-history me-1"></i>Belum Dinilai
                                                </span>
                                            @endif
                                            @if($sub->respon_guru)
                                                <small class="text-dark d-block text-truncate" style="max-width: 220px;" title="{{ $sub->respon_guru }}">
                                                    <i class="bi bi-chat-left-text-fill text-primary me-1"></i>{{ $sub->respon_guru }}
                                                </small>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="pe-4 text-end">
                                        @if($sub)
                                            <a href="{{ route('tugas.review', $sub->id) }}" class="btn btn-primary btn-sm fw-bold shadow-sm" title="Periksa Hasil Pekerjaan Siswa & Beri Nilai/Saran">
                                                <i class="bi bi-journal-check me-1"></i> Periksa & Beri Nilai
                                            </a>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                </tr>

                                @if($sub)
                                    <tr class="collapse bg-light" id="gradeForm_{{ $sub->id }}">
                                        <td colspan="6" class="p-3 border-bottom">
                                            <form action="{{ route('tugas.grade', $sub->id) }}" method="POST" class="row g-2 align-items-center">
                                                @csrf
                                                <div class="col-md-3">
                                                    <label class="form-label fw-bold small mb-1">Nilai Siswa (0 - 100)</label>
                                                    <input type="number" name="nilai" class="form-control form-control-sm" min="0" max="100" placeholder="Contoh: 90" value="{{ old('nilai', $sub->nilai) }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold small mb-1">Respon / Catatan Guru</label>
                                                    <input type="text" name="respon_guru" class="form-control form-control-sm" placeholder="Contoh: Jawaban sangat bagus dan rapi!" value="{{ old('respon_guru', $sub->respon_guru) }}">
                                                </div>
                                                <div class="col-md-3 d-flex align-items-end pt-3">
                                                    <button type="submit" class="btn btn-success btn-sm fw-bold w-100"><i class="bi bi-check-circle-fill me-1"></i> Simpan Nilai & Respon</button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        Tidak ada siswa terdaftar di kelas ini.
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
@endsection
