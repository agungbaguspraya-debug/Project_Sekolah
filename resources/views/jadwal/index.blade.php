@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 1200px; margin: 0 auto;">

    <!-- Page Title Header -->
    <div class="col-md-12 mb-4">
        <h2 class="fw-bold text-dark mb-1">
            <i class="bi bi-calendar3 me-2 text-warning"></i>
            @if(Auth::user()->isGuru())
                Jadwal Mengajar Guru
            @elseif(Auth::user()->isSiswa())
                Jadwal Pelajaran Saya
            @else
                Kelola Jadwal Pelajaran Sekolah
            @endif
        </h2>
        <p class="text-muted mb-0">
            @if(Auth::user()->isGuru() && Auth::user()->guru)
                Jadwal mengajar mata pelajaran <strong>{{ Auth::user()->guru->mata_pelajaran }}</strong> untuk akun <strong>{{ Auth::user()->guru->nama }}</strong>.
            @elseif(Auth::user()->isSiswa() && Auth::user()->siswa)
                Jadwal kegiatan belajar mengajar mingguan untuk kelas <strong>{{ Auth::user()->siswa->kelas }}</strong> (diurutkan dari jam paling pagi).
            @else
                Daftar alokasi jadwal pelajaran dan penetapan guru pengajar sekolah per kelas dan per hari (jam paling pagi di bagian paling atas).
            @endif
        </p>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="col-md-12 mb-4">
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if(Auth::user()->isAdmin())
        <div class="row g-4">
            <!-- Add Schedule Form (Admin Only - Left Column) -->
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-dark text-white py-3 border-0">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-plus-circle-fill me-2 text-warning"></i>Tambah Jadwal Pelajaran</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('jadwal.store') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="kelas" class="form-label fw-bold small">Pilih Kelas</label>
                                <select name="kelas" id="kelas" class="form-select" required>
                                    <option value="">-- Pilih Kelas --</option>
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
                                <label for="guru_id" class="form-label fw-bold small">Guru Pengajar</label>
                                <select name="guru_id" id="guru_id" class="form-select">
                                    <option value="">-- Pilih Guru --</option>
                                    @foreach($gurus as $g)
                                        <option value="{{ $g->id }}">{{ $g->nama }} ({{ $g->mata_pelajaran }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="hari" class="form-label fw-bold small">Hari Pelajaran</label>
                                <select name="hari" id="hari" class="form-select" required>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="mata_pelajaran" class="form-label fw-bold small">Mata Pelajaran</label>
                                <input type="text" name="mata_pelajaran" id="mata_pelajaran" class="form-control" placeholder="Contoh: Matematika" required>
                            </div>

                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <label for="jam_mulai" class="form-label fw-bold small">Jam Mulai</label>
                                    <input type="time" name="jam_mulai" id="jam_mulai_j" class="form-control" value="07:30" required>
                                </div>
                                <div class="col-6">
                                    <label for="jam_selesai" class="form-label fw-bold small">Jam Selesai</label>
                                    <input type="time" name="jam_selesai" id="jam_selesai_j" class="form-control" value="12:00" required>
                                </div>
                            </div>

                            <!-- Quick Time Presets for Lessons -->
                            <div class="mb-3">
                                <small class="text-muted fw-bold me-1 d-block mb-1" style="font-size: 0.75rem;">Pintas Jam Sekolah:</small>
                                <div class="d-flex flex-wrap gap-1">
                                    <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-2" style="font-size: 0.75rem;" onclick="document.getElementById('jam_mulai_j').value='07:30'; document.getElementById('jam_selesai_j').value='12:00';">07:30 Pagi - 12:00 Pagi</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-2" style="font-size: 0.75rem;" onclick="document.getElementById('jam_mulai_j').value='13:15'; document.getElementById('jam_selesai_j').value='15:10';">13:15 Siang - 15:10 Siang</button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="sesi" class="form-label fw-bold small">Sesi Waktu</label>
                                <select name="sesi" id="sesi" class="form-select">
                                    <option value="Pagi">Pagi</option>
                                    <option value="Siang">Siang</option>
                                </select>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary py-2 fw-bold"><i class="bi bi-plus-circle me-1"></i> Tambah Jadwal Pelajaran</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Filter & Schedules Grid (Admin Right Column) -->
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm mb-4 rounded-3">
                    <div class="card-body p-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-bold text-dark small"><i class="bi bi-funnel-fill text-primary me-1"></i>Filter Tampilan Kelas:</span>
                            <form action="{{ route('jadwal.index') }}" method="GET" class="d-flex align-items-center gap-2">
                                <select name="filter_kelas" class="form-select form-select-sm" onchange="this.form.submit()" style="min-width: 220px;">
                                    <option value="">-- Semua Kelas --</option>
                                    @if(count($kelasX) > 0)
                                        <optgroup label="🏫 Tingkat X (Kelas 10)">
                                            @foreach($kelasX as $k)
                                                <option value="{{ $k->nama_kelas }}" {{ request('filter_kelas') == $k->nama_kelas ? 'selected' : '' }}>
                                                    Kelas: {{ $k->nama_kelas }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                    @if(count($kelasXI) > 0)
                                        <optgroup label="🏫 Tingkat XI (Kelas 11)">
                                            @foreach($kelasXI as $k)
                                                <option value="{{ $k->nama_kelas }}" {{ request('filter_kelas') == $k->nama_kelas ? 'selected' : '' }}>
                                                    Kelas: {{ $k->nama_kelas }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                    @if(count($kelasXII) > 0)
                                        <optgroup label="🏫 Tingkat XII (Kelas 12)">
                                            @foreach($kelasXII as $k)
                                                <option value="{{ $k->nama_kelas }}" {{ request('filter_kelas') == $k->nama_kelas ? 'selected' : '' }}>
                                                    Kelas: {{ $k->nama_kelas }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                    @if(count($kelasOther) > 0)
                                        <optgroup label="🏫 Kelas Lainnya">
                                            @foreach($kelasOther as $k)
                                                <option value="{{ $k->nama_kelas }}" {{ request('filter_kelas') == $k->nama_kelas ? 'selected' : '' }}>
                                                    Kelas: {{ $k->nama_kelas }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                </select>
                                @if(request('filter_kelas'))
                                    <a href="{{ route('jadwal.index') }}" class="btn btn-outline-secondary btn-sm" title="Reset Filter">Reset</a>
                                @endif
                            </form>
                        </div>
                        <span class="badge bg-primary px-3 py-2"><i class="bi bi-clock-history me-1"></i>Jam Pagi Teratas</span>
                    </div>
                </div>

                @if(!request('filter_kelas') && count($jadwalsByKelas) > 0)
                    <!-- VIEW ALL CLASSES: Grouped by Class, 5 Days Side by Side -->
                    @foreach($jadwalsByKelas as $className => $classItems)
                        @php $dayGrouped = $classItems->groupBy('hari'); @endphp
                        <div class="card border-0 shadow-sm mb-4 rounded-3 overflow-hidden">
                            <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center border-0">
                                <h6 class="mb-0 fw-bold"><i class="bi bi-building me-2 text-warning"></i>Jadwal Pelajaran Kelas: {{ $className }}</h6>
                                <span class="badge bg-warning text-dark font-bold">{{ count($classItems) }} Mapel</span>
                            </div>
                            <div class="card-body p-3 bg-light">
                                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-2">
                                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                                        <div class="col">
                                            <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                                                <div class="card-header bg-secondary text-white py-2 text-center fw-bold small">
                                                    {{ $day }}
                                                </div>
                                                <div class="card-body p-2 bg-white">
                                                    @if(isset($dayGrouped[$day]) && count($dayGrouped[$day]) > 0)
                                                        <div class="d-flex flex-column gap-2">
                                                            @foreach($dayGrouped[$day]->sortBy('jam_mulai') as $item)
                                                                <div class="p-2 border rounded-3 bg-light position-relative">
                                                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                                                        <span class="badge bg-primary text-wrap" style="font-size: 0.72rem;">{{ $item->mata_pelajaran }}</span>
                                                                        <form action="{{ route('jadwal.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')" class="d-inline">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-link text-danger p-0 ms-1" style="font-size: 0.85rem;" title="Hapus">
                                                                                <i class="bi bi-trash-fill"></i>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                    @if($item->guru)
                                                                        <div class="text-dark fw-bold mb-1" style="font-size: 0.72rem;">
                                                                            <i class="bi bi-person-fill text-primary me-1"></i>{{ $item->guru->nama }}
                                                                        </div>
                                                                    @else
                                                                        <div class="text-muted mb-1" style="font-size: 0.72rem;">
                                                                            <i class="bi bi-person-dash me-1"></i>Guru belum diatur
                                                                        </div>
                                                                    @endif
                                                                    <div class="small fw-semibold text-muted" style="font-size: 0.7rem;">
                                                                        <i class="bi bi-clock me-1 text-primary"></i>
                                                                        {{ \App\Helpers\WaktuHelper::format('2026-08-05 '.$item->jam_mulai, false) }}
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <div class="text-center py-4 text-muted small" style="font-size: 0.75rem;">
                                                            <i class="bi bi-calendar2-minus d-block fs-4 mb-1 text-secondary opacity-50"></i>
                                                            Kosong
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach

                @elseif(request('filter_kelas') && count($jadwals) > 0)
                    <!-- FILTERED CLASS VIEW -->
                    <div class="card border-0 shadow-sm mb-4 rounded-3 overflow-hidden">
                        <div class="card-header bg-dark text-white py-3 border-0">
                            <h6 class="mb-0 fw-bold"><i class="bi bi-building me-2 text-warning"></i>Jadwal Pelajaran Kelas: {{ request('filter_kelas') }}</h6>
                        </div>
                        <div class="card-body p-3 bg-light">
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-2">
                                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                                    <div class="col">
                                        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                                            <div class="card-header bg-secondary text-white py-2 text-center fw-bold small">
                                                {{ $day }}
                                            </div>
                                            <div class="card-body p-2 bg-white">
                                                @if(isset($jadwals[$day]) && count($jadwals[$day]) > 0)
                                                    <div class="d-flex flex-column gap-2">
                                                        @foreach($jadwals[$day]->sortBy('jam_mulai') as $item)
                                                            <div class="p-2 border rounded-3 bg-light">
                                                                <div class="d-flex justify-content-between align-items-start mb-1">
                                                                    <span class="badge bg-primary text-wrap" style="font-size: 0.72rem;">{{ $item->mata_pelajaran }}</span>
                                                                    <form action="{{ route('jadwal.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-link text-danger p-0 ms-1" style="font-size: 0.85rem;" title="Hapus">
                                                                            <i class="bi bi-trash-fill"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                @if($item->guru)
                                                                    <div class="text-dark fw-bold mb-1" style="font-size: 0.72rem;">
                                                                        <i class="bi bi-person-fill text-primary me-1"></i>{{ $item->guru->nama }}
                                                                    </div>
                                                                @else
                                                                    <div class="text-muted mb-1" style="font-size: 0.72rem;">
                                                                        <i class="bi bi-person-dash me-1"></i>Guru belum diatur
                                                                    </div>
                                                                @endif
                                                                <div class="small fw-semibold text-muted" style="font-size: 0.7rem;">
                                                                    <i class="bi bi-clock me-1 text-primary"></i>
                                                                    {{ \App\Helpers\WaktuHelper::format('2026-08-05 '.$item->jam_mulai, false) }}
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="text-center py-4 text-muted small" style="font-size: 0.75rem;">
                                                        <i class="bi bi-calendar2-minus d-block fs-4 mb-1 text-secondary opacity-50"></i>
                                                        Kosong
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body py-5 text-center text-muted">
                            <i class="bi bi-calendar-x fs-1 mb-2 d-block text-secondary opacity-50"></i>
                            Belum ada data jadwal pelajaran yang ditambahkan.
                        </div>
                    </div>
                @endif
            </div>
        </div>

    @elseif(Auth::user()->isGuru())
        <!-- TEACHER SCHEDULE VIEW -->
        <div class="col-md-12 mb-4">
            <div class="card border-0 shadow-sm bg-gradient bg-primary text-white rounded-3 mb-4">
                <div class="card-body p-4 p-lg-5 d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 70px; height: 70px; font-size: 2rem;">
                            @if(Auth::user()->guru && Auth::user()->guru->foto)
                                <img src="{{ asset('storage/'.Auth::user()->guru->foto) }}" class="rounded-circle object-fit-cover" style="width: 70px; height: 70px;">
                            @else
                                <i class="bi bi-person-badge-fill"></i>
                            @endif
                        </div>
                        <div>
                            <span class="badge bg-white text-primary fw-bold px-3 py-1 mb-2">PORTAL JADWAL MENGAJAR GURU</span>
                            <h2 class="fw-bold text-white mb-1">
                                {{ Auth::user()->name }}
                            </h2>
                            <p class="mb-0 text-white-50">
                                <i class="bi bi-journal-bookmark-fill me-1"></i> Mata Pelajaran: <strong>{{ Auth::user()->guru->mata_pelajaran ?? '-' }}</strong>
                                | NIP: <strong>{{ Auth::user()->guru->nip ?? '-' }}</strong>
                            </p>
                        </div>
                    </div>
                    <div class="text-end bg-white bg-opacity-10 p-3 rounded-3 border border-white border-opacity-25 shadow-sm">
                        <small class="text-white-50 d-block mb-1"><i class="bi bi-clock-history me-1"></i> Hari Mengajar</small>
                        <h5 class="fw-bold text-white mb-0">Senin - Jumat</h5>
                    </div>
                </div>
            </div>

            <!-- 5-Day Horizontal Schedule Cards for Teacher -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3">
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $dayName)
                    <div class="col">
                        <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden">
                            <div class="card-header bg-dark text-white py-2 fw-bold text-center small border-0">
                                <i class="bi bi-calendar-event me-1 text-warning"></i> {{ $dayName }}
                            </div>
                            <div class="card-body p-2 bg-light bg-opacity-50">
                                @if(isset($jadwals[$dayName]) && count($jadwals[$dayName]) > 0)
                                    <div class="d-flex flex-column gap-2">
                                        @foreach($jadwals[$dayName]->sortBy('jam_mulai') as $item)
                                            <div class="card border-0 shadow-sm bg-white p-3 rounded-3 border-start border-4 border-primary">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="badge bg-primary bg-opacity-10 text-primary fw-bold" style="font-size: 0.75rem;">
                                                        <i class="bi bi-building me-1"></i>{{ $item->kelas }}
                                                    </span>
                                                </div>
                                                <div class="fw-bold text-dark mb-1 small">{{ $item->mata_pelajaran }}</div>
                                                <div class="small fw-semibold text-muted" style="font-size: 0.72rem;">
                                                    <i class="bi bi-clock me-1 text-primary"></i> 
                                                    {{ \App\Helpers\WaktuHelper::format('2026-08-05 '.$item->jam_mulai, false) }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-5 text-muted small">
                                        <i class="bi bi-calendar2-minus d-block fs-3 mb-1 text-secondary opacity-50"></i>
                                        Tidak ada jadwal mengajar
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    @elseif(Auth::user()->isSiswa())
        <!-- DEDICATED STUDENT SCHEDULE VIEW -->
        <div class="col-md-12 mb-4">
            <div class="card border-0 shadow-sm bg-warning bg-opacity-10 mb-4 rounded-3 border-start border-4 border-warning">
                <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <span class="badge bg-warning text-dark fw-bold px-3 py-1 mb-2">JADWAL KELAS SAYA</span>
                        <h3 class="fw-bold text-dark mb-1"><i class="bi bi-building me-2 text-warning"></i>Kelas: {{ Auth::user()->siswa->kelas ?? '' }}</h3>
                        <p class="text-secondary mb-0">Jurusan: <strong>{{ Auth::user()->siswa->jurusan ?? '-' }}</strong></p>
                    </div>
                    <div class="text-end bg-white p-3 rounded-3 shadow-sm border">
                        <small class="text-muted d-block mb-1"><i class="bi bi-calendar-check me-1"></i> Hari Efektif</small>
                        <h5 class="fw-bold text-dark mb-0">Senin - Jumat</h5>
                    </div>
                </div>
            </div>

            <!-- 5 Day Schedule Cards Layout -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3">
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                            <div class="card-header bg-dark text-white py-3 fw-bold text-center fs-6 border-0">
                                <i class="bi bi-calendar-day me-1 text-warning"></i> {{ $day }}
                            </div>
                            <div class="card-body p-3">
                                @if(isset($jadwals[$day]) && count($jadwals[$day]) > 0)
                                    <div class="d-flex flex-column gap-3">
                                        @foreach($jadwals[$day]->sortBy('jam_mulai') as $item)
                                            <div class="p-3 border rounded-3 bg-light border-start border-4 border-primary shadow-sm">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="badge bg-primary fs-6">{{ $item->mata_pelajaran }}</span>
                                                </div>
                                                @if($item->guru)
                                                    <div class="small text-dark fw-bold mt-2">
                                                        <i class="bi bi-person-fill text-primary me-1"></i>{{ $item->guru->nama }}
                                                    </div>
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
    @endif
</div>
@endsection
