<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Berita;
use App\Models\Fasilitas;
use App\Models\Ekstrakurikuler;
use App\Models\Prestasi;
use App\Models\Galeri;
use App\Models\Testimoni;
use App\Models\Faq;

class LandingPageSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Berita
        Berita::create([
            'judul' => 'Pelepasan Siswa Kelas XII Angkatan ke-25 Berjalan Penuh Haru',
            'slug' => 'pelepasan-siswa-kelas-xii',
            'konten' => 'Acara pelepasan siswa kelas XII berjalan dengan sangat khidmat...',
            'foto' => 'https://images.unsplash.com/photo-1523580494863-6f3031224c94?q=80&w=2070&auto=format&fit=crop',
            'tanggal_publikasi' => '2026-08-12',
            'is_highlight' => true
        ]);
        
        Berita::create([
            'judul' => 'Kunjungan Industri ke Perusahaan Teknologi Multinasional',
            'slug' => 'kunjungan-industri-perusahaan-teknologi',
            'konten' => 'Siswa kami melakukan kunjungan industri untuk belajar secara langsung...',
            'foto' => 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?q=80&w=2070&auto=format&fit=crop',
            'tanggal_publikasi' => '2026-08-08',
            'is_highlight' => false
        ]);
        
        Berita::create([
            'judul' => 'Pelantikan Pengurus OSIS Masa Bakti 2026/2027',
            'slug' => 'pelantikan-osis-2026',
            'konten' => 'Pengurus OSIS baru resmi dilantik hari ini...',
            'foto' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=2070&auto=format&fit=crop',
            'tanggal_publikasi' => '2026-08-03',
            'is_highlight' => false
        ]);

        Berita::create([
            'judul' => 'Workshop Pengembangan Soft Skills untuk Menghadapi Dunia Kerja',
            'slug' => 'workshop-soft-skills',
            'konten' => 'Workshop ini ditujukan bagi siswa yang bersiap masuk dunia kerja...',
            'foto' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=2120&auto=format&fit=crop',
            'tanggal_publikasi' => '2026-07-28',
            'is_highlight' => false
        ]);

        // 2. Fasilitas
        Fasilitas::create([
            'nama_fasilitas' => 'Perpustakaan Digital Modern',
            'deskripsi' => 'Ribuan literatur dan akses digital untuk mendukung riset.',
            'foto' => 'https://images.unsplash.com/photo-1562774053-701939374585?q=80&w=2086&auto=format&fit=crop',
            'is_large' => true
        ]);
        Fasilitas::create([
            'nama_fasilitas' => 'Laboratorium Sains',
            'deskripsi' => 'Laboratorium sains dengan alat peraga terkini.',
            'foto' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2070&auto=format&fit=crop',
            'is_large' => false
        ]);
        Fasilitas::create([
            'nama_fasilitas' => 'Lab Komputer & iMac',
            'deskripsi' => 'Fasilitas komputer canggih untuk jurusan IT.',
            'foto' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=2070&auto=format&fit=crop',
            'is_large' => false
        ]);

        // 3. Ekstrakurikuler
        $ekskuls = [
            ['nama' => 'Bola Basket', 'foto' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?q=80&w=2090&auto=format&fit=crop'],
            ['nama' => 'Seni Musik & Paduan Suara', 'foto' => 'https://images.unsplash.com/photo-1511192336575-5a79af67a629?q=80&w=2664&auto=format&fit=crop'],
            ['nama' => 'Pramuka', 'foto' => 'https://images.unsplash.com/photo-1533560904424-a0c61dc306fc?q=80&w=2070&auto=format&fit=crop'],
            ['nama' => 'IT & Robotics Club', 'foto' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?q=80&w=2070&auto=format&fit=crop'],
            ['nama' => 'Pecinta Alam', 'foto' => 'https://images.unsplash.com/photo-1542652694-40abf526446e?q=80&w=2070&auto=format&fit=crop']
        ];
        foreach ($ekskuls as $eks) {
            Ekstrakurikuler::create(['nama_ekstrakurikuler' => $eks['nama'], 'foto' => $eks['foto']]);
        }

        // 4. Prestasi
        Prestasi::create([
            'judul_prestasi' => 'Olimpiade Sains Nasional Bidang Informatika',
            'tahun' => '2026',
            'deskripsi' => 'Siswa Astika Dharma kembali mengharumkan nama sekolah dengan meraih medali emas pada ajang bergengsi OSN tingkat nasional, membuktikan dedikasi terhadap keunggulan akademik.',
            'foto' => 'https://images.unsplash.com/photo-1568227653555-5c1a11306385?q=80&w=1974&auto=format&fit=crop'
        ]);

        // 5. Galeri
        $galeriFotos = [
            'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=1932&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?q=80&w=2070&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=2120&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=2070&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1511192336575-5a79af67a629?q=80&w=2664&auto=format&fit=crop'
        ];
        foreach ($galeriFotos as $i => $foto) {
            Galeri::create(['judul' => 'Kegiatan ' . ($i+1), 'foto' => $foto]);
        }

        // 6. Testimoni
        Testimoni::create([
            'nama' => 'Budi Santoso',
            'peran' => 'Alumni Angkatan 2024 - Kuliah di Teknik Informatika UI',
            'konten' => 'Pengalaman belajar di Astika Dharma memberikan banyak bekal tidak hanya akademis, tetapi juga cara berpikir kritis dan keberanian untuk mengambil keputusan. Sekolah ini benar-benar membentuk karakter saya.'
        ]);
        Testimoni::create([
            'nama' => 'Siti Aminah',
            'peran' => 'Alumni Angkatan 2022 - Pengusaha Sukses',
            'konten' => 'Fasilitas yang lengkap sangat menunjang hobi saya dalam desain dan bisnis.'
        ]);
        Testimoni::create([
            'nama' => 'Rangga Pratama',
            'peran' => 'Orang Tua Siswa',
            'konten' => 'Saya merasa bangga anak saya bisa bersekolah di sini. Pendidik berdedikasi tinggi.'
        ]);

        // 7. FAQ
        Faq::create([
            'pertanyaan' => 'Bagaimana cara melakukan pendaftaran?',
            'jawaban' => 'Pendaftaran dapat dilakukan secara online melalui portal PPDB kami dengan menekan tombol "Daftar Sekarang" pada website ini. Anda akan diarahkan untuk mengisi formulir pendaftaran dan mengunggah berkas-berkas yang diperlukan.'
        ]);
        Faq::create([
            'pertanyaan' => 'Apa saja program keahlian yang tersedia?',
            'jawaban' => 'Kami menyediakan 3 program keahlian utama: Rekayasa Perangkat Lunak, Bisnis & Manajemen, dan Desain Komunikasi Visual. Setiap program didukung oleh laboratorium khusus dan tenaga pengajar dari kalangan praktisi.'
        ]);
        Faq::create([
            'pertanyaan' => 'Kapan pendaftaran siswa baru dibuka?',
            'jawaban' => 'Gelombang pertama pendaftaran siswa baru biasanya dibuka pada bulan Januari hingga Maret setiap tahunnya. Pantau terus informasi terbaru melalui halaman website dan media sosial kami.'
        ]);
        Faq::create([
            'pertanyaan' => 'Apakah tersedia kegiatan ekstrakurikuler?',
            'jawaban' => 'Ya, kami memiliki lebih dari 15 ekstrakurikuler pilihan yang terbagi dalam bidang olahraga, seni, akademik, dan kepemimpinan. Siswa diwajibkan untuk mengikuti minimal satu ekstrakurikuler.'
        ]);
    }
}
