<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\User;
use App\Models\ProfilSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $tab = $request->input('tab', 'aktif'); // 'aktif' or 'alumni'
        
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();

        $kelasX = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'X ') || str_starts_with($k->nama_kelas, '10 '));
        $kelasXI = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'XI ') || str_starts_with($k->nama_kelas, '11 '));
        $kelasXII = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'XII ') || str_starts_with($k->nama_kelas, '12 '));
        $kelasOther = $kelas->reject(fn($k) => 
            str_starts_with($k->nama_kelas, 'X ') || str_starts_with($k->nama_kelas, '10 ') ||
            str_starts_with($k->nama_kelas, 'XI ') || str_starts_with($k->nama_kelas, '11 ') ||
            str_starts_with($k->nama_kelas, 'XII ') || str_starts_with($k->nama_kelas, '12 ')
        );

        if ($tab === 'alumni') {
            $query = Siswa::where('status', 'Lulus');
            if ($q) {
                $query->where(function($query) use ($q) {
                    $query->where('nis', 'like', "%{$q}%")
                          ->orWhere('nama', 'like', "%{$q}%")
                          ->orWhere('kelas', 'like', "%{$q}%")
                          ->orWhere('tahun_lulus', 'like', "%{$q}%");
                });
            }
            $alumniList = $query->orderBy('tahun_lulus', 'desc')->get()->groupBy('tahun_lulus');
            return view('siswa.index', compact('alumniList', 'q', 'tab', 'kelas', 'jurusans', 'kelasX', 'kelasXI', 'kelasXII', 'kelasOther'));
        }

        // Active Students (Status !== 'Lulus')
        $query = Siswa::where('status', '!=', 'Lulus');
        if ($q) {
            $query->where(function($query) use ($q) {
                $query->where('nis', 'like', "%{$q}%")
                      ->orWhere('nama', 'like', "%{$q}%")
                      ->orWhere('kelas', 'like', "%{$q}%")
                      ->orWhere('jurusan', 'like', "%{$q}%");
            });
        }
        
        $siswa = $query->orderBy('kelas')->orderBy('nama')->get();
        return view('siswa.index', compact('siswa', 'q', 'tab', 'kelas', 'jurusans', 'kelasX', 'kelasXI', 'kelasXII', 'kelasOther'));
    }

    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();

        $kelasX = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'X ') || str_starts_with($k->nama_kelas, '10 '));
        $kelasXI = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'XI ') || str_starts_with($k->nama_kelas, '11 '));
        $kelasXII = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'XII ') || str_starts_with($k->nama_kelas, '12 '));
        $kelasOther = $kelas->reject(fn($k) => 
            str_starts_with($k->nama_kelas, 'X ') || str_starts_with($k->nama_kelas, '10 ') ||
            str_starts_with($k->nama_kelas, 'XI ') || str_starts_with($k->nama_kelas, '11 ') ||
            str_starts_with($k->nama_kelas, 'XII ') || str_starts_with($k->nama_kelas, '12 ')
        );

        return view('siswa.create', compact('kelas', 'jurusans', 'kelasX', 'kelasXI', 'kelasXII', 'kelasOther'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|unique:siswa,nis',
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string',
            'jurusan' => 'required|string',
            'foto' => 'nullable|image|max:2048',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'nullable|string|min:6'
        ]);

        $data = $request->only(['nis', 'nama', 'kelas', 'jurusan']);
        $data['status'] = 'Pelajar';

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $siswa = Siswa::create($data);

        // Create linked user account if email is provided
        if ($request->filled('email') && $request->filled('password')) {
            User::create([
                'name' => $siswa->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'siswa',
                'siswa_id' => $siswa->id
            ]);
        }

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();

        $kelasX = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'X ') || str_starts_with($k->nama_kelas, '10 '));
        $kelasXI = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'XI ') || str_starts_with($k->nama_kelas, '11 '));
        $kelasXII = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'XII ') || str_starts_with($k->nama_kelas, '12 '));
        $kelasOther = $kelas->reject(fn($k) => 
            str_starts_with($k->nama_kelas, 'X ') || str_starts_with($k->nama_kelas, '10 ') ||
            str_starts_with($k->nama_kelas, 'XI ') || str_starts_with($k->nama_kelas, '11 ') ||
            str_starts_with($k->nama_kelas, 'XII ') || str_starts_with($k->nama_kelas, '12 ')
        );

        $userAccount = $siswa->user;
        return view('siswa.edit', compact('siswa', 'kelas', 'jurusans', 'userAccount', 'kelasX', 'kelasXI', 'kelasXII', 'kelasOther'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis' => 'required|string|unique:siswa,nis,' . $siswa->id,
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string',
            'jurusan' => 'required|string',
            'foto' => 'nullable|image|max:2048',
            'email' => 'nullable|email|unique:users,email,' . ($siswa->user ? $siswa->user->id : 'NULL'),
            'password' => 'nullable|string|min:6',
            'total_nilai' => 'nullable|numeric',
            'tahun_lulus' => 'nullable|string',
            'status' => 'nullable|string'
        ]);

        $data = $request->only(['nis', 'nama', 'kelas', 'jurusan', 'total_nilai', 'tahun_lulus', 'status']);

        if ($request->hasFile('foto')) {
            if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $siswa->update($data);

        // Update or create linked user account
        if ($request->filled('email')) {
            $user = $siswa->user;
            if ($user) {
                $userUpdate = ['name' => $siswa->nama, 'email' => $request->email];
                if ($request->filled('password')) {
                    $userUpdate['password'] = Hash::make($request->password);
                }
                $user->update($userUpdate);
            } else if ($request->filled('password')) {
                User::create([
                    'name' => $siswa->nama,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'siswa',
                    'siswa_id' => $siswa->id
                ]);
            }
        }

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
            Storage::disk('public')->delete($siswa->foto);
        }

        if ($siswa->user) {
            $siswa->user->delete();
        } else {
            $siswa->delete();
        }

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    // Bulk Naik Kelas / Kenaikan Kelas Siswa
    public function naikKelas(Request $request)
    {
        $request->validate([
            'kelas_asal' => 'required|string',
            'kelas_tujuan' => 'required|string',
        ]);

        $kelasAsal = $request->kelas_asal;
        $kelasTujuan = $request->kelas_tujuan;

        if ($kelasTujuan === 'LULUS' || $kelasTujuan === 'LULUSKAN') {
            Siswa::where('kelas', $kelasAsal)->update([
                'status' => 'Lulus',
                'tahun_lulus' => date('Y'),
                'status_kenaikan' => 'Lulus',
                'pesan_kenaikan' => 'Selamat! Anda dinyatakan LULUS dari sekolah.'
            ]);
            return redirect()->route('siswa.index')->with('success', "Seluruh siswa kelas {$kelasAsal} berhasil diluluskan.");
        }

        Siswa::where('kelas', $kelasAsal)->update([
            'kelas' => $kelasTujuan,
            'status_kenaikan' => 'Naik Kelas',
            'pesan_kenaikan' => "Selamat! Anda telah NAIK KELAS ke {$kelasTujuan}."
        ]);

        return redirect()->route('siswa.index')->with('success', "Siswa kelas {$kelasAsal} berhasil dinaikkan ke kelas {$kelasTujuan}.");
    }

    // Process Graduation / Luluskan Siswa
    public function luluskan(Request $request)
    {
        $request->validate([
            'siswa_id' => 'nullable|exists:siswa,id',
            'kelas_asal' => 'nullable|string',
            'tahun_lulus' => 'required|string',
            'total_nilai' => 'nullable|numeric',
        ]);

        $tahunLulus = $request->tahun_lulus;
        $totalNilai = $request->total_nilai ?? 85.00;

        if ($request->kelas_asal === 'SEMUA_KELAS_12') {
            $count = Siswa::where('status', '!=', 'Lulus')
                ->where(function($q) {
                    $q->where('kelas', 'like', 'XII %')
                      ->orWhere('kelas', 'like', '12 %')
                      ->orWhere('kelas', 'XII')
                      ->orWhere('kelas', '12');
                })
                ->update([
                    'status' => 'Lulus',
                    'tahun_lulus' => $tahunLulus,
                    'total_nilai' => $totalNilai,
                    'status_kenaikan' => 'Lulus',
                    'pesan_kenaikan' => 'Selamat! Anda telah resmi LULUS dari sekolah.'
                ]);

            return redirect()->back()->with('success', "Seluruh siswa kelas 12 ({$count} siswa) berhasil dinyatakan LULUS (Tahun {$tahunLulus}).");
        }

        if ($request->filled('siswa_id')) {
            $siswa = Siswa::findOrFail($request->siswa_id);
            $siswa->update([
                'status' => 'Lulus',
                'tahun_lulus' => $tahunLulus,
                'total_nilai' => $request->total_nilai ?? $siswa->total_nilai ?? 85.00,
                'status_kenaikan' => 'Lulus',
                'pesan_kenaikan' => 'Selamat! Anda telah resmi LULUS dari sekolah.'
            ]);
            return redirect()->back()->with('success', "Siswa {$siswa->nama} berhasil dinyatakan LULUS (Tahun {$tahunLulus}).");
        }

        if ($request->filled('kelas_asal')) {
            $count = Siswa::where('kelas', $request->kelas_asal)->update([
                'status' => 'Lulus',
                'tahun_lulus' => $tahunLulus,
                'total_nilai' => $totalNilai,
                'status_kenaikan' => 'Lulus',
                'pesan_kenaikan' => 'Selamat! Anda telah resmi LULUS dari sekolah.'
            ]);
            return redirect()->back()->with('success', "Seluruh siswa kelas {$request->kelas_asal} ({$count} siswa) berhasil dinyatakan LULUS (Tahun {$tahunLulus}).");
        }

        return redirect()->back()->with('error', 'Pilih kelas atau siswa yang akan diluluskan.');
    }

    // Student Upload Foto Kenangan
    public function uploadFotoKenangan(Request $request)
    {
        $request->validate([
            'foto_kenangan' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $siswa = auth()->user()->siswa;
        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        if ($request->hasFile('foto_kenangan')) {
            if ($siswa->foto_kenangan && Storage::disk('public')->exists($siswa->foto_kenangan)) {
                Storage::disk('public')->delete($siswa->foto_kenangan);
            }
            $path = $request->file('foto_kenangan')->store('siswa/kenangan', 'public');
            $siswa->update(['foto_kenangan' => $path]);
        }

        return redirect()->back()->with('success', 'Foto kenangan kelulusan berhasil diunggah.');
    }

    // Upload Multiple Photos or Videos for Alumni Album (>10 files)
    public function uploadMediaKenangan(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:jpeg,png,jpg,gif,webp,mp4,mov,avi,mkv,webm|max:51200',
            'caption' => 'nullable|string|max:255',
        ]);

        $siswa = auth()->user()->siswa;
        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        if ($request->hasFile('files')) {
            $uploadedCount = 0;
            foreach ($request->file('files') as $file) {
                $mime = $file->getMimeType();
                $isVid = str_contains($mime, 'video');
                $type = $isVid ? 'video' : 'image';
                $folder = $isVid ? 'siswa/kenangan_videos' : 'siswa/kenangan_photos';

                $path = $file->store($folder, 'public');

                \App\Models\SiswaMedia::create([
                    'siswa_id' => $siswa->id,
                    'file_path' => $path,
                    'file_type' => $type,
                    'caption' => $request->caption,
                ]);
                $uploadedCount++;
            }

            return redirect()->back()->with('success', "{$uploadedCount} berkas foto/video kenangan berhasil diunggah.");
        }

        return redirect()->back()->with('error', 'Tidak ada berkas yang dipilih.');
    }

    // Delete a specific media item from alumni album
    public function deleteMediaKenangan($id)
    {
        $siswa = auth()->user()->siswa;
        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $media = \App\Models\SiswaMedia::where('siswa_id', $siswa->id)->findOrFail($id);

        if ($media->file_path && Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }

        $media->delete();

        return redirect()->back()->with('success', 'Berkas foto/video kenangan berhasil dihapus.');
    }

    public function profile()
    {
        $user = auth()->user();
        $siswa = $user->siswa;
        
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Akun Anda tidak memiliki data siswa terkait.');
        }

        $profilSekolah = ProfilSekolah::first();
        $pelanggarans = $siswa->pelanggaran()->orderBy('tanggal', 'desc')->get();
        $totalPoints = $pelanggarans->sum('point');

        // Fetch Schedule for student's class with teacher info
        $jadwals = \App\Models\JadwalPelajaran::with('guru')
            ->where('kelas', $siswa->kelas)
            ->orderByRaw("CASE 
                WHEN hari = 'Senin' THEN 1
                WHEN hari = 'Selasa' THEN 2
                WHEN hari = 'Rabu' THEN 3
                WHEN hari = 'Kamis' THEN 4
                WHEN hari = 'Jumat' THEN 5
                ELSE 6 END")
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        // Fetch Assignments for student's class
        $tugas = \App\Models\Tugas::where('kelas', $siswa->kelas)
            ->orderBy('deadline', 'asc')
            ->get();

        // Fetch Submissions of this student
        $submissions = \App\Models\TugasSubmission::where('siswa_id', $siswa->id)
            ->get()
            ->keyBy('tugas_id');

        return view('siswa.profile', compact('siswa', 'profilSekolah', 'pelanggarans', 'totalPoints', 'jadwals', 'tugas', 'submissions'));
    }

    public function jadwal()
    {
        $user = auth()->user();
        $siswa = $user->siswa;

        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Akun Anda tidak memiliki data siswa terkait.');
        }

        if ($siswa->status === 'Lulus') {
            return redirect()->route('dashboard')->with('error', 'Siswa yang telah lulus tidak memiliki jadwal pelajaran aktif.');
        }

        $jadwals = \App\Models\JadwalPelajaran::with('guru')
            ->where('kelas', $siswa->kelas)
            ->orderByRaw("CASE 
                WHEN hari = 'Senin' THEN 1
                WHEN hari = 'Selasa' THEN 2
                WHEN hari = 'Rabu' THEN 3
                WHEN hari = 'Kamis' THEN 4
                WHEN hari = 'Jumat' THEN 5
                ELSE 6 END")
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        return view('siswa.jadwal', compact('siswa', 'jadwals'));
    }

    public function tugas()
    {
        $user = auth()->user();
        $siswa = $user->siswa;

        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Akun Anda tidak memiliki data siswa terkait.');
        }

        if ($siswa->status === 'Lulus') {
            return redirect()->route('dashboard')->with('error', 'Siswa yang telah lulus tidak memiliki tugas sekolah aktif.');
        }

        $tugas = \App\Models\Tugas::with('guru')
            ->where('kelas', $siswa->kelas)
            ->orderBy('deadline', 'asc')
            ->get();

        $submissions = \App\Models\TugasSubmission::where('siswa_id', $siswa->id)
            ->get()
            ->keyBy('tugas_id');

        return view('siswa.tugas', compact('siswa', 'tugas', 'submissions'));
    }
}
