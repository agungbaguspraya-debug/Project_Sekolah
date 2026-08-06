<?php

namespace App\Http\Controllers;

use App\Models\ProfilSekolah;
use Illuminate\Http\Request;

class ProfilSekolahController extends Controller
{
    public function edit()
    {
        $profil = ProfilSekolah::first();
        if (!$profil) {
            $profil = ProfilSekolah::create([
                'nama_sekolah' => 'SMK Negeri 1 SAT System',
                'npsn_status' => '10802999 | Negeri',
                'kepala_sekolah' => 'Dr. H. Ahmad Wijaya, M.Pd.',
                'akreditasi' => 'A',
                'jam_operasional' => 'Senin - Jumat (07:00 - 15:30 WIB)',
                'alamat' => 'Jl. Pendidikan No. 45, Kompleks Edukasi Terpadu SAT',
                'email' => 'info@smkn1sat.sch.id',
                'telepon' => '(021) 555-0199',
                'visi' => 'Menjadi Lembaga Pendidikan Kejuruan Unggul, Berkarakter, Berkualitas, dan Berbasis Teknologi Terdepan dalam Mewujudkan Generasi Siap Kerja.',
                'misi' => "1. Menyelenggarakan pembelajaran berbasis standar industri terkini.\n2. Mengembangkan jiwa kewirausahaan dan keterampilan vokasional siswa.\n3. Mewujudkan lulusan berdaya saing tinggi, jujur, dan berakhlak mulia.",
            ]);
        }

        return view('profil_sekolah.edit', compact('profil'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'npsn_status' => 'required|string|max:255',
            'kepala_sekolah' => 'required|string|max:255',
            'akreditasi' => 'required|string|max:10',
            'jam_operasional' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:50',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
        ]);

        $profil = ProfilSekolah::first();
        if (!$profil) {
            $profil = new ProfilSekolah();
        }

        $profil->fill($request->all());
        $profil->save();

        return redirect()->route('profil-sekolah.edit')->with('success', 'Informasi & Profil Sekolah berhasil diperbarui.');
    }
}
