<!DOCTYPE html>
<html lang="id">
<head>
    <title>SAT-PROJECT | CRUD Sekolah</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5 bg-light">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Daftar Siswa - SAT PROJECT</h4>
        </div>
        <div class="card-body">
            <!-- Form Tambah -->
            <form action="/siswa/simpan" method="POST" class="row g-3 mb-4">
                @csrf
                <div class="col-md-2"><input type="text" name="nis" class="form-control" placeholder="NIS" required></div>
                <div class="col-md-3"><input type="text" name="nama" class="form-control" placeholder="Nama" required></div>
                <div class="col-md-1"><input type="text" name="kelas" class="form-control" placeholder="Kelas" required></div>
                <div class="col-md-2"><input type="text" name="jurusan" class="form-control" placeholder="Jurusan" required></div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="pelajar">Pelajar</option>
                        <option value="Lulus Kuliah">Lulus Kuliah</option>
                        <option value="Lulus Kerja">Lulus Kerja</option>
                    </select>
                </div>
                <div class="col-md-2"><button type="submit" class="btn btn-primary w-100">Tambah</button></div>
            </form>

            <table class="table table-bordered table-hover">
                <thead class="table-secondary">
                    <tr>
                        <th>NIS</th><th>Nama</th><th>Kelas</th><th>Jurusan</th><th>Status</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $s)
                    <tr>
                        <td>{{ $s->nis }}</td>
                        <td>{{ $s->nama }}</td>
                        <td>{{ $s->kelas }}</td>
                        <td>{{ $s->jurusan }}</td>
                        <td><span class="badge bg-success">{{ $s->status }}</span></td>
                        <td>
                            <a href="/siswa/edit/{{ $s->id }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="/siswa/hapus/{{ $s->id }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>