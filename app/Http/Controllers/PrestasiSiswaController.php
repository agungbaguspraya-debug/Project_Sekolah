<?php

namespace App\Http\Controllers;

use App\Models\PrestasiSiswa;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestasiSiswaController extends Controller
{
    // Admin & Public Index
    public function index(Request $request)
    {
        $query = PrestasiSiswa::with('siswa');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        $prestasis = $query->orderBy('tahun', 'desc')->orderBy('created_at', 'desc')->get();
        $siswas = Siswa::orderBy('nama')->get();

        return view('admin.prestasi.index', compact('prestasis', 'siswas'));
    }

    // Admin Store Student Achievement
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'nullable|exists:siswa,id',
            'nama_siswa' => 'required_without:siswa_id|nullable|string|max:255',
            'judul_prestasi' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'tingkat' => 'required|string|max:100',
            'peringkat' => 'required|string|max:100',
            'tahun' => 'required|string|max:20',
            'penyelenggara' => 'nullable|string|max:255',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3072',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_bukti')) {
            $fotoPath = $request->file('foto_bukti')->store('prestasi', 'public');
        }

        $namaSiswa = $request->nama_siswa;
        $kelasSiswa = null;

        if ($request->siswa_id) {
            $siswaModel = Siswa::find($request->siswa_id);
            if ($siswaModel) {
                $namaSiswa = $siswaModel->nama;
                $kelasSiswa = $siswaModel->kelas;
                if (!$fotoPath && $siswaModel->foto) {
                    $fotoPath = $siswaModel->foto;
                }
            }
        }

        PrestasiSiswa::create([
            'siswa_id' => $request->siswa_id,
            'nama_siswa' => $namaSiswa,
            'kelas' => $kelasSiswa,
            'judul_prestasi' => $request->judul_prestasi,
            'kategori' => $request->kategori,
            'tingkat' => $request->tingkat,
            'peringkat' => $request->peringkat,
            'tahun' => $request->tahun,
            'penyelenggara' => $request->penyelenggara,
            'foto_bukti' => $fotoPath,
            'tampilkan_di_beranda' => $request->has('tampilkan_di_beranda'),
        ]);

        return redirect()->back()->with('success', 'Prestasi siswa berhasil ditambahkan dan ditayangkan!');
    }

    // Toggle Display on Homepage
    public function toggleHomepage(PrestasiSiswa $prestasiSiswa)
    {
        $prestasiSiswa->update([
            'tampilkan_di_beranda' => !$prestasiSiswa->tampilkan_di_beranda
        ]);

        return redirect()->back()->with('success', 'Status penayangan prestasi di halaman beranda berhasil diperbarui.');
    }

    // Delete Achievement
    public function destroy(PrestasiSiswa $prestasiSiswa)
    {
        if ($prestasiSiswa->foto_bukti && !str_contains($prestasiSiswa->foto_bukti, 'siswa/')) {
            Storage::disk('public')->delete($prestasiSiswa->foto_bukti);
        }
        $prestasiSiswa->delete();

        return redirect()->back()->with('success', 'Prestasi siswa berhasil dihapus.');
    }
}
