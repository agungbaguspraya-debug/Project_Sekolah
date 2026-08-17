@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 1200px; margin: 0 auto;">
    <!-- Success or Error Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Hero Header Banner -->
    <div class="card border-0 shadow-sm bg-warning bg-opacity-10 mb-4 rounded-3 border-start border-5 border-warning">
        <div class="card-body p-4 p-lg-5 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <span class="badge bg-warning text-dark fw-bold px-3 py-1 mb-2">JADWAL PELAJARAN SAYA</span>
                <h2 class="fw-bold text-dark mb-1">
                    <i class="bi bi-calendar3 me-2 text-warning"></i>Jadwal Pelajaran Kelas {{ $siswa->kelas }}
                </h2>
                <p class="mb-0 text-secondary">
                    Daftar alokasi mata pelajaran, jam mengajar, dan guru pengampu mingguan Anda (diurutkan dari jam paling pagi).
                </p>
            </div>
            <div class="text-end bg-white p-3 rounded-3 shadow-sm border">
                <small class="text-muted d-block mb-1"><i class="bi bi-person-circle me-1 text-primary"></i> Siswa</small>
                <h5 class="fw-bold text-dark mb-0">{{ $siswa->nama }}</h5>
                <small class="text-secondary">NIS: {{ $siswa->nis }}</small>
            </div>
        </div>
    </div>

    <!-- Schedule Grid: 5 Days (Senin - Jumat) -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3">
        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-header bg-dark text-white py-3 fw-bold text-center fs-6 border-0">
                        <i class="bi bi-calendar-day me-1 text-warning"></i> {{ $day }}
                    </div>
                    <div class="card-body p-3 bg-light bg-opacity-50">
                        @if(isset($jadwals[$day]) && count($jadwals[$day]) > 0)
                            <div class="d-flex flex-column gap-3">
                                @foreach($jadwals[$day]->sortBy('jam_mulai') as $item)
                                    @php
                                        $teacherIzin = ($item->guru && isset($activeIzinGurus[$item->guru->id])) ? $activeIzinGurus[$item->guru->id] : null;
                                    @endphp
                                    <div class="p-3 border rounded-3 bg-white border-start border-4 {{ $teacherIzin ? 'border-warning' : 'border-primary' }} shadow-sm">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="badge bg-primary fs-6">{{ $item->mata_pelajaran }}</span>
                                            @if($teacherIzin)
                                                <span class="badge bg-warning text-dark small fw-bold"><i class="bi bi-person-exclamation me-1"></i>Guru {{ $teacherIzin->jenis }}</span>
                                            @endif
                                        </div>
                                        @if($item->guru)
                                            <div class="small text-dark fw-bold mt-2">
                                                <i class="bi bi-person-fill text-primary me-1"></i>{{ $item->guru->nama }}
                                            </div>
                                            @if($teacherIzin)
                                                @if($teacherIzin->guruPengganti)
                                                    <div class="small text-success fw-bold mt-1.5 p-1.5 rounded bg-success bg-opacity-10 border border-success border-opacity-25">
                                                        <i class="bi bi-person-check-fill me-1"></i>Guru Pengganti: {{ $teacherIzin->guruPengganti->nama }}
                                                    </div>
                                                @endif
                                                @if($teacherIzin->tugas)
                                                    <a href="{{ route('siswa.tugas') }}" class="btn btn-sm btn-primary w-100 mt-2 fw-bold text-truncate">
                                                        <i class="bi bi-file-earmark-check me-1"></i>Kerjakan: {{ $teacherIzin->tugas->judul }}
                                                    </a>
                                                @elseif($teacherIzin->tugas_siswa)
                                                    <div class="small text-dark mt-1 fst-italic">
                                                        <i class="bi bi-journal-text text-primary me-1"></i>Tugas: "{{ Str::limit($teacherIzin->tugas_siswa, 40) }}"
                                                    </div>
                                                @endif
                                            @endif
                                        @else
                                            <div class="small text-muted mt-2">
                                                <i class="bi bi-person-dash me-1"></i>Guru belum diatur
                                            </div>
                                        @endif
                                        <div class="text-muted small mt-2 fw-semibold">
                                            <i class="bi bi-clock me-1 text-primary"></i>{{ \App\Helpers\WaktuHelper::format('2026-08-05 '.$item->jam_mulai, false) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5 text-muted small">
                                <i class="bi bi-calendar2-minus d-block fs-3 mb-2 text-secondary opacity-50"></i>
                                Tidak ada pelajaran
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
