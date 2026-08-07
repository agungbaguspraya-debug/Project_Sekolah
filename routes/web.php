<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AlumniTracerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EkstrakurikulerController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\IzinGuruController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\PiketGuruController;
use App\Http\Controllers\PrestasiSiswaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilSekolahController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TugasController;
use Illuminate\Support\Facades\Route;

// Redirect home page to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware(['auth']);

// Dashboard main route
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile, Schedule & Task & Ekskul portal for logged-in students
    Route::get('/siswa/profile', [SiswaController::class, 'profile'])->name('siswa.profile');
    Route::get('/siswa/jadwal', [SiswaController::class, 'jadwal'])->name('siswa.jadwal');
    Route::get('/siswa/tugas', [SiswaController::class, 'tugas'])->name('siswa.tugas');
    Route::get('/siswa/ekskul', [EkstrakurikulerController::class, 'siswaIndex'])->name('siswa.ekskul');
    Route::post('/siswa/ekskul/register', [EkstrakurikulerController::class, 'register'])->name('siswa.ekskul.register');

    // Student submitting assignment & photo memory & Alumni Tracer
    Route::post('/siswa/tugas/{tugas}/submit', [TugasController::class, 'submit'])->name('siswa.tugas.submit');
    Route::post('/siswa/upload-foto-kenangan', [SiswaController::class, 'uploadFotoKenangan'])->name('siswa.upload-foto-kenangan');
    Route::post('/siswa/upload-media-kenangan', [SiswaController::class, 'uploadMediaKenangan'])->name('siswa.upload-media-kenangan');
    Route::delete('/siswa/media-kenangan/{id}', [SiswaController::class, 'deleteMediaKenangan'])->name('siswa.delete-media-kenangan');
    Route::post('/siswa/alumni-tracer', [AlumniTracerController::class, 'store'])->name('siswa.alumni.store');

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

        // Absensi Siswa Management (Input, Store, Rekap, Monitoring Harian & Export PDF)
        Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
        Route::get('/absensi/rekap', [AbsensiController::class, 'rekap'])->name('absensi.rekap');
        Route::get('/absensi/pdf', [AbsensiController::class, 'exportPdf'])->name('absensi.pdf');
        Route::get('/absensi/harian', [AbsensiController::class, 'harian'])->name('absensi.harian');
        Route::get('/absensi/harian/pdf', [AbsensiController::class, 'exportPdfHarian'])->name('absensi.harian.pdf');

        // Pengajuan Izin / Sakit Guru
        Route::get('/guru/izin', [IzinGuruController::class, 'index'])->name('guru.izin.index');
        Route::post('/guru/izin', [IzinGuruController::class, 'store'])->name('guru.izin.store');
        Route::delete('/guru/izin/{izinGuru}', [IzinGuruController::class, 'destroy'])->name('guru.izin.destroy');
    });

    // Admin-only route group
    Route::middleware('admin')->group(function () {
        // Persetujuan (ACC) Izin & Sakit Guru + Penunjukan Guru Pengganti
        Route::get('/admin/izin-guru', [IzinGuruController::class, 'adminIndex'])->name('admin.izin.index');
        Route::post('/admin/izin-guru/{izinGuru}/approve', [IzinGuruController::class, 'approve'])->name('admin.izin.approve');
        Route::post('/admin/izin-guru/{izinGuru}/reject', [IzinGuruController::class, 'reject'])->name('admin.izin.reject');

        // Laporan Alumni Tracer (Kuliah & Bekerja)
        Route::get('/admin/alumni', [AlumniTracerController::class, 'adminIndex'])->name('admin.alumni.index');
        Route::delete('/admin/alumni/{alumniTracer}', [AlumniTracerController::class, 'destroy'])->name('admin.alumni.destroy');

        // Management Prestasi Siswa
        Route::resource('/admin/prestasi', PrestasiSiswaController::class)->names('admin.prestasi');
        Route::post('/admin/prestasi/{prestasiSiswa}/toggle-homepage', [PrestasiSiswaController::class, 'toggleHomepage'])->name('admin.prestasi.toggle-homepage');

        // Management Ekstrakurikuler Sekolah & ACC Pendaftaran Siswa
        Route::resource('/admin/ekskul', EkstrakurikulerController::class)->names('admin.ekskul');
        Route::post('/admin/ekskul/pendaftaran/{pendaftaran}/approve', [EkstrakurikulerController::class, 'approveRegistration'])->name('admin.ekskul.approve');
        Route::post('/admin/ekskul/pendaftaran/{pendaftaran}/reject', [EkstrakurikulerController::class, 'rejectRegistration'])->name('admin.ekskul.reject');

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
