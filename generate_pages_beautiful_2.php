<?php
$viewsDir = __DIR__ . '/resources/views/landing page/pages/';
if (!is_dir($viewsDir)) {
    mkdir($viewsDir, 0777, true);
}

$pages = [
    'kurikulum' => [
        'title' => 'Kurikulum',
        'bg' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop',
        'content' => '
        <div class="container" style="padding: 5rem 5%; margin-top: -3rem;">
            <div style="max-width: 900px; margin: 0 auto; text-align: center; position: relative; z-index: 10;">
                <div style="background: var(--white); padding: 4rem; border-radius: var(--radius-lg); box-shadow: 0 20px 40px rgba(0,0,0,0.08); text-align: left;">
                    <div style="text-align: center; margin-bottom: 2rem;">
                        <h2 style="color: var(--primary); font-size: 2.2rem; margin-bottom: 1rem; font-family: var(--font-heading);">Kurikulum Merdeka</h2>
                        <p style="font-size: 1.15rem; color: var(--text-muted);">Astika Dharma menerapkan kurikulum yang fleksibel dan berpusat pada minat serta bakat siswa.</p>
                    </div>
                    
                    <p style="font-size: 1.15rem; line-height: 1.8; margin-bottom: 2rem; color: var(--text-main);">Kurikulum Merdeka memberikan keleluasaan bagi pendidik untuk menciptakan pembelajaran berkualitas yang sesuai dengan kebutuhan dan lingkungan belajar peserta didik. Pendekatan ini memungkinkan siswa untuk belajar dengan lebih menyenangkan dan mendalam.</p>
                    
                    <ul style="list-style-type: none; padding: 0;">
                        <li style="display: flex; gap: 1rem; margin-bottom: 1.5rem; align-items: flex-start; background: var(--bg-light); padding: 1.5rem; border-radius: var(--radius-md);">
                            <i data-lucide="compass" size="32" style="color: var(--accent); flex-shrink: 0;"></i>
                            <div>
                                <strong style="display: block; font-size: 1.1rem; color: var(--primary); margin-bottom: 0.25rem;">Pembelajaran Berbasis Proyek (Project-Based Learning)</strong>
                                <span style="color: var(--text-muted);">Fokus pada penyelesaian masalah nyata melalui kolaborasi dan kreativitas.</span>
                            </div>
                        </li>
                        <li style="display: flex; gap: 1rem; margin-bottom: 1.5rem; align-items: flex-start; background: var(--bg-light); padding: 1.5rem; border-radius: var(--radius-md);">
                            <i data-lucide="book-open" size="32" style="color: var(--accent); flex-shrink: 0;"></i>
                            <div>
                                <strong style="display: block; font-size: 1.1rem; color: var(--primary); margin-bottom: 0.25rem;">Fokus pada Materi Esensial</strong>
                                <span style="color: var(--text-muted);">Mendalami konsep dasar secara komprehensif tanpa terbebani dengan muatan materi yang terlalu padat.</span>
                            </div>
                        </li>
                        <li style="display: flex; gap: 1rem; align-items: flex-start; background: var(--bg-light); padding: 1.5rem; border-radius: var(--radius-md);">
                            <i data-lucide="users" size="32" style="color: var(--accent); flex-shrink: 0;"></i>
                            <div>
                                <strong style="display: block; font-size: 1.1rem; color: var(--primary); margin-bottom: 0.25rem;">Pengembangan Karakter Profil Pelajar Pancasila</strong>
                                <span style="color: var(--text-muted);">Penanaman nilai-nilai budi pekerti, kemandirian, dan gotong royong terintegrasi dalam setiap mata pelajaran.</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>'
    ],
    'pengumuman' => [
        'title' => 'Papan Pengumuman',
        'bg' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=2070&auto=format&fit=crop',
        'content' => '
        <div class="container" style="padding: 5rem 5%; margin-top: -3rem;">
            <div style="max-width: 900px; margin: 0 auto; background: var(--white); border-radius: var(--radius-lg); box-shadow: 0 20px 40px rgba(0,0,0,0.08); padding: 3rem; position: relative; z-index: 10;">
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 2px solid var(--border);">
                    <h2 style="color: var(--primary); font-size: 1.8rem; margin: 0;">Informasi Terbaru</h2>
                    <span style="background: rgba(37,99,235,0.1); color: var(--accent); padding: 5px 15px; border-radius: 50px; font-weight: 600; font-size: 0.9rem;">2 Pengumuman</span>
                </div>
                
                <div class="announcement-item" style="padding: 2rem; background: var(--bg-light); border-radius: var(--radius-md); margin-bottom: 1.5rem; border-left: 4px solid var(--accent); transition: var(--transition);">
                    <div style="display: flex; gap: 0.5rem; align-items: center; margin-bottom: 0.75rem;">
                        <i data-lucide="calendar" size="16" style="color: var(--text-muted);"></i>
                        <span style="color: var(--text-muted); font-size: 0.9rem; font-weight: 500;">12 Agustus 2026</span>
                        <span style="margin: 0 0.5rem; color: var(--border);">|</span>
                        <span style="background: rgba(16, 185, 129, 0.1); color: #10B981; padding: 2px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: 600;">Akademik</span>
                    </div>
                    <h3 style="margin: 0 0 1rem 0; color: var(--primary); font-size: 1.4rem;">Informasi Pengambilan Ijazah Alumni 2025/2026</h3>
                    <p style="color: var(--text-main); margin-bottom: 1.5rem; line-height: 1.6;">Bagi siswa-siswi kelas XII tahun ajaran 2025/2026 yang telah dinyatakan lulus, pengambilan ijazah beserta transkrip nilai dapat dilakukan mulai tanggal 15 Agustus 2026 di Ruang Tata Usaha dengan membawa bukti bebas tanggungan perpustakaan dan laboratorium.</p>
                    <a href="#" class="btn btn-outline" style="border-color: var(--border); color: var(--text-main); padding: 0.5rem 1.25rem; font-size: 0.9rem;">Baca Detail <i data-lucide="arrow-right" size="16"></i></a>
                </div>
                
                <div class="announcement-item" style="padding: 2rem; background: var(--bg-light); border-radius: var(--radius-md); border-left: 4px solid #F59E0B; transition: var(--transition);">
                    <div style="display: flex; gap: 0.5rem; align-items: center; margin-bottom: 0.75rem;">
                        <i data-lucide="calendar" size="16" style="color: var(--text-muted);"></i>
                        <span style="color: var(--text-muted); font-size: 0.9rem; font-weight: 500;">10 Agustus 2026</span>
                        <span style="margin: 0 0.5rem; color: var(--border);">|</span>
                        <span style="background: rgba(245, 158, 11, 0.1); color: #F59E0B; padding: 2px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: 600;">Umum</span>
                    </div>
                    <h3 style="margin: 0 0 1rem 0; color: var(--primary); font-size: 1.4rem;">Libur Nasional Hari Kemerdekaan RI ke-81</h3>
                    <p style="color: var(--text-main); margin-bottom: 1.5rem; line-height: 1.6;">Diberitahukan kepada seluruh civitas akademika Sekolah Astika Dharma, bahwa dalam rangka memperingati Hari Kemerdekaan Republik Indonesia ke-81, kegiatan belajar mengajar akan diliburkan pada tanggal 17 Agustus 2026. Namun, seluruh siswa dan guru DIWAJIBKAN hadir untuk mengikuti upacara bendera.</p>
                </div>
            </div>
            <style>
                .announcement-item:hover { transform: translateX(5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
            </style>
        </div>'
    ],
    'agenda' => [
        'title' => 'Agenda Kegiatan',
        'bg' => 'https://images.unsplash.com/photo-1506784951206-a9f7acaef9a8?q=80&w=2074&auto=format&fit=crop',
        'content' => '
        <div class="container" style="padding: 5rem 5%; margin-top: -3rem;">
            <div style="max-width: 900px; margin: 0 auto; position: relative; z-index: 10;">
                
                <div style="display: flex; background: var(--white); border-radius: var(--radius-lg); overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.08); margin-bottom: 2rem; transition: var(--transition);" class="agenda-card">
                    <div style="background: linear-gradient(135deg, var(--primary), var(--accent)); color: var(--white); padding: 2.5rem 2rem; display: flex; flex-direction: column; justify-content: center; align-items: center; min-width: 180px; text-align: center;">
                        <span style="text-transform: uppercase; letter-spacing: 2px; font-size: 0.9rem; font-weight: 600; opacity: 0.8;">Agustus</span>
                        <h2 style="color: var(--white); font-size: 3.5rem; margin: 0.25rem 0; line-height: 1; font-family: var(--font-heading);">17</h2>
                        <span style="font-size: 1.1rem; font-weight: 500;">2026</span>
                    </div>
                    <div style="padding: 2.5rem;">
                        <span style="background: rgba(239, 68, 68, 0.1); color: #EF4444; padding: 4px 12px; border-radius: 50px; font-size: 0.8rem; font-weight: 600; margin-bottom: 1rem; display: inline-block;">Wajib</span>
                        <h3 style="margin: 0 0 1rem 0; font-size: 1.6rem; color: var(--primary);">Upacara Bendera HUT RI ke-81</h3>
                        <div style="display: flex; gap: 1.5rem; margin-bottom: 1.5rem;">
                            <span style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-muted); font-size: 0.95rem;">
                                <i data-lucide="clock" size="18"></i> 07:00 WITA - Selesai
                            </span>
                            <span style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-muted); font-size: 0.95rem;">
                                <i data-lucide="map-pin" size="18"></i> Lapangan Utama
                            </span>
                        </div>
                        <p style="color: var(--text-main); margin: 0; line-height: 1.6;">Wajib diikuti oleh seluruh civitas akademika (guru, staf, dan seluruh siswa) mengenakan seragam OSIS lengkap dengan atribut.</p>
                    </div>
                </div>
                
                <div style="display: flex; background: var(--white); border-radius: var(--radius-lg); overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 2rem; transition: var(--transition);" class="agenda-card">
                    <div style="background: var(--bg-light); color: var(--primary); padding: 2.5rem 2rem; display: flex; flex-direction: column; justify-content: center; align-items: center; min-width: 180px; text-align: center; border-right: 1px solid var(--border);">
                        <span style="text-transform: uppercase; letter-spacing: 2px; font-size: 0.9rem; font-weight: 600; color: var(--text-muted);">Agustus</span>
                        <h2 style="color: var(--primary); font-size: 3.5rem; margin: 0.25rem 0; line-height: 1; font-family: var(--font-heading);">24</h2>
                        <span style="font-size: 1.1rem; font-weight: 500; color: var(--text-muted);">2026</span>
                    </div>
                    <div style="padding: 2.5rem;">
                        <span style="background: rgba(16, 185, 129, 0.1); color: #10B981; padding: 4px 12px; border-radius: 50px; font-size: 0.8rem; font-weight: 600; margin-bottom: 1rem; display: inline-block;">Ekstrakurikuler</span>
                        <h3 style="margin: 0 0 1rem 0; font-size: 1.6rem; color: var(--primary);">Pekan Olahraga Antar Kelas (Porak)</h3>
                        <div style="display: flex; gap: 1.5rem; margin-bottom: 1.5rem;">
                            <span style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-muted); font-size: 0.95rem;">
                                <i data-lucide="clock" size="18"></i> 08:00 - 15:00 WITA
                            </span>
                            <span style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-muted); font-size: 0.95rem;">
                                <i data-lucide="map-pin" size="18"></i> Gelanggang Olahraga
                            </span>
                        </div>
                        <p style="color: var(--text-main); margin: 0; line-height: 1.6;">Ajang pencarian bakat dan pertandingan persahabatan antar kelas untuk cabang olahraga futsal, bola basket, dan voli.</p>
                    </div>
                </div>
                
            </div>
            <style>
                .agenda-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.12) !important; }
            </style>
        </div>'
    ]
];

foreach ($pages as $filename => $page) {
    $content = "@extends('layouts.landing')\n\n@section('content')\n";
    
    // Add Mini Hero
    $content .= '
    <div style="position: relative; height: 400px; display: flex; align-items: center; justify-content: center; text-align: center; color: white;">
        <div style="position: absolute; inset: 0; background-image: url(\''.$page['bg'].'\'); background-size: cover; background-position: center; z-index: 1;"></div>
        <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(15,23,42,0.8), rgba(15,23,42,0.9)); z-index: 2;"></div>
        <div style="position: relative; z-index: 3; max-width: 800px; padding: 0 5%; margin-top: 50px;">
            <h1 style="font-size: 3.5rem; font-weight: 800; margin-bottom: 1rem; color: white; font-family: var(--font-heading);">'.$page['title'].'</h1>
            <div style="display: flex; gap: 0.5rem; justify-content: center; font-size: 1rem; opacity: 0.8; font-weight: 500;">
                <a href="{{ route(\'landing_page\') }}">Beranda</a>
                <span>/</span>
                <span>'.$page['title'].'</span>
            </div>
        </div>
    </div>
    ';
    
    $content .= $page['content'] . "\n@endsection\n";
    file_put_contents($viewsDir . $filename . '.blade.php', $content);
}
echo 'Remaining pages generated beautifully.';
