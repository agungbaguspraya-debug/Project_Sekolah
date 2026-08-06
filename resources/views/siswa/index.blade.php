@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <div>
        <h2 class="mb-0 fw-bold"><i class="bi bi-people-fill me-2 text-primary"></i>Kelola Data Siswa & Alumni</h2>
        <p class="text-muted mb-0">Manajemen data siswa aktif, kenaikan kelas massal, serta arsip data alumni lulusan.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('siswa.create') }}" class="btn btn-primary fw-bold shadow-sm">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah Siswa Baru
        </a>
        <button type="button" class="btn btn-success fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#naikKelasModal">
            <i class="bi bi-arrow-up-circle-fill me-1"></i> Proses Naik Kelas
        </button>
        <button type="button" class="btn btn-warning text-dark fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#luluskanModal">
            <i class="bi bi-mortarboard-fill me-1"></i> Luluskan Siswa
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Nav Filter Tabs: Aktif vs Alumni -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <ul class="nav nav-pills gap-2" id="siswaTab">
                <li class="nav-item">
                    <a href="{{ route('siswa.index', ['tab' => 'aktif']) }}" class="nav-link fw-bold px-4 rounded-3 {{ $tab === 'aktif' ? 'active' : 'bg-light text-dark' }}">
                        <i class="bi bi-person-check-fill me-1"></i> Data Siswa Aktif
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('siswa.index', ['tab' => 'alumni']) }}" class="nav-link fw-bold px-4 rounded-3 {{ $tab === 'alumni' ? 'active' : 'bg-light text-dark' }}">
                        <i class="bi bi-mortarboard-fill me-1"></i> Data Alumni / Siswa Lulus
                    </a>
                </li>
            </ul>

            <form action="{{ route('siswa.index') }}" method="GET" class="d-flex" style="min-width: 280px;">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <input type="text" name="q" class="form-control form-control-sm me-2" placeholder="Cari NIS, Nama, Kelas..." value="{{ $q ?? '' }}">
                <button type="submit" class="btn btn-primary btn-sm px-3"><i class="bi bi-search"></i></button>
                @if(isset($q) && $q !== '')
                    <a href="{{ route('siswa.index', ['tab' => $tab]) }}" class="btn btn-outline-secondary btn-sm ms-2">Reset</a>
                @endif
            </form>
        </div>
    </div>
</div>

@if($tab === 'aktif')
    <!-- TAB 1: DATA SISWA AKTIF -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">Foto</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Status Kenaikan</th>
                            <th>Poin Pelanggaran</th>
                            <th class="pe-4 text-end" style="width: 220px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $item)
                        <tr>
                            <td class="ps-4">
                                @if($item->foto)
                                    <img src="{{ asset('storage/'.$item->foto) }}" width="45" height="45" class="rounded-circle object-fit-cover border shadow-sm">
                                @else
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px;">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-bold text-dark">{{ $item->nis }}</td>
                            <td class="fw-semibold text-dark">{{ $item->nama }}</td>
                            <td><span class="badge bg-primary fs-6">{{ $item->kelas }}</span></td>
                            <td>{{ $item->jurusan }}</td>
                            <td>
                                @if($item->status_kenaikan === 'Naik Kelas')
                                    <span class="badge bg-success"><i class="bi bi-arrow-up-circle me-1"></i>Naik Kelas</span>
                                @else
                                    <span class="badge bg-light text-muted border">Aktif</span>
                                @endif
                            </td>
                            <td>
                                @php $totalPoints = $item->pelanggaran->sum('point'); @endphp
                                @if($totalPoints > 0)
                                    <span class="badge bg-danger fs-6">{{ $totalPoints }} Poin</span>
                                @else
                                    <span class="badge bg-light text-dark border">0 Poin</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('siswa.pelanggaran.index', $item->id) }}" class="btn btn-warning btn-sm text-dark fw-semibold" title="Data Pelanggaran">
                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                    </a>
                                    <a href="{{ route('siswa.edit', $item->id) }}" class="btn btn-primary btn-sm" title="Edit Siswa">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('siswa.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus Siswa">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-emoji-neutral fs-2 d-block mb-2"></i>
                                Belum ada data siswa aktif.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@else
    <!-- TAB 2: DATA ALUMNI / SISWA LULUS (Grouped by Tahun Lulus) -->
    @forelse($alumniList as $tahun => $graduates)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-mortarboard-fill me-2 text-warning"></i>Alumni Kelulusan Tahun {{ $tahun }}</h5>
                <span class="badge bg-warning text-dark fw-bold fs-6">{{ count($graduates) }} Alumni</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Foto</th>
                                <th>NIS & Nama Alumni</th>
                                <th>Kelas Terakhir</th>
                                <th>Tahun Lulus</th>
                                <th>Total Nilai</th>
                                <th>Foto Kenangan</th>
                                <th class="pe-4 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($graduates as $item)
                            <tr>
                                <td class="ps-4">
                                    @if($item->foto)
                                        <img src="{{ asset('storage/'.$item->foto) }}" width="45" height="45" class="rounded-circle object-fit-cover border shadow-sm">
                                    @else
                                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px;">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $item->nama }}</div>
                                    <small class="text-muted">NIS: {{ $item->nis }}</small>
                                </td>
                                <td><span class="badge bg-secondary fs-6">{{ $item->kelas }}</span></td>
                                <td><span class="badge bg-success fs-6">{{ $item->tahun_lulus }}</span></td>
                                <td>
                                    <span class="badge bg-info text-dark fs-6">{{ number_format($item->total_nilai ?? 85.00, 2) }}</span>
                                </td>
                                <td>
                                    @if($item->foto_kenangan)
                                        <a href="{{ asset('storage/'.$item->foto_kenangan) }}" target="_blank" class="badge bg-success text-decoration-none">
                                            <i class="bi bi-camera me-1"></i> Ada Foto
                                        </a>
                                    @else
                                        <span class="text-muted small">Belum Upload</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('siswa.edit', $item->id) }}" class="btn btn-primary btn-sm" title="Edit Alumni">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('siswa.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus alumni ini?')" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @empty
        <div class="card border-0 shadow-sm p-5 text-center text-muted">
            <i class="bi bi-mortarboard fs-1 d-block mb-2 text-secondary"></i>
            Belum ada data alumni / siswa yang diluluskan.
        </div>
    @endforelse
@endif

<!-- MODAL PROSES NAIK KELAS MASSAL -->
<div class="modal fade" id="naikKelasModal" tabindex="-1" aria-labelledby="naikKelasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white py-3">
                <h5 class="modal-header-title mb-0 fw-bold" id="naikKelasModalLabel">
                    <i class="bi bi-arrow-up-circle-fill me-2"></i>Proses Kenaikan Kelas Siswa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('siswa.naik-kelas') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="kelas_asal" class="form-label fw-bold">Pilih Kelas Asal (Saat Ini)</label>
                        <select name="kelas_asal" id="kelas_asal" class="form-select border-2" required>
                            <option value="">-- Pilih Kelas Asal --</option>
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
                        <label for="kelas_tujuan" class="form-label fw-bold">Dinaikkan Ke Kelas Tujuan</label>
                        <select name="kelas_tujuan" id="kelas_tujuan" class="form-select border-2" required>
                            <option value="">-- Pilih Kelas Tujuan --</option>
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
                            @if(count($kelasX) > 0)
                                <optgroup label="🏫 Tingkat X (Kelas 10)">
                                    @foreach($kelasX as $k)
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
                        <small class="text-muted mt-2 d-block bg-light p-2 rounded border">
                            <i class="bi bi-info-circle text-primary me-1"></i> Saat Kelas Asal dipilih, sistem otomatis menyarankannya ke tingkat kelas berikutnya.
                        </small>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-bold"><i class="bi bi-check-circle-fill me-1"></i> Proses Naik Kelas</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL LULUSKAN SISWA MASSAL / KELAS -->
<div class="modal fade" id="luluskanModal" tabindex="-1" aria-labelledby="luluskanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning text-dark py-3">
                <h5 class="modal-header-title mb-0 fw-bold" id="luluskanModalLabel">
                    <i class="bi bi-mortarboard-fill me-2"></i>Proses Kelulusan Siswa (Alumni)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('siswa.luluskan') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="kelas_asal_lulus" class="form-label fw-bold">Pilih Kelas yang Diluluskan</label>
                        <select name="kelas_asal" id="kelas_asal_lulus" class="form-select border-2" required>
                            <option value="">-- Pilih Kelas Siswa Lulus --</option>
                            <option value="SEMUA_KELAS_12" class="fw-bold text-danger py-2">
                                🎓 LULUSKAN SEMUA KELAS 12 (SEMUA KELAS XII)
                            </option>
                            @if(count($kelasXII) > 0)
                                <optgroup label="🎓 Daftar Kelas 12 (Tingkat XII)">
                                    @foreach($kelasXII as $k)
                                        <option value="{{ $k->nama_kelas }}">Kelas {{ $k->nama_kelas }}</option>
                                    @endforeach
                                </optgroup>
                            @endif
                        </select>
                        <small class="text-muted mt-2 d-block bg-light p-2 rounded border">
                            <i class="bi bi-info-circle text-primary me-1"></i> Pilih <strong>"LULUSKAN SEMUA KELAS 12"</strong> untuk meluluskan seluruh siswa tingkat 12 sekaligus.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="tahun_lulus" class="form-label fw-bold">Tahun Kelulusan</label>
                        <input type="text" name="tahun_lulus" id="tahun_lulus" class="form-control" value="{{ date('Y') }}" placeholder="Contoh: 2026" required>
                    </div>

                    <div class="mb-3">
                        <label for="total_nilai" class="form-label fw-bold">Total / Rata-rata Nilai (Opsional)</label>
                        <input type="number" step="0.01" name="total_nilai" id="total_nilai" class="form-control" placeholder="Contoh: 88.50">
                        <small class="text-muted">Dapat diubah secara individual per siswa di halaman edit siswa.</small>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-dark fw-bold"><i class="bi bi-mortarboard-fill me-1"></i> Proses Kelulusan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const kelasAsalSelect = document.getElementById('kelas_asal');
        const kelasTujuanSelect = document.getElementById('kelas_tujuan');

        if (kelasAsalSelect && kelasTujuanSelect) {
            kelasAsalSelect.addEventListener('change', function() {
                const asal = this.value.trim();
                if (!asal) return;

                let suggested = '';
                if (asal.startsWith('X ')) {
                    suggested = 'XI ' + asal.substring(2);
                } else if (asal.startsWith('10 ')) {
                    suggested = '11 ' + asal.substring(3);
                } else if (asal.startsWith('XI ')) {
                    suggested = 'XII ' + asal.substring(3);
                } else if (asal.startsWith('11 ')) {
                    suggested = '12 ' + asal.substring(3);
                }

                if (suggested) {
                    for (let opt of kelasTujuanSelect.options) {
                        if (opt.value === suggested) {
                            kelasTujuanSelect.value = suggested;
                            break;
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
