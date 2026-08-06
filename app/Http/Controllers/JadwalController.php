<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Guru;
use App\Models\JadwalPelajaran;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $gurus = Guru::orderBy('nama')->get();

        $query = JadwalPelajaran::with('guru')->orderBy('jam_mulai', 'asc');

        $jadwalsByKelas = collect();
        $jadwals = collect();

        // If user is a Teacher, filter teaching schedule for their ID or subject
        if ($user->isGuru() && $user->guru) {
            $guruId = $user->guru->id;
            $mapelGuru = $user->guru->mata_pelajaran;

            $query->where(function($q) use ($guruId, $mapelGuru) {
                $q->where('guru_id', $guruId);
                if ($mapelGuru) {
                    $q->orWhere('mata_pelajaran', 'like', '%' . $mapelGuru . '%');
                }
            });

            $jadwals = $query->orderByRaw("CASE 
                    WHEN hari = 'Senin' THEN 1
                    WHEN hari = 'Selasa' THEN 2
                    WHEN hari = 'Rabu' THEN 3
                    WHEN hari = 'Kamis' THEN 4
                    WHEN hari = 'Jumat' THEN 5
                    ELSE 6 END")
                ->orderBy('jam_mulai', 'asc')
                ->get()
                ->groupBy('hari');

        } else if ($user->isSiswa() && $user->siswa) {
            if ($user->siswa->status === 'Lulus') {
                return redirect()->route('dashboard')->with('error', 'Siswa yang telah lulus tidak memiliki jadwal pelajaran aktif.');
            }
            // Siswa sees schedule for their class grouped by day, sorted by earliest time
            $jadwals = $query->where('kelas', $user->siswa->kelas)
                ->orderByRaw("CASE 
                    WHEN hari = 'Senin' THEN 1
                    WHEN hari = 'Selasa' THEN 2
                    WHEN hari = 'Rabu' THEN 3
                    WHEN hari = 'Kamis' THEN 4
                    WHEN hari = 'Jumat' THEN 5
                    ELSE 6 END")
                ->orderBy('jam_mulai', 'asc')
                ->get()
                ->groupBy('hari');

        } else {
            // Admin view:
            $selectedKelas = $request->input('filter_kelas');
            if ($selectedKelas) {
                // Specific class filtered: group by day, sorted by time ASC
                $jadwals = $query->where('kelas', $selectedKelas)
                    ->orderByRaw("CASE 
                        WHEN hari = 'Senin' THEN 1
                        WHEN hari = 'Selasa' THEN 2
                        WHEN hari = 'Rabu' THEN 3
                        WHEN hari = 'Kamis' THEN 4
                        WHEN hari = 'Jumat' THEN 5
                        ELSE 6 END")
                    ->orderBy('jam_mulai', 'asc')
                    ->get()
                    ->groupBy('hari');
            } else {
                // "Semua Kelas" selected: group by class first, then items inside are sorted by day and time ASC
                $allJadwals = $query->orderBy('kelas')
                    ->orderByRaw("CASE 
                        WHEN hari = 'Senin' THEN 1
                        WHEN hari = 'Selasa' THEN 2
                        WHEN hari = 'Rabu' THEN 3
                        WHEN hari = 'Kamis' THEN 4
                        WHEN hari = 'Jumat' THEN 5
                        ELSE 6 END")
                    ->orderBy('jam_mulai', 'asc')
                    ->get();
                $jadwalsByKelas = $allJadwals->groupBy('kelas');
            }
        }

        $kelasX = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'X ') || str_starts_with($k->nama_kelas, '10 '));
        $kelasXI = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'XI ') || str_starts_with($k->nama_kelas, '11 '));
        $kelasXII = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'XII ') || str_starts_with($k->nama_kelas, '12 '));
        $kelasOther = $kelas->reject(fn($k) => 
            str_starts_with($k->nama_kelas, 'X ') || str_starts_with($k->nama_kelas, '10 ') ||
            str_starts_with($k->nama_kelas, 'XI ') || str_starts_with($k->nama_kelas, '11 ') ||
            str_starts_with($k->nama_kelas, 'XII ') || str_starts_with($k->nama_kelas, '12 ')
        );

        return view('jadwal.index', compact('kelas', 'gurus', 'jadwals', 'jadwalsByKelas', 'kelasX', 'kelasXI', 'kelasXII', 'kelasOther'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas' => 'required|string',
            'guru_id' => 'nullable|exists:gurus,id',
            'hari' => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'mata_pelajaran' => 'required|string|max:255',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'sesi' => 'nullable|string|in:Pagi,Siang,Sore',
        ]);

        $data = $request->all();
        
        $jamMulai = date('H:i:s', strtotime($request->jam_mulai));
        $jamSelesai = date('H:i:s', strtotime($request->jam_selesai));

        // If jam_selesai is earlier than jam_mulai (e.g. 13:40 - 02:44), fix 12-hour offset
        if (strtotime($jamSelesai) < strtotime($jamMulai)) {
            $jamSelesai = date('H:i:s', strtotime($jamSelesai) + (12 * 3600));
        }

        $data['jam_mulai'] = $jamMulai;
        $data['jam_selesai'] = $jamSelesai;

        if (empty($data['sesi'])) {
            $hour = (int)date('H', strtotime($jamMulai));
            $data['sesi'] = $hour < 11 ? 'Pagi' : 'Siang';
        }

        JadwalPelajaran::create($data);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal pelajaran berhasil ditambahkan.');
    }

    public function destroy(JadwalPelajaran $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal pelajaran berhasil dihapus.');
    }
}
