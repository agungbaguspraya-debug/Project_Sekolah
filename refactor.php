<?php
$file = 'resources/views/landing page/landing_page.blade.php';
$content = file_get_contents($file);

// Extract parts
$parts = explode('<!-- Hero -->', $content);
$headAndNav = $parts[0];
$rest = explode('<!-- Footer -->', $parts[1]);
$bodyContent = '<!-- Hero -->' . $rest[0];
$footerAndScripts = '<!-- Footer -->' . $rest[1];

// Create layouts directory if not exists
if (!is_dir('resources/views/layouts')) {
    mkdir('resources/views/layouts', 0777, true);
}

// Build layout content
$layoutContent = $headAndNav . "\n    <!-- Main Content -->\n    <main style=\"min-height: 80vh;\">\n        @yield('content')\n    </main>\n\n    " . $footerAndScripts;

// Update the links in layout
$layoutContent = str_replace(
    '<a href="#" class="dropdown-item">Sambutan Kepala Sekolah</a>',
    '<a href="{{ route(\'sambutan\') }}" class="dropdown-item">Sambutan Kepala Sekolah</a>',
    $layoutContent
);
$layoutContent = str_replace(
    '<a href="#" class="dropdown-item">Sejarah</a>',
    '<a href="{{ route(\'sejarah\') }}" class="dropdown-item">Sejarah</a>',
    $layoutContent
);
$layoutContent = str_replace(
    '<a href="#" class="dropdown-item">Visi & Misi</a>',
    '<a href="{{ route(\'visi_misi\') }}" class="dropdown-item">Visi & Misi</a>',
    $layoutContent
);
$layoutContent = str_replace(
    '<a href="#" class="dropdown-item">Guru & Staff</a>',
    '<a href="{{ route(\'guru_staff\') }}" class="dropdown-item">Guru & Staff</a>',
    $layoutContent
);
$layoutContent = str_replace(
    '<a href="#" class="dropdown-item">Kurikulum</a>',
    '<a href="{{ route(\'kurikulum\') }}" class="dropdown-item">Kurikulum</a>',
    $layoutContent
);
$layoutContent = str_replace(
    '<a href="#" class="dropdown-item">Pengumuman</a>',
    '<a href="{{ route(\'pengumuman\') }}" class="dropdown-item">Pengumuman</a>',
    $layoutContent
);
$layoutContent = str_replace(
    '<a href="#" class="dropdown-item">Agenda</a>',
    '<a href="{{ route(\'agenda\') }}" class="dropdown-item">Agenda</a>',
    $layoutContent
);
$layoutContent = str_replace(
    '<a href="#beranda" class="nav-link">Beranda</a>',
    '<a href="{{ route(\'landing_page\') }}#beranda" class="nav-link">Beranda</a>',
    $layoutContent
);
$layoutContent = str_replace(
    'href="#profil"',
    'href="{{ route(\'landing_page\') }}#profil"',
    $layoutContent
);
$layoutContent = str_replace(
    'href="#akademik"',
    'href="{{ route(\'landing_page\') }}#akademik"',
    $layoutContent
);
$layoutContent = str_replace(
    'href="#informasi"',
    'href="{{ route(\'landing_page\') }}#informasi"',
    $layoutContent
);
$layoutContent = str_replace(
    'href="#kontak"',
    'href="{{ route(\'landing_page\') }}#kontak"',
    $layoutContent
);
$layoutContent = str_replace(
    'href="#fasilitas"',
    'href="{{ route(\'landing_page\') }}#fasilitas"',
    $layoutContent
);
$layoutContent = str_replace(
    'href="#program"',
    'href="{{ route(\'landing_page\') }}#program"',
    $layoutContent
);
$layoutContent = str_replace(
    'href="#ekstrakurikuler"',
    'href="{{ route(\'landing_page\') }}#ekstrakurikuler"',
    $layoutContent
);
$layoutContent = str_replace(
    'href="#prestasi"',
    'href="{{ route(\'landing_page\') }}#prestasi"',
    $layoutContent
);
$layoutContent = str_replace(
    'href="#berita"',
    'href="{{ route(\'landing_page\') }}#berita"',
    $layoutContent
);
$layoutContent = str_replace(
    'href="#galeri"',
    'href="{{ route(\'landing_page\') }}#galeri"',
    $layoutContent
);


file_put_contents('resources/views/layouts/landing.blade.php', $layoutContent);

// Refactor landing_page.blade.php
$newLandingPage = "@extends('layouts.landing')\n\n@section('content')\n" . trim($bodyContent) . "\n@endsection\n";
file_put_contents($file, $newLandingPage);

echo 'Layout extracted and landing_page refactored.';
