<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SARF Tracking - SARF Checking</title>
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
            <div class="topbar-title">SARF Checking</div>
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
                    <div class="panel-title"><i class="fas fa-clipboard-check"></i> SARF Checking List</div>
                    <div class="panel-controls">
                        <div class="search-wrap">
                            <i class="fas fa-search"></i>
                            <input class="search-input" type="text" placeholder="Search...">
                        </div>
                        <select class="filter-select">
                            <option>All Status</option>
                            <option>Pending Review</option>
                            <option>Verified</option>
                            <option>Issues Found</option>
                        </select>
                        <button class="btn btn-filter"><i class="fas fa-sliders-h"></i> Filter</button>
                        <button class="btn btn-add"><i class="fas fa-plus"></i> New Check</button>
                    </div>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:70%;">Check Name</th>
                                <th style="width:18%;">Checker</th>
                                <th style="width:18%;">Report Ref.</th>
                                <th style="width:15%;">Status</th>
                                <th style="width:22%;">Created</th>
                                <th style="width:18%; text-align:center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td><span class="row-id">#{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</span></td>
                                <td><div class="td-name">Check {{ $user->id }}</div></td>
                                <td class="td-muted">{{ $user->name }}</td>
                                <td class="td-muted">SARF-{{ $user->id }}</td>
                                <td><span class="badge b-admin">Pending</span></td>
                                <td>
                                    <div class="action-cell">
                                        <button class="abtn abtn-view" title="View"><i class="fas fa-eye"></i></button>
                                        <button class="abtn abtn-edit" title="Edit"><i class="fas fa-edit"></i></button>
                                        <button class="abtn abtn-del" title="Delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 30px;">No checking records found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="panel-footer">
                    <div class="footer-left">
                        <span class="footer-info">Showing {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }} of {{ $users->total() }} entries</span>
                        <div class="show-wrap">
                            Show
                            <select><option>10</option><option>25</option><option>50</option></select>
                            entries
                        </div>
                    </div>
                    <div class="pagi">
                        @if($users->onFirstPage())
                            <span class="pbtn pd">&#8249; Previous</span>
                        @else
                            <a class="pbtn" href="{{ $users->previousPageUrl() }}">&#8249; Previous</a>
                        @endif

                        @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                            @if($page == $users->currentPage())
                                <span class="pbtn pa">{{ $page }}</span>
                            @else
                                <a class="pbtn" href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if($users->hasMorePages())
                            <a class="pbtn" href="{{ $users->nextPageUrl() }}">Next &#8250;</a>
                        @else
                            <span class="pbtn pd">Next &#8250;</span>
                        @endif
                    </div>
                </div>
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