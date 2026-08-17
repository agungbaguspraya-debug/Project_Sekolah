@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 650px; margin: 0 auto;">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('siswa.index') }}" class="btn btn-outline-secondary me-3 btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <h2 class="mb-0 fw-bold">Edit Data Siswa</h2>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <h5 class="text-secondary border-bottom pb-2 mb-3"><i class="bi bi-person-fill me-1"></i> Data Pribadi Siswa</h5>

                <div class="mb-3">
                    <label for="nis" class="form-label fw-bold">NIS</label>
                    <input type="text" name="nis" id="nis" class="form-control" value="{{ old('nis', $siswa->nis) }}" required>
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label fw-bold">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $siswa->nama) }}" required>
                </div>

                <div class="mb-3">
                    <label for="kelas" class="form-label fw-bold">Kelas</label>
                    <select name="kelas" id="kelas" class="form-select border-2" required>
                        <option value="">-- Pilih Kelas --</option>
                        @if(count($kelasX) > 0)
                            <optgroup label="🏫 Tingkat X (Kelas 10)">
                                @foreach($kelasX as $k)
                                    <option value="{{ $k->nama_kelas }}" {{ old('kelas', $siswa->kelas) == $k->nama_kelas ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if(count($kelasXI) > 0)
                            <optgroup label="🏫 Tingkat XI (Kelas 11)">
                                @foreach($kelasXI as $k)
                                    <option value="{{ $k->nama_kelas }}" {{ old('kelas', $siswa->kelas) == $k->nama_kelas ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if(count($kelasXII) > 0)
                            <optgroup label="🏫 Tingkat XII (Kelas 12)">
                                @foreach($kelasXII as $k)
                                    <option value="{{ $k->nama_kelas }}" {{ old('kelas', $siswa->kelas) == $k->nama_kelas ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if(count($kelasOther) > 0)
                            <optgroup label="🏫 Kelas Lainnya">
                                @foreach($kelasOther as $k)
                                    <option value="{{ $k->nama_kelas }}" {{ old('kelas', $siswa->kelas) == $k->nama_kelas ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jurusan" class="form-label fw-bold d-flex justify-content-between align-items-center">
                        <span>Jurusan</span>
                        <span id="jurusanSyncBadge" class="badge bg-success bg-opacity-10 text-success border border-success small" style="display: none;">
                            ✨ Otomatis Terpilih
                        </span>
                    </label>
                    <select name="jurusan" id="jurusan" class="form-select" required>
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach($jurusans as $j)
                            <option value="{{ $j->nama_jurusan }}" {{ old('jurusan', $siswa->jurusan) == $j->nama_jurusan ? 'selected' : '' }}>
                                {{ $j->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="foto" class="form-label fw-bold">Foto Profil</label>
                    @if($siswa->foto)
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$siswa->foto) }}" alt="Foto {{ $siswa->nama }}" width="100" class="img-thumbnail rounded">
                        </div>
                    @endif
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>

                <h5 class="text-secondary border-bottom pb-2 mb-3 mt-4"><i class="bi bi-mortarboard-fill me-1"></i> Status Akademik & Kelulusan</h5>

                <div class="mb-3">
                    <label for="status" class="form-label fw-bold">Status Siswa</label>
                    <select name="status" id="status" class="form-select">
                        <option value="Pelajar" {{ old('status', $siswa->status) == 'Pelajar' ? 'selected' : '' }}>Pelajar (Aktif)</option>
                        <option value="Lulus" {{ old('status', $siswa->status) == 'Lulus' ? 'selected' : '' }}>Lulus (Alumni)</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tahun_lulus" class="form-label fw-bold">Tahun Lulus</label>
                        <input type="text" name="tahun_lulus" id="tahun_lulus" class="form-control" value="{{ old('tahun_lulus', $siswa->tahun_lulus) }}" placeholder="Contoh: 2026">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="total_nilai" class="form-label fw-bold">Total / Rata-rata Nilai</label>
                        <input type="number" step="0.01" name="total_nilai" id="total_nilai" class="form-control" value="{{ old('total_nilai', $siswa->total_nilai) }}" placeholder="Contoh: 88.50">
                    </div>
                </div>

                <h5 class="text-secondary border-bottom pb-2 mb-3 mt-4"><i class="bi bi-shield-lock-fill me-1"></i> Akun Login Siswa</h5>
                <p class="text-muted small">Kelola email dan password login untuk akun siswa ini.</p>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $userAccount ? $userAccount->email : '') }}" placeholder="siswa@gmail.com">
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-bold">Password Baru (Opsional)</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password" title="Tampilkan / Sembunyikan Password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill me-1"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
