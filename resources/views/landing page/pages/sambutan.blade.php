@extends('layouts.landing')

@section('content')

    <div style="position: relative; height: 400px; display: flex; align-items: center; justify-content: center; text-align: center; color: white;">
        <div style="position: absolute; inset: 0; background-image: url('https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=2070&auto=format&fit=crop'); background-size: cover; background-position: center; z-index: 1;"></div>
        <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(15,23,42,0.8), rgba(15,23,42,0.9)); z-index: 2;"></div>
        <div style="position: relative; z-index: 3; max-width: 800px; padding: 0 5%; margin-top: 50px;">
            <h1 style="font-size: 3.5rem; font-weight: 800; margin-bottom: 1rem; color: white;">Sambutan Kepala Sekolah</h1>
            <div style="display: flex; gap: 0.5rem; justify-content: center; font-size: 1rem; opacity: 0.8;">
                <a href="{{ route('landing_page') }}">Beranda</a>
                <span>/</span>
                <span>Profil</span>
                <span>/</span>
                <span>Sambutan Kepala Sekolah</span>
            </div>
        </div>
    </div>
    
        <div class="container" style="padding: 5rem 5%; margin-top: -3rem;">
            <div style="max-width: 900px; margin: 0 auto; background: var(--white); padding: 4rem; border-radius: var(--radius-lg); box-shadow: 0 20px 40px rgba(0,0,0,0.08); position: relative; z-index: 10;">
                <div style="text-align: center; margin-bottom: 3rem;">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=2000&auto=format&fit=crop" alt="Kepala Sekolah" style="width: 180px; height: 180px; object-fit: cover; border-radius: 50%; margin: 0 auto 1.5rem; border: 5px solid var(--bg-light); box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                    <h2 class="section-title" style="font-size: 2.2rem; margin-bottom: 0.5rem;">Bpk. Drs. H. Ahmad Dahlan, M.Pd.</h2>
                    <p style="color: var(--accent); font-weight: 700; letter-spacing: 1px; text-transform: uppercase;">Kepala Sekolah Astika Dharma</p>
                </div>
                <div style="color: var(--text-main); font-size: 1.15rem; line-height: 1.9; text-align: justify;">
                    <p style="margin-bottom: 1.5rem;">Assalamu’alaikum Warahmatullahi Wabarakatuh, Salam sejahtera bagi kita semua.</p>
                    <p style="margin-bottom: 1.5rem;">Selamat datang di website resmi <strong>Sekolah Astika Dharma</strong>. Puji syukur senantiasa kita panjatkan ke hadirat Tuhan Yang Maha Esa atas segala rahmat dan karunia-Nya. Kami hadir untuk memberikan layanan pendidikan berkualitas demi mencetak generasi muda yang cerdas, berkarakter, dan berdaya saing global.</p>
                    <p style="margin-bottom: 1.5rem;">Melalui portal website ini, kami berharap dapat memberikan informasi terkini secara cepat dan transparan kepada seluruh peserta didik, orang tua wali, serta masyarakat umum. Kami terus berupaya meningkatkan fasilitas dan kualitas pendidikan agar selaras dengan perkembangan zaman dan teknologi.</p>
                    <p style="margin-bottom: 2rem;">Terima kasih atas kepercayaan yang diberikan. Mari bersama-sama kita wujudkan cita-cita bangsa melalui pendidikan yang bermutu.</p>
                    <p style="font-weight: 600; font-style: italic;">Wassalamu’alaikum Warahmatullahi Wabarakatuh.</p>
                </div>
            </div>
        </div>
@endsection
