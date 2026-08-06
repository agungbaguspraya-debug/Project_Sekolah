<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\PiketGuru;
use Illuminate\Http\Request;

class PiketGuruController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $gurus = Guru::orderBy('nama')->get();

        // Query all piket records ordered by day of week (Senin..Sabtu) and earliest time (jam_mulai ASC)
        $allPiket = PiketGuru::with('guru')
            ->orderByRaw("CASE 
                WHEN hari = 'Senin' THEN 1
                WHEN hari = 'Selasa' THEN 2
                WHEN hari = 'Rabu' THEN 3
                WHEN hari = 'Kamis' THEN 4
                WHEN hari = 'Jumat' THEN 5
                WHEN hari = 'Sabtu' THEN 6
                ELSE 7 END")
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // Group piket list by Day
        $piketByHari = $allPiket->groupBy('hari');

        $myPiket = collect();
        if ($user->isGuru() && $user->guru) {
            $myPiket = PiketGuru::where('guru_id', $user->guru->id)
                ->orderByRaw("CASE 
                    WHEN hari = 'Senin' THEN 1
                    WHEN hari = 'Selasa' THEN 2
                    WHEN hari = 'Rabu' THEN 3
                    WHEN hari = 'Kamis' THEN 4
                    WHEN hari = 'Jumat' THEN 5
                    WHEN hari = 'Sabtu' THEN 6
                    ELSE 7 END")
                ->orderBy('jam_mulai', 'asc')
                ->get();
        }

        return view('piket.index', compact('allPiket', 'piketByHari', 'gurus', 'myPiket'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'hari' => 'required|string',
            'tugas_piket' => 'required|string|max:255',
            'jam_mulai' => 'nullable',
            'jam_selesai' => 'nullable',
            'keterangan' => 'nullable|string',
        ]);

        PiketGuru::create($request->all());

        return redirect()->route('piket.index')->with('success', 'Jadwal Piket Guru berhasil ditambahkan.');
    }

    public function destroy(PiketGuru $piket)
    {
        $piket->delete();
        return redirect()->route('piket.index')->with('success', 'Jadwal Piket Guru berhasil dihapus.');
    }
}
