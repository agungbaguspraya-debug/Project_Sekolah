<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\ProfilSekolah;
use App\Models\Siswa;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user->isGuru() && $user->guru) {
            $guruId = $user->guru->id;
            $teachingClasses = \App\Models\JadwalPelajaran::where('guru_id', $guruId)->pluck('kelas');
            $substituteTugasIds = \App\Models\IzinGuru::where('guru_pengganti_id', $guruId)
                ->where('status', 'Disetujui')
                ->whereNotNull('tugas_id')
                ->pluck('tugas_id');
            $substituteClasses = \App\Models\Tugas::whereIn('id', $substituteTugasIds)->pluck('kelas');

            $allowedKelasNames = $teachingClasses->merge($substituteClasses)->unique();
            $kelas = Kelas::whereIn('nama_kelas', $allowedKelasNames)->orderBy('nama_kelas')->get();
        } else {
            $kelas = Kelas::orderBy('nama_kelas')->get();
        }

        $selectedKelas = $request->input('kelas', $kelas->first()?->nama_kelas ?? '');
        $tanggal = $request->input('tanggal', date('Y-m-d'));

        $kelasX = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'X ') || str_starts_with($k->nama_kelas, '10 '));
        $kelasXI = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'XI ') || str_starts_with($k->nama_kelas, '11 '));
        $kelasXII = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'XII ') || str_starts_with($k->nama_kelas, '12 '));
        $kelasOther = $kelas->reject(fn($k) => 
            str_starts_with($k->nama_kelas, 'X ') || str_starts_with($k->nama_kelas, '10 ') ||
            str_starts_with($k->nama_kelas, 'XI ') || str_starts_with($k->nama_kelas, '11 ') ||
            str_starts_with($k->nama_kelas, 'XII ') || str_starts_with($k->nama_kelas, '12 ')
        );

        $siswas = collect();
        $existingAbsensi = collect();

        if ($selectedKelas) {
            $siswas = Siswa::where('kelas', $selectedKelas)
                ->where('status', '!=', 'Lulus')
                ->orderBy('nama')
                ->get();

            $existingAbsensi = Absensi::whereIn('siswa_id', $siswas->pluck('id'))
                ->where('tanggal', $tanggal)
                ->get()
                ->keyBy('siswa_id');
        }

        return view('absensi.index', compact(
            'kelas', 'selectedKelas', 'tanggal', 'siswas', 'existingAbsensi',
            'kelasX', 'kelasXI', 'kelasXII', 'kelasOther'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas' => 'required|string',
            'tanggal' => 'required|date',
            'absensi' => 'required|array',
            'absensi.*.status' => 'required|in:Hadir,Izin,Sakit,Alpa',
            'absensi.*.alasan' => 'nullable|string|max:255',
        ]);

        $guruId = auth()->user()->isGuru() && auth()->user()->guru ? auth()->user()->guru->id : null;
        $savedCount = 0;

        foreach ($request->input('absensi') as $siswaId => $data) {
            Absensi::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'tanggal' => $request->tanggal,
                ],
                [
                    'guru_id' => $guruId,
                    'kelas' => $request->kelas,
                    'status' => $data['status'],
                    'alasan' => $data['status'] !== 'Hadir' ? ($data['alasan'] ?? null) : null,
                ]
            );
            $savedCount++;
        }

        $formattedDate = date('d/m/Y', strtotime($request->tanggal));
        return redirect()->route('absensi.index', ['kelas' => $request->kelas, 'tanggal' => $request->tanggal])
            ->with('success', "Absensi kelas {$request->kelas} untuk tanggal {$formattedDate} ({$savedCount} siswa) berhasil disimpan.");
    }

    public function rekap(Request $request)
    {
        $user = auth()->user();
        if ($user->isGuru() && $user->guru) {
            $guruId = $user->guru->id;
            $teachingClasses = \App\Models\JadwalPelajaran::where('guru_id', $guruId)->pluck('kelas');
            $substituteTugasIds = \App\Models\IzinGuru::where('guru_pengganti_id', $guruId)
                ->where('status', 'Disetujui')
                ->whereNotNull('tugas_id')
                ->pluck('tugas_id');
            $substituteClasses = \App\Models\Tugas::whereIn('id', $substituteTugasIds)->pluck('kelas');

            $allowedKelasNames = $teachingClasses->merge($substituteClasses)->unique();
            $kelas = Kelas::whereIn('nama_kelas', $allowedKelasNames)->orderBy('nama_kelas')->get();
        } else {
            $kelas = Kelas::orderBy('nama_kelas')->get();
        }

        $selectedKelas = $request->input('kelas', $kelas->first()?->nama_kelas ?? '');
        $bulan = $request->input('bulan', date('Y-m'));

        $kelasX = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'X ') || str_starts_with($k->nama_kelas, '10 '));
        $kelasXI = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'XI ') || str_starts_with($k->nama_kelas, '11 '));
        $kelasXII = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'XII ') || str_starts_with($k->nama_kelas, '12 '));
        $kelasOther = $kelas->reject(fn($k) => 
            str_starts_with($k->nama_kelas, 'X ') || str_starts_with($k->nama_kelas, '10 ') ||
            str_starts_with($k->nama_kelas, 'XI ') || str_starts_with($k->nama_kelas, '11 ') ||
            str_starts_with($k->nama_kelas, 'XII ') || str_starts_with($k->nama_kelas, '12 ')
        );

        $siswas = collect();
        if ($selectedKelas) {
            $siswas = Siswa::where('kelas', $selectedKelas)
                ->where('status', '!=', 'Lulus')
                ->with(['absensi' => function($q) use ($bulan) {
                    if ($bulan) {
                        $q->where('tanggal', 'like', $bulan . '%');
                    }
                    $q->orderBy('tanggal', 'desc');
                }])
                ->orderBy('nama')
                ->get();
        }

        return view('absensi.rekap', compact(
            'kelas', 'selectedKelas', 'bulan', 'siswas',
            'kelasX', 'kelasXI', 'kelasXII', 'kelasOther'
        ));
    }

    public function exportPdf(Request $request)
    {
        $selectedKelas = $request->input('kelas');
        $bulan = $request->input('bulan', date('Y-m'));

        if (!$selectedKelas) {
            return redirect()->back()->with('error', 'Pilih kelas terlebih dahulu untuk cetak PDF.');
        }

        $profilSekolah = ProfilSekolah::first();
        $siswas = Siswa::where('kelas', $selectedKelas)
            ->where('status', '!=', 'Lulus')
            ->with(['absensi' => function($q) use ($bulan) {
                if ($bulan) {
                    $q->where('tanggal', 'like', $bulan . '%');
                }
                $q->orderBy('tanggal', 'desc');
            }])
            ->orderBy('nama')
            ->get();

        $namaBulan = \Carbon\Carbon::parse($bulan . '-01')->translatedFormat('F Y');

        $html = view('absensi.pdf', compact('selectedKelas', 'bulan', 'namaBulan', 'siswas', 'profilSekolah'))->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = "Laporan_Absensi_{$selectedKelas}_{$bulan}.pdf";
        return $dompdf->stream($filename, ['Attachment' => true]);
    }

    public function harian(Request $request)
    {
        $tanggal = $request->input('tanggal', date('Y-m-d'));
        $selectedKelas = $request->input('kelas', '');
        $statusFilter = $request->input('status', '');
        $search = $request->input('q', '');

        $kelas = Kelas::orderBy('nama_kelas')->get();

        $query = Siswa::where('status', '!=', 'Lulus');
        if ($selectedKelas) {
            $query->where('kelas', $selectedKelas);
        }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }
        $allActiveSiswa = $query->orderBy('kelas')->orderBy('nama')->get();

        // Get absensi records for all active students on $tanggal
        $absensiRecords = Absensi::with('guru')
            ->whereIn('siswa_id', $allActiveSiswa->pluck('id'))
            ->where('tanggal', $tanggal)
            ->get()
            ->keyBy('siswa_id');

        // Overall stats for $tanggal
        $totalSiswa = $allActiveSiswa->count();
        $totalTercatat = $absensiRecords->count();
        $totalHadir = $absensiRecords->where('status', 'Hadir')->count();
        $totalIzin = $absensiRecords->where('status', 'Izin')->count();
        $totalSakit = $absensiRecords->where('status', 'Sakit')->count();
        $totalAlpa = $absensiRecords->where('status', 'Alpa')->count();
        $totalBelum = max(0, $totalSiswa - $totalTercatat);

        // Filter list if statusFilter is requested
        $siswas = $allActiveSiswa->filter(function($s) use ($absensiRecords, $statusFilter) {
            $record = $absensiRecords->get($s->id);
            $status = $record ? $record->status : 'Belum Diabsen';
            if ($statusFilter === 'Non-Hadir') {
                return in_array($status, ['Izin', 'Sakit', 'Alpa']);
            }
            if ($statusFilter) {
                return $status === $statusFilter;
            }
            return true;
        });

        // Group summary per class for the day
        $summaryPerKelas = $allActiveSiswa->groupBy('kelas')->map(function($classStudents, $className) use ($absensiRecords) {
            $records = $absensiRecords->whereIn('siswa_id', $classStudents->pluck('id'));
            return [
                'kelas' => $className,
                'total' => $classStudents->count(),
                'hadir' => $records->where('status', 'Hadir')->count(),
                'izin' => $records->where('status', 'Izin')->count(),
                'sakit' => $records->where('status', 'Sakit')->count(),
                'alpa' => $records->where('status', 'Alpa')->count(),
                'belum' => max(0, $classStudents->count() - $records->count()),
            ];
        });

        return view('absensi.harian', compact(
            'tanggal', 'selectedKelas', 'statusFilter', 'search', 'kelas', 'siswas', 'absensiRecords',
            'totalSiswa', 'totalTercatat', 'totalHadir', 'totalIzin', 'totalSakit', 'totalAlpa', 'totalBelum',
            'summaryPerKelas'
        ));
    }

    public function exportPdfHarian(Request $request)
    {
        $tanggal = $request->input('tanggal', date('Y-m-d'));
        $selectedKelas = $request->input('kelas', '');

        $profilSekolah = ProfilSekolah::first();
        $query = Siswa::where('status', '!=', 'Lulus');
        if ($selectedKelas) {
            $query->where('kelas', $selectedKelas);
        }
        $siswas = $query->orderBy('kelas')->orderBy('nama')->get();

        $absensiRecords = Absensi::with('guru')
            ->whereIn('siswa_id', $siswas->pluck('id'))
            ->where('tanggal', $tanggal)
            ->get()
            ->keyBy('siswa_id');

        $formattedDate = \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y');

        $html = view('absensi.pdf_harian', compact('tanggal', 'formattedDate', 'selectedKelas', 'siswas', 'absensiRecords', 'profilSekolah'))->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = "Laporan_Absensi_Harian_" . str_replace('-', '', $tanggal) . ".pdf";
        return $dompdf->stream($filename, ['Attachment' => true]);
    }
}
