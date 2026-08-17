<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Ekstrakurikuler;
use App\Models\Faq;
use App\Models\Fasilitas;
use App\Models\Galeri;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Prestasi;
use App\Models\ProfilSekolah;
use App\Models\Siswa;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        // Counts for stats
        $siswaCount = Siswa::count() ?: 500;
        $guruCount = Guru::count() ?: 50;
        $alumniCount = 1000; // Static for now, no Alumni table
        $tahunDedikasi = 25; // Static for now

        // Get single records
        $profil = ProfilSekolah::first();
        $prestasiUtama = Prestasi::latest()->first();

        // Get multiple records
        $jurusans = Jurusan::all();
        $fasilitas = Fasilitas::all();
        $ekstrakurikuler = Ekstrakurikuler::all();
        $beritaHighlight = Berita::where('is_highlight', true)->latest()->first();
        $beritaList = Berita::where('id', '!=', $beritaHighlight?->id)->latest()->take(3)->get();
        $galeri = Galeri::all();
        $testimoni = Testimoni::all();
        $faqs = Faq::all();

        return view('landing page.landing_page', compact(
            'siswaCount', 'guruCount', 'alumniCount', 'tahunDedikasi',
            'profil', 'prestasiUtama', 'jurusans', 'fasilitas',
            'ekstrakurikuler', 'beritaHighlight', 'beritaList',
            'galeri', 'testimoni', 'faqs'
        ));
    }

    public function sambutan() {
        return view('landing page.pages.sambutan');
    }

    public function sejarah() {
        return view('landing page.pages.sejarah');
    }

    public function visiMisi() {
        $profil = ProfilSekolah::first();
        return view('landing page.pages.visi_misi', compact('profil'));
    }

    public function guruStaff() {
        $gurus = Guru::all();
        return view('landing page.pages.guru_staff', compact('gurus'));
    }

    public function kurikulum() {
        return view('landing page.pages.kurikulum');
    }

    public function pengumuman() {
        return view('landing page.pages.pengumuman');
    }

    public function agenda() {
        return view('landing page.pages.agenda');
    }
}
