@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 1250px; margin: 0 auto;">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-shield-check text-primary me-2"></i>Monitoring Presensi & Total Kehadiran Siswa
            </h2>
            <p class="text-muted mb-0">
                Pantau statistik kehadiran harian seluruh siswa sekolah (Hadir, Izin, Sakit, Alpa, dan Alasan).
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('absensi.index') }}" class="btn btn-outline-primary fw-bold shadow-sm">
                <i class="bi bi-pencil-square me-1"></i> Input Absensi
            </a>
            <a href="{{ route('absensi.harian.pdf', ['tanggal' => $tanggal, 'kelas' => $selectedKelas]) }}" class="btn btn-danger fw-bold shadow-sm" target="_blank">
                <i class="bi bi-file-pdf-fill me-1"></i> Cetak PDF Laporan Harian
            </a>
        </div>
    </div>

    <!-- Filter Control Card -->
    <div class="card border-0 shadow-sm mb-4 rounded-3">
        <div class="card-body p-3">
            <form action="{{ route('absensi.harian') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-3">
                    <label for="tanggal" class="form-label fw-bold small text-muted mb-1"><i class="bi bi-calendar-event me-1 text-warning"></i>Pilih Tanggal Presensi</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control fw-bold" value="{{ $tanggal }}" onchange="this.form.submit()">
                </div>
                <div class="col-md-3">
                    <label for="kelas" class="form-label fw-bold small text-muted mb-1"><i class="bi bi-building me-1 text-primary"></i>Filter Kelas</label>
                    <select name="kelas" id="kelas" class="form-select fw-bold" onchange="this.form.submit()">
                        <option value="">-- Semua Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->nama_kelas }}" {{ $selectedKelas == $k->nama_kelas ? 'selected' : '' }}>Kelas {{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label fw-bold small text-muted mb-1"><i class="bi bi-funnel me-1 text-info"></i>Filter Status Kehadiran</label>
                    <select name="status" id="status" class="form-select fw-bold" onchange="this.form.submit()">
                        <option value="">-- Semua Status --</option>
                        <option value="Hadir" {{ $statusFilter == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="Izin" {{ $statusFilter == 'Izin' ? 'selected' : '' }}>Izin</option>
                        <option value="Sakit" {{ $statusFilter == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="Alpa" {{ $statusFilter == 'Alpa' ? 'selected' : '' }}>Alpa</option>
                        <option value="Non-Hadir" {{ $statusFilter == 'Non-Hadir' ? 'selected' : '' }}>Khusus Non-Hadir (Izin/Sakit/Alpa)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="q" class="form-label fw-bold small text-muted mb-1"><i class="bi bi-search me-1 text-secondary"></i>Cari Nama / NIS</label>
                    <div class="input-group">
                        <input type="text" name="q" id="q" class="form-control" placeholder="Cari nama..." value="{{ $search }}">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Daily Statistics Overview Cards -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-6 g-3 mb-4">
        <!-- Total Active Students -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100 p-3 border-start border-4 border-dark bg-white">
                <small class="text-muted fw-bold text-uppercase d-block mb-1" style="font-size: 0.72rem;">Total Siswa</small>
                <h3 class="fw-bold text-dark mb-0">{{ $totalSiswa }}</h3>
                <small class="text-secondary" style="font-size: 0.72rem;">Siswa Aktif</small>
            </div>
        </div>

        <!-- Hadir -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100 p-3 border-start border-4 border-success bg-white">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-success fw-bold text-uppercase" style="font-size: 0.72rem;">Hadir</small>
                    <span class="badge bg-success" style="font-size: 0.7rem;">
                        {{ $totalSiswa > 0 ? round(($totalHadir / $totalSiswa) * 100) : 0 }}%
                    </span>
                </div>
                <h3 class="fw-bold text-success mb-0">{{ $totalHadir }}</h3>
                <small class="text-muted" style="font-size: 0.72rem;">Siswa Hadir</small>
            </div>
        </div>

        <!-- Izin -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100 p-3 border-start border-4 border-warning bg-white">
                <small class="text-warning fw-bold text-uppercase d-block mb-1" style="font-size: 0.72rem;">Izin</small>
                <h3 class="fw-bold text-dark mb-0">{{ $totalIzin }}</h3>
                <small class="text-muted" style="font-size: 0.72rem;">Dengan Alasan</small>
            </div>
        </div>

        <!-- Sakit -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100 p-3 border-start border-4 border-info bg-white">
                <small class="text-info fw-bold text-uppercase d-block mb-1" style="font-size: 0.72rem;">Sakit</small>
                <h3 class="fw-bold text-dark mb-0">{{ $totalSakit }}</h3>
                <small class="text-muted" style="font-size: 0.72rem;">Surat / Keterangan</small>
            </div>
        </div>

        <!-- Alpa -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100 p-3 border-start border-4 border-danger bg-white">
                <small class="text-danger fw-bold text-uppercase d-block mb-1" style="font-size: 0.72rem;">Alpa</small>
                <h3 class="fw-bold text-danger mb-0">{{ $totalAlpa }}</h3>
                <small class="text-muted" style="font-size: 0.72rem;">Tanpa Keterangan</small>
            </div>
        </div>

        <!-- Belum Diabsen -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100 p-3 border-start border-4 border-secondary bg-white">
                <small class="text-secondary fw-bold text-uppercase d-block mb-1" style="font-size: 0.72rem;">Belum Diabsen</small>
                <h3 class="fw-bold text-secondary mb-0">{{ $totalBelum }}</h3>
                <small class="text-muted" style="font-size: 0.72rem;">Belum Diisi Guru</small>
            </div>
        </div>
    </div>

    <!-- Per Class Attendance Summary Progress -->
    @if(count($summaryPerKelas) > 0 && !$selectedKelas)
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-pie-chart-fill text-primary me-2"></i>Ringkasan Kehadiran Per Kelas Hari Ini</h5>
            </div>
            <div class="card-body p-3 bg-light bg-opacity-50">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
                    @foreach($summaryPerKelas as $className => $cData)
                        @php
                            $hadirPct = $cData['total'] > 0 ? round(($cData['hadir'] / $cData['total']) * 100) : 0;
                        @endphp
                        <div class="col">
                            <div class="bg-white p-3 rounded-3 border shadow-sm h-100">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold text-dark"><i class="bi bi-building me-1 text-primary"></i>{{ $className }}</span>
                                    <span class="badge bg-primary fs-6">{{ $hadirPct }}% Hadir</span>
                                </div>
                                <div class="progress mb-2" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: {{ $hadirPct }}%"></div>
                                </div>
                                <div class="d-flex justify-content-between text-muted small" style="font-size: 0.75rem;">
                                    <span>Hadir: <strong class="text-success">{{ $cData['hadir'] }}</strong></span>
                                    <span>Izin: <strong class="text-warning">{{ $cData['izin'] }}</strong></span>
                                    <span>Sakit: <strong class="text-info">{{ $cData['sakit'] }}</strong></span>
                                    <span>Alpa: <strong class="text-danger">{{ $cData['alpa'] }}</strong></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Full Student Daily Attendance Table -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
        <div class="card-header bg-dark text-white py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-list-check text-warning me-2"></i>Daftar Presensi Siswa Tanggal {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
            </h5>
            <span class="badge bg-warning text-dark font-monospace px-3 py-1 fs-6">
                Menampilkan {{ count($siswas) }} Siswa
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 50px;">No</th>
                            <th>Nama Siswa & NIS</th>
                            <th style="width: 140px;">Kelas</th>
                            <th class="text-center" style="width: 150px;">Status Kehadiran</th>
                            <th>Alasan / Keterangan Izin/Sakit/Alpa</th>
                            <th class="pe-4 text-end" style="width: 160px;">Diabsen Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $idx => $s)
                            @php
                                $rec = $absensiRecords->get($s->id);
                                $status = $rec ? $rec->status : 'Belum Diabsen';
                                $alasan = $rec ? $rec->alasan : null;
                                $guruNama = $rec && $rec->guru ? $rec->guru->nama : ($rec ? 'Admin/Guru' : '-');
                            @endphp
                            <tr class="{{ $status === 'Alpa' ? 'table-danger' : ($status === 'Izin' || $status === 'Sakit' ? 'table-warning' : '') }}">
                                <td class="ps-4 fw-bold text-secondary">{{ $idx + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($s->foto)
                                            <img src="{{ asset('storage/'.$s->foto) }}" alt="{{ $s->nama }}" class="rounded-circle object-fit-cover border" style="width: 38px; height: 38px;">
                                        @else
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold text-dark mb-0">{{ $s->nama }}</div>
                                            <small class="text-muted">NIS: {{ $s->nis }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary px-2.5 py-1.5"><i class="bi bi-building me-1"></i>{{ $s->kelas }}</span>
                                </td>
                                <td class="text-center">
                                    @if($status === 'Hadir')
                                        <span class="badge bg-success px-3 py-1.5 fs-6"><i class="bi bi-check-circle-fill me-1"></i>Hadir</span>
                                    @elseif($status === 'Izin')
                                        <span class="badge bg-warning text-dark px-3 py-1.5 fs-6"><i class="bi bi-envelope-fill me-1"></i>Izin</span>
                                    @elseif($status === 'Sakit')
                                        <span class="badge bg-info text-dark px-3 py-1.5 fs-6"><i class="bi bi-hospital-fill me-1"></i>Sakit</span>
                                    @elseif($status === 'Alpa')
                                        <span class="badge bg-danger px-3 py-1.5 fs-6"><i class="bi bi-x-circle-fill me-1"></i>Alpa</span>
                                    @else
                                        <span class="badge bg-light text-muted border px-3 py-1.5 fs-6"><i class="bi bi-question-circle me-1"></i>Belum Diabsen</span>
                                    @endif
                                </td>
                                <td>
                                    @if($alasan)
                                        <span class="fw-semibold text-dark fst-italic">"{{ $alasan }}"</span>
                                    @elseif($status === 'Hadir')
                                        <span class="text-success small fw-semibold"><i class="bi bi-check me-1"></i>Tepat Waktu</span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end text-muted small">
                                    <i class="bi bi-person-badge me-1"></i>{{ $guruNama }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-search fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                    Tidak ada data siswa yang cocok dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
