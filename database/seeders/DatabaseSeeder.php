<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Pelanggaran;
use App\Models\JadwalPelajaran;
use App\Models\Tugas;
use App\Models\TugasSubmission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Kelas
        $kelasNames = ['X RPL 1', 'XI RPL 1', 'XII RPL 1', 'X TKJ 1', 'XI TKJ 1', 'XII TKJ 1'];
        foreach ($kelasNames as $name) {
            Kelas::firstOrCreate(['nama_kelas' => $name]);
        }

        // 2. Seed Jurusan
        $jurusans = ['Rekayasa Perangkat Lunak (RPL)', 'Teknik Komputer & Jaringan (TKJ)'];
        foreach ($jurusans as $name) {
            Jurusan::firstOrCreate(['nama_jurusan' => $name]);
        }

        // 3. Seed Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Sat',
                'password' => Hash::make('password123'),
                'role' => 'admin'
            ]
        );
        $admin->update(['role' => 'admin']);

        // 4. Seed Siswa (Budi)
        $siswa = Siswa::firstOrCreate(
            ['nis' => '10001'],
            [
                'nama' => 'Budi Santoso',
                'kelas' => 'XI RPL 1',
                'jurusan' => 'Rekayasa Perangkat Lunak (RPL)',
                'status' => 'Pelajar'
            ]
        );

        // 5. Seed Student User Account
        User::firstOrCreate(
            ['email' => 'budi@gmail.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
                'siswa_id' => $siswa->id
            ]
        );

        // 6. Seed some violations for Budi
        Pelanggaran::firstOrCreate(
            [
                'siswa_id' => $siswa->id,
                'nama_pelanggaran' => 'Terlambat masuk sekolah'
            ],
            [
                'point' => 10,
                'tanggal' => now()->format('Y-m-d')
            ]
        );

        Pelanggaran::firstOrCreate(
            [
                'siswa_id' => $siswa->id,
                'nama_pelanggaran' => 'Tidak memakai seragam rapi'
            ],
            [
                'point' => 5,
                'tanggal' => now()->subDays(2)->format('Y-m-d')
            ]
        );

        // 7. Seed Jadwal Pelajaran (Schedule) for class 'XI RPL 1'
        $schedules = [
            ['hari' => 'Senin', 'mata_pelajaran' => 'Matematika', 'jam_mulai' => '08:00', 'jam_selesai' => '09:30'],
            ['hari' => 'Senin', 'mata_pelajaran' => 'Bahasa Inggris', 'jam_mulai' => '09:45', 'jam_selesai' => '11:15'],
            ['hari' => 'Selasa', 'mata_pelajaran' => 'Pemrograman Web', 'jam_mulai' => '08:00', 'jam_selesai' => '11:15'],
            ['hari' => 'Rabu', 'mata_pelajaran' => 'Basis Data', 'jam_mulai' => '08:00', 'jam_selesai' => '10:15'],
            ['hari' => 'Rabu', 'mata_pelajaran' => 'Pendidikan Agama', 'jam_mulai' => '10:30', 'jam_selesai' => '12:00'],
            ['hari' => 'Kamis', 'mata_pelajaran' => 'Produk Kreatif dan Kewirausahaan (PKK)', 'jam_mulai' => '08:00', 'jam_selesai' => '11:15'],
            ['hari' => 'Jumat', 'mata_pelajaran' => 'Pendidikan Jasmani (PJOK)', 'jam_mulai' => '08:00', 'jam_selesai' => '09:30'],
        ];

        foreach ($schedules as $sched) {
            JadwalPelajaran::firstOrCreate([
                'kelas' => 'XI RPL 1',
                'hari' => $sched['hari'],
                'mata_pelajaran' => $sched['mata_pelajaran'],
                'jam_mulai' => $sched['jam_mulai'],
                'jam_selesai' => $sched['jam_selesai'],
            ]);
        }

        // 8. Seed Assignments (Tugas)
        $tugas1 = Tugas::firstOrCreate(
            [
                'kelas' => 'XI RPL 1',
                'judul' => 'Membuat Form Login Laravel'
            ],
            [
                'mata_pelajaran' => 'Pemrograman Web',
                'deskripsi' => 'Buatlah rancangan form login menggunakan Laravel Breeze, lengkapi dengan styling Bootstrap 5 pada layout-nya.',
                'deadline' => now()->addDays(7)->format('Y-m-d')
            ]
        );

        $tugas2 = Tugas::firstOrCreate(
            [
                'kelas' => 'XI RPL 1',
                'judul' => 'Normalisasi Basis Data'
            ],
            [
                'mata_pelajaran' => 'Basis Data',
                'deskripsi' => 'Kerjakan latihan normalisasi tabel dari bentuk 1NF, 2NF hingga 3NF seperti yang telah dipelajari.',
                'deadline' => now()->subDay()->format('Y-m-d')
            ]
        );

        // 9. Seed Assignment Submission (Budi submitted the DB Normalization task)
        TugasSubmission::firstOrCreate(
            [
                'tugas_id' => $tugas2->id,
                'siswa_id' => $siswa->id
            ],
            [
                'catatan' => 'Tugas Normalisasi Basis Data bentuk 1NF-3NF selesai dikerjakan, Pak.',
                'file_path' => 'siswa/tugas/budi_normalisasi.pdf',
                'dikumpulkan_pada' => now()->subHours(2)
            ]
        );
    }
}
