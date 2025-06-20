<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistem Informasi Warga')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CSS dan Font Awesome (via CDN) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">

    {{-- Custom CSS --}}
    <style>
        :root {
            --sidebar-width: 250px;
            --topbar-height: 60px;
            --primary-color: #4e73df;
            --secondary-color: #224abe;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
        }

        #wrapper {
            display: flex;
        }

        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-color) 10%, var(--secondary-color) 100%);
            color: white;
            position: fixed;
            z-index: 999;
            transition: all 0.3s;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        #sidebar.toggled {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        #sidebar .sidebar-brand {
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            padding: 0 1rem;
            font-size: 1.2rem;
            font-weight: 800;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        #sidebar .nav-item {
            position: relative;
        }

        #sidebar .nav-item .nav-link {
            color: rgba(255,255,255,.8);
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }

        #sidebar .nav-item .nav-link:hover {
            color: #fff;
            background-color: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }

        #sidebar .nav-item .nav-link.active {
            color: #fff;
            font-weight: 700;
            background-color: rgba(255,255,255,0.15);
            border-left: 4px solid #fff;
        }

        #sidebar .nav-item .nav-link i {
            margin-right: 0.5rem;
            width: 1.25rem;
            text-align: center;
        }

        #content-wrapper {
            flex: 1;
            width: 100%;
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #content-wrapper.toggled {
            margin-left: 0;
        }

        #topbar {
            height: var(--topbar-height);
            background-color: #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            display: flex;
            align-items: center;
            padding: 0 1rem;
            position: sticky;
            top: 0;
            z-index: 990;
        }

        #sidebarToggle {
            background-color: transparent;
            border: none;
            color: #555;
            font-size: 1.2rem;
            cursor: pointer;
            transition: transform 0.3s;
        }

        #sidebarToggle:hover {
            transform: rotate(15deg);
            color: var(--primary-color);
        }

        #content {
            padding: 1.5rem;
            flex: 1;
        }

        .card {
            border: none;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            margin-bottom: 1.5rem;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.15);
        }

        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            padding: 0.75rem 1.25rem;
            font-weight: 700;
        }

        .border-left-primary {
            border-left: 0.25rem solid var(--primary-color) !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }

        .border-left-danger {
            border-left: 0.25rem solid #e74a3b !important;
        }

        .text-xs {
            font-size: 0.7rem;
        }

        .text-gray-300 {
            color: #dddfeb !important;
        }

        .text-gray-800 {
            color: #5a5c69 !important;
        }

        footer {
            background-color: #fff;
            border-top: 1px solid #e3e6f0;
            margin-top: auto;
        }

        .btn {
            border-radius: 0.35rem;
            padding: 0.375rem 0.75rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .alert {
            border-radius: 0.35rem;
            border: none;
        }

        @media (max-width: 768px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            #sidebar.toggled {
                margin-left: 0;
            }

            #content-wrapper {
                margin-left: 0;
            }

            #content-wrapper.toggled {
                margin-left: var(--sidebar-width);
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar">
            <div class="sidebar-brand">
                <i class="fas fa-users me-2"></i>
                <span>SIM Warga</span>
            </div>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('warga.index') }}" class="nav-link {{ request()->routeIs('warga.*') ? 'active' : '' }}">
                        <i class="fas fa-user"></i>
                        <span>Data Warga</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('keluarga.index') }}" class="nav-link {{ request()->routeIs('keluarga.*') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span>Data Keluarga</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('surat.index') }}" class="nav-link {{ request()->routeIs('surat.*') ? 'active' : '' }}">
                        <i class="fas fa-envelope"></i>
                        <span>Surat Pengantar</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('keuangan.index') }}" class="nav-link {{ request()->routeIs('keuangan.*') ? 'active' : '' }}">
                        <i class="fas fa-money-bill"></i>
                        <span>Keuangan Kas RT</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <i class="fas fa-user-cog"></i>
                        <span>Profil</span>
                    </a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Content Wrapper -->
        <div id="content-wrapper">
            <!-- Top Navigation -->
            <div id="topbar">
                <button id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="ms-auto d-flex align-items-center">
                    @auth
                    <div class="me-3">
                        <span class="fw-bold">{{ Auth::user()->name }}</span>
                    </div>
                    @endauth
                </div>
            </div>

            <!-- Main Content -->
            <div id="content">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="text-center py-4 text-muted">
                <small>© {{ date('Y') }} Sistem Informasi Warga RT</small>
            </footer>
        </div>
    </div>

    {{-- Bootstrap JS & jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- DataTables JS --}}
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>

    {{-- Custom JS --}}
    <script>
        $(document).ready(function() {
            $("#sidebarToggle").click(function(e) {
                e.preventDefault();
                $("#sidebar").toggleClass("toggled");
                $("#content-wrapper").toggleClass("toggled");
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $(".alert").alert('close');
            }, 5000);
        });
    </script>

    @stack('scripts')
</body>
</html>
