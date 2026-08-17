<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\IzinGuru;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IzinGuruController extends Controller
{
    // Teacher View & Submit Leave Requests
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.izin.index');
        }

        if (!$user->isGuru() || !$user->guru) {
            return redirect()->route('dashboard')->with('error', 'Akun Anda tidak terhubung dengan data guru.');
        }

        $guru = $user->guru;
        $myIzinList = IzinGuru::with(['guruPengganti', 'tugas'])
            ->where('guru_id', $guru->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $today = date('Y-m-d');
        $activeApprovedIzin = IzinGuru::with(['guruPengganti', 'tugas'])
            ->where('guru_id', $guru->id)
            ->where('status', 'Disetujui')
            ->where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->first();

        $pendingIzinCount = IzinGuru::where('guru_id', $guru->id)
            ->where('status', 'Pending')
            ->count();

        // Fetch substitute duties assigned to this teacher by Admin
        $mySubstituteDutiesAll = IzinGuru::with(['guru', 'guruPengganti', 'tugas'])
            ->where('guru_pengganti_id', $guru->id)
            ->where('status', 'Disetujui')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        // Fetch existing assignments created by this teacher
        $existingTugas = \App\Models\Tugas::where('guru_id', $guru->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetch list of classes
        $kelases = \App\Models\Kelas::orderBy('nama_kelas')->get();

        return view('guru.izin.index', compact('guru', 'myIzinList', 'activeApprovedIzin', 'pendingIzinCount', 'existingTugas', 'kelases', 'mySubstituteDutiesAll'));
    }

    // Teacher Store Leave Request
    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user->isGuru() || !$user->guru) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'jenis' => 'required|in:Izin,Sakit',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:1000',
            'tugas_mode' => 'nullable|in:none,existing,new',
            'tugas_id' => 'nullable|exists:tugas,id',
            'judul_tugas' => 'nullable|string|max:255',
            'kelas_tugas' => 'nullable|string|max:50',
            'deskripsi_tugas' => 'nullable|string|max:1000',
            'deadline_tugas' => 'nullable|date',
            'tugas_siswa' => 'nullable|string|max:1000',
        ]);

        $start = Carbon::parse($request->tanggal_mulai);
        $end = Carbon::parse($request->tanggal_selesai);
        $jumlahHari = $start->diffInDays($end) + 1;

        $tugasId = null;

        // Option A: Linked to an existing Tugas
        if ($request->tugas_mode === 'existing' && $request->tugas_id) {
            $tugasId = $request->tugas_id;
            $tugasModel = \App\Models\Tugas::find($tugasId);
            $requestTugasText = $tugasModel ? "Tugas Terhubung: {$tugasModel->judul} (Kelas {$tugasModel->kelas})" : $request->tugas_siswa;
        } 
        // Option B: Auto-create a NEW Tugas for students
        elseif ($request->tugas_mode === 'new' && $request->judul_tugas) {
            $deadline = $request->deadline_tugas 
                ? Carbon::parse($request->deadline_tugas)->format('Y-m-d H:i:s') 
                : Carbon::parse($request->tanggal_selesai)->format('Y-m-d') . ' 23:59:00';

            $newTugas = \App\Models\Tugas::create([
                'guru_id' => $user->guru->id,
                'kelas' => $request->kelas_tugas ?? ($user->guru->jadwal->first()?->kelas ?? 'Semua Kelas'),
                'mata_pelajaran' => $user->guru->mata_pelajaran ?? 'Mata Pelajaran',
                'judul' => $request->judul_tugas,
                'deskripsi' => $request->deskripsi_tugas ?? "Tugas Pengganti karena Guru sedang {$request->jenis}. Alasan: {$request->alasan}",
                'deadline' => $deadline,
            ]);
            $tugasId = $newTugas->id;
            $requestTugasText = "Tugas Baru Dibuat: {$newTugas->judul} (Kelas {$newTugas->kelas})";
        } 
        else {
            $requestTugasText = $request->tugas_siswa;
        }

        IzinGuru::create([
            'guru_id' => $user->guru->id,
            'jenis' => $request->jenis,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jumlah_hari' => $jumlahHari,
            'alasan' => $request->alasan,
            'tugas_id' => $tugasId,
            'tugas_siswa' => $requestTugasText,
            'minta_guru_pengganti' => true,
            'status' => 'Pending',
        ]);

        return redirect()->route('guru.izin.index')->with('success', "Pengajuan {$request->jenis} selama {$jumlahHari} hari beserta tugas siswa berhasil dikirim ke Admin untuk ACC.");
    }

    // Admin View All Leave Requests
    public function adminIndex(Request $request)
    {
        $statusFilter = $request->input('status', '');
        $query = IzinGuru::with(['guru', 'guruPengganti', 'tugas']);

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        $izinList = $query->orderBy('created_at', 'desc')->get();
        $gurus = Guru::orderBy('nama')->get();

        $pendingCount = IzinGuru::where('status', 'Pending')->count();
        $approvedCount = IzinGuru::where('status', 'Disetujui')->count();
        $rejectedCount = IzinGuru::where('status', 'Ditolak')->count();

        return view('admin.izin.index', compact('izinList', 'gurus', 'statusFilter', 'pendingCount', 'approvedCount', 'rejectedCount'));
    }

    // Admin Approve (ACC) Leave Request & Assign Substitute Teacher
    public function approve(Request $request, IzinGuru $izinGuru)
    {
        $request->validate([
            'guru_pengganti_id' => 'nullable|exists:gurus,id',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $izinGuru->update([
            'status' => 'Disetujui',
            'guru_pengganti_id' => $request->guru_pengganti_id,
            'catatan_admin' => $request->catatan_admin,
        ]);

        $guruNama = $izinGuru->guru ? $izinGuru->guru->nama : 'Guru';
        return redirect()->back()->with('success', "Pengajuan izin/sakit {$guruNama} ({$izinGuru->jumlah_hari} hari) berhasil DISETUJUI (ACC). Guru pengganti telah ditugaskan.");
    }

    // Admin Reject Leave Request
    public function reject(Request $request, IzinGuru $izinGuru)
    {
        $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $izinGuru->update([
            'status' => 'Ditolak',
            'catatan_admin' => $request->catatan_admin,
        ]);

        $guruNama = $izinGuru->guru ? $izinGuru->guru->nama : 'Guru';
        return redirect()->back()->with('success', "Pengajuan izin/sakit {$guruNama} telah DITOLAK.");
    }

    // Cancel / Delete Pending Leave Request
    public function destroy(IzinGuru $izinGuru)
    {
        $user = auth()->user();
        if ($user->isGuru() && $user->guru && $izinGuru->guru_id !== $user->guru->id) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $izinGuru->delete();
        return redirect()->back()->with('success', 'Pengajuan izin/sakit berhasil dibatalkan.');
    }
}
