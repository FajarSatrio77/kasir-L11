<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .sidebar {
            min-height: 100vh;
            background: #2c3e50;
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.8);
            padding: 1rem;
            margin: 0.2rem 0;
            border-radius: 0.5rem;
        }
        .sidebar .nav-link:hover {
            color: white;
            background: rgba(255,255,255,.1);
        }
        .sidebar .nav-link.active {
            color: white;
            background: #3498db;
        }
        .sidebar .nav-link i {
            margin-right: 0.5rem;
        }
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .navbar {
            background: white !important;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
            border-radius: 0.5rem;
        }
        .card-header {
            background: white;
            border-bottom: 1px solid rgba(0,0,0,.125);
            padding: 1rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="p-3">
                    <h4 class="text-center mb-4">
                        <i class="fas fa-cash-register"></i>
                        {{ config('app.name', 'Laravel') }}
                    </h4>
                    <div class="nav flex-column">
                        <a href="{{ route('home') }}" wire:navigate class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                            <i class="fas fa-home"></i> Beranda
                        </a>
                        @if(in_array(Auth::user()->peran, ['admin', 'pemilik']))
                        <a href="{{ route('user') }}" wire:navigate class="nav-link {{ request()->routeIs('user') ? 'active' : '' }}">
                            <i class="fas fa-users"></i> Pengguna
                        </a>
                        <a href="{{ route('produk') }}" wire:navigate class="nav-link {{ request()->routeIs('produk') ? 'active' : '' }}">
                            <i class="fas fa-box"></i> Produk
                        </a>
                        <a href="{{ route('admin.categories') }}" wire:navigate class="nav-link {{ request()->routeIs('admin.categories') ? 'active' : '' }}">
                            <i class="fas fa-tags"></i> Kategori
                        </a>
                        @endif
                        @if(in_array(Auth::user()->peran, ['admin', 'pemilik', 'kasir']))
                        <a href="{{ route('transaksi') }}" wire:navigate class="nav-link {{ request()->routeIs('transaksi') ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart"></i> Transaksi
                        </a>
                        <a href="{{ route('laporan') }}" wire:navigate class="nav-link {{ request()->routeIs('laporan') ? 'active' : '' }}">
                            <i class="fas fa-chart-line"></i> Laporan Penjualan
                        </a>
                        <a href="{{ route('laporan.stok') }}" wire:navigate class="nav-link {{ request()->routeIs('laporan.stok') ? 'active' : '' }}">
                            <i class="fas fa-boxes"></i> Laporan Stok
                        </a>
                        @endif
                        @if(Auth::user()->peran === 'admin')
                        <a href="{{ route('activity-logs.index') }}" wire:navigate class="nav-link {{ request()->routeIs('activity-logs.index') ? 'active' : '' }}">
                            <i class="fas fa-history"></i> Log Aktivitas
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <!-- Top Navbar -->
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <!-- Page Content -->
                <div class="container-fluid py-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
