@extends('layouts.landing')

@section('content')

    <div style="position: relative; height: 400px; display: flex; align-items: center; justify-content: center; text-align: center; color: white;">
        <div style="position: absolute; inset: 0; background-image: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop'); background-size: cover; background-position: center; z-index: 1;"></div>
        <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(15,23,42,0.8), rgba(15,23,42,0.9)); z-index: 2;"></div>
        <div style="position: relative; z-index: 3; max-width: 800px; padding: 0 5%; margin-top: 50px;">
            <h1 style="font-size: 3.5rem; font-weight: 800; margin-bottom: 1rem; color: white;">Sejarah Sekolah</h1>
            <div style="display: flex; gap: 0.5rem; justify-content: center; font-size: 1rem; opacity: 0.8;">
                <a href="{{ route('landing_page') }}">Beranda</a>
                <span>/</span>
                <span>Profil</span>
                <span>/</span>
                <span>Sejarah Sekolah</span>
            </div>
        </div>
    </div>
    
        <div class="container" style="padding: 5rem 5%; margin-top: -3rem;">
            <div style="max-width: 1000px; margin: 0 auto; background: var(--white); padding: 4rem; border-radius: var(--radius-lg); box-shadow: 0 20px 40px rgba(0,0,0,0.08); position: relative; z-index: 10;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center;">
                    <div>
                        <h2 class="section-title" style="margin-bottom: 1.5rem;">Awal Mula Berdiri</h2>
                        <p style="font-size: 1.1rem; line-height: 1.8; margin-bottom: 1.5rem; text-align: justify;">Sekolah Astika Dharma didirikan pada tahun 1998 dengan semangat untuk memajukan pendidikan di daerah sekitar. Berawal dari 2 gedung kelas sederhana, kini Astika Dharma telah berkembang menjadi salah satu sekolah terfavorit dan terlengkap.</p>
                        <p style="font-size: 1.1rem; line-height: 1.8; text-align: justify;">Dalam perjalanannya, sekolah ini terus melakukan inovasi kurikulum dan penyediaan fasilitas mutakhir, termasuk laboratorium teknologi informasi dan perpustakaan digital, untuk menjawab tantangan global.</p>
                    </div>
                    <div>
                        <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=2070&auto=format&fit=crop" style="border-radius: var(--radius-md); box-shadow: 0 10px 20px rgba(0,0,0,0.1);" alt="Sejarah">
                    </div>
                </div>
                <div style="margin-top: 4rem; padding-top: 3rem; border-top: 1px solid var(--border);">
                    <h3 style="font-size: 1.8rem; margin-bottom: 2rem; color: var(--primary); text-align: center;">Tonggak Sejarah Penting</h3>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div style="display: flex; gap: 1.5rem; align-items: flex-start;">
                            <div style="background: var(--accent); color: var(--white); padding: 0.5rem 1rem; border-radius: var(--radius-sm); font-weight: 700; font-family: var(--font-heading);">1998</div>
                            <div>
                                <h4 style="font-size: 1.2rem; margin-bottom: 0.5rem;">Pendirian Yayasan</h4>
                                <p style="color: var(--text-muted);">Sekolah mulai dibangun dan menerima 50 siswa angkatan pertama.</p>
                            </div>
                        </div>
                        <div style="display: flex; gap: 1.5rem; align-items: flex-start;">
                            <div style="background: var(--accent); color: var(--white); padding: 0.5rem 1rem; border-radius: var(--radius-sm); font-weight: 700; font-family: var(--font-heading);">2005</div>
                            <div>
                                <h4 style="font-size: 1.2rem; margin-bottom: 0.5rem;">Akreditasi A</h4>
                                <p style="color: var(--text-muted);">Mendapatkan akreditasi A untuk pertama kalinya dari Badan Akreditasi Nasional.</p>
                            </div>
                        </div>
                        <div style="display: flex; gap: 1.5rem; align-items: flex-start;">
                            <div style="background: var(--accent); color: var(--white); padding: 0.5rem 1rem; border-radius: var(--radius-sm); font-weight: 700; font-family: var(--font-heading);">2020</div>
                            <div>
                                <h4 style="font-size: 1.2rem; margin-bottom: 0.5rem;">Ekspansi Kampus</h4>
                                <p style="color: var(--text-muted);">Pembangunan gedung baru berlantai 4 dan fasilitas lab komputer standar industri.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
