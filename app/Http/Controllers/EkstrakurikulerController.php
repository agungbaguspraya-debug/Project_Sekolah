<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Models\PendaftaranEkskul;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EkstrakurikulerController extends Controller
{
    // Admin View All Extracurriculars & Student Registrations
    public function index(Request $request)
    {
        $ekskuls = Ekstrakurikuler::withCount(['pendaftaran as total_pendaftar' => function($q) {
            $q->where('status', 'Disetujui');
        }])->orderBy('nama_ekskul')->get();

        $statusFilter = $request->input('status', '');
        $query = PendaftaranEkskul::with(['siswa', 'ekstrakurikuler']);

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        $pendaftarans = $query->orderBy('created_at', 'desc')->get();

        $pendingCount = PendaftaranEkskul::where('status', 'Pending')->count();
        $approvedCount = PendaftaranEkskul::where('status', 'Disetujui')->count();
        $rejectedCount = PendaftaranEkskul::where('status', 'Ditolak')->count();

        return view('admin.ekskul.index', compact(
            'ekskuls', 'pendaftarans', 'statusFilter', 'pendingCount', 'approvedCount', 'rejectedCount'
        ));
    }

    // Admin Store Extracurricular
    public function store(Request $request)
    {
        $request->validate([
            'nama_ekskul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'pembina' => 'nullable|string|max:255',
            'hari_latihan' => 'nullable|string|max:100',
            'jam_latihan' => 'nullable|string|max:100',
            'lokasi' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3072',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('ekskul', 'public');
        }

        Ekstrakurikuler::create([
            'nama_ekskul' => $request->nama_ekskul,
            'kategori' => $request->kategori,
            'pembina' => $request->pembina,
            'hari_latihan' => $request->hari_latihan,
            'jam_latihan' => $request->jam_latihan,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
        ]);

        return redirect()->back()->with('success', 'Ekstrakurikuler berhasil ditambahkan!');
    }

    // Admin Update Extracurricular Details
    public function update(Request $request, Ekstrakurikuler $ekskul)
    {
        $request->validate([
            'nama_ekskul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'pembina' => 'nullable|string|max:255',
            'hari_latihan' => 'nullable|string|max:100',
            'jam_latihan' => 'nullable|string|max:100',
            'lokasi' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3072',
        ]);

        $data = [
            'nama_ekskul' => $request->nama_ekskul,
            'kategori' => $request->kategori,
            'pembina' => $request->pembina,
            'hari_latihan' => $request->hari_latihan,
            'jam_latihan' => $request->jam_latihan,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('foto')) {
            if ($ekskul->foto) {
                Storage::disk('public')->delete($ekskul->foto);
            }
            $data['foto'] = $request->file('foto')->store('ekskul', 'public');
        }

        $ekskul->update($data);

        return redirect()->back()->with('success', "Informasi ekstrakurikuler {$ekskul->nama_ekskul} (Pembina & Jadwal) berhasil diperbarui.");
    }

    // Admin Delete Extracurricular
    public function destroy(Ekstrakurikuler $ekskul)
    {
        if ($ekskul->foto) {
            Storage::disk('public')->delete($ekskul->foto);
        }
        $ekskul->delete();

        return redirect()->back()->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }

    // Admin Approve (ACC) Student Registration
    public function approveRegistration(Request $request, PendaftaranEkskul $pendaftaran)
    {
        $pendaftaran->update([
            'status' => 'Disetujui',
            'catatan_admin' => $request->catatan_admin ?? 'Selamat, pendaftaran Anda disetujui Admin!',
        ]);

        $siswaNama = $pendaftaran->siswa ? $pendaftaran->siswa->nama : 'Siswa';
        $ekskulNama = $pendaftaran->ekstrakurikuler ? $pendaftaran->ekstrakurikuler->nama_ekskul : 'Ekskul';

        return redirect()->back()->with('success', "Pendaftaran ekskul {$ekskulNama} untuk siswa {$siswaNama} berhasil DISETUJUI (ACC).");
    }

    // Admin Reject Student Registration
    public function rejectRegistration(Request $request, PendaftaranEkskul $pendaftaran)
    {
        $pendaftaran->update([
            'status' => 'Ditolak',
            'catatan_admin' => $request->catatan_admin ?? 'Maaf, pendaftaran ekskul ditolak.',
        ]);

        $siswaNama = $pendaftaran->siswa ? $pendaftaran->siswa->nama : 'Siswa';
        return redirect()->back()->with('success', "Pendaftaran ekskul siswa {$siswaNama} telah DITOLAK. Siswa dapat mendaftar ekskul lain.");
    }

    // Student View Ekstrakurikuler Page (/siswa/ekskul)
    public function siswaIndex()
    {
        $user = auth()->user();
        if (!$user->isSiswa() || !$user->siswa) {
            return redirect()->route('dashboard')->with('error', 'Akses khusus portal siswa.');
        }

        $siswa = $user->siswa;
        $kelas = $siswa->kelas;
        $isKelas10 = str_starts_with($kelas, 'X ') || str_starts_with($kelas, '10 ');

        $ekskuls = Ekstrakurikuler::orderBy('nama_ekskul')->get();
        $myRegistrations = PendaftaranEkskul::with('ekstrakurikuler')
            ->where('siswa_id', $siswa->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $activeApproved = $myRegistrations->where('status', 'Disetujui')->first();
        $activePending = $myRegistrations->where('status', 'Pending')->first();
        $lastRejected = $myRegistrations->where('status', 'Ditolak')->first();

        return view('siswa.ekskul', compact(
            'siswa', 'isKelas10', 'ekskuls', 'myRegistrations', 'activeApproved', 'activePending', 'lastRejected'
        ));
    }

    // Student Grade 10 Submit Registration
    public function register(Request $request)
    {
        $user = auth()->user();
        if (!$user->isSiswa() || !$user->siswa) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $siswa = $user->siswa;
        $kelas = $siswa->kelas;
        $isKelas10 = str_starts_with($kelas, 'X ') || str_starts_with($kelas, '10 ');

        if (!$isKelas10) {
            return redirect()->back()->with('error', 'Pendaftaran ekstrakurikuler baru khusus dibuka untuk siswa Kelas 10 (Tingkat X).');
        }

        $request->validate([
            'ekstrakurikuler_id' => 'required|exists:ekstrakurikulers,id',
            'alasan_bergabung' => 'nullable|string|max:1000',
        ]);

        // Check active registration
        $activeReg = PendaftaranEkskul::where('siswa_id', $siswa->id)
            ->whereIn('status', ['Pending', 'Disetujui'])
            ->first();

        if ($activeReg) {
            $statusText = $activeReg->status === 'Disetujui' ? 'disetujui' : 'sedang diproses (pending)';
            return redirect()->back()->with('error', "Anda sudah memiliki pendaftaran ekskul yang {$statusText} ({$activeReg->ekstrakurikuler->nama_ekskul}).");
        }

        $ekskul = Ekstrakurikuler::findOrFail($request->ekstrakurikuler_id);

        PendaftaranEkskul::create([
            'siswa_id' => $siswa->id,
            'ekstrakurikuler_id' => $ekskul->id,
            'alasan_bergabung' => $request->alasan_bergabung,
            'status' => 'Pending',
        ]);

        return redirect()->back()->with('success', "Pendaftaran ekskul {$ekskul->nama_ekskul} berhasil dikirim! Silakan menunggu persetujuan (ACC) dari Admin.");
    }
}
