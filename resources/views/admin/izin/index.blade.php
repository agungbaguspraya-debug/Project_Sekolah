@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 1200px; margin: 0 auto;">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-shield-lock-fill text-warning me-2"></i>Persetujuan (ACC) Izin & Sakit Guru
            </h2>
            <p class="text-muted mb-0">
                Persetujuan pengajuan izin/sakit guru sekolah dan penunjukan Guru Pengganti untuk mencegah kelas kosong (jamkos).
            </p>
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

    <!-- Summary Statistics Cards -->
    <div class="row row-cols-1 row-cols-md-3 g-3 mb-4">
        <div class="col">
            <div class="card border-0 shadow-sm p-3 border-start border-4 border-warning bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-warning fw-bold text-uppercase">Menunggu ACC Admin</small>
                    <span class="badge bg-warning text-dark font-monospace">{{ $pendingCount }} Pengajuan</span>
                </div>
                <h2 class="fw-bold text-dark mb-0">{{ $pendingCount }}</h2>
                <small class="text-muted">Butuh Peninjauan & Guru Pengganti</small>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm p-3 border-start border-4 border-success bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-success fw-bold text-uppercase">Disetujui (ACC)</small>
                    <span class="badge bg-success font-monospace">{{ $approvedCount }} Ter-ACC</span>
                </div>
                <h2 class="fw-bold text-success mb-0">{{ $approvedCount }}</h2>
                <small class="text-muted">Guru Pengganti Ditugaskan</small>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm p-3 border-start border-4 border-danger bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-danger fw-bold text-uppercase">Ditolak</small>
                    <span class="badge bg-danger font-monospace">{{ $rejectedCount }} Ditolak</span>
                </div>
                <h2 class="fw-bold text-danger mb-0">{{ $rejectedCount }}</h2>
                <small class="text-muted">Tidak Diizinkan Admin</small>
            </div>
        </div>
    </div>

    <!-- Filter Pills -->
    <div class="mb-3 d-flex gap-2">
        <a href="{{ route('admin.izin.index') }}" class="btn btn-sm {{ !$statusFilter ? 'btn-dark' : 'btn-outline-dark' }} fw-bold">Semua Pengajuan</a>
        <a href="{{ route('admin.izin.index', ['status' => 'Pending']) }}" class="btn btn-sm {{ $statusFilter === 'Pending' ? 'btn-warning text-dark' : 'btn-outline-warning text-dark' }} fw-bold">Menunggu ACC ({{ $pendingCount }})</a>
        <a href="{{ route('admin.izin.index', ['status' => 'Disetujui']) }}" class="btn btn-sm {{ $statusFilter === 'Disetujui' ? 'btn-success' : 'btn-outline-success' }} fw-bold">Disetujui ({{ $approvedCount }})</a>
        <a href="{{ route('admin.izin.index', ['status' => 'Ditolak']) }}" class="btn btn-sm {{ $statusFilter === 'Ditolak' ? 'btn-danger' : 'btn-outline-danger' }} fw-bold">Ditolak ({{ $rejectedCount }})</a>
    </div>

    <!-- Main Requests Table -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
        <div class="card-header bg-dark text-white py-3 border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="bi bi-list-check text-warning me-2"></i>Daftar Pengajuan Izin & Sakit Guru</h5>
            <span class="badge bg-warning text-dark font-monospace px-3 py-1 fs-6">{{ count($izinList) }} Data</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Guru Pemohon & Mapel</th>
                            <th>Jenis & Periode Izin</th>
                            <th>Alasan Izin/Sakit</th>
                            <th>Tugas Siswa (Jamkos)</th>
                            <th>Guru Pengganti</th>
                            <th>Status ACC</th>
                            <th class="pe-4 text-end" style="width: 180px;">Aksi Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($izinList as $item)
                            <tr class="{{ $item->status === 'Pending' ? 'table-warning' : '' }}">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-2">
                                        @if($item->guru && $item->guru->foto)
                                            <img src="{{ asset('storage/'.$item->guru->foto) }}" class="rounded-circle object-fit-cover border" style="width: 40px; height: 40px;">
                                        @else
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold text-dark mb-0">{{ $item->guru->nama ?? 'Guru' }}</div>
                                            <small class="text-primary font-monospace">{{ $item->guru->mata_pelajaran ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $item->jenis === 'Sakit' ? 'bg-info text-dark' : 'bg-warning text-dark' }} fs-6 mb-1">
                                        {{ $item->jenis }} ({{ $item->jumlah_hari }} Hari)
                                    </span>
                                    <div class="small text-muted font-monospace">
                                        {{ date('d/m/Y', strtotime($item->tanggal_mulai)) }} - {{ date('d/m/Y', strtotime($item->tanggal_selesai)) }}
                                    </div>
                                </td>
                                <td style="max-width: 200px;">
                                    <div class="fw-semibold text-dark small">"{{ $item->alasan }}"</div>
                                </td>
                                <td style="max-width: 220px;">
                                    @if($item->tugas)
                                        <a href="{{ route('tugas.submissions', $item->tugas->id) }}" class="text-decoration-none">
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary p-2 text-wrap text-start d-block">
                                                <i class="bi bi-file-earmark-check-fill me-1"></i>{{ $item->tugas->judul }} (Kelas {{ $item->tugas->kelas }})
                                            </span>
                                        </a>
                                    @elseif($item->tugas_siswa)
                                        <small class="text-dark fw-semibold d-block"><i class="bi bi-journal-text text-primary me-1"></i>{{ Str::limit($item->tugas_siswa, 60) }}</small>
                                    @else
                                        <span class="text-muted small fst-italic">Tidak ada tugas khusus</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->guruPengganti)
                                        <span class="badge bg-success bg-opacity-10 text-success fw-bold p-2 fs-6 border border-success border-opacity-25">
                                            <i class="bi bi-person-check-fill me-1"></i>{{ $item->guruPengganti->nama }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border p-1.5 small">Belum Ditunjuk</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->status === 'Disetujui')
                                        <span class="badge bg-success px-3 py-1.5 fs-6"><i class="bi bi-check-circle-fill me-1"></i>Disetujui (ACC)</span>
                                    @elseif($item->status === 'Ditolak')
                                        <span class="badge bg-danger px-3 py-1.5 fs-6"><i class="bi bi-x-circle-fill me-1"></i>Ditolak</span>
                                    @else
                                        <span class="badge bg-warning text-dark px-3 py-1.5 fs-6"><i class="bi bi-clock-history me-1"></i>Menunggu ACC</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <button type="button" class="btn btn-success btn-sm me-1 fw-bold" data-bs-toggle="modal" data-bs-target="#approveModal_{{ $item->id }}" title="ACC & Tunjuk Guru Pengganti">
                                        <i class="bi bi-check-circle-fill me-1"></i> ACC
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm p-1 px-2" data-bs-toggle="modal" data-bs-target="#rejectModal_{{ $item->id }}" title="Tolak Pengajuan">
                                        <i class="bi bi-x-circle"></i>
                                    </button>

                                    <!-- APPROVE MODAL -->
                                    <div class="modal fade text-start" id="approveModal_{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-success text-white">
                                                    <h5 class="modal-title fw-bold"><i class="bi bi-check-circle-fill me-2"></i>Persetujuan (ACC) & Guru Pengganti</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('admin.izin.approve', $item->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body p-4">
                                                        <p class="small text-muted mb-3">
                                                            Anda akan menyetujui (ACC) pengajuan <strong>{{ $item->jenis }}</strong> untuk <strong>{{ $item->guru->nama ?? 'Guru' }}</strong> selama <strong>{{ $item->jumlah_hari }} hari</strong> ({{ date('d M Y', strtotime($item->tanggal_mulai)) }} s/d {{ date('d M Y', strtotime($item->tanggal_selesai)) }}).
                                                        </p>

                                                        <div class="mb-3">
                                                            <label for="guru_pengganti_id_{{ $item->id }}" class="form-label fw-bold">Tunjuk Guru Pengganti (Cegah Jamkos)</label>
                                                            <select name="guru_pengganti_id" id="guru_pengganti_id_{{ $item->id }}" class="form-select">
                                                                <option value="">-- Pilih Guru Pengganti --</option>
                                                                @foreach($gurus as $g)
                                                                    @if($g->id != $item->guru_id)
                                                                        <option value="{{ $g->id }}" {{ $item->guru_pengganti_id == $g->id ? 'selected' : '' }}>
                                                                            {{ $g->nama }} ({{ $g->mata_pelajaran }})
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="catatan_admin_{{ $item->id }}" class="form-label fw-bold">Catatan Admin (Opsional)</label>
                                                            <textarea name="catatan_admin" id="catatan_admin_{{ $item->id }}" class="form-control" rows="2" placeholder="Catatan persetujuan admin...">{{ $item->catatan_admin }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-success fw-bold"><i class="bi bi-check-circle-fill me-1"></i> Disetujui & Tunjuk Guru Pengganti</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- REJECT MODAL -->
                                    <div class="modal fade text-start" id="rejectModal_{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title fw-bold"><i class="bi bi-x-circle-fill me-2"></i>Tolak Pengajuan Izin/Sakit</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('admin.izin.reject', $item->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body p-4">
                                                        <p class="small text-muted mb-3">
                                                            Apakah Anda yakin ingin menolak pengajuan {{ $item->jenis }} dari <strong>{{ $item->guru->nama ?? 'Guru' }}</strong>?
                                                        </p>
                                                        <div class="mb-3">
                                                            <label for="catatan_admin_r_{{ $item->id }}" class="form-label fw-bold">Alasan Penolakan</label>
                                                            <textarea name="catatan_admin" id="catatan_admin_r_{{ $item->id }}" class="form-control" rows="2" placeholder="Tuliskan alasan penolakan..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger fw-bold"><i class="bi bi-x-circle-fill me-1"></i> Tolak Pengajuan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    Belum ada data pengajuan izin atau sakit guru.
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
