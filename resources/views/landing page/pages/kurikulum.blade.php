@extends('layouts.landing')

@section('content')

    <div style="position: relative; height: 400px; display: flex; align-items: center; justify-content: center; text-align: center; color: white;">
        <div style="position: absolute; inset: 0; background-image: url('https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop'); background-size: cover; background-position: center; z-index: 1;"></div>
        <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(15,23,42,0.8), rgba(15,23,42,0.9)); z-index: 2;"></div>
        <div style="position: relative; z-index: 3; max-width: 800px; padding: 0 5%; margin-top: 50px;">
            <h1 style="font-size: 3.5rem; font-weight: 800; margin-bottom: 1rem; color: white; font-family: var(--font-heading);">Kurikulum</h1>
            <div style="display: flex; gap: 0.5rem; justify-content: center; font-size: 1rem; opacity: 0.8; font-weight: 500;">
                <a href="{{ route('landing_page') }}">Beranda</a>
                <span>/</span>
                <span>Kurikulum</span>
            </div>
        </div>
    </div>
    
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
        </div>
@endsection
