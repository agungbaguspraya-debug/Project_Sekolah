<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tugas;
use App\Models\TugasSubmission;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    // List assignments
    public function index()
    {
        $user = auth()->user();
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $jadwals = JadwalPelajaran::all();
        $submissions = collect();

        if ($user->isGuru() && $user->guru) {
            $tugas = Tugas::with('guru')
                ->where('guru_id', $user->guru->id)
                ->orderBy('deadline', 'asc')
                ->get();
        } else if ($user->isSiswa() && $user->siswa) {
            if ($user->siswa->status === 'Lulus') {
                return redirect()->route('dashboard')->with('error', 'Siswa yang telah lulus tidak memiliki tugas sekolah aktif.');
            }
            $tugas = Tugas::with('guru')
                ->where('kelas', $user->siswa->kelas)
                ->orderBy('deadline', 'asc')
                ->get();

            $submissions = TugasSubmission::where('siswa_id', $user->siswa->id)
                ->get()
                ->keyBy('tugas_id');
        } else {
            $tugas = Tugas::with('guru')->orderBy('deadline', 'asc')->get();
        }

        $kelasX = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'X ') || str_starts_with($k->nama_kelas, '10 '));
        $kelasXI = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'XI ') || str_starts_with($k->nama_kelas, '11 '));
        $kelasXII = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'XII ') || str_starts_with($k->nama_kelas, '12 '));
        $kelasOther = $kelas->reject(fn($k) => 
            str_starts_with($k->nama_kelas, 'X ') || str_starts_with($k->nama_kelas, '10 ') ||
            str_starts_with($k->nama_kelas, 'XI ') || str_starts_with($k->nama_kelas, '11 ') ||
            str_starts_with($k->nama_kelas, 'XII ') || str_starts_with($k->nama_kelas, '12 ')
        );

        return view('tugas.index', compact('kelas', 'jadwals', 'tugas', 'submissions', 'kelasX', 'kelasXII', 'kelasXI', 'kelasOther'));
    }

    // Create assignment
    public function store(Request $request)
    {
        if ($request->filled('deadline_date') && $request->filled('deadline_time')) {
            $request->merge(['deadline' => $request->deadline_date . ' ' . $request->deadline_time]);
        }

        $request->validate([
            'kelas' => 'required|string',
            'mata_pelajaran' => 'required|string',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'deadline' => 'required|date',
        ]);

        $data = $request->only(['kelas', 'mata_pelajaran', 'judul', 'deskripsi', 'deadline']);

        $user = auth()->user();
        if ($user->isGuru() && $user->guru) {
            $data['guru_id'] = $user->guru->id;
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('tugas_foto', 'public');
        }

        Tugas::create($data);

        return redirect()->route('tugas.index')->with('success', 'Tugas baru berhasil dibuat dan dikirim ke kelas ' . $request->kelas . '.');
    }

    // Delete assignment
    public function destroy(Tugas $tuga)
    {
        $tuga->delete();
        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus.');
    }

    // View submission details
    public function submissions(Tugas $tuga)
    {
        // Get all students in the assigned class
        $students = Siswa::where('kelas', $tuga->kelas)->orderBy('nama')->get();

        // Get submissions indexed by student ID
        $submissions = $tuga->submissions->keyBy('siswa_id');

        return view('tugas.submissions', compact('tuga', 'students', 'submissions'));
    }

    // Student submit assignment
    public function submit(Request $request, Tugas $tugas)
    {
        $request->validate([
            'catatan' => 'nullable|string',
            'file' => 'nullable|file|max:5120',
        ]);

        $siswa = auth()->user()->siswa;
        if (!$siswa) {
            return redirect()->back()->with('error', 'Akun Anda tidak memiliki data siswa terkait.');
        }

        $data = [
            'tugas_id' => $tugas->id,
            'siswa_id' => $siswa->id,
            'catatan' => $request->catatan,
            'dikumpulkan_pada' => now(),
        ];

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('siswa/tugas', 'public');
        }

        TugasSubmission::updateOrCreate(
            ['tugas_id' => $tugas->id, 'siswa_id' => $siswa->id],
            $data
        );

        return redirect()->back()->with('success', 'Tugas berhasil dikumpulkan.');
    }

    // Dedicated review page for examining student submission work & grading
    public function review(TugasSubmission $submission)
    {
        $submission->load(['tugas.guru', 'siswa']);
        $tuga = $submission->tugas;
        $siswa = $submission->siswa;

        return view('tugas.review', compact('submission', 'tuga', 'siswa'));
    }

    // Teacher grade & respond to student submission
    public function grade(Request $request, TugasSubmission $submission)
    {
        $request->validate([
            'nilai' => 'required|integer|min:0|max:100',
            'respon_guru' => 'nullable|string',
        ], [
            'nilai.required' => 'Nilai wajib diisi (0 - 100).',
            'nilai.integer' => 'Nilai harus berupa angka (0 - 100).',
            'nilai.min' => 'Nilai minimal 0.',
            'nilai.max' => 'Nilai maksimal 100.',
        ]);

        $submission->update([
            'nilai' => $request->nilai,
            'respon_guru' => $request->respon_guru,
        ]);

        return redirect()->route('tugas.submissions', $submission->tugas_id)->with('success', 'Nilai (' . $request->nilai . ') dan respon guru berhasil disimpan untuk ' . ($submission->siswa->nama ?? 'siswa') . '.');
    }
}
