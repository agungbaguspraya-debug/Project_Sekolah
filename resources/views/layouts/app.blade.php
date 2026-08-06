<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="theme-color" content="#0f172a">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Data Kelas - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Figtree', system-ui, -apple-system, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
            -webkit-tap-highlight-color: transparent;
        }
        
        /* Layout Structure */
        .wrapper {
            display: flex;
            align-items: stretch;
            min-height: 100vh;
            position: relative;
        }
        
        /* Left Sidebar Styling */
        #sidebar {
            min-width: 260px;
            max-width: 260px;
            background-color: #0f172a;
            color: #94a3b8;
            transition: all 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.05);
            z-index: 1040;
        }
        
        #sidebar .sidebar-header {
            padding: 20px 24px;
            background-color: #020617;
            border-bottom: 1px solid #1e293b;
        }
        
        #sidebar ul.components {
            padding: 16px 0;
        }
        
        #sidebar ul li {
            padding: 2px 14px;
        }
        
        #sidebar ul li a {
            padding: 12px 14px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s;
            font-weight: 500;
        }
        
        #sidebar ul li a i {
            font-size: 1.2rem;
            margin-right: 12px;
            transition: all 0.2s;
        }
        
        #sidebar ul li a:hover {
            color: #f8fafc;
            background-color: #1e293b;
        }
        
        #sidebar ul li a:hover i {
            color: #3b82f6;
        }
        
        #sidebar ul li.active a {
            color: #ffffff;
            background-color: #2563eb;
        }
        
        #sidebar ul li.active a i {
            color: #ffffff;
        }
        
        /* Main Content Styling */
        #content-area {
            width: 100%;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        
        /* Top Navbar */
        .top-navbar {
            background-color: #ffffff;
            padding: 14px 24px;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }
        
        /* Page Content container */
        .main-container {
            padding: 24px;
            flex-grow: 1;
        }
        
        /* Card enhancements */
        .card {
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
        }

        /* Mobile Backdrop Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(2px);
            z-index: 1030;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Responsive Mobile / Tablet Styling for Android Portrait Screen */
        @media (max-width: 991.98px) {
            #sidebar {
                position: fixed;
                top: 0;
                left: -280px;
                height: 100vh;
                width: 280px;
                max-width: 280px;
            }

            #sidebar.show {
                left: 0;
            }

            .sidebar-overlay.show {
                display: block;
                opacity: 1;
            }

            .main-container {
                padding: 16px 12px;
            }

            .top-navbar {
                padding: 12px 16px;
            }

            .table-responsive {
                -webkit-overflow-scrolling: touch;
            }
        }

        /* Mobile & Tablet LANDSCAPE Orientation Optimization */
        @media (orientation: landscape) and (max-height: 600px) {
            .top-navbar {
                padding: 6px 16px !important;
            }
            .main-container {
                padding: 10px 8px !important;
            }
            .card-header {
                padding: 8px 12px !important;
            }
            .card-body {
                padding: 10px !important;
            }
            .table-responsive {
                max-height: 78vh;
                overflow-y: auto;
            }
        }

        /* Wide / Landscape Screen Table Fitting */
        @media (min-width: 576px) {
            .table-responsive .table {
                font-size: 0.88rem;
            }
            .table-responsive .table th, 
            .table-responsive .table td {
                padding-top: 0.65rem;
                padding-bottom: 0.65rem;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar Navigation -->
        <nav id="sidebar">
            <div class="sidebar-header d-flex justify-content-between align-items-center">
                <a href="{{ route('dashboard') }}" class="text-white text-decoration-none d-flex align-items-center">
                    <i class="bi bi-rocket-takeoff-fill fs-3 text-primary me-2"></i>
                    <span class="fs-4 fw-bold tracking-wide">DATA KELAS</span>
                </a>
                <button type="button" class="btn text-white-50 p-0 d-lg-none" id="sidebarClose" aria-label="Close Sidebar">
                    <i class="bi bi-x-lg fs-4"></i>
                </button>
            </div>

            <ul class="list-unstyled components flex-grow-1 overflow-y-auto">
                @auth
                    <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    @if(Auth::user()->isAdmin())
                        <!-- Group 1: Master Data -->
                        <li>
                            <a href="#adminMasterSubmenu" data-bs-toggle="collapse" class="d-flex align-items-center justify-content-between {{ request()->routeIs('siswa.*') || request()->routeIs('guru.*') || request()->routeIs('kelas.*') || request()->routeIs('jurusan.*') ? 'text-white fw-bold' : '' }}">
                                <span><i class="bi bi-folder-fill me-2 text-primary"></i> Master Data Sekolah</span>
                                <i class="bi bi-chevron-down ms-2"></i>
                            </a>
                            <div class="collapse {{ request()->routeIs('siswa.*') || request()->routeIs('guru.*') || request()->routeIs('kelas.*') || request()->routeIs('jurusan.*') ? 'show' : '' }} ps-3 mt-1" id="adminMasterSubmenu">
                                <ul class="list-unstyled mb-0">
                                    <li class="{{ request()->routeIs('siswa.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('siswa.index') }}" class="py-2">
                                            <i class="bi bi-people-fill me-2"></i> Data Siswa
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('guru.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('guru.index') }}" class="py-2">
                                            <i class="bi bi-person-workspace me-2"></i> Data Guru
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('kelas.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('kelas.index') }}" class="py-2">
                                            <i class="bi bi-building-fill me-2"></i> Data Kelas
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('jurusan.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('jurusan.index') }}" class="py-2">
                                            <i class="bi bi-journal-text me-2"></i> Data Jurusan
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Group 2: Jadwal & Piket -->
                        <li>
                            <a href="#adminJadwalSubmenu" data-bs-toggle="collapse" class="d-flex align-items-center justify-content-between {{ request()->routeIs('piket.*') || request()->routeIs('jadwal.*') ? 'text-white fw-bold' : '' }}">
                                <span><i class="bi bi-calendar-range-fill me-2 text-warning"></i> Jadwal & Piket Guru</span>
                                <i class="bi bi-chevron-down ms-2"></i>
                            </a>
                            <div class="collapse {{ request()->routeIs('piket.*') || request()->routeIs('jadwal.*') ? 'show' : '' }} ps-3 mt-1" id="adminJadwalSubmenu">
                                <ul class="list-unstyled mb-0">
                                    <li class="{{ request()->routeIs('piket.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('piket.index') }}" class="py-2">
                                            <i class="bi bi-calendar-check-fill me-2"></i> Tugas Piket Guru
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('jadwal.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('jadwal.index') }}" class="py-2">
                                            <i class="bi bi-calendar3 me-2"></i> Jadwal Pelajaran
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Group 3: Tugas & Profil Sekolah -->
                        <li>
                            <a href="#adminAkademikSubmenu" data-bs-toggle="collapse" class="d-flex align-items-center justify-content-between {{ request()->routeIs('tugas.*') || request()->routeIs('profil-sekolah.*') ? 'text-white fw-bold' : '' }}">
                                <span><i class="bi bi-gear-wide-connected me-2 text-info"></i> Tugas & Profil Sekolah</span>
                                <i class="bi bi-chevron-down ms-2"></i>
                            </a>
                            <div class="collapse {{ request()->routeIs('tugas.*') || request()->routeIs('profil-sekolah.*') ? 'show' : '' }} ps-3 mt-1" id="adminAkademikSubmenu">
                                <ul class="list-unstyled mb-0">
                                    <li class="{{ request()->routeIs('tugas.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('tugas.index') }}" class="py-2">
                                            <i class="bi bi-file-earmark-text-fill me-2"></i> Tugas Sekolah
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('profil-sekolah.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('profil-sekolah.edit') }}" class="py-2">
                                            <i class="bi bi-building-gear me-2"></i> Profil Sekolah
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @elseif(Auth::user()->isGuru())
                        <li class="{{ request()->routeIs('tugas.*') ? 'active' : '' }}">
                            <a href="{{ route('tugas.index') }}">
                                <i class="bi bi-file-earmark-plus-fill"></i> Buat & Kelola Tugas
                            </a>
                        </li>
                        <li>
                            <a href="#guruJadwalSubmenu" data-bs-toggle="collapse" class="d-flex align-items-center justify-content-between {{ request()->routeIs('piket.*') || request()->routeIs('jadwal.*') ? 'text-white font-bold' : '' }}">
                                <span><i class="bi bi-calendar-range-fill me-2"></i> Jadwal & Piket Guru</span>
                                <i class="bi bi-chevron-down"></i>
                            </a>
                            <div class="collapse {{ request()->routeIs('piket.*') || request()->routeIs('jadwal.*') ? 'show' : '' }} ps-3 mt-1" id="guruJadwalSubmenu">
                                <ul class="list-unstyled mb-0">
                                    <li class="{{ request()->routeIs('piket.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('piket.index') }}" class="py-2">
                                            <i class="bi bi-calendar-check-fill me-2"></i> Jadwal Piket
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('jadwal.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('jadwal.index') }}" class="py-2">
                                            <i class="bi bi-calendar3 me-2"></i> Jadwal Mengajar Guru
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @else
                        <li class="{{ request()->routeIs('siswa.profile') ? 'active' : '' }}">
                            <a href="{{ route('siswa.profile') }}">
                                <i class="bi bi-person-badge-fill"></i> Profil Saya
                            </a>
                        </li>
                        @if(Auth::user()->siswa?->status !== 'Lulus')
                            <li class="{{ request()->routeIs('siswa.jadwal') ? 'active' : '' }}">
                                <a href="{{ route('siswa.jadwal') }}">
                                    <i class="bi bi-calendar3"></i> Jadwal Pelajaran
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('siswa.tugas') ? 'active' : '' }}">
                                @php
                                    $pendingCountNav = 0;
                                    if(Auth::user()->siswa) {
                                        $siswaKelas = Auth::user()->siswa->kelas;
                                        $siswaId = Auth::user()->siswa->id;
                                        $allTugasIds = \App\Models\Tugas::where('kelas', $siswaKelas)->pluck('id');
                                        $submittedTugasIds = \App\Models\TugasSubmission::where('siswa_id', $siswaId)->pluck('tugas_id');
                                        $pendingCountNav = $allTugasIds->diff($submittedTugasIds)->count();
                                    }
                                @endphp
                                <a href="{{ route('siswa.tugas') }}" class="d-flex align-items-center justify-content-between">
                                    <span><i class="bi bi-file-earmark-text-fill me-2"></i>Tugas Sekolah</span>
                                    @if($pendingCountNav > 0)
                                        <span class="badge bg-danger rounded-pill shadow-sm" title="{{ $pendingCountNav }} Tugas Belum Dikumpulkan">{{ $pendingCountNav }}</span>
                                    @endif
                                </a>
                            </li>
                        @endif
                    @endif
                @endauth
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content-area">
            <!-- Top Bar with Android Mobile Hamburger Button -->
            <div class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-light border p-2 d-lg-none rounded-3" id="sidebarCollapse" aria-label="Toggle Navigation">
                        <i class="bi bi-list fs-4 text-dark"></i>
                    </button>
                    <div class="header-title">
                        <h5 class="mb-0 fw-bold text-dark">
                            @if(Auth::user()->isAdmin())
                                Panel Admin
                            @elseif(Auth::user()->isGuru())
                                Portal Guru ({{ Auth::user()->guru->mata_pelajaran ?? 'Guru' }})
                            @else
                                Portal Siswa
                            @endif
                        </h5>
                    </div>
                </div>
                
                <div class="d-flex align-items-center gap-2">
                    @auth
                        <span class="text-dark fw-semibold small d-none d-sm-inline">
                            <i class="bi bi-person-circle text-primary me-1 fs-5"></i> {{ Auth::user()->name }}
                        </span>
                        <form method="POST" action="{{ route('logout') }}" id="logout-form" class="d-none">
                            @csrf
                        </form>
                        <a class="btn btn-outline-danger btn-sm px-2 px-sm-3" href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-1"></i> <span class="d-none d-sm-inline">Log Out</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm px-3">Log In</a>
                    @endauth
                </div>
            </div>

            <!-- Main Content Slot -->
            <div class="main-container">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Mobile Sidebar JavaScript Toggle for Android -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarCollapse');
            const sidebarClose = document.getElementById('sidebarClose');
            const sidebar = document.getElementById('sidebar');

            // Create Backdrop Overlay
            const overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            document.body.appendChild(overlay);

            function toggleSidebar() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }

            function closeSidebar() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            }

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }

            if (sidebarClose) {
                sidebarClose.addEventListener('click', closeSidebar);
            }

            overlay.addEventListener('click', closeSidebar);

            // Close sidebar when tapping a link on Android mobile screen
            const sidebarLinks = sidebar.querySelectorAll('a:not([data-bs-toggle="collapse"])');
            sidebarLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        closeSidebar();
                    }
                });
            });
        });
    </script>
</body>
</html>
