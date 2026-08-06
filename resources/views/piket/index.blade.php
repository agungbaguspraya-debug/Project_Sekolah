@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 1200px; margin: 0 auto;">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-calendar-check-fill text-warning me-2"></i>Jadwal & Tugas Piket Guru
            </h2>
            <p class="text-muted mb-0">
                Daftar tugas piket guru sekolah terurut berdasarkan hari dan jadwal paling pagi.
            </p>
        </div>
        @if(Auth::user()->isAdmin())
            <button type="button" class="btn btn-warning text-dark fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahPiketModal">
                <i class="bi bi-plus-circle-fill me-1"></i> Tambah Jadwal Piket
            </button>
        @endif
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Logged-in Teacher Duty Schedule Highlight -->
    @if(Auth::user()->isGuru() && $myPiket->count() > 0)
        <div class="card border-0 shadow-sm bg-warning bg-opacity-10 border-start border-5 border-warning mb-4 rounded-3">
            <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-3">
                    <i class="bi bi-star-fill text-warning me-2"></i>Jadwal Piket Saya: {{ Auth::user()->name }}
                </h5>
                <div class="row row-cols-1 row-cols-md-3 g-3">
                    @foreach($myPiket as $mp)
                        <div class="col">
                            <div class="bg-white p-3 rounded-3 shadow-sm h-100 border">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-dark px-3 py-1">{{ $mp->hari }}</span>
                                    <span class="badge bg-warning text-dark fw-bold">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $mp->jam_mulai ? \App\Helpers\WaktuHelper::format('2026-08-05 '.$mp->jam_mulai, false) : '07:00 Pagi' }}
                                    </span>
                                </div>
                                <h6 class="fw-bold text-primary mb-1">{{ $mp->tugas_piket }}</h6>
                                <p class="small text-muted mb-1">
                                    Jam Tugas: <strong>{{ $mp->jam_mulai ? date('H:i', strtotime($mp->jam_mulai)) : '07:00' }} - {{ $mp->jam_selesai ? date('H:i', strtotime($mp->jam_selesai)) : 'Selesai' }}</strong>
                                </p>
                                @if($mp->keterangan)
                                    <small class="text-secondary d-block mt-2 pt-2 border-top"><i class="bi bi-info-circle me-1"></i>{{ $mp->keterangan }}</small>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- TABLES GROUPED BY DAY (SENIN..SABTU), SORTED BY EARLIEST TIME -->
    @php
        $daysOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    @endphp

    @forelse($daysOrder as $hari)
        @if($piketByHari->has($hari) && $piketByHari->get($hari)->count() > 0)
            @php
                $piketList = $piketByHari->get($hari);
            @endphp
            <div class="card border-0 shadow-sm mb-4 rounded-3 overflow-hidden">
                <!-- Day Header -->
                <div class="card-header bg-dark text-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-calendar-event-fill text-warning me-2"></i>JADWAL PIKET HARI {{ strtoupper($hari) }}
                    </h5>
                    <span class="badge bg-warning text-dark fw-bold px-3 py-1 fs-6">
                        {{ $piketList->count() }} Guru Bertugas
                    </span>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4" style="width: 220px;">Jam Piket (Terpagi Awal)</th>
                                    <th>Nama Guru Piket</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Lokasi / Tugas Piket</th>
                                    <th>Keterangan</th>
                                    @if(Auth::user()->isAdmin())
                                        <th class="pe-4 text-end" style="width: 100px;">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($piketList as $p)
                                    <tr class="{{ Auth::user()->isGuru() && Auth::user()->guru && Auth::user()->guru->id == $p->guru_id ? 'table-warning' : '' }}">
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 text-primary p-2 rounded me-2">
                                                    <i class="bi bi-alarm-fill fs-5"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-bold text-dark d-block">
                                                        {{ $p->jam_mulai ? \App\Helpers\WaktuHelper::format('2026-08-05 '.$p->jam_mulai, false) : '07:00 Pagi' }}
                                                    </span>
                                                    <small class="text-muted">
                                                        s/d {{ $p->jam_selesai ? \App\Helpers\WaktuHelper::format('2026-08-05 '.$p->jam_selesai, false) : 'Selesai' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($p->guru && $p->guru->foto)
                                                    <img src="{{ asset('storage/'.$p->guru->foto) }}" width="38" height="38" class="rounded-circle object-fit-cover me-2 border">
                                                @else
                                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 38px; height: 38px;">
                                                        <i class="bi bi-person-fill"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $p->guru->nama ?? '-' }}</div>
                                                    <small class="text-muted">NIP: {{ $p->guru->nip ?? '-' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($p->guru && $p->guru->mata_pelajaran)
                                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1">
                                                    {{ $p->guru->mata_pelajaran }}
                                                </span>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td class="fw-bold text-dark">
                                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $p->tugas_piket }}
                                        </td>
                                        <td class="small text-secondary">
                                            {{ $p->keterangan ?? '-' }}
                                        </td>
                                        @if(Auth::user()->isAdmin())
                                            <td class="pe-4 text-end">
                                                <form action="{{ route('piket.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal piket ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash-fill"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    @empty
        <div class="card border-0 shadow-sm">
            <div class="card-body py-5 text-center text-muted">
                <i class="bi bi-calendar-x fs-1 d-block mb-2 text-secondary"></i>
                Belum ada jadwal piket guru yang terdaftar.
            </div>
        </div>
    @endforelse
</div>

@if(Auth::user()->isAdmin())
<!-- Modal Tambah Piket Guru -->
<div class="modal fade" id="tambahPiketModal" tabindex="-1" aria-labelledby="tambahPiketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title mb-0 fw-bold" id="tambahPiketModalLabel">
                    <i class="bi bi-plus-circle-fill me-2"></i>Tambah Jadwal Piket Guru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('piket.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="guru_id" class="form-label fw-bold">Pilih Guru Piket</label>
                        <select name="guru_id" id="guru_id" class="form-select" required>
                            <option value="">-- Pilih Guru Piket --</option>
                            @foreach($gurus as $g)
                                <option value="{{ $g->id }}">{{ $g->nama }} ({{ $g->mata_pelajaran }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="hari" class="form-label fw-bold">Hari Piket</label>
                        <select name="hari" id="hari" class="form-select" required>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tugas_piket" class="form-label fw-bold">Lokasi / Tugas Piket</label>
                        <input type="text" name="tugas_piket" id="tugas_piket" class="form-control" placeholder="Contoh: Piket Gerbang Utama & Absensi / Piket Kedisiplinan" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="jam_mulai" class="form-label fw-bold">Jam Mulai Piket</label>
                            <input type="time" name="jam_mulai" id="jam_mulai_piket" class="form-control" value="07:30" required>
                        </div>
                        <div class="col-md-6">
                            <label for="jam_selesai" class="form-label fw-bold">Jam Selesai Piket</label>
                            <input type="time" name="jam_selesai" id="jam_selesai_piket" class="form-control" value="15:10" required>
                        </div>
                    </div>

                    <!-- Quick Time Presets for Duty Hours -->
                    <div class="mb-3">
                        <small class="text-muted fw-bold d-block mb-1">Pintas Jam Tugas Sekolah:</small>
                        <div class="d-flex flex-wrap gap-1">
                            <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-2" style="font-size: 0.75rem;" onclick="document.getElementById('jam_mulai_piket').value='07:30'; document.getElementById('jam_selesai_piket').value='12:00';">07:30 Pagi - 12:00 Pagi</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-2" style="font-size: 0.75rem;" onclick="document.getElementById('jam_mulai_piket').value='13:15'; document.getElementById('jam_selesai_piket').value='15:10';">13:15 Siang - 15:10 Siang</button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label fw-bold">Keterangan Tambahan <span class="badge bg-secondary">Opsional</span></label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="2" placeholder="Catatan tugas piket..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-dark fw-bold"><i class="bi bi-save me-1"></i> Simpan Jadwal Piket</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
