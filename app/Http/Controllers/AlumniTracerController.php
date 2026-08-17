<?php

namespace App\Http\Controllers;

use App\Models\AlumniTracer;
use App\Models\Siswa;
use Illuminate\Http\Request;

class AlumniTracerController extends Controller
{
    // Student Store/Update Alumni Tracer Info (For Graduated Students)
    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user->isSiswa() || !$user->siswa || $user->siswa->status !== 'Lulus') {
            return redirect()->back()->with('error', 'Fitur ini khusus untuk siswa yang telah lulus.');
        }

        $request->validate([
            'status_alumni' => 'required|in:Kuliah,Bekerja,Kuliah & Bekerja,Wirausaha,Mencari Kerja',
            'nama_instansi' => 'required|string|max:255',
            'jurusan_atau_jabatan' => 'nullable|string|max:255',
            'tahun_masuk' => 'nullable|string|max:50',
            'lokasi' => 'nullable|string|max:255',
            'catatan' => 'nullable|string|max:1000',
        ]);

        AlumniTracer::create([
            'siswa_id' => $user->siswa->id,
            'status_alumni' => $request->status_alumni,
            'nama_instansi' => $request->nama_instansi,
            'jurusan_atau_jabatan' => $request->jurusan_atau_jabatan,
            'tahun_masuk' => $request->tahun_masuk ?? date('Y'),
            'lokasi' => $request->lokasi,
            'catatan' => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Data jejak alumni (karir/kuliah) Anda berhasil disimpan dan masuk ke laporan Admin!');
    }

    // Admin View All Alumni Tracer Records
    public function adminIndex(Request $request)
    {
        $statusFilter = $request->input('status', '');
        $tahunFilter = $request->input('tahun', '');

        $query = AlumniTracer::with('siswa');

        if ($statusFilter) {
            $query->where('status_alumni', $statusFilter);
        }

        if ($tahunFilter) {
            $query->whereHas('siswa', function($q) use ($tahunFilter) {
                $q->where('tahun_lulus', $tahunFilter);
            });
        }

        $tracers = $query->orderBy('created_at', 'desc')->get();
        $alumniList = Siswa::where('status', 'Lulus')->orderBy('tahun_lulus', 'desc')->orderBy('nama')->get();

        $totalAlumni = $alumniList->count();
        $totalKuliah = AlumniTracer::whereIn('status_alumni', ['Kuliah', 'Kuliah & Bekerja'])->count();
        $totalBekerja = AlumniTracer::whereIn('status_alumni', ['Bekerja', 'Kuliah & Bekerja'])->count();
        $totalWirausaha = AlumniTracer::where('status_alumni', 'Wirausaha')->count();

        return view('admin.alumni.index', compact(
            'tracers', 'alumniList', 'statusFilter', 'tahunFilter',
            'totalAlumni', 'totalKuliah', 'totalBekerja', 'totalWirausaha'
        ));
    }

    // Admin Delete Alumni Tracer Entry
    public function destroy(AlumniTracer $alumniTracer)
    {
        $alumniTracer->delete();
        return redirect()->back()->with('success', 'Data jejak alumni berhasil dihapus.');
    }
}
