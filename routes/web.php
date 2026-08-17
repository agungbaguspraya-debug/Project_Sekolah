<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\PiketGuruController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilSekolahController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;

// Landing Page route
Route::get('/', [LandingPageController::class, 'index'])->name('landing_page');
Route::get('/sambutan-kepala-sekolah', [LandingPageController::class, 'sambutan'])->name('sambutan');
Route::get('/sejarah', [LandingPageController::class, 'sejarah'])->name('sejarah');
Route::get('/visi-misi', [LandingPageController::class, 'visiMisi'])->name('visi_misi');
Route::get('/guru-staff', [LandingPageController::class, 'guruStaff'])->name('guru_staff');
Route::get('/kurikulum', [LandingPageController::class, 'kurikulum'])->name('kurikulum');
Route::get('/pengumuman', [LandingPageController::class, 'pengumuman'])->name('pengumuman');
Route::get('/agenda', [LandingPageController::class, 'agenda'])->name('agenda');

// Dashboard main route
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile, Schedule & Task portal for logged-in students
    Route::get('/siswa/profile', [SiswaController::class, 'profile'])->name('siswa.profile');
    Route::get('/siswa/jadwal', [SiswaController::class, 'jadwal'])->name('siswa.jadwal');
    Route::get('/siswa/tugas', [SiswaController::class, 'tugas'])->name('siswa.tugas');

    // Student submitting assignment & photo memory
    Route::post('/siswa/tugas/{tugas}/submit', [TugasController::class, 'submit'])->name('siswa.tugas.submit');
    Route::post('/siswa/upload-foto-kenangan', [SiswaController::class, 'uploadFotoKenangan'])->name('siswa.upload-foto-kenangan');
    Route::post('/siswa/upload-media-kenangan', [SiswaController::class, 'uploadMediaKenangan'])->name('siswa.upload-media-kenangan');
    Route::delete('/siswa/media-kenangan/{id}', [SiswaController::class, 'deleteMediaKenangan'])->name('siswa.delete-media-kenangan');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Duty Schedule (Piket Guru) - View for Guru and Admin
    Route::get('/piket', [PiketGuruController::class, 'index'])->name('piket.index');

    // Lesson Schedule (Jadwal Mengajar) - View for Guru and Admin
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');

    // Task List route - accessible by all auth users (Admin, Guru, Siswa)
    Route::get('/tugas', [TugasController::class, 'index'])->name('tugas.index');

    // Task Management (Store, Delete, Submissions, Grade) - accessible by Admin and Guru
    Route::middleware('guru')->group(function () {
        Route::post('/tugas', [TugasController::class, 'store'])->name('tugas.store');
        Route::delete('/tugas/{tuga}', [TugasController::class, 'destroy'])->name('tugas.destroy');
        Route::get('/tugas/{tuga}/submissions', [TugasController::class, 'submissions'])->name('tugas.submissions');
        Route::get('/tugas/submissions/{submission}/review', [TugasController::class, 'review'])->name('tugas.review');
        Route::post('/tugas/submissions/{submission}/grade', [TugasController::class, 'grade'])->name('tugas.grade');
    });

    // Admin-only route group
    Route::middleware('admin')->group(function () {
        Route::get('/siswa/export-excel', [SiswaController::class, 'exportExcel'])->name('siswa.exportExcel');
        Route::get('/siswa/export-pdf', [SiswaController::class, 'exportPdf'])->name('siswa.exportPdf');

        // CRUD Siswa
        Route::resource('siswa', SiswaController::class)->except(['show']);

        // CRUD Guru
        Route::resource('guru', GuruController::class);

        // CRUD Piket Guru (Store & Delete)
        Route::post('/piket', [PiketGuruController::class, 'store'])->name('piket.store');
        Route::delete('/piket/{piket}', [PiketGuruController::class, 'destroy'])->name('piket.destroy');

        // CRUD Kelas (Classes) - Admin only
        Route::resource('kelas', KelasController::class)->except(['create']);

        // CRUD Jurusan (Majors)
        Route::resource('jurusan', JurusanController::class)->except(['create', 'show']);

        // Promotion (Naik Kelas) & Graduation (Luluskan) Management
        Route::post('/siswa/naik-kelas', [SiswaController::class, 'naikKelas'])->name('siswa.naik-kelas');
        Route::post('/siswa/luluskan', [SiswaController::class, 'luluskan'])->name('siswa.luluskan');

        // Violations (Pelanggaran) Management for specific students
        Route::get('/siswa/{siswa}/pelanggaran', [PelanggaranController::class, 'index'])->name('siswa.pelanggaran.index');
        Route::post('/siswa/{siswa}/pelanggaran', [PelanggaranController::class, 'store'])->name('siswa.pelanggaran.store');
        Route::delete('/siswa/{siswa}/pelanggaran/{pelanggaran}', [PelanggaranController::class, 'destroy'])->name('siswa.pelanggaran.destroy');

        // CRUD Jadwal (Store & Destroy)
        Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
        Route::delete('/jadwal/{jadwal}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

        // Manage School Profile / Information
        Route::get('/profil-sekolah', [ProfilSekolahController::class, 'edit'])->name('profil-sekolah.edit');
        Route::put('/profil-sekolah', [ProfilSekolahController::class, 'update'])->name('profil-sekolah.update');
    });
});

require __DIR__.'/auth.php';
