@extends('layouts.landing')

@section('content')

    <div style="position: relative; height: 400px; display: flex; align-items: center; justify-content: center; text-align: center; color: white;">
        <div style="position: absolute; inset: 0; background-image: url('https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=2070&auto=format&fit=crop'); background-size: cover; background-position: center; z-index: 1;"></div>
        <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(15,23,42,0.8), rgba(15,23,42,0.9)); z-index: 2;"></div>
        <div style="position: relative; z-index: 3; max-width: 800px; padding: 0 5%; margin-top: 50px;">
            <h1 style="font-size: 3.5rem; font-weight: 800; margin-bottom: 1rem; color: white;">Direktori Guru & Staff</h1>
            <div style="display: flex; gap: 0.5rem; justify-content: center; font-size: 1rem; opacity: 0.8;">
                <a href="{{ route('landing_page') }}">Beranda</a>
                <span>/</span>
                <span>Profil</span>
                <span>/</span>
                <span>Direktori Guru & Staff</span>
            </div>
        </div>
    </div>
    
        <div class="container" style="padding: 5rem 5%;">
            <div style="text-align: center; margin-bottom: 4rem;">
                <p class="section-subtitle mx-auto">Mengenal lebih dekat para pendidik berdedikasi tinggi yang siap membimbing siswa-siswi meraih cita-cita dan masa depan yang gemilang.</p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2.5rem;">
                @foreach($gurus as $guru)
                <div style="background: var(--white); border-radius: var(--radius-lg); overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.06); transition: var(--transition);" class="guru-card">
                    <div style="height: 250px; background: var(--bg-light); display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        @if($guru->foto)
                            <img src="{{ Storage::url($guru->foto) }}" alt="{{ $guru->nama }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;">
                        @else
                            <i data-lucide="user" size="64" style="color: var(--border);"></i>
                        @endif
                    </div>
                    <div style="padding: 2rem; text-align: center;">
                        <h4 style="font-size: 1.2rem; margin-bottom: 0.5rem;">{{ $guru->nama }}</h4>
                        <p style="color: var(--accent); font-size: 0.95rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;">{{ $guru->posisi ?? 'Guru Pengajar' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <style>
                .guru-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
                .guru-card:hover img { transform: scale(1.05); }
            </style>
        </div>
@endsection
