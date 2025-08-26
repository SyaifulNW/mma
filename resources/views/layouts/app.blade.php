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
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-2 col-lg-2 me-0 px-3" href="#">Mastermind MBC</a>
        <div class="navbar-nav ms-auto">
            <div class="nav-item text-nowrap">
                <span class="text-white me-3">{{ Auth::user()->name ?? 'User' }}</span>
                <a class="nav-link d-inline" href="#" onclick="event.preventDefault(); confirmLogout();">Logout</a>
            </div>

            <!-- hidden logout form -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>

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
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('home') }}">
                                <i class="fa fa-chart-line"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('task*') ? 'active' : '' }}" href="{{ route('task.index') }}">
                                <i class="fa fa-tasks"></i> Task
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('sprint*') ? 'active' : '' }}" href="{{ route('sprint.index') }}">
                                <i class="fa fa-clipboard-list"></i> Sprint
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>