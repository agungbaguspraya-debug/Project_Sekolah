@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px; margin: 0 auto;">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('siswa.index') }}" class="btn btn-outline-secondary me-3 btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <h2 class="mb-0 fw-bold">Tambah Siswa Baru</h2>
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
            <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <h5 class="text-secondary border-bottom pb-2 mb-3"><i class="bi bi-person-fill me-1"></i> Data Pribadi Siswa</h5>

                <div class="mb-3">
                    <label for="nis" class="form-label fw-bold">NIS</label>
                    <input type="text" name="nis" id="nis" class="form-control" value="{{ old('nis') }}" placeholder="Contoh: 10021" required>
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label fw-bold">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" placeholder="Nama lengkap siswa" required>
                </div>

                <div class="mb-3">
                    <label for="kelas" class="form-label fw-bold">Kelas</label>
                    <select name="kelas" id="kelas" class="form-select border-2" required>
                        <option value="">-- Pilih Kelas --</option>
                        @if(count($kelasX) > 0)
                            <optgroup label="🏫 Tingkat X (Kelas 10)">
                                @foreach($kelasX as $k)
                                    <option value="{{ $k->nama_kelas }}" {{ old('kelas') == $k->nama_kelas ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if(count($kelasXI) > 0)
                            <optgroup label="🏫 Tingkat XI (Kelas 11)">
                                @foreach($kelasXI as $k)
                                    <option value="{{ $k->nama_kelas }}" {{ old('kelas') == $k->nama_kelas ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if(count($kelasXII) > 0)
                            <optgroup label="🏫 Tingkat XII (Kelas 12)">
                                @foreach($kelasXII as $k)
                                    <option value="{{ $k->nama_kelas }}" {{ old('kelas') == $k->nama_kelas ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if(count($kelasOther) > 0)
                            <optgroup label="🏫 Kelas Lainnya">
                                @foreach($kelasOther as $k)
                                    <option value="{{ $k->nama_kelas }}" {{ old('kelas') == $k->nama_kelas ? 'selected' : '' }}>
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
                        @forelse($jurusans as $j)
                            <option value="{{ $j->nama_jurusan }}" {{ old('jurusan') == $j->nama_jurusan ? 'selected' : '' }}>
                                {{ $j->nama_jurusan }}
                            </option>
                        @empty
                            <option value="" disabled>Belum ada data jurusan. Tambah di menu Kelola Jurusan.</option>
                        @endforelse
                    </select>
                </div>

                <div class="mb-4">
                    <label for="foto" class="form-label fw-bold">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>

                <h5 class="text-secondary border-bottom pb-2 mb-3 mt-4"><i class="bi bi-shield-lock-fill me-1"></i> Akun Login Siswa (Opsional)</h5>
                <p class="text-muted small">Isi bagian ini jika ingin langsung membuatkan akun login agar siswa dapat melihat profil & pelanggaran mereka.</p>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="siswa@gmail.com">
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-bold">Password Akun</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 6 karakter">
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password" title="Tampilkan / Sembunyikan Password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill me-1"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
