@extends('layouts.landing')

@section('content')

    <div style="position: relative; height: 400px; display: flex; align-items: center; justify-content: center; text-align: center; color: white;">
        <div style="position: absolute; inset: 0; background-image: url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=2070&auto=format&fit=crop'); background-size: cover; background-position: center; z-index: 1;"></div>
        <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(15,23,42,0.8), rgba(15,23,42,0.9)); z-index: 2;"></div>
        <div style="position: relative; z-index: 3; max-width: 800px; padding: 0 5%; margin-top: 50px;">
            <h1 style="font-size: 3.5rem; font-weight: 800; margin-bottom: 1rem; color: white; font-family: var(--font-heading);">Papan Pengumuman</h1>
            <div style="display: flex; gap: 0.5rem; justify-content: center; font-size: 1rem; opacity: 0.8; font-weight: 500;">
                <a href="{{ route('landing_page') }}">Beranda</a>
                <span>/</span>
                <span>Papan Pengumuman</span>
            </div>
        </div>
    </div>
    
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
        </div>
@endsection
