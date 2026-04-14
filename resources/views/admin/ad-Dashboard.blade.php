<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SARF Tracking - Users Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    <aside class="sidebar" id="sidebar">
        <div class="sb-logo">
            <div class="sb-logo-icon"><i class="fas fa-tachometer-alt"></i></div>
            <div class="sb-logo-name">SARF Tracking <span>Management System</span></div>
        </div>

        <nav class="sb-nav">
            <p class="sb-section">Main</p>
            <ul class="sb-list">
                <li><a href="{{ route('dashboard') }}" class="sb-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i><span>Dashboard</span></a></li>
            </ul>

            <p class="sb-section">SARF</p>
            <ul class="sb-list">
                <li><a href="{{ route('admin.sarf-report') }}" class="sb-item {{ request()->routeIs('admin.sarf-report') ? 'active' : '' }}"><i class="fas fa-file-alt"></i><span>SARF Report</span></a></li>
                <li><a href="{{ route('admin.sarf-checking') }}" class="sb-item {{ request()->routeIs('admin.sarf-checking') ? 'active' : '' }}"><i class="fas fa-clipboard-check"></i><span>SARF Checking</span></a></li>
            </ul>

            <p class="sb-section">Management</p>
            <ul class="sb-list">
                <li><a href="{{ route('admin.users') }}" class="sb-item {{ request()->routeIs('admin.users') ? 'active' : '' }}"><i class="fas fa-users"></i><span>Users</span></a></li>
                <li><a href="{{ route('admin.branches') }}" class="sb-item {{ request()->routeIs('admin.branches') ? 'active' : '' }}"><i class="fas fa-building"></i><span>Branches</span></a></li>
                <li><a href="{{ route('admin.departments') }}" class="sb-item {{ request()->routeIs('admin.departments') ? 'active' : '' }}"><i class="fas fa-sitemap"></i><span>Departments</span></a></li>
                <li><a href="{{ route('admin.organizations') }}" class="sb-item {{ request()->routeIs('admin.organizations') ? 'active' : '' }}"><i class="fas fa-network-wired"></i><span>Organizations</span></a></li>
            </ul>
        </nav>

        <div class="sb-footer">
            <div class="sb-user">
                <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                <div>
                    <div class="sb-uname">{{ auth()->user()->name }}</div>
                    <div class="sb-urole"><i class="fas fa-crown"></i> Administrator</div>
                </div>
            </div>
            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit" class="sb-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </aside>

    <div class="main">
        <header class="topbar">
            <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
            <div class="topbar-title">Dashboard</div>
            <div class="topbar-right">
                <div class="topbar-info">
                    <div class="topbar-name">{{ auth()->user()->name }}</div>
                    <div class="topbar-role">Administrator</div>
                </div>
                <div class="topbar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
            </div>
        </header>

        <div class="content">
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title"><i class="fas fa-tachometer-alt"></i> Dashboard Overview</div>
                </div>

                <div class="panel-body" style="padding: 40px; text-align: center;">
                    <h2 style="color: #1e40af; margin-bottom: 20px;">Welcome to SARF Tracking Management System</h2>
                    <p style="color: #666; font-size: 16px;">
                        Select a section from the sidebar to get started.
                    </p>
                </div>
            </div>
        </div>


    <script>
        document.getElementById('menuToggle').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('open');
        });
    </script>
</body>
</html>