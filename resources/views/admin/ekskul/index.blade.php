@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 1200px; margin: 0 auto;">
    <!-- Title -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-palette-fill text-primary me-2"></i>Kelola Ekstrakurikuler & ACC Pendaftaran Siswa
            </h2>
            <p class="text-muted mb-0">Edit informasi pembina/pelatih, jadwal latihan, serta persetujuan (ACC) pendaftaran siswa kelas 10.</p>
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

    <!-- SECTION 1: MANAGE EKSTRAKURIKULER (ADD & EDIT) -->
    <div class="row g-4 mb-5">
        <!-- Form Add Ekskul (Left) -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-dark text-white py-3 border-0">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle-fill text-primary me-2"></i>Tambah Ekstrakurikuler Baru</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.ekskul.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Nama Ekskul -->
                        <div class="mb-3">
                            <label for="nama_ekskul" class="form-label fw-bold small">Nama Ekstrakurikuler <span class="text-danger">*</span></label>
                            <input type="text" name="nama_ekskul" id="nama_ekskul" class="form-control form-control-sm" placeholder="Contoh: Pramuka / Basket / Coding Club" required>
                        </div>

                        <!-- Kategori -->
                        <div class="mb-3">
                            <label for="kategori" class="form-label fw-bold small">Kategori Kegiatan</label>
                            <select name="kategori" id="kategori" class="form-select form-select-sm">
                                <option value="Olahraga">Olahraga & Kebugaran</option>
                                <option value="Seni & Budaya">Seni, Musik & Budaya</option>
                                <option value="Sains & Teknologi">Sains & Teknologi / IT</option>
                                <option value="Kepanduan">Kepanduan & Belanegara</option>
                                <option value="Keagamaan">Keagamaan & Kerohanian</option>
                            </select>
                        </div>

                        <!-- Pembina -->
                        <div class="mb-3">
                            <label for="pembina" class="form-label fw-bold small">Guru Pembina / Pelatih</label>
                            <input type="text" name="pembina" id="pembina" class="form-control form-control-sm" placeholder="Nama Guru Pembina atau Pelatih...">
                        </div>

                        <!-- Jadwal & Lokasi -->
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label for="hari_latihan" class="form-label fw-bold small">Hari Latihan</label>
                                <input type="text" name="hari_latihan" id="hari_latihan" class="form-control form-control-sm" placeholder="Jumat & Sabtu">
                            </div>
                            <div class="col-6">
                                <label for="jam_latihan" class="form-label fw-bold small">Jam Latihan</label>
                                <input type="text" name="jam_latihan" id="jam_latihan" class="form-control form-control-sm" placeholder="15:30 - 17:00">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="lokasi" class="form-label fw-bold small">Lokasi Latihan</label>
                            <input type="text" name="lokasi" id="lokasi" class="form-control form-control-sm" placeholder="Lapangan Utama / Lab IT">
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-bold small">Deskripsi Kegiatan</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control form-control-sm" rows="2" placeholder="Jelaskan mengenai ekskul ini..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="foto" class="form-label fw-bold small">Foto Logo / Banner Ekskul</label>
                            <input type="file" name="foto" id="foto" class="form-control form-control-sm" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary text-white fw-bold w-100 py-2">
                            <i class="bi bi-save me-1"></i> Simpan Ekskul
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- List Cards with Edit Modals (Right) -->
        <div class="col-lg-8">
            <div class="row g-3">
                @forelse($ekskuls as $e)
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-3 h-100 overflow-hidden bg-white">
                            @if($e->foto)
                                <img src="{{ asset('storage/'.$e->foto) }}" class="card-img-top object-fit-cover" style="height: 130px;">
                            @else
                                <div class="bg-primary bg-gradient text-white d-flex align-items-center justify-content-center p-3" style="height: 130px;">
                                    <i class="bi bi-palette fs-1"></i>
                                </div>
                            @endif
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary small">{{ $e->kategori }}</span>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-primary btn-sm px-2" data-bs-toggle="modal" data-bs-target="#modalEditEkskul{{ $e->id }}">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>
                                        <form action="{{ route('admin.ekskul.destroy', $e->id) }}" method="POST" onsubmit="return confirm('Hapus ekskul ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm px-2">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <h5 class="fw-bold text-dark mb-1">{{ $e->nama_ekskul }}</h5>
                                <p class="small text-muted mb-2"><i class="bi bi-person-badge text-primary me-1"></i>Pembina: <strong>{{ $e->pembina ?? '-' }}</strong></p>
                                <div class="small text-secondary mb-1">
                                    <i class="bi bi-clock me-1 text-warning"></i>{{ $e->hari_latihan ?? '-' }} ({{ $e->jam_latihan ?? '-' }})
                                </div>
                                <div class="small text-secondary mb-2">
                                    <i class="bi bi-geo-alt me-1 text-danger"></i>{{ $e->lokasi ?? '-' }}
                                </div>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success small">
                                    <i class="bi bi-people-fill me-1"></i>{{ $e->total_pendaftar }} Siswa Terdaftar (ACC)
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL EDIT EKSKUL -->
                    <div class="modal fade" id="modalEditEkskul{{ $e->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-dark text-white">
                                    <h5 class="modal-header-title fw-bold text-white mb-0">
                                        <i class="bi bi-pencil-square me-2 text-warning"></i>Edit Informasi {{ $e->nama_ekskul }}
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.ekskul.update', $e->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body p-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small">Nama Ekstrakurikuler</label>
                                            <input type="text" name="nama_ekskul" class="form-control" value="{{ $e->nama_ekskul }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small">Kategori</label>
                                            <select name="kategori" class="form-select">
                                                <option value="Olahraga" {{ $e->kategori === 'Olahraga' ? 'selected' : '' }}>Olahraga & Kebugaran</option>
                                                <option value="Seni & Budaya" {{ $e->kategori === 'Seni & Budaya' ? 'selected' : '' }}>Seni, Musik & Budaya</option>
                                                <option value="Sains & Teknologi" {{ $e->kategori === 'Sains & Teknologi' ? 'selected' : '' }}>Sains & Teknologi / IT</option>
                                                <option value="Kepanduan" {{ $e->kategori === 'Kepanduan' ? 'selected' : '' }}>Kepanduan & Belanegara</option>
                                                <option value="Keagamaan" {{ $e->kategori === 'Keagamaan' ? 'selected' : '' }}>Keagamaan & Kerohanian</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small">Guru Pembina / Pelatih</label>
                                            <input type="text" name="pembina" class="form-control" value="{{ $e->pembina }}">
                                        </div>
                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <label class="form-label fw-bold small">Hari Latihan</label>
                                                <input type="text" name="hari_latihan" class="form-control" value="{{ $e->hari_latihan }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-bold small">Jam Latihan</label>
                                                <input type="text" name="jam_latihan" class="form-control" value="{{ $e->jam_latihan }}">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small">Lokasi Latihan</label>
                                            <input type="text" name="lokasi" class="form-control" value="{{ $e->lokasi }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small">Deskripsi</label>
                                            <textarea name="deskripsi" class="form-control" rows="3">{{ $e->deskripsi }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small">Ganti Foto Logo/Banner (Opsional)</label>
                                            <input type="file" name="foto" class="form-control" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary fw-bold">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card border-0 shadow-sm p-4 text-center text-muted">
                            Belum ada data ekstrakurikuler terdaftar.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- SECTION 2: ACC / TOLAK PENDAFTARAN EKSKUL SISWA -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
        <div class="card-header bg-dark text-white py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0 fw-bold"><i class="bi bi-shield-check text-warning me-2"></i>Persetujuan (ACC) Pendaftaran Ekskul Siswa</h5>
            <div class="btn-group btn-group-sm" role="group">
                <a href="{{ route('admin.ekskul.index') }}" class="btn {{ $statusFilter === '' ? 'btn-warning text-dark font-bold' : 'btn-outline-light' }}">Semua ({{ count($pendaftarans) }})</a>
                <a href="{{ route('admin.ekskul.index', ['status' => 'Pending']) }}" class="btn {{ $statusFilter === 'Pending' ? 'btn-warning text-dark font-bold' : 'btn-outline-light' }}">Pending ({{ $pendingCount }})</a>
                <a href="{{ route('admin.ekskul.index', ['status' => 'Disetujui']) }}" class="btn {{ $statusFilter === 'Disetujui' ? 'btn-warning text-dark font-bold' : 'btn-outline-light' }}">Disetujui ({{ $approvedCount }})</a>
                <a href="{{ route('admin.ekskul.index', ['status' => 'Ditolak']) }}" class="btn {{ $statusFilter === 'Ditolak' ? 'btn-warning text-dark font-bold' : 'btn-outline-light' }}">Ditolak ({{ $rejectedCount }})</a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Siswa Pendaftar</th>
                            <th>Ekstrakurikuler</th>
                            <th>Alasan Pendaftaran</th>
                            <th>Status ACC</th>
                            <th class="pe-4 text-end" style="width: 220px;">Aksi Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftarans as $p)
                            <tr class="{{ $p->status === 'Pending' ? 'table-warning' : '' }}">
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $p->siswa->nama ?? 'Siswa' }}</div>
                                    <small class="text-primary font-monospace">Kelas: {{ $p->siswa->kelas ?? '-' }} | NIS: {{ $p->siswa->nis ?? '-' }}</small>
                                </td>
                                <td>
                                    <div class="fw-bold text-primary">{{ $p->ekstrakurikuler->nama_ekskul ?? 'Ekskul' }}</div>
                                    <small class="text-muted">{{ $p->ekstrakurikuler->kategori ?? '-' }}</small>
                                </td>
                                <td>
                                    <small class="text-dark fw-semibold d-block">"{{ Str::limit($p->alasan_bergabung ?? 'Ingin mengembangkan minat', 60) }}"</small>
                                </td>
                                <td>
                                    @if($p->status === 'Disetujui')
                                        <span class="badge bg-success px-3 py-1 fs-6"><i class="bi bi-check-circle-fill me-1"></i>Disetujui (ACC)</span>
                                    @elseif($p->status === 'Ditolak')
                                        <span class="badge bg-danger px-3 py-1 fs-6"><i class="bi bi-x-circle-fill me-1"></i>Ditolak</span>
                                    @else
                                        <span class="badge bg-warning text-dark px-3 py-1 fs-6"><i class="bi bi-clock me-1"></i>Menunggu ACC</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    @if($p->status === 'Pending')
                                        <div class="d-flex justify-content-end gap-1">
                                            <form action="{{ route('admin.ekskul.approve', $p->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm fw-bold">
                                                    <i class="bi bi-check-lg"></i> ACC
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-outline-danger btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalTolakEkskul{{ $p->id }}">
                                                <i class="bi bi-x-lg"></i> Tolak
                                            </button>
                                        </div>
                                    @else
                                        <small class="text-muted fst-italic">Telah Diproses</small>
                                    @endif
                                </td>
                            </tr>

                            <!-- MODAL REJECT EXSKUL -->
                            <div class="modal fade" id="modalTolakEkskul{{ $p->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title fw-bold text-white mb-0">Tolak Pendaftaran Ekskul</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.ekskul.reject', $p->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body p-4">
                                                <p class="mb-2">Anda akan menolak pendaftaran <strong>{{ $p->siswa->nama ?? 'Siswa' }}</strong> pada ekskul <strong>{{ $p->ekstrakurikuler->nama_ekskul ?? 'Ekskul' }}</strong>.</p>
                                                <p class="small text-muted mb-3">Setelah ditolak, siswa dapat mendaftar ke pilihan ekstrakurikuler lainnya.</p>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small">Catatan Alasan Penolakan</label>
                                                    <textarea name="catatan_admin" class="form-control" rows="3" placeholder="Tuliskan alasan penolakan..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger fw-bold">Konfirmasi Tolak</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    Belum ada pendaftaran ekskul dari siswa.
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
