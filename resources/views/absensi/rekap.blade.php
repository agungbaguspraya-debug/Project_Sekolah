@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 1200px; margin: 0 auto;">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-file-earmark-bar-graph-fill text-success me-2"></i>Rekap Absensi Siswa
            </h2>
            <p class="text-muted mb-0">
                Rangkuman total kehadiran (Hadir, Izin, Sakit, Alpa) dan catatan alasan siswa per kelas.
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('absensi.index', ['kelas' => $selectedKelas]) }}" class="btn btn-outline-secondary fw-bold shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Input Absensi
            </a>
            @if($selectedKelas)
                <a href="{{ route('absensi.pdf', ['kelas' => $selectedKelas, 'bulan' => $bulan]) }}" class="btn btn-danger fw-bold shadow-sm" target="_blank">
                    <i class="bi bi-file-pdf-fill me-1"></i> Unduh / Cetak PDF Laporan
                </a>
            @endif
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card border-0 shadow-sm mb-4 rounded-3">
        <div class="card-body p-3">
            <form action="{{ route('absensi.rekap') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-6">
                    <label for="kelas_select" class="form-label fw-bold small text-muted mb-1"><i class="bi bi-building me-1 text-primary"></i>Pilih Kelas Siswa</label>
                    <select name="kelas" id="kelas_select" class="form-select fw-bold" onchange="this.form.submit()">
                        @if(count($kelasX) > 0)
                            <optgroup label="🏫 Tingkat X (Kelas 10)">
                                @foreach($kelasX as $k)
                                    <option value="{{ $k->nama_kelas }}" {{ $selectedKelas == $k->nama_kelas ? 'selected' : '' }}>
                                        Kelas: {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if(count($kelasXI) > 0)
                            <optgroup label="🏫 Tingkat XI (Kelas 11)">
                                @foreach($kelasXI as $k)
                                    <option value="{{ $k->nama_kelas }}" {{ $selectedKelas == $k->nama_kelas ? 'selected' : '' }}>
                                        Kelas: {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if(count($kelasXII) > 0)
                            <optgroup label="🏫 Tingkat XII (Kelas 12)">
                                @foreach($kelasXII as $k)
                                    <option value="{{ $k->nama_kelas }}" {{ $selectedKelas == $k->nama_kelas ? 'selected' : '' }}>
                                        Kelas: {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if(count($kelasOther) > 0)
                            <optgroup label="🏫 Kelas Lainnya">
                                @foreach($kelasOther as $k)
                                    <option value="{{ $k->nama_kelas }}" {{ $selectedKelas == $k->nama_kelas ? 'selected' : '' }}>
                                        Kelas: {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="bulan_select" class="form-label fw-bold small text-muted mb-1"><i class="bi bi-calendar-month me-1 text-warning"></i>Filter Bulan Absensi</label>
                    <input type="month" name="bulan" id="bulan_select" class="form-control fw-bold" value="{{ $bulan }}" onchange="this.form.submit()">
                </div>
            </form>
        </div>
    </div>

    <!-- Attendance Summary Table -->
    @if(count($siswas) > 0)
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
            <div class="card-header bg-dark text-white py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-journal-check text-warning me-2"></i>Rekap Absensi Kelas {{ $selectedKelas }} - {{ \Carbon\Carbon::parse($bulan.'-01')->translatedFormat('F Y') }}
                </h5>
                <span class="badge bg-warning text-dark fw-bold px-3 py-1 fs-6">
                    Total {{ count($siswas) }} Siswa
                </span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 50px;">No</th>
                                <th>Nama Siswa & NIS</th>
                                <th class="text-center" style="width: 90px;">Hadir</th>
                                <th class="text-center" style="width: 90px;">Izin</th>
                                <th class="text-center" style="width: 90px;">Sakit</th>
                                <th class="text-center" style="width: 90px;">Alpa</th>
                                <th class="pe-4">Rincian Alasan Izin / Sakit / Alpa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswas as $idx => $s)
                                @php
                                    $hadirCount = $s->absensi->where('status', 'Hadir')->count();
                                    $izinCount = $s->absensi->where('status', 'Izin')->count();
                                    $sakitCount = $s->absensi->where('status', 'Sakit')->count();
                                    $alpaCount = $s->absensi->where('status', 'Alpa')->count();
                                    $nonHadirList = $s->absensi->whereIn('status', ['Izin', 'Sakit', 'Alpa']);
                                @endphp
                                <tr>
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
                                    <td class="text-center">
                                        <span class="badge bg-success fs-6 px-2.5 py-1">{{ $hadirCount }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-warning text-dark fs-6 px-2.5 py-1">{{ $izinCount }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info text-dark fs-6 px-2.5 py-1">{{ $sakitCount }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-danger fs-6 px-2.5 py-1">{{ $alpaCount }}</span>
                                    </td>
                                    <td class="pe-4">
                                        @if($nonHadirList->count() > 0)
                                            <div class="d-flex flex-column gap-1">
                                                @foreach($nonHadirList as $ab)
                                                    <div class="small">
                                                        <span class="badge {{ $ab->status === 'Alpa' ? 'bg-danger' : ($ab->status === 'Sakit' ? 'bg-info text-dark' : 'bg-warning text-dark') }}">
                                                            {{ $ab->status }}
                                                        </span>
                                                        <span class="fw-semibold text-dark me-1">
                                                            {{ date('d/m/Y', strtotime($ab->tanggal)) }}:
                                                        </span>
                                                        <span class="text-secondary fst-italic">
                                                            "{{ $ab->alasan ?? 'Tanpa Keterangan' }}"
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-success small fw-semibold"><i class="bi bi-check-all me-1"></i>Kehadiran 100% Sempurna</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body py-5 text-center text-muted">
                <i class="bi bi-clipboard-x fs-1 text-secondary opacity-50 d-block mb-2"></i>
                <h5 class="fw-bold text-dark mb-1">Tidak Ada Data Absensi</h5>
                <p class="small text-secondary mb-0">Belum ada catatan absensi untuk kelas dan bulan yang dipilih.</p>
            </div>
        </div>
    @endif
</div>
@endsection
