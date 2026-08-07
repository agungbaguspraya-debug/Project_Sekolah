@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 1200px; margin: 0 auto;">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-clipboard-check-fill text-primary me-2"></i>Input Absensi Siswa
            </h2>
            <p class="text-muted mb-0">
                Pencatatan kehadiran siswa per kelas (Hadir, Izin, Sakit, Alpa) dan keterangan alasan secara langsung. 
                @if(Auth::user()->isGuru())
                    <span class="text-primary fw-semibold"><i class="bi bi-info-circle me-1"></i>(Menampilkan khusus kelas yang Anda ajar)</span>
                @endif
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('absensi.rekap', ['kelas' => $selectedKelas]) }}" class="btn btn-outline-primary fw-bold shadow-sm">
                <i class="bi bi-file-earmark-bar-graph me-1"></i> Rekap & Cetak PDF
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Class & Date Selector Card -->
    <div class="card border-0 shadow-sm mb-4 rounded-3">
        <div class="card-body p-3">
            <form action="{{ route('absensi.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-5">
                    <label for="kelas_select" class="form-label fw-bold small text-muted mb-1"><i class="bi bi-building me-1 text-primary"></i>Pilih Kelas Siswa</label>
                    <select name="kelas" id="kelas_select" class="form-select fw-bold" onchange="this.form.submit()">
                        @if(count($kelas) == 0)
                            <option value="">-- Anda Belum Memiliki Jadwal Kelas --</option>
                        @endif
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
                <div class="col-md-4">
                    <label for="tanggal_select" class="form-label fw-bold small text-muted mb-1"><i class="bi bi-calendar-event me-1 text-warning"></i>Tanggal Absensi Hari Ini</label>
                    <input type="date" name="tanggal" id="tanggal_select" class="form-control fw-bold" value="{{ $tanggal }}" onchange="this.form.submit()">
                </div>
                <div class="col-md-3 text-md-end pt-md-4">
                    <button type="button" class="btn btn-outline-success fw-bold w-100 py-2" onclick="setSemuaHadir()">
                        <i class="bi bi-check-all me-1 fs-5"></i> Set Semua HADIR
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Attendance Entry Table -->
    @if(count($siswas) > 0)
        <form action="{{ route('absensi.store') }}" method="POST">
            @csrf
            <input type="hidden" name="kelas" value="{{ $selectedKelas }}">
            <input type="hidden" name="tanggal" value="{{ $tanggal }}">

            <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
                <div class="card-header bg-dark text-white py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="mb-1 fw-bold text-white">
                            <i class="bi bi-people-fill text-warning me-2"></i>Daftar Siswa Kelas {{ $selectedKelas }}
                        </h5>
                        <small class="text-white-50">
                            Tanggal: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                        </small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        @if($existingAbsensi->count() == 0)
                            <span class="badge bg-success px-3 py-2 fs-6 shadow-sm">
                                <i class="bi bi-stars me-1"></i>Presensi Baru Hari Ini (Mengulang dari 0)
                            </span>
                        @else
                            <span class="badge bg-info text-dark px-3 py-2 fs-6 shadow-sm">
                                <i class="bi bi-check-circle-fill me-1"></i>Telah Diisi Hari Ini ({{ $existingAbsensi->count() }} Siswa)
                            </span>
                        @endif
                        <span class="badge bg-warning text-dark fw-bold px-3 py-2 fs-6 shadow-sm">
                            Total {{ count($siswas) }} Siswa
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4" style="width: 50px;">No</th>
                                    <th style="width: 250px;">Nama Siswa & NIS</th>
                                    <th class="text-center" style="width: 380px;">Status Kehadiran Hari Ini</th>
                                    <th class="pe-4">Alasan / Keterangan Izin/Sakit/Alpa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($siswas as $idx => $s)
                                    @php
                                        $ex = $existingAbsensi->get($s->id);
                                        $currentStatus = $ex ? $ex->status : 'Hadir';
                                        $currentAlasan = $ex ? $ex->alasan : '';
                                    @endphp
                                    <tr>
                                        <td class="ps-4 fw-bold text-secondary">{{ $idx + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if($s->foto)
                                                    <img src="{{ asset('storage/'.$s->foto) }}" alt="{{ $s->nama }}" class="rounded-circle object-fit-cover border" style="width: 40px; height: 40px;">
                                                @else
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                                        <i class="bi bi-person-fill fs-5"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold text-dark mb-0">{{ $s->nama }}</div>
                                                    <small class="text-muted">NIS: {{ $s->nis }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group w-100" role="group" aria-label="Status Absensi {{ $s->id }}">
                                                <!-- Hadir -->
                                                <input type="radio" class="btn-check radio-status-hadir" name="absensi[{{ $s->id }}][status]" id="hadir_{{ $s->id }}" value="Hadir" {{ $currentStatus === 'Hadir' ? 'checked' : '' }} autocomplete="off">
                                                <label class="btn btn-outline-success fw-bold py-2" for="hadir_{{ $s->id }}">
                                                    <i class="bi bi-check-circle me-1"></i> Hadir
                                                </label>

                                                <!-- Izin -->
                                                <input type="radio" class="btn-check" name="absensi[{{ $s->id }}][status]" id="izin_{{ $s->id }}" value="Izin" {{ $currentStatus === 'Izin' ? 'checked' : '' }} autocomplete="off">
                                                <label class="btn btn-outline-warning fw-bold text-dark py-2" for="izin_{{ $s->id }}">
                                                    <i class="bi bi-envelope me-1"></i> Izin
                                                </label>

                                                <!-- Sakit -->
                                                <input type="radio" class="btn-check" name="absensi[{{ $s->id }}][status]" id="sakit_{{ $s->id }}" value="Sakit" {{ $currentStatus === 'Sakit' ? 'checked' : '' }} autocomplete="off">
                                                <label class="btn btn-outline-info fw-bold text-dark py-2" for="sakit_{{ $s->id }}">
                                                    <i class="bi bi-hospital me-1"></i> Sakit
                                                </label>

                                                <!-- Alpa -->
                                                <input type="radio" class="btn-check" name="absensi[{{ $s->id }}][status]" id="alpa_{{ $s->id }}" value="Alpa" {{ $currentStatus === 'Alpa' ? 'checked' : '' }} autocomplete="off">
                                                <label class="btn btn-outline-danger fw-bold py-2" for="alpa_{{ $s->id }}">
                                                    <i class="bi bi-x-circle me-1"></i> Alpa
                                                </label>
                                            </div>
                                        </td>
                                        <td class="pe-4">
                                            <input type="text" name="absensi[{{ $s->id }}][alasan]" class="form-control form-control-sm input-alasan" value="{{ $currentAlasan }}" placeholder="Tulis alasan jika Izin / Sakit / Alpa...">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light p-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Tekan tombol simpan untuk memperbarui kehadiran siswa kelas ini.</small>
                    <button type="submit" class="btn btn-primary fw-bold px-4 py-2">
                        <i class="bi bi-save-fill me-1"></i> Simpan Presensi Absensi
                    </button>
                </div>
            </div>
        </form>
    @else
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body py-5 text-center text-muted">
                <i class="bi bi-people fs-1 text-secondary opacity-50 d-block mb-2"></i>
                <h5 class="fw-bold text-dark mb-1">Belum Ada Siswa di Kelas Ini</h5>
                <p class="small text-secondary mb-0">Silakan pilih kelas lain atau tambahkan data siswa terlebih dahulu.</p>
            </div>
        </div>
    @endif
</div>

<script>
    function setSemuaHadir() {
        const hadirRadios = document.querySelectorAll('.radio-status-hadir');
        hadirRadios.forEach(radio => {
            radio.checked = true;
        });
    }
</script>
@endsection
