@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 1100px; margin: 0 auto;">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-calendar-event-fill text-warning me-2"></i>Pengajuan Izin & Sakit Guru
            </h2>
            <p class="text-muted mb-0">
                Formulir pengajuan izin atau sakit guru ke Administrator beserta penugasan guru pengganti dan tugas siswa.
            </p>
        </div>
        <a href="{{ route('tugas.index') }}" class="btn btn-outline-primary fw-bold shadow-sm">
            <i class="bi bi-file-earmark-plus me-1"></i> Buat Tugas Pengganti Siswa
        </a>
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

    <!-- ACTIVE APPROVED LEAVE BANNER FOR GURU -->
    @if($activeApprovedIzin)
        <div class="card border-0 shadow-lg mb-4 bg-gradient bg-warning bg-opacity-10 border-start border-5 border-warning rounded-3">
            <div class="card-body p-4 p-lg-5">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="bg-warning text-dark p-3 rounded-circle fs-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px;">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                    <div>
                        <span class="badge bg-warning text-dark fw-bold px-3 py-1 mb-1">STATUS PERSETUJUAN (ACC) AKTIF</span>
                        <h3 class="fw-bold text-dark mb-0">
                            Anda Sedang {{ strtoupper($activeApprovedIzin->jenis) }} SELAMA {{ $activeApprovedIzin->jumlah_hari }} HARI
                        </h3>
                    </div>
                </div>

                <div class="row g-3 bg-white p-3 rounded-3 shadow-sm border mb-3">
                    <div class="col-md-4">
                        <small class="text-muted d-block fw-bold mb-1">Periode Tanggal:</small>
                        <span class="fw-bold text-dark fs-6">
                            <i class="bi bi-calendar-range text-primary me-1"></i>
                            {{ date('d M Y', strtotime($activeApprovedIzin->tanggal_mulai)) }} s/d {{ date('d M Y', strtotime($activeApprovedIzin->tanggal_selesai)) }}
                        </span>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block fw-bold mb-1">Guru Pengganti Kelas (Admin ACC):</small>
                        @if($activeApprovedIzin->guruPengganti)
                            <span class="fw-bold text-success fs-6">
                                <i class="bi bi-person-badge-fill me-1"></i>{{ $activeApprovedIzin->guruPengganti->nama }}
                            </span>
                        @else
                            <span class="text-muted small fst-italic"><i class="bi bi-clock me-1"></i>Admin belum menunjuk guru pengganti</span>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block fw-bold mb-1">Alasan Izin/Sakit:</small>
                        <span class="fw-semibold text-dark fst-italic">"{{ $activeApprovedIzin->alasan }}"</span>
                    </div>
                </div>

                @if($activeApprovedIzin->tugas_siswa)
                    <div class="bg-white p-3 rounded-3 border shadow-sm mb-3">
                        <small class="text-muted d-block fw-bold mb-1"><i class="bi bi-journal-text me-1 text-primary"></i> Tugas / Petunjuk Belajar untuk Siswa agar Tidak Jamkos:</small>
                        <p class="mb-0 text-dark small fw-semibold">{{ $activeApprovedIzin->tugas_siswa }}</p>
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 pt-2">
                    <small class="text-secondary"><i class="bi bi-info-circle me-1"></i>Pesan ini otomatis aktif selama periode izin/sakit Anda berlangsung.</small>
                    <a href="{{ route('tugas.index') }}" class="btn btn-primary fw-bold px-3">
                        <i class="bi bi-plus-circle me-1"></i> Buat / Kelola Tugas Kelas
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- PENDING LEAVE NOTIFICATION -->
    @if($pendingIzinCount > 0)
        <div class="alert alert-warning border-0 shadow-sm p-3 mb-4 rounded-3 d-flex align-items-center gap-3">
            <div class="bg-warning text-dark p-2 rounded-circle fs-4">
                <i class="bi bi-clock-history"></i>
            </div>
            <div>
                <h6 class="fw-bold text-dark mb-0">Pengajuan Izin/Sakit Anda Sedang Menunggu Persetujuan (ACC) Admin</h6>
                <small class="text-secondary">Anda memiliki {{ $pendingIzinCount }} pengajuan izin/sakit yang belum ditinjau oleh Admin Utama.</small>
            </div>
        </div>
    @endif

    <!-- MAIN FORM & HISTORY SECTION -->
    <div class="row g-4 mb-4">
        <!-- Form Request Column (Left) -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-dark text-white py-3 border-0">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square text-warning me-2"></i>Form Pengajuan Izin / Sakit</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('guru.izin.store') }}" method="POST">
                        @csrf

                        <!-- Jenis Izin / Sakit -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Status Kehadiran <span class="text-danger">*</span></label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="jenis" id="jenis_izin" value="Izin" checked autocomplete="off">
                                <label class="btn btn-outline-warning fw-bold text-dark py-2" for="jenis_izin">
                                    <i class="bi bi-envelope me-1"></i> Izin
                                </label>

                                <input type="radio" class="btn-check" name="jenis" id="jenis_sakit" value="Sakit" autocomplete="off">
                                <label class="btn btn-outline-info fw-bold text-dark py-2" for="jenis_sakit">
                                    <i class="bi bi-hospital me-1"></i> Sakit
                                </label>
                            </div>
                        </div>

                        <!-- Date Range -->
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label for="tanggal_mulai" class="form-label fw-bold small">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-6">
                                <label for="tanggal_selesai" class="form-label fw-bold small">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <!-- Reason -->
                        <div class="mb-3">
                            <label for="alasan" class="form-label fw-bold">Alasan Izin / Sakit <span class="text-danger">*</span></label>
                            <textarea name="alasan" id="alasan" class="form-control" rows="3" placeholder="Tuliskan alasan lengkap izin atau sakit Anda..." required></textarea>
                        </div>

                        <!-- Student Task / Instruction Connection (To Prevent Empty Class / Jamkos) -->
                        <div class="card bg-light border-primary border-opacity-25 mb-3">
                            <div class="card-body p-3">
                                <label class="form-label fw-bold text-dark mb-2">
                                    <i class="bi bi-journal-check text-primary me-1"></i> Penugasan Siswa (Anti Jamkos) <span class="badge bg-primary">Hubungkan Tugas</span>
                                </label>
                                
                                <div class="mb-3">
                                    <select name="tugas_mode" id="tugas_mode" class="form-select fw-bold text-primary border-primary" onchange="toggleTugasMode(this.value)">
                                        <option value="new">➕ Buat Tugas Baru Otomatis untuk Kelas</option>
                                        <option value="existing">🔗 Hubungkan dengan Tugas yang Sudah Ada</option>
                                        <option value="none">📝 Hanya Catatan Teks Biasa</option>
                                    </select>
                                </div>

                                <!-- MODE A: New Tugas Form -->
                                <div id="mode_new_tugas" class="border p-3 bg-white rounded-3 shadow-sm mb-2">
                                    <small class="text-primary fw-bold d-block mb-2"><i class="bi bi-plus-circle-fill me-1"></i>Pemberian Tugas Baru ke Siswa:</small>
                                    <div class="mb-2">
                                        <label for="judul_tugas" class="form-label small fw-bold mb-1">Judul Tugas Siswa</label>
                                        <input type="text" name="judul_tugas" id="judul_tugas" class="form-control form-control-sm" placeholder="Contoh: Meresum Bab 4 & Latihan Soal Hal 80">
                                    </div>
                                    <div class="row g-2 mb-2">
                                        <div class="col-6">
                                            <label for="kelas_tugas" class="form-label small fw-bold mb-1">Pilih Kelas Target</label>
                                            <select name="kelas_tugas" id="kelas_tugas" class="form-select form-select-sm">
                                                @foreach($kelases as $k)
                                                    <option value="{{ $k->nama_kelas }}">Kelas {{ $k->nama_kelas }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="deadline_tugas" class="form-label small fw-bold mb-1">Deadline Tugas</label>
                                            <input type="date" name="deadline_tugas" id="deadline_tugas" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="deskripsi_tugas" class="form-label small fw-bold mb-1">Petunjuk pengerjaan (Opsional)</label>
                                        <textarea name="deskripsi_tugas" id="deskripsi_tugas" class="form-control form-control-sm" rows="2" placeholder="Kerjakan di buku catatan dan unggah ke portal siswa..."></textarea>
                                    </div>
                                </div>

                                <!-- MODE B: Existing Tugas Dropdown -->
                                <div id="mode_existing_tugas" class="border p-3 bg-white rounded-3 shadow-sm mb-2 d-none">
                                    <label for="tugas_id" class="form-label small fw-bold mb-1"><i class="bi bi-link-45deg text-primary me-1"></i>Pilih Tugas yang Pernah Dibuat</label>
                                    <select name="tugas_id" id="tugas_id" class="form-select form-select-sm">
                                        <option value="">-- Pilih Tugas --</option>
                                        @foreach($existingTugas as $t)
                                            <option value="{{ $t->id }}">{{ $t->judul }} (Kelas {{ $t->kelas }}) - Deadline: {{ date('d/m/Y', strtotime($t->deadline)) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- MODE C: Manual Note -->
                                <div id="mode_manual_tugas" class="d-none">
                                    <textarea name="tugas_siswa" id="tugas_siswa" class="form-control form-control-sm" rows="2" placeholder="Tuliskan instruksi materi singkat untuk kelas..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="minta_guru_pengganti" id="minta_guru_pengganti" value="1" checked>
                            <label class="form-check-label fw-semibold text-dark small" for="minta_guru_pengganti">
                                Beritahu Admin untuk menunjuk <strong>Guru Pengganti</strong> di kelas
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning text-dark fw-bold py-2.5">
                                <i class="bi bi-send-fill me-1"></i> Kirim Pengajuan ke Admin (Menunggu ACC)
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- History Column (Right) -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-clock-history text-primary me-2"></i>Riwayat Pengajuan Saya</h5>
                    <span class="badge bg-primary px-3 py-1">{{ count($myIzinList) }} Riwayat</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Jenis & Periode</th>
                                    <th>Alasan & Tugas</th>
                                    <th>Guru Pengganti</th>
                                    <th>Status ACC</th>
                                    <th class="pe-4 text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($myIzinList as $item)
                                    <tr>
                                        <td class="ps-4">
                                            <span class="badge {{ $item->jenis === 'Sakit' ? 'bg-info text-dark' : 'bg-warning text-dark' }} mb-1 fs-6">
                                                {{ $item->jenis }} ({{ $item->jumlah_hari }} Hari)
                                            </span>
                                            <div class="small fw-semibold text-dark">
                                                {{ date('d/m/Y', strtotime($item->tanggal_mulai)) }} - {{ date('d/m/Y', strtotime($item->tanggal_selesai)) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-dark small">"{{ $item->alasan }}"</div>
                                            @if($item->tugas)
                                                <div class="mt-1">
                                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary small">
                                                        <i class="bi bi-file-earmark-check-fill me-1"></i>Tugas: {{ $item->tugas->judul }} (Kelas {{ $item->tugas->kelas }})
                                                    </span>
                                                </div>
                                            @elseif($item->tugas_siswa)
                                                <small class="text-muted d-block mt-1"><i class="bi bi-journal-text me-1 text-primary"></i>Tugas: {{ Str::limit($item->tugas_siswa, 40) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->guruPengganti)
                                                <span class="badge bg-success bg-opacity-10 text-success fw-bold p-2">
                                                    <i class="bi bi-person-badge-fill me-1"></i>{{ $item->guruPengganti->nama }}
                                                </span>
                                            @else
                                                <span class="text-muted small fst-italic">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->status === 'Disetujui')
                                                <span class="badge bg-success px-3 py-1 fs-6"><i class="bi bi-check-circle-fill me-1"></i>Disetujui (ACC)</span>
                                            @elseif($item->status === 'Ditolak')
                                                <span class="badge bg-danger px-3 py-1 fs-6"><i class="bi bi-x-circle-fill me-1"></i>Ditolak</span>
                                            @else
                                                <span class="badge bg-warning text-dark px-3 py-1 fs-6"><i class="bi bi-clock me-1"></i>Menunggu ACC</span>
                                            @endif
                                            @if($item->catatan_admin)
                                                <small class="text-secondary d-block mt-1 fst-italic">Note: {{ $item->catatan_admin }}</small>
                                            @endif
                                        </td>
                                        <td class="pe-4 text-end">
                                            @if($item->status === 'Pending')
                                                <form action="{{ route('guru.izin.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Batalkan pengajuan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                                        <i class="bi bi-trash"></i> Batalkan
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            Belum ada riwayat pengajuan izin atau sakit.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Substitute Duties Card (Daftar Kelas yang Harus Digantikan) -->
            <div class="card border-0 shadow-sm rounded-3 mt-4">
                <div class="card-header bg-primary text-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-person-badge-fill me-2"></i>Tugas Mengajar Pengganti Saya (Mandat Admin)</h5>
                    <span class="badge bg-warning text-dark font-monospace px-3 py-1 fs-6">{{ count($mySubstituteDutiesAll) }} Penugasan</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Guru yang Digantikan</th>
                                    <th>Periode & Mapel</th>
                                    <th>Kelas & Info Tugas</th>
                                    <th class="pe-4 text-end">Aksi Absensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mySubstituteDutiesAll as $duty)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $duty->guru->nama ?? 'Guru' }}</div>
                                            <span class="badge bg-danger text-white small">{{ $duty->jenis }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-primary small">{{ $duty->guru->mata_pelajaran ?? '-' }}</div>
                                            <small class="text-muted font-monospace d-block">
                                                {{ date('d/m/Y', strtotime($duty->tanggal_mulai)) }} - {{ date('d/m/Y', strtotime($duty->tanggal_selesai)) }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark mb-1">
                                                <i class="bi bi-building me-1 text-primary"></i>Kelas: {{ $duty->tugas->kelas ?? 'Semua Kelas' }}
                                            </div>
                                            @if($duty->tugas)
                                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary small d-inline-block">
                                                    <i class="bi bi-file-earmark-check-fill me-1"></i>Tugas: {{ $duty->tugas->judul }}
                                                </span>
                                            @elseif($duty->tugas_siswa)
                                                <small class="text-muted d-block fst-italic">"{{ Str::limit($duty->tugas_siswa, 40) }}"</small>
                                            @endif
                                        </td>
                                        <td class="pe-4 text-end">
                                            <a href="{{ route('absensi.index', ['kelas' => $duty->tugas->kelas ?? '']) }}" class="btn btn-outline-primary btn-sm fw-bold">
                                                <i class="bi bi-clipboard-check me-1"></i> Absenkan Kelas
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            Belum ada penugasan sebagai guru pengganti dari admin.
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
</div>

<script>
    function toggleTugasMode(mode) {
        document.getElementById('mode_new_tugas').classList.add('d-none');
        document.getElementById('mode_existing_tugas').classList.add('d-none');
        document.getElementById('mode_manual_tugas').classList.add('d-none');

        if (mode === 'new') {
            document.getElementById('mode_new_tugas').classList.remove('d-none');
        } else if (mode === 'existing') {
            document.getElementById('mode_existing_tugas').classList.remove('d-none');
        } else if (mode === 'none') {
            document.getElementById('mode_manual_tugas').classList.remove('d-none');
        }
    }
</script>
@endsection
