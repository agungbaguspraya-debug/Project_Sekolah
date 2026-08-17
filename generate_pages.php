<?php
$viewsDir = __DIR__ . '/resources/views/landing page/pages/';
if (!is_dir($viewsDir)) {
    mkdir($viewsDir, 0777, true);
}

$pages = [
    'sambutan' => [
        'title' => 'Sambutan Kepala Sekolah',
        'content' => '
        <div class="container" style="padding: 120px 5% 5rem;">
            <div style="max-width: 800px; margin: 0 auto; background: var(--white); padding: 3rem; border-radius: var(--radius-lg); box-shadow: 0 10px 40px rgba(0,0,0,0.05);">
                <div style="text-align: center; margin-bottom: 2rem;">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=2000&auto=format&fit=crop" alt="Kepala Sekolah" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; margin: 0 auto 1rem;">
                    <h2 class="section-title" style="font-size: 2rem;">Sambutan Kepala Sekolah</h2>
                    <p style="color: var(--text-muted); font-weight: 600;">Bpk. Drs. H. Ahmad Dahlan, M.Pd.</p>
                </div>
                <div style="color: var(--text-main); font-size: 1.1rem; line-height: 1.8;">
                    <p style="margin-bottom: 1.5rem;">Assalamu’alaikum Warahmatullahi Wabarakatuh, Salam sejahtera bagi kita semua.</p>
                    <p style="margin-bottom: 1.5rem;">Selamat datang di website resmi Sekolah Astika Dharma. Puji syukur senantiasa kita panjatkan ke hadirat Tuhan Yang Maha Esa atas segala rahmat dan karunia-Nya. Kami hadir untuk memberikan layanan pendidikan berkualitas demi mencetak generasi muda yang cerdas, berkarakter, dan berdaya saing global.</p>
                    <p style="margin-bottom: 1.5rem;">Melalui portal website ini, kami berharap dapat memberikan informasi terkini secara cepat dan transparan kepada seluruh peserta didik, orang tua wali, serta masyarakat umum. Kami terus berupaya meningkatkan fasilitas dan kualitas pendidikan agar selaras dengan perkembangan zaman.</p>
                    <p>Terima kasih atas kepercayaan yang diberikan. Mari bersama-sama kita wujudkan cita-cita bangsa melalui pendidikan yang bermutu. Wassalamu’alaikum Warahmatullahi Wabarakatuh.</p>
                </div>
            </div>
        </div>'
    ],
    'sejarah' => [
        'title' => 'Sejarah Sekolah',
        'content' => '
        <div class="container" style="padding: 120px 5% 5rem;">
            <div style="max-width: 800px; margin: 0 auto;">
                <h2 class="section-title text-center" style="margin-bottom: 3rem;">Sejarah Astika Dharma</h2>
                <div style="background: var(--white); padding: 3rem; border-radius: var(--radius-lg); box-shadow: 0 10px 40px rgba(0,0,0,0.05); position: relative;">
                    <p style="font-size: 1.1rem; line-height: 1.8; margin-bottom: 1.5rem;">Sekolah Astika Dharma didirikan pada tahun 1998 dengan semangat untuk memajukan pendidikan di daerah sekitar. Berawal dari 2 gedung kelas sederhana, kini Astika Dharma telah berkembang menjadi salah satu sekolah terfavorit dan terlengkap.</p>
                    <p style="font-size: 1.1rem; line-height: 1.8; margin-bottom: 1.5rem;">Dalam perjalanannya, sekolah ini terus melakukan inovasi kurikulum dan penyediaan fasilitas mutakhir, termasuk laboratorium teknologi informasi dan perpustakaan digital, untuk menjawab tantangan global.</p>
                    <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=2070&auto=format&fit=crop" style="border-radius: var(--radius-md); margin-top: 2rem;" alt="Sejarah">
                </div>
            </div>
        </div>'
    ],
    'visi_misi' => [
        'title' => 'Visi & Misi',
        'content' => '
        <div class="container" style="padding: 120px 5% 5rem;">
            <div style="max-width: 800px; margin: 0 auto; text-align: center;">
                <h2 class="section-title">Visi & Misi</h2>
                <p class="section-subtitle mx-auto">Tujuan dan komitmen kami dalam membangun pendidikan.</p>
                
                <div style="background: var(--white); padding: 3rem; border-radius: var(--radius-lg); box-shadow: 0 10px 40px rgba(0,0,0,0.05); text-align: left; margin-bottom: 2rem;">
                    <h3 style="color: var(--accent); font-size: 1.5rem; margin-bottom: 1rem;">Visi</h3>
                    <p style="font-size: 1.25rem; font-weight: 500; color: var(--primary);">"{{ $profil->visi ?? \'Mewujudkan generasi unggul, berakhlak mulia, dan berwawasan global.\' }}"</p>
                </div>
                
                <div style="background: var(--white); padding: 3rem; border-radius: var(--radius-lg); box-shadow: 0 10px 40px rgba(0,0,0,0.05); text-align: left;">
                    <h3 style="color: var(--accent); font-size: 1.5rem; margin-bottom: 1rem;">Misi</h3>
                    <div style="font-size: 1.1rem; line-height: 1.8;">
                        {!! nl2br(e($profil->misi ?? "- Menyelenggarakan pembelajaran yang aktif, inovatif, kreatif, dan menyenangkan.\n- Mengembangkan potensi peserta didik secara optimal melalui kegiatan ekstrakurikuler.\n- Menanamkan nilai-nilai karakter bangsa dan budi pekerti luhur.")) !!}
                    </div>
                </div>
            </div>
        </div>'
    ],
    'guru_staff' => [
        'title' => 'Guru & Staff',
        'content' => '
        <div class="container" style="padding: 120px 5% 5rem;">
            <h2 class="section-title text-center">Direktori Guru & Staff</h2>
            <p class="section-subtitle mx-auto text-center" style="margin-bottom: 4rem;">Para pendidik berdedikasi yang siap membimbing siswa-siswi meraih cita-cita.</p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 2rem;">
                @foreach($gurus as $guru)
                <div style="background: var(--white); border-radius: var(--radius-md); overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.05); text-align: center;">
                    <div style="height: 200px; background: var(--bg-light); display: flex; align-items: center; justify-content: center;">
                        @if($guru->foto)
                            <img src="{{ Storage::url($guru->foto) }}" alt="{{ $guru->nama }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i data-lucide="user" size="64" style="color: var(--border);"></i>
                        @endif
                    </div>
                    <div style="padding: 1.5rem;">
                        <h4 style="font-size: 1.1rem; margin-bottom: 0.25rem;">{{ $guru->nama }}</h4>
                        <p style="color: var(--accent); font-size: 0.9rem; font-weight: 600;">{{ $guru->posisi ?? \'Guru\' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>'
    ],
    'kurikulum' => [
        'title' => 'Kurikulum',
        'content' => '
        <div class="container" style="padding: 120px 5% 5rem;">
            <div style="max-width: 800px; margin: 0 auto; text-align: center;">
                <h2 class="section-title">Kurikulum Merdeka</h2>
                <p class="section-subtitle mx-auto">Astika Dharma menerapkan kurikulum yang fleksibel dan berpusat pada minat serta bakat siswa.</p>
                <div style="background: var(--white); padding: 3rem; border-radius: var(--radius-lg); box-shadow: 0 10px 40px rgba(0,0,0,0.05); text-align: left;">
                    <p style="font-size: 1.1rem; margin-bottom: 1.5rem;">Kurikulum Merdeka memberikan keleluasaan bagi pendidik untuk menciptakan pembelajaran berkualitas yang sesuai dengan kebutuhan dan lingkungan belajar peserta didik.</p>
                    <ul style="list-style-type: none; font-size: 1.1rem; line-height: 2;">
                        <li><i data-lucide="check-circle" style="color: var(--accent); margin-right: 10px; vertical-align: middle;"></i> Pembelajaran berbasis proyek (Project-Based Learning)</li>
                        <li><i data-lucide="check-circle" style="color: var(--accent); margin-right: 10px; vertical-align: middle;"></i> Fokus pada materi esensial dan pengembangan kompetensi dasar</li>
                        <li><i data-lucide="check-circle" style="color: var(--accent); margin-right: 10px; vertical-align: middle;"></i> Fleksibilitas bagi guru untuk menyesuaikan pembelajaran dengan konteks lokal</li>
                    </ul>
                </div>
            </div>
        </div>'
    ],
    'pengumuman' => [
        'title' => 'Pengumuman',
        'content' => '
        <div class="container" style="padding: 120px 5% 5rem;">
            <h2 class="section-title text-center">Papan Pengumuman</h2>
            <div style="max-width: 800px; margin: 3rem auto 0; background: var(--white); border-radius: var(--radius-lg); box-shadow: 0 10px 40px rgba(0,0,0,0.05); padding: 2rem;">
                <div style="border-bottom: 1px solid var(--border); padding-bottom: 1.5rem; margin-bottom: 1.5rem;">
                    <span style="background: rgba(37,99,235,0.1); color: var(--accent); padding: 4px 12px; border-radius: 50px; font-size: 0.8rem; font-weight: 600;">12 Agustus 2026</span>
                    <h3 style="margin: 0.5rem 0;">Informasi Pengambilan Ijazah Alumni 2025/2026</h3>
                    <p style="color: var(--text-muted); margin-bottom: 1rem;">Pengambilan ijazah bagi alumni tahun ajaran 2025/2026 dapat dilakukan di ruang Tata Usaha mulai tanggal 15 Agustus pada jam kerja.</p>
                    <a href="#" class="link-arrow" style="font-size: 0.9rem;">Selengkapnya <i data-lucide="arrow-right" size="14"></i></a>
                </div>
                <div style="border-bottom: 1px solid var(--border); padding-bottom: 1.5rem; margin-bottom: 1.5rem;">
                    <span style="background: rgba(37,99,235,0.1); color: var(--accent); padding: 4px 12px; border-radius: 50px; font-size: 0.8rem; font-weight: 600;">10 Agustus 2026</span>
                    <h3 style="margin: 0.5rem 0;">Libur Nasional Hari Kemerdekaan</h3>
                    <p style="color: var(--text-muted); margin-bottom: 1rem;">Diberitahukan kepada seluruh siswa bahwa kegiatan belajar mengajar diliburkan pada tanggal 17 Agustus 2026.</p>
                    <a href="#" class="link-arrow" style="font-size: 0.9rem;">Selengkapnya <i data-lucide="arrow-right" size="14"></i></a>
                </div>
                <div style="text-align: center;">
                    <p style="color: var(--text-muted);">Tidak ada pengumuman lain.</p>
                </div>
            </div>
        </div>'
    ],
    'agenda' => [
        'title' => 'Agenda Kegiatan',
        'content' => '
        <div class="container" style="padding: 120px 5% 5rem;">
            <h2 class="section-title text-center">Agenda Kegiatan Sekolah</h2>
            <div style="max-width: 800px; margin: 3rem auto 0;">
                <div style="display: flex; background: var(--white); border-radius: var(--radius-lg); overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.05); margin-bottom: 1.5rem;">
                    <div style="background: var(--accent); color: var(--white); padding: 2rem; display: flex; flex-direction: column; justify-content: center; align-items: center; min-width: 150px;">
                        <h2 style="color: var(--white); font-size: 2.5rem; margin: 0; line-height: 1;">17</h2>
                        <span style="text-transform: uppercase; letter-spacing: 2px;">Agustus</span>
                    </div>
                    <div style="padding: 2rem;">
                        <h3 style="margin-bottom: 0.5rem;">Upacara Bendera HUT RI ke-81</h3>
                        <p style="color: var(--text-muted); margin-bottom: 1rem;"><i data-lucide="clock" size="16" style="vertical-align: middle;"></i> 07:00 - Selesai &nbsp;&nbsp; <i data-lucide="map-pin" size="16" style="vertical-align: middle;"></i> Lapangan Utama</p>
                        <p>Wajib diikuti oleh seluruh civitas akademika mengenakan seragam upacara lengkap.</p>
                    </div>
                </div>
                
                <div style="display: flex; background: var(--white); border-radius: var(--radius-lg); overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.05); margin-bottom: 1.5rem;">
                    <div style="background: var(--primary); color: var(--white); padding: 2rem; display: flex; flex-direction: column; justify-content: center; align-items: center; min-width: 150px;">
                        <h2 style="color: var(--white); font-size: 2.5rem; margin: 0; line-height: 1;">24</h2>
                        <span style="text-transform: uppercase; letter-spacing: 2px;">Agustus</span>
                    </div>
                    <div style="padding: 2rem;">
                        <h3 style="margin-bottom: 0.5rem;">Pekan Olahraga Antar Kelas (Porak)</h3>
                        <p style="color: var(--text-muted); margin-bottom: 1rem;"><i data-lucide="clock" size="16" style="vertical-align: middle;"></i> 08:00 - 15:00 &nbsp;&nbsp; <i data-lucide="map-pin" size="16" style="vertical-align: middle;"></i> Lapangan Olahraga</p>
                        <p>Pertandingan futsal, basket, dan bola voli antar kelas.</p>
                    </div>
                </div>
            </div>
        </div>'
    ]
];

foreach ($pages as $filename => $page) {
    $content = "@extends('layouts.landing')\n\n@section('content')\n" . $page['content'] . "\n@endsection\n";
    file_put_contents($viewsDir . $filename . '.blade.php', $content);
}
echo 'Pages created.';
