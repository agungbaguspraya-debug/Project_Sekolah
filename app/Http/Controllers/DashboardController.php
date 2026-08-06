<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\PiketGuru;
use App\Models\ProfilSekolah;
use App\Models\Siswa;
use App\Models\Tugas;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKelas = Kelas::count();
        $totalJurusan = Jurusan::count();
        $totalSiswa = Siswa::count();
        $totalTugas = Tugas::count();
        $totalGuru = Guru::count();

        $user = auth()->user();
        $myPiketDashboard = collect();
        $myTugasCount = 0;
        $myPiketCount = 0;

        $siswa = null;
        $pelanggarans = collect();
        $totalPoints = 0;
        $siswaMedia = collect();

        if ($user && $user->isGuru() && $user->guru) {
            $guruId = $user->guru->id;
            $myPiketDashboard = PiketGuru::where('guru_id', $guruId)->get();
            $myPiketCount = $myPiketDashboard->count();
            $myTugasCount = Tugas::where('guru_id', $guruId)->count();
            $recentTugas = Tugas::where('guru_id', $guruId)->latest()->take(5)->get();

            // Filter teaching schedules for this teacher
            $mapelGuru = $user->guru->mata_pelajaran;
            $myJadwalQuery = JadwalPelajaran::with('guru')->where(function($q) use ($guruId, $mapelGuru) {
                $q->where('guru_id', $guruId);
                if ($mapelGuru) {
                    $q->orWhere('mata_pelajaran', 'like', '%' . $mapelGuru . '%');
                }
            });

            $totalJadwal = $myJadwalQuery->count();
            $recentJadwal = $myJadwalQuery->orderByRaw("CASE 
                WHEN hari = 'Senin' THEN 1
                WHEN hari = 'Selasa' THEN 2
                WHEN hari = 'Rabu' THEN 3
                WHEN hari = 'Kamis' THEN 4
                WHEN hari = 'Jumat' THEN 5
                ELSE 6 END")->orderBy('jam_mulai', 'asc')->take(5)->get();

        } else if ($user && $user->isSiswa() && $user->siswa) {
            $siswa = $user->siswa;
            $kelasSiswa = $siswa->kelas;
            $totalJadwal = JadwalPelajaran::where('kelas', $kelasSiswa)->count();
            
            $recentTugas = Tugas::where('kelas', $kelasSiswa)->latest()->take(5)->get();
            $recentJadwal = JadwalPelajaran::with('guru')->where('kelas', $kelasSiswa)->orderByRaw("CASE 
                WHEN hari = 'Senin' THEN 1
                WHEN hari = 'Selasa' THEN 2
                WHEN hari = 'Rabu' THEN 3
                WHEN hari = 'Kamis' THEN 4
                WHEN hari = 'Jumat' THEN 5
                ELSE 6 END")->orderBy('jam_mulai', 'asc')->take(5)->get();

            if ($siswa->status === 'Lulus') {
                $pelanggarans = $siswa->pelanggaran()->orderBy('tanggal', 'desc')->get();
                $totalPoints = $pelanggarans->sum('point');
                $siswaMedia = $siswa->media()->latest()->get();
            }

        } else {
            // Admin sees all
            $totalJadwal = JadwalPelajaran::count();
            $recentTugas = Tugas::latest()->take(5)->get();
            $recentJadwal = JadwalPelajaran::with('guru')->orderByRaw("CASE 
                WHEN hari = 'Senin' THEN 1
                WHEN hari = 'Selasa' THEN 2
                WHEN hari = 'Rabu' THEN 3
                WHEN hari = 'Kamis' THEN 4
                WHEN hari = 'Jumat' THEN 5
                ELSE 6 END")->orderBy('jam_mulai', 'asc')->take(5)->get();
        }

        // Fetch dynamic School Profile
        $profilSekolah = ProfilSekolah::first();

        return view('dashboard', compact(
            'totalKelas',
            'totalJurusan',
            'totalJadwal',
            'totalSiswa',
            'totalTugas',
            'totalGuru',
            'recentJadwal',
            'recentTugas',
            'myPiketDashboard',
            'myTugasCount',
            'myPiketCount',
            'profilSekolah',
            'siswa',
            'pelanggarans',
            'totalPoints',
            'siswaMedia'
        ));
    }
}
