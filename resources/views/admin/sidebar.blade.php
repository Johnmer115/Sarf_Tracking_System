<aside class="sidebar" id="sidebar">
    <div class="sb-logo">
        <div class="sb-logo-icon">
            <img src="{{ asset('img/logo/arellano_logo.png') }}" alt="Logo">
        </div>
        <div class="sb-logo-name">AU-SARF Tracking <span>Management System</span></div>
    </div>

    <nav class="sb-nav">
    <p class="sb-section">Main</p>
    <ul class="sb-list">
        <li>
            <a href="{{ route('admin.index') }}" class="sb-item">
                <i class="fas fa-home"></i><span>Dashboard</span>
            </a>
        </li>
    </ul>

    <p class="sb-section">SARF</p>
    <ul class="sb-list">
        <li>
            <a href="" class="sb-item">
                <i class="fas fa-file-alt"></i><span>SARF Records</span>
            </a>
        </li>
    </ul>

    <p class="sb-section">Management</p>
    <ul class="sb-list">
        <li>
            <a href="{{ route('admin.account.index') }}" class="sb-item">
                <i class="fas fa-users"></i><span>Account</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.branch.index') }}" class="sb-item">
                <i class="fas fa-code-branch"></i><span>Branch</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.department.index') }}" class="sb-item">
                <i class="fas fa-sitemap"></i><span>Department</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.orgs.index') }}" class="sb-item">
                <i class="fas fa-building"></i><span>Organization</span>
            </a>
        </li>
    </ul>
</nav>

    <div class="sb-footer">
    <div class="sb-user">
        <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->username, 0, 2)) }}</div>
        <div>
            <div class="sb-uname">{{ auth()->user()->username }}</div>
            <div><i class="fas fa-crown"></i> {{ auth()->user()->usertype }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="sb-logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
</div>
</aside>
