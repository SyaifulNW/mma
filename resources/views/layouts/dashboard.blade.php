<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mastermind MBC</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-size: .875rem;
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }

        .sidebar .nav-link {
            color: #ddd;
        }

        .sidebar .nav-link.active {
            color: #fff;
            background-color: #0d6efd;
        }

        main {
            margin-left: 220px;
            padding: 20px;
        }
    </style>
    @stack('styles')
</head>

<body>

    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Mastermind MBC</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('home') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('task*') ? 'active' : '' }}" href="{{ route('task.index') }}">Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('sprint*') ? 'active' : '' }}" href="{{ route('sprint.index') }}">Sprints</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name ?? 'User' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); confirmLogout();">Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <!-- hidden logout form -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>

        <script>
            function confirmLogout() {
                if (confirm('Are you sure you want to logout?')) {
                    document.getElementById('logout-form').submit();
                }
            }
        </script>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebarMenu" class="col-md-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky">
                    <ul class="nav flex-column mt-3">
                        <li class="nav-item mb-2">
                            @if(Auth::user()->role === 'admin')
                            <a class="nav-link d-flex align-items-center gap-2 {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                                href="{{ route('admin.dashboard') }}">
                                <i class="fa fa-chart-line"></i>
                                <span>Dashboard Admin</span>
                            </a>
                            @elseif(Auth::user()->role === 'coach')
                            <a class="nav-link d-flex align-items-center gap-2 {{ request()->is('coach/dashboard') ? 'active' : '' }}"
                                href="{{ route('coach.dashboard') }}">
                                <i class="fa fa-chart-line"></i>
                                <span>Dashboard Coach</span>
                            </a>
                            @elseif(Auth::user()->role === 'peserta')
                            <a class="nav-link d-flex align-items-center gap-2 {{ request()->is('peserta/dashboard') ? 'active' : '' }}"
                                href="{{ route('peserta.dashboard') }}">
                                <i class="fa fa-chart-line"></i>
                                <span>Dashboard Peserta</span>
                            </a>
                            @endif
                        </li>

                        <li class="nav-item mb-2">
                            <a class="nav-link d-flex align-items-center gap-2 {{ request()->is('task*') ? 'active' : '' }}"
                                href="{{ route('task.index') }}">
                                <i class="fa fa-tasks"></i>
                                <span>Task</span>
                            </a>
                        </li>
                        @if(auth()->check() && auth()->user()->role == 'coach' || auth()->user()->role == 'admin')
                        <li class="nav-item mb-2">
                            <a class="nav-link d-flex align-items-center gap-2 {{ request()->is('sprint*') ? 'active' : '' }}"
                                href="{{ route('sprint.index') }}">
                                <i class="fa fa-clipboard-list"></i>
                                <span>Sprint</span>
                            </a>
                        </li>
                        @endif

                    <!-- sprint.my -->
                     @if(auth()->check() && auth()->user()->role == 'peserta')
                        <li class="nav-item mb-2">
                            <a class="nav-link d-flex align-items-center gap-2 {{ request()->is('sprint/my*') ? 'active' : '' }}"
                                href="{{ route('sprint.my') }}">
                                <i class="fa fa-clipboard-list"></i>
                                <span>My Sprint</span>
                            </a>
                        </li>
                     @endif




                        <!-- Peserta -->
                         @if(auth()->check() && auth()->user()->role == 'coach' || auth()->user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('peserta*') ? 'active' : '' }}" href="{{ route('peserta.index') }}">
                                <i class="fa fa-users"></i> Daftar Mentee
                            </a>
                        </li>
                        @endif

                        <!-- Coaches -->
                        @if(auth()->check() && auth()->user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('coach*') ? 'active' : '' }}" href="{{ route('coach.index') }}">
                                <i class="fa fa-chalkboard-teacher"></i> Coaches
                            </a>
                        </li>
                        @endif

                        <!-- Settings -->
                        @if(auth()->check() && auth()->user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('settings*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
                                <i class="fa fa-cogs"></i> Settings
                            </a>
                        </li>
                        @endif

                    </ul>
                </div>
            </nav>


            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('content')
            </main>
        </div>
    </div>
    <style>
        .sidebar {
            padding-top: 40px;
            min-height: 100vh;
            background: #1e1e2d;
            /* lebih gelap elegan */
        }

        .sidebar .nav-link {
            color: #bbb;
            font-size: 15px;
            padding: 10px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link i {
            width: 18px;
            text-align: center;
        }

        .sidebar .nav-link:hover {
            background: #343a40;
            color: #fff;
            transform: translateX(5px);
            /* efek geser */
        }

        .sidebar .nav-link.active {
            background: #0d6efd;
            color: #fff !important;
            font-weight: bold;
        }
    </style>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>