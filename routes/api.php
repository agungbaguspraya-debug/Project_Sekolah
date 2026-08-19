<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\ProfilSekolah;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Fasilitas;
use App\Models\Ekstrakurikuler;
use App\Models\Berita;
use App\Models\Prestasi;
use App\Models\Galeri;
use App\Models\Testimoni;
use App\Models\Faq;
use App\Models\Siswa;

// 🚀 Endpoint Lengkap untuk Landing Page Next.js
Route::get('/landing-page', function () {
    return response()->json([
        'stats' => [
            'siswa_count' => Siswa::count() ?: 500,
            'guru_count' => Guru::count() ?: 45,
            'alumni_count' => 1200,
            'tahun_dedikasi' => 25,
        ],
        'profil' => ProfilSekolah::first(),
        'jurusans' => Jurusan::all(),
        'fasilitas' => Fasilitas::all(),
        'ekstrakurikuler' => Ekstrakurikuler::all(),
        'berita_highlight' => Berita::where('is_highlight', true)->latest()->first() ?? Berita::latest()->first(),
        'berita_list' => Berita::latest()->take(3)->get(),
        'prestasi' => Prestasi::latest()->take(4)->get(),
        'galeri' => Galeri::latest()->take(6)->get(),
        'testimoni' => Testimoni::all(),
        'faqs' => Faq::all(),
    ]);
});

// Endpoint Spesifik per Halaman
Route::get('/profil', fn() => response()->json(ProfilSekolah::first()));
Route::get('/guru', fn() => response()->json(Guru::all()));
Route::get('/jurusan', fn() => response()->json(Jurusan::all()));
Route::get('/ekskul', fn() => response()->json(Ekstrakurikuler::all()));
Route::get('/berita', fn() => response()->json(Berita::latest()->get()));
Route::get('/fasilitas', fn() => response()->json(Fasilitas::all()));
