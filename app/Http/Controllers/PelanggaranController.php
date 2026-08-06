<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    public function index(Siswa $siswa)
    {
        $pelanggarans = $siswa->pelanggaran()->orderBy('tanggal', 'desc')->get();
        $totalPoints = $pelanggarans->sum('point');
        return view('pelanggaran.index', compact('siswa', 'pelanggarans', 'totalPoints'));
    }

    public function store(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama_pelanggaran' => 'required|string|max:255',
            'point' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ]);

        $siswa->pelanggaran()->create([
            'nama_pelanggaran' => $request->nama_pelanggaran,
            'point' => $request->point,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('siswa.pelanggaran.index', $siswa->id)
            ->with('success', 'Pelanggaran berhasil dicatat.');
    }

    public function destroy(Siswa $siswa, Pelanggaran $pelanggaran)
    {
        $pelanggaran->delete();
        return redirect()->route('siswa.pelanggaran.index', $siswa->id)
            ->with('success', 'Catatan pelanggaran berhasil dihapus.');
    }
}
