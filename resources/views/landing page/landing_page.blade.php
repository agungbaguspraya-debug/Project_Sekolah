@extends('layouts.landing')

@section('content')
<!-- Hero -->
    <header class="hero" id="beranda">
        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop" alt="Sekolah Astika Dharma" class="hero-bg">
        <div class="hero-overlay"></div>
        <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
            <h1>MEMBENTUK GENERASI UNGGUL UNTUK MASA DEPAN</h1>
            <p>Pendidikan berkualitas untuk membangun karakter, kompetensi, dan kreativitas peserta didik. Mari mulai perjalanan prestasimu bersama Astika Dharma.</p>
            <div class="hero-btns">
                <a href="{{ route('register') }}" class="btn btn-primary">Daftar Sekarang</a>
                <a href="#profil" class="btn btn-outline">Jelajahi Sekolah</a>
            </div>
        </div>
    </header>

    <!-- Statistics -->
    <section class="container" style="position: relative;">
        <div class="stats" data-aos="fade-up" data-aos-delay="200" id="stats-section">
            <div class="stats-grid">
                <div class="stat-item">
                    <h3><span class="counter" data-target="{{ $siswaCount }}">0</span>+</h3>
                    <p>Siswa</p>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <h3><span class="counter" data-target="{{ $guruCount }}">0</span>+</h3>
                    <p>Guru & Staf</p>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <h3><span class="counter" data-target="{{ $alumniCount }}">0</span>+</h3>
                    <p>Alumni</p>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <h3><span class="counter" data-target="{{ $tahunDedikasi }}">0</span>+</h3>
                    <p>Tahun Dedikasi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Sekolah -->
    <section class="about" id="profil">
        <div class="container about-grid">
            <div class="about-image" data-aos="fade-right" data-aos-duration="800">
                <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=2022&auto=format&fit=crop" alt="Tentang Astika Dharma">
            </div>
            <div class="about-text" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                <div class="about-badge">Tentang {{ $profil?->nama_sekolah ?? 'Astika Dharma' }}</div>
                <h2 class="section-title">Mengenal Lebih Dekat</h2>
                <p>{{ $profil?->visi ?? 'Sekolah Astika Dharma adalah lembaga pendidikan terkemuka yang berdedikasi untuk menciptakan lingkungan belajar yang inspiratif dan berpusat pada siswa.' }}</p>
                <p>{{ $profil?->misi ?? 'Dengan fasilitas modern dan tenaga pengajar yang berdedikasi, kami menyeimbangkan prestasi akademik dengan pembentukan karakter mulia.' }}</p>
                <a href="#" class="link-arrow">Selengkapnya <i data-lucide="arrow-right" size="18"></i></a>
            </div>
        </div>
    </section>

    <!-- Program Keahlian -->
    <section class="programs" id="program">
        <div class="container text-center">
            <h2 class="section-title" data-aos="fade-up">Program Keahlian</h2>
            <p class="section-subtitle mx-auto" data-aos="fade-up" data-aos-delay="100">Temukan bidang yang sesuai dengan minat dan masa depanmu. Kami menawarkan kurikulum unggul yang dirancang untuk kesuksesan industri.</p>
            
            <div class="programs-grid">
                @foreach($jurusans as $index => $jurusan)
                <div class="program-card" data-aos="fade-up" data-aos-delay="{{ 200 + ($index * 100) }}">
                    <div class="program-icon">
                        <i data-lucide="{{ ['monitor', 'briefcase', 'camera'][$index % 3] }}" size="28"></i>
                    </div>
                    <h3>{{ $jurusan->nama_jurusan }}</h3>
                    <p>{{ $jurusan->deskripsi ?? 'Pelajari skill unggulan dan kembangkan potensi diri untuk masa depan di industri terkait.' }}</p>
                    <a href="#" class="link-arrow">Lihat Kurikulum <i data-lucide="arrow-right" size="16"></i></a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Fasilitas -->
    <section class="facilities bg-light" id="fasilitas">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;" data-aos="fade-up">
                <div>
                    <h2 class="section-title" style="margin-bottom: 0;">Fasilitas Sekolah</h2>
                </div>
                <a href="#" class="link-arrow">Lihat Semua Fasilitas <i data-lucide="arrow-right" size="18"></i></a>
            </div>
            
            <div class="fac-grid">
                @foreach($fasilitas as $index => $fac)
                <div class="fac-item {{ $fac->is_large ? 'large' : '' }}" @if($index == 0) data-aos="zoom-in" data-aos-duration="800" @endif>
                    <img src="{{ $fac->foto }}" alt="{{ $fac->nama_fasilitas }}">
                    <div class="fac-overlay">
                        <div class="fac-content">
                            <h3>{{ $fac->nama_fasilitas }}</h3>
                            @if($fac->deskripsi)
                            <p>{{ $fac->deskripsi }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Ekstrakurikuler -->
    <section class="eksul" id="ekstrakurikuler">
        <div class="container">
            <h2 class="section-title" style="margin-bottom: 2rem;" data-aos="fade-up">Ekstrakurikuler</h2>
            <div class="eksul-wrapper" data-aos="fade-left" data-aos-delay="200">
                @foreach($ekstrakurikuler as $eks)
                <div class="eksul-card">
                    <img src="{{ $eks->foto }}" alt="{{ $eks->nama_ekstrakurikuler }}">
                    <div class="overlay"><h3>{{ $eks->nama_ekstrakurikuler }}</h3></div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Prestasi -->
    <section class="prestasi bg-light" id="prestasi">
        <div class="container">
            <div class="prestasi-box" data-aos="flip-up" data-aos-duration="1000">
                @if($prestasiUtama)
                <div class="prestasi-img">
                    <img src="{{ $prestasiUtama->foto }}" alt="Prestasi Siswa">
                </div>
                <div class="prestasi-content">
                    <div class="prestasi-year">TAHUN {{ $prestasiUtama->tahun }}</div>
                    <h2>{{ $prestasiUtama->judul_prestasi }}</h2>
                    <p style="color: var(--text-muted); margin-bottom: 2rem; font-size: 1.1rem;">{{ $prestasiUtama->deskripsi }}</p>
                    <div>
                        <a href="#" class="btn btn-primary">Lihat Semua Prestasi</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Berita -->
    <section class="news" id="berita">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;" data-aos="fade-up">
                <div>
                    <h2 class="section-title" style="margin-bottom: 0;">Berita Terbaru</h2>
                </div>
                <a href="#" class="link-arrow">Semua Berita <i data-lucide="arrow-right" size="18"></i></a>
            </div>

            <div class="news-grid">
                <!-- Highlight News -->
                @if($beritaHighlight)
                <div class="news-main" data-aos="fade-right">
                    <img src="{{ $beritaHighlight->foto }}" alt="{{ $beritaHighlight->judul }}">
                    <div class="news-main-overlay">
                        <span class="news-date">{{ \Carbon\Carbon::parse($beritaHighlight->tanggal_publikasi)->translatedFormat('d F Y') }}</span>
                        <h3>{{ $beritaHighlight->judul }}</h3>
                        <a href="#" class="link-arrow" style="color: var(--white); opacity: 0.9;">Baca selengkapnya <i data-lucide="arrow-right" size="16"></i></a>
                    </div>
                </div>
                @endif
                <!-- Small News -->
                <div class="news-list">
                    @foreach($beritaList as $berita)
                    <div class="news-card">
                        <img src="{{ $berita->foto }}" alt="{{ $berita->judul }}">
                        <div class="news-card-content">
                            <span class="news-date" style="font-size: 0.75rem; color: var(--accent);">{{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->translatedFormat('d F Y') }}</span>
                            <h4>{{ $berita->judul }}</h4>
                            <a href="#" class="link-arrow" style="font-size: 0.9rem; margin-top: 0.5rem;">Baca selengkapnya <i data-lucide="arrow-right" size="14"></i></a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Galeri (Masonry) -->
    <section class="gallery bg-light" id="galeri">
        <div class="container">
            <h2 class="section-title text-center" style="margin-bottom: 2rem;">Galeri Sekolah</h2>
            <div class="gallery-grid">
                @foreach($galeri as $gal)
                <div class="gallery-item"><img src="{{ $gal->foto }}" alt="{{ $gal->judul }}"></div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="container">
            <h2 class="section-subtitle mx-auto" style="color: var(--accent); font-weight: 700; margin-bottom: 1rem; text-transform: uppercase;">Apa Kata Mereka?</h2>
            
            <div class="testi-slider">
                @foreach($testimoni as $index => $testi)
                <div class="testi-item" style="display: {{ $index == 0 ? 'block' : 'none' }};">
                    <p class="testi-content">"{{ $testi->konten }}"</p>
                    <div class="testi-author">
                        <h4>{{ $testi->nama }}</h4>
                        <p>{{ $testi->peran }}</p>
                    </div>
                </div>
                @endforeach
                
                <div class="testi-dots">
                    @foreach($testimoni as $index => $testi)
                    <div class="dot {{ $index == 0 ? 'active' : '' }}"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="faq bg-light" id="faq">
        <h2 class="section-title text-center" style="margin-bottom: 3rem;">Pertanyaan yang Sering Ditanyakan</h2>
        
        @foreach($faqs as $index => $faq)
        <details class="faq-item" {{ $index == 0 ? 'open' : '' }}>
            <summary class="faq-summary">
                {{ $faq->pertanyaan }}
                <i data-lucide="plus" class="faq-icon"></i>
            </summary>
            <div class="faq-content">
                {{ $faq->jawaban }}
            </div>
        </details>
        @endforeach
    </section>

    <!-- CTA PPDB -->
    <section class="cta" id="ppdb">
        <div class="container">
            <div class="cta-box">
                <div class="cta-decoration"></div>
                <h2>Siap Menjadi Bagian dari Astika Dharma?</h2>
                <p>Mulai perjalanan pendidikanmu bersama kami dan raih masa depan yang gemilang.</p>
                <div style="position: relative; z-index: 2;">
                    <a href="#kontak" class="btn btn-outline" style="margin-right: 1rem; border-color: white;">Hubungi Kami</a>
                    <a href="{{ route('register') }}" class="btn" style="background: var(--white); color: var(--primary);">Daftar Sekarang <i data-lucide="arrow-right" size="18"></i></a>
                </div>
            </div>
        </div>
    </section>
@endsection
