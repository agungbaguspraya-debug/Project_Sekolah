<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        return view('jurusan.index', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|unique:jurusans,nama_jurusan'
        ]);

        $jurusan = Jurusan::create($request->all());

        // Extract code/name for auto class generation (e.g., "ULW" or "Usaha Perjalanan Wisata (ULW)")
        $namaJurusan = trim($request->nama_jurusan);
        $code = $namaJurusan;

        if (preg_match('/\(([^)]+)\)/', $namaJurusan, $matches)) {
            $code = trim($matches[1]);
        }

        $code = strtoupper($code);

        // Automatically create classes X, XI, XII for this major
        $levels = ['X', 'XI', 'XII'];
        $createdClasses = [];

        foreach ($levels as $level) {
            $className = "{$level} {$code} 1";
            $createdClass = Kelas::firstOrCreate(['nama_kelas' => $className]);
            $createdClasses[] = $createdClass->nama_kelas;
        }

        $classListStr = implode(', ', $createdClasses);

        return redirect()->route('jurusan.index')->with('success', "Jurusan '{$namaJurusan}' berhasil ditambahkan dan otomatis membuat kelas: {$classListStr}.");
    }

    public function edit(Jurusan $jurusan)
    {
        return view('jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|unique:jurusans,nama_jurusan,' . $jurusan->id
        ]);

        $oldName = $jurusan->nama_jurusan;
        $newName = trim($request->nama_jurusan);

        $jurusan->update(['nama_jurusan' => $newName]);

        // Cascade update related student records using updated major name
        if ($oldName !== $newName) {
            Siswa::where('jurusan', $oldName)->update(['jurusan' => $newName]);
        }

        return redirect()->route('jurusan.index')->with('success', 'Data jurusan berhasil diperbarui.');
    }

    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();
        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil dihapus.');
    }
}
