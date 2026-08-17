<?php
$viewsDir = __DIR__ . '/resources/views/landing page/pages/';
if (!is_dir($viewsDir)) {
    mkdir($viewsDir, 0777, true);
}

$pages = [
    'sambutan' => [
        'title' => 'Sambutan Kepala Sekolah',
        'bg' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=2070&auto=format&fit=crop',
        'content' => '
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
        </div>'
    ],
    'sejarah' => [
        'title' => 'Sejarah Sekolah',
        'bg' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop',
        'content' => '
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
        </div>'
    ],
    'visi_misi' => [
        'title' => 'Visi & Misi',
        'bg' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=2120&auto=format&fit=crop',
        'content' => '
        <div class="container" style="padding: 5rem 5%; margin-top: -3rem;">
            <div style="max-width: 900px; margin: 0 auto; position: relative; z-index: 10;">
                
                <div style="background: var(--white); padding: 4rem; border-radius: var(--radius-lg); box-shadow: 0 20px 40px rgba(0,0,0,0.08); text-align: center; margin-bottom: 3rem;">
                    <div style="width: 80px; height: 80px; background: rgba(37,99,235,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                        <i data-lucide="eye" size="40" style="color: var(--accent);"></i>
                    </div>
                    <h3 style="color: var(--primary); font-size: 2rem; margin-bottom: 1.5rem;">Visi Kami</h3>
                    <p style="font-size: 1.5rem; font-weight: 600; color: var(--text-main); font-family: var(--font-heading); line-height: 1.5;">"{{ $profil->visi ?? \'Mewujudkan generasi unggul, berakhlak mulia, dan berwawasan global.\' }}"</p>
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
        </div>'
    ],
    'guru_staff' => [
        'title' => 'Direktori Guru & Staff',
        'bg' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=2070&auto=format&fit=crop',
        'content' => '
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
                        <p style="color: var(--accent); font-size: 0.95rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;">{{ $guru->posisi ?? \'Guru Pengajar\' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <style>
                .guru-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
                .guru-card:hover img { transform: scale(1.05); }
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
            <h1 style="font-size: 3.5rem; font-weight: 800; margin-bottom: 1rem; color: white;">'.$page['title'].'</h1>
            <div style="display: flex; gap: 0.5rem; justify-content: center; font-size: 1rem; opacity: 0.8;">
                <a href="{{ route(\'landing_page\') }}">Beranda</a>
                <span>/</span>
                <span>Profil</span>
                <span>/</span>
                <span>'.$page['title'].'</span>
            </div>
        </div>
    </div>
    ';
    
    $content .= $page['content'] . "\n@endsection\n";
    file_put_contents($viewsDir . $filename . '.blade.php', $content);
}
echo 'Pages generated beautifully.';
