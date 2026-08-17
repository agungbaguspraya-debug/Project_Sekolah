@extends('layouts.landing')

@section('content')

    <div style="position: relative; height: 400px; display: flex; align-items: center; justify-content: center; text-align: center; color: white;">
        <div style="position: absolute; inset: 0; background-image: url('https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=2120&auto=format&fit=crop'); background-size: cover; background-position: center; z-index: 1;"></div>
        <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(15,23,42,0.8), rgba(15,23,42,0.9)); z-index: 2;"></div>
        <div style="position: relative; z-index: 3; max-width: 800px; padding: 0 5%; margin-top: 50px;">
            <h1 style="font-size: 3.5rem; font-weight: 800; margin-bottom: 1rem; color: white;">Visi & Misi</h1>
            <div style="display: flex; gap: 0.5rem; justify-content: center; font-size: 1rem; opacity: 0.8;">
                <a href="{{ route('landing_page') }}">Beranda</a>
                <span>/</span>
                <span>Profil</span>
                <span>/</span>
                <span>Visi & Misi</span>
            </div>
        </div>
    </div>
    
        <div class="container" style="padding: 5rem 5%; margin-top: -3rem;">
            <div style="max-width: 900px; margin: 0 auto; position: relative; z-index: 10;">
                
                <div style="background: var(--white); padding: 4rem; border-radius: var(--radius-lg); box-shadow: 0 20px 40px rgba(0,0,0,0.08); text-align: center; margin-bottom: 3rem;">
                    <div style="width: 80px; height: 80px; background: rgba(37,99,235,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                        <i data-lucide="eye" size="40" style="color: var(--accent);"></i>
                    </div>
                    <h3 style="color: var(--primary); font-size: 2rem; margin-bottom: 1.5rem;">Visi Kami</h3>
                    <p style="font-size: 1.5rem; font-weight: 600; color: var(--text-main); font-family: var(--font-heading); line-height: 1.5;">"{{ $profil->visi ?? 'Mewujudkan generasi unggul, berakhlak mulia, dan berwawasan global.' }}"</p>
                </div>
                
                <div style="background: var(--white); padding: 4rem; border-radius: var(--radius-lg); box-shadow: 0 20px 40px rgba(0,0,0,0.08);">
                    <div style="text-align: center; margin-bottom: 3rem;">
                        <div style="width: 80px; height: 80px; background: rgba(37,99,235,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                            <i data-lucide="target" size="40" style="color: var(--accent);"></i>
                        </div>
                        <h3 style="color: var(--primary); font-size: 2rem;">Misi Kami</h3>
                    </div>
                    
                    <div style="font-size: 1.15rem; line-height: 2; padding: 0 2rem;">
                        @php
                            $misiList = explode("\n", $profil->misi ?? "- Menyelenggarakan pembelajaran yang aktif, inovatif, kreatif, dan menyenangkan.\n- Mengembangkan potensi peserta didik secara optimal melalui kegiatan ekstrakurikuler.\n- Menanamkan nilai-nilai karakter bangsa dan budi pekerti luhur.");
                        @endphp
                        
                        <ul style="list-style-type: none; padding: 0;">
                            @foreach($misiList as $misiItem)
                                @if(trim($misiItem) != "")
                                <li style="display: flex; gap: 1rem; margin-bottom: 1rem; align-items: flex-start;">
                                    <i data-lucide="check-circle-2" style="color: var(--accent); flex-shrink: 0; margin-top: 5px;"></i>
                                    <span>{{ ltrim(trim($misiItem), "-") }}</span>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
@endsection
