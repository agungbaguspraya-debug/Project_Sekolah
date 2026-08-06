<!DOCTYPE html>
<html>
<head>
    <title>Edit Data - SAT Project</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <div class="col-md-6 mx-auto card shadow">
        <div class="card-header bg-warning"><h4>Edit Data Siswa</h4></div>
        <div class="card-body">
            <form action="/siswa/update/{{ $siswa->id }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3"><label>NIS</label><input type="text" name="nis" class="form-control" value="{{ $siswa->nis }}"></div>
                <div class="mb-3"><label>Nama</label><input type="text" name="nama" class="form-control" value="{{ $siswa->nama }}"></div>
                <div class="mb-3"><label>Kelas</label><input type="text" name="kelas" class="form-control" value="{{ $siswa->kelas }}"></div>
                <div class="mb-3"><label>Jurusan</label><input type="text" name="jurusan" class="form-control" value="{{ $siswa->jurusan }}"></div>
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select">
                        <option value="pelajar" {{ $siswa->status == 'pelajar' ? 'selected' : '' }}>Pelajar</option>
                        <option value="Lulus Kuliah" {{ $siswa->status == 'Lulus Kuliah' ? 'selected' : '' }}>Lulus Kuliah</option>
                        <option value="Lulus Kerja" {{ $siswa->status == 'Lulus Kerja' ? 'selected' : '' }}>Lulus Kerja</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Update</button>
                <a href="/siswa" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>