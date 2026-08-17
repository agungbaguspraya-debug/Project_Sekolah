<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sekolah Astika Dharma</title>
    <meta name="description" content="Sekolah Astika Dharma - Membentuk generasi unggul, berkarakter, dan kompeten untuk masa depan.">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            /* Colors */
            --primary: #0F172A; /* Dark Navy */
            --primary-light: #1E293B;
            --accent: #2563EB; /* Royal Blue */
            --accent-hover: #1D4ED8;
            --bg-light: #F8FAFC; /* Light gray background */
            --white: #FFFFFF;
            --text-main: #334155;
            --text-muted: #64748B;
            --border: #E2E8F0;
            
            /* Typography */
            --font-heading: 'Manrope', sans-serif;
            --font-body: 'Inter', sans-serif;
            
            /* Layout & Spacing */
            --radius-lg: 24px;
            --radius-md: 16px;
            --radius-sm: 8px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --section-padding: 6rem 5%;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            color: var(--text-main);
            background-color: var(--bg-light);
            line-height: 1.6;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-heading);
            color: var(--primary);
            line-height: 1.2;
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: var(--transition);
        }

        img {
            max-width: 100%;
            display: block;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }
        
        .section-subtitle {
            font-size: 1.125rem;
            color: var(--text-muted);
            margin-bottom: 3rem;
            max-width: 600px;
        }

        .text-center { text-align: center; }
        .mx-auto { margin-left: auto; margin-right: auto; }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.875rem 1.75rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            transition: var(--transition);
            cursor: pointer;
            border: none;
            font-family: var(--font-body);
        }

        .btn-primary {
            background-color: var(--accent);
            color: var(--white);
            box-shadow: 0 4px 14px 0 rgba(37, 99, 235, 0.39);
        }

        .btn-primary:hover {
            background-color: var(--accent-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.23);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--white);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }
        
        .btn-outline:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 1.25rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            transition: var(--transition);
        }

        .navbar.transparent {
            background: transparent;
            color: var(--white);
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            color: var(--primary);
            padding: 1rem 5%;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-family: var(--font-heading);
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
            align-items: center;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.5rem 0;
        }

        .navbar.scrolled .nav-link:hover {
            color: var(--accent);
        }
        
        .navbar.transparent .nav-link:hover {
            opacity: 0.8;
        }

        /* Dropdown (Simple CSS) */
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(10px);
            background: var(--white);
            min-width: 200px;
            border-radius: var(--radius-md);
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            padding: 0.5rem;
            display: flex;
            flex-direction: column;
        }

        .nav-item:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            color: var(--text-main);
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .dropdown-item:hover {
            background: var(--bg-light);
            color: var(--accent);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Hero */
        .hero {
            position: relative;
            height: 100vh;
            min-height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--white);
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -2;
            transform: scale(1.05); /* Slight scale for potential animation */
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(15,23,42,0.6) 0%, rgba(15,23,42,0.8) 100%);
            z-index: -1;
        }

        .hero-content {
            max-width: 800px;
            padding: 0 1.5rem;
            z-index: 1;
            animation: fadeInUp 1s ease-out;
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 1.5rem;
            line-height: 1.1;
            letter-spacing: -0.03em;
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 2.5rem;
            color: rgba(255,255,255,0.85);
            font-weight: 400;
        }

        .hero-btns {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        /* Stats */
        .stats {
            background: var(--white);
            padding: 4rem 5%;
            margin-top: -50px;
            position: relative;
            z-index: 10;
            border-radius: var(--radius-lg);
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
            max-width: 1100px;
            margin-left: auto;
            margin-right: auto;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            text-align: center;
            position: relative;
        }

        .stat-item h3 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 0.25rem;
        }

        .stat-item p {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .stat-divider {
            position: absolute;
            width: 1px;
            height: 60%;
            background: var(--border);
            top: 20%;
        }
        
        .stat-divider:nth-child(2) { left: 25%; }
        .stat-divider:nth-child(4) { left: 50%; }
        .stat-divider:nth-child(6) { left: 75%; }

        /* About */
        .about { padding: var(--section-padding); }
        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .about-image {
            position: relative;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .about-image img {
            width: 100%;
            aspect-ratio: 4/3;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .about-image:hover img {
            transform: scale(1.05);
        }

        .about-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: rgba(37, 99, 235, 0.1);
            color: var(--accent);
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .about-text h2 { margin-bottom: 1.5rem; }
        .about-text p {
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
            color: var(--text-muted);
        }

        .link-arrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--accent);
            font-weight: 600;
            font-size: 1rem;
        }
        
        .link-arrow:hover { gap: 0.75rem; }

        /* Programs */
        .programs {
            background-color: var(--white);
            padding: var(--section-padding);
        }
        
        .programs-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .program-card {
            background: var(--bg-light);
            border-radius: var(--radius-lg);
            padding: 2.5rem;
            transition: var(--transition);
            border: 1px solid var(--border);
            text-align: left;
        }

        .program-card:hover {
            background: var(--white);
            box-shadow: 0 20px 40px rgba(0,0,0,0.06);
            transform: translateY(-5px);
            border-color: transparent;
        }

        .program-icon {
            width: 60px;
            height: 60px;
            background: var(--primary);
            color: var(--white);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .program-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .program-card p {
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        /* Facilities - Editorial Layout */
        .facilities { padding: var(--section-padding); }
        .fac-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 1.5rem;
            height: 600px;
        }

        .fac-item {
            position: relative;
            border-radius: var(--radius-lg);
            overflow: hidden;
            group: hover;
        }

        .fac-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s;
        }

        .fac-item:hover img { transform: scale(1.05); }

        .fac-item.large {
            grid-row: span 2;
        }

        .fac-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(15,23,42,0.8) 0%, transparent 60%);
            display: flex;
            align-items: flex-end;
            padding: 2rem;
        }

        .fac-content {
            color: var(--white);
        }

        .fac-content h3 {
            color: var(--white);
            font-size: 1.5rem;
            margin-bottom: 0.25rem;
        }

        /* Extracurriculars - Horizontal Scroll */
        .eksul {
            background: var(--white);
            padding: var(--section-padding);
            overflow: hidden;
        }
        
        .eksul-wrapper {
            display: flex;
            gap: 1.5rem;
            overflow-x: auto;
            padding-bottom: 2rem;
            scrollbar-width: none; /* Firefox */
        }
        .eksul-wrapper::-webkit-scrollbar { display: none; }

        .eksul-card {
            min-width: 250px;
            position: relative;
            border-radius: var(--radius-lg);
            overflow: hidden;
            flex-shrink: 0;
        }

        .eksul-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        
        .eksul-card .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(15,23,42,0.9) 0%, transparent 50%);
            display: flex;
            align-items: flex-end;
            padding: 1.5rem;
        }
        
        .eksul-card h3 { color: var(--white); font-size: 1.25rem; margin:0;}

        /* Achievements */
        .prestasi { padding: var(--section-padding); }
        .prestasi-box {
            background: var(--white);
            border-radius: var(--radius-lg);
            display: flex;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
        }

        .prestasi-img {
            flex: 1;
            position: relative;
        }
        .prestasi-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .prestasi-content {
            flex: 1;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .prestasi-content h2 { font-size: 2.5rem; margin-bottom: 1rem; }
        .prestasi-year {
            font-size: 1rem;
            font-weight: 700;
            color: var(--accent);
            margin-bottom: 1.5rem;
            display: inline-block;
        }

        /* News / Portal */
        .news { padding: var(--section-padding); background: var(--white); }
        .news-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .news-main {
            border-radius: var(--radius-lg);
            overflow: hidden;
            position: relative;
            height: 100%;
            min-height: 400px;
        }
        
        .news-main img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
        }
        
        .news-main-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(15,23,42,0.9) 0%, transparent 60%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 2.5rem;
            color: var(--white);
        }
        
        .news-main-overlay h3 { color: var(--white); font-size: 1.75rem; margin: 0.5rem 0 1rem; }
        .news-date { font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.8; }

        .news-list { display: flex; flex-direction: column; gap: 1.5rem; }
        .news-card {
            display: flex;
            gap: 1.5rem;
            align-items: center;
            background: var(--bg-light);
            padding: 1rem;
            border-radius: var(--radius-md);
            transition: var(--transition);
        }
        .news-card:hover { background: var(--white); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .news-card img {
            width: 120px;
            height: 120px;
            border-radius: var(--radius-sm);
            object-fit: cover;
        }
        .news-card-content h4 { font-size: 1.125rem; margin: 0.5rem 0; }

        /* Gallery - Masonry (CSS Columns) */
        .gallery { padding: var(--section-padding); }
        .gallery-grid {
            column-count: 3;
            column-gap: 1.5rem;
        }
        .gallery-item {
            break-inside: avoid;
            margin-bottom: 1.5rem;
            border-radius: var(--radius-md);
            overflow: hidden;
        }
        .gallery-item img {
            width: 100%;
            display: block;
            border-radius: var(--radius-md);
            transition: var(--transition);
        }
        .gallery-item:hover img { transform: scale(1.05); }

        /* Testimonials */
        .testimonials {
            background: var(--white);
            padding: var(--section-padding);
            text-align: center;
        }
        
        .testi-slider {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
        }

        .testi-content {
            font-size: 1.75rem;
            font-family: var(--font-heading);
            font-weight: 500;
            color: var(--primary);
            line-height: 1.4;
            margin-bottom: 2rem;
            font-style: italic;
        }

        .testi-author {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .testi-author h4 { font-size: 1.125rem; margin-bottom: 0.25rem; }
        .testi-author p { color: var(--text-muted); font-size: 0.875rem; }

        .testi-dots {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 3rem;
        }
        
        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--border);
            cursor: pointer;
            transition: var(--transition);
        }
        .dot.active { background: var(--accent); width: 20px; border-radius: 10px; }

        /* FAQ */
        .faq { padding: var(--section-padding); max-width: 800px; margin: 0 auto; }
        .faq-item {
            background: var(--white);
            border-radius: var(--radius-md);
            margin-bottom: 1rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
            overflow: hidden;
        }
        
        .faq-summary {
            padding: 1.5rem;
            font-weight: 600;
            font-family: var(--font-heading);
            font-size: 1.125rem;
            color: var(--primary);
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            list-style: none;
        }
        
        .faq-summary::-webkit-details-marker { display: none; }
        
        .faq-content {
            padding: 0 1.5rem 1.5rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        .faq-icon {
            transition: transform 0.3s ease;
        }

        details[open] .faq-icon {
            transform: rotate(45deg);
            color: var(--accent);
        }

        /* CTA */
        .cta { padding: var(--section-padding); }
        .cta-box {
            background: var(--primary);
            border-radius: var(--radius-lg);
            padding: 5rem 2rem;
            text-align: center;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }
        
        .cta-box h2 { color: var(--white); font-size: 3rem; margin-bottom: 1rem; position: relative; z-index: 2; }
        .cta-box p { font-size: 1.25rem; color: rgba(255,255,255,0.8); margin-bottom: 2.5rem; position: relative; z-index: 2;}
        
        .cta-decoration {
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(37, 99, 235, 0.2);
            filter: blur(80px);
            border-radius: 50%;
            top: -100px;
            right: -100px;
            z-index: 1;
        }

        /* Footer */
        footer {
            background: var(--primary-light);
            color: var(--white);
            padding: 6rem 5% 2rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 4rem;
            margin-bottom: 4rem;
        }

        .footer-brand h3 {
            color: var(--white);
            font-size: 1.5rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .footer-brand p { color: rgba(255,255,255,0.7); max-width: 300px; }

        .footer-col h4 {
            color: var(--white);
            font-size: 1.125rem;
            margin-bottom: 1.5rem;
        }

        .footer-col ul { list-style: none; }
        .footer-col ul li { margin-bottom: 0.75rem; }
        .footer-col ul a { color: rgba(255,255,255,0.7); }
        .footer-col ul a:hover { color: var(--white); }

        .footer-contact li {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            color: rgba(255,255,255,0.7);
            margin-bottom: 1rem;
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 2rem;
            display: flex;
            justify-content: space-between;
            color: rgba(255,255,255,0.5);
            font-size: 0.875rem;
        }
        
        .social-links { display: flex; gap: 1rem; }
        .social-links a { color: rgba(255,255,255,0.5); }
        .social-links a:hover { color: var(--white); }

        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .stat-divider:nth-child(2) { display: none; }
            .stat-divider:nth-child(4) { display: none; }
            .stat-divider:nth-child(6) { display: none; }
            .programs-grid { grid-template-columns: 1fr 1fr; }
            .prestasi-box { flex-direction: column; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .hero h1 { font-size: 2.5rem; }
            .nav-links { display: none; }
            .about-grid { grid-template-columns: 1fr; }
            .fac-grid { grid-template-columns: 1fr; grid-template-rows: auto; height: auto; }
            .fac-item.large { grid-row: auto; height: 300px; }
            .fac-item { height: 250px; }
            .programs-grid { grid-template-columns: 1fr; }
            .news-grid { grid-template-columns: 1fr; }
            .gallery-grid { column-count: 2; }
            .footer-grid { grid-template-columns: 1fr; gap: 2.5rem; }
            .footer-bottom { flex-direction: column; gap: 1rem; text-align: center; }
            .cta-box { padding: 3rem 1.5rem; }
            .cta-box h2 { font-size: 2rem; }
        }
        
        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr; }
            .gallery-grid { column-count: 1; }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar transparent" id="navbar">
        <a href="#" class="nav-brand">
            <i data-lucide="graduation-cap" stroke-width="2.5" size="28"></i>
            Astika Dharma
        </a>
        
        <ul class="nav-links">
            <li class="nav-item">
                <a href="{{ route('landing_page') }}#beranda" class="nav-link">Beranda</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('landing_page') }}#profil" class="nav-link">Profil <i data-lucide="chevron-down" size="16"></i></a>
                <div class="dropdown-menu">
                    <a href="{{ route('sambutan') }}" class="dropdown-item">Sambutan Kepala Sekolah</a>
                    <a href="{{ route('sejarah') }}" class="dropdown-item">Sejarah</a>
                    <a href="{{ route('visi_misi') }}" class="dropdown-item">Visi & Misi</a>
                    <a href="{{ route('guru_staff') }}" class="dropdown-item">Guru & Staff</a>
                    <a href="{{ route('landing_page') }}#fasilitas" class="dropdown-item">Fasilitas</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="{{ route('landing_page') }}#akademik" class="nav-link">Akademik <i data-lucide="chevron-down" size="16"></i></a>
                <div class="dropdown-menu">
                    <a href="{{ route('landing_page') }}#program" class="dropdown-item">Program Keahlian</a>
                    <a href="{{ route('kurikulum') }}" class="dropdown-item">Kurikulum</a>
                    <a href="{{ route('landing_page') }}#ekstrakurikuler" class="dropdown-item">Ekstrakurikuler</a>
                    <a href="{{ route('landing_page') }}#prestasi" class="dropdown-item">Prestasi</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="{{ route('landing_page') }}#informasi" class="nav-link">Informasi <i data-lucide="chevron-down" size="16"></i></a>
                <div class="dropdown-menu">
                    <a href="{{ route('landing_page') }}#berita" class="dropdown-item">Berita</a>
                    <a href="{{ route('pengumuman') }}" class="dropdown-item">Pengumuman</a>
                    <a href="{{ route('agenda') }}" class="dropdown-item">Agenda</a>
                    <a href="{{ route('landing_page') }}#galeri" class="dropdown-item">Galeri</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="{{ route('landing_page') }}#kontak" class="nav-link">Kontak</a>
            </li>
        </ul>

        <div class="nav-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary" style="padding: 0.6rem 1.5rem; font-size: 0.875rem;">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline" style="padding: 0.6rem 1.5rem; font-size: 0.875rem;">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 0.6rem 1.5rem; font-size: 0.875rem;">PPDB 2026</a>
            @endauth
        </div>
    </nav>

    
    <!-- Main Content -->
    <main style="min-height: 80vh;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer id="kontak">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <h3><i data-lucide="graduation-cap" size="24"></i> Astika Dharma</h3>
                    <p>Sekolah yang membangun generasi unggul dan berkarakter dengan pendidikan holistik bertaraf internasional.</p>
                </div>
                
                <div class="footer-col">
                    <h4>Navigasi</h4>
                    <ul>
                        <li><a href="#beranda">Beranda</a></li>
                        <li><a href="{{ route('landing_page') }}#profil">Profil Sekolah</a></li>
                        <li><a href="{{ route('landing_page') }}#akademik">Akademik</a></li>
                        <li><a href="#ppdb">PPDB 2026</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Informasi</h4>
                    <ul>
                        <li><a href="{{ route('landing_page') }}#berita">Berita</a></li>
                        <li><a href="#">Pengumuman</a></li>
                        <li><a href="{{ route('landing_page') }}#galeri">Galeri</a></li>
                        <li><a href="#">Agenda</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Kontak Kami</h4>
                    <ul class="footer-contact">
                        <li>
                            <i data-lucide="map-pin" size="18" style="flex-shrink: 0; margin-top: 3px;"></i>
                            <span>Jl. Pendidikan No. 123, Karangasem, Bali 80811</span>
                        </li>
                        <li>
                            <i data-lucide="phone" size="18" style="flex-shrink: 0;"></i>
                            <span>(0361) 1234567<br>0812-3456-7890</span>
                        </li>
                        <li>
                            <i data-lucide="mail" size="18" style="flex-shrink: 0;"></i>
                            <span>info@astikadharma.sch.id</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div>&copy; 2026 Sekolah Astika Dharma. All rights reserved.</div>
                <div class="social-links">
                    <a href="#"><i data-lucide="instagram" size="20"></i></a>
                    <a href="#"><i data-lucide="facebook" size="20"></i></a>
                    <a href="#"><i data-lucide="twitter" size="20"></i></a>
                    <a href="#"><i data-lucide="youtube" size="20"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // Sticky Navbar
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
                navbar.classList.remove('transparent');
            } else {
                navbar.classList.remove('scrolled');
                navbar.classList.add('transparent');
            }
        });

        // FAQ Accordion logic (close others when one opens)
        const details = document.querySelectorAll('details.faq-item');
        details.forEach((targetDetail) => {
            targetDetail.addEventListener('click', () => {
                details.forEach((detail) => {
                    if (detail !== targetDetail) {
                        detail.removeAttribute('open');
                    }
                });
            });
        });
    </script>
    
    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // AOS Animation JS Init
        AOS.init({
            once: true,
            offset: 100,
            duration: 600,
            easing: 'ease-out-cubic',
        });

        // Number Counter Animation
        const counters = document.querySelectorAll('.counter');
        const speed = 100; // The higher the slower

        const startCounting = (counter) => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const inc = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 15);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        };

        // Intersection Observer for Counters
        const statsSection = document.getElementById('stats-section');
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if(entry.isIntersecting){
                    counters.forEach(counter => {
                        startCounting(counter);
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        if(statsSection){
            observer.observe(statsSection);
        }
    </script>
</body>
</html>
