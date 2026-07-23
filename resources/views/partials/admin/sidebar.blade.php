<div class="sidebar">

    <!-- Logo -->
    <div class="sidebar-header text-center">
        <img src="{{ asset('images/logo-presisi.png') }}" alt="Logo" class="logo">
    </div>

    <!-- Menu -->
    <div class="sidebar-menu-list">

        <a href="{{ route('admin') }}" class="sidebar-menu {{ request()->routeIs('admin') ? 'active' : '' }}">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.verifikasi') }}"
            class="sidebar-menu {{ request()->routeIs('admin.verifikasi*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart"></i>
            <span>Verifikasi Admin</span>
        </a>

        <a href="{{ route('admin.laporan.index') }}"
            class="sidebar-menu {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
            <i class="bi bi-wallet2"></i>
            <span>Verifikasi Laporan</span>
        </a>

        <a href="{{ route('admin.data.index') }}"
            class="sidebar-menu {{ request()->routeIs('admin.data.*') ? 'active' : '' }}">
            <i class="bi bi-box-arrow-in-down"></i>
            <span>Data Retribusi</span>
        </a>

        <a href="{{ route('admin.target.index') }}"
            class="sidebar-menu {{ request()->routeIs('admin.target.*') ? 'active' : '' }}">
            <i class="bi bi-bullseye"></i>
            <span>Target Retribusi</span>
        </a>

        <a href="#" class="sidebar-menu">
            <i class="bi bi-gear"></i>
            <span>Pengaturan</span>
        </a>

    </div>

    <!-- Bottom -->
    <div class="sidebar-footer">

        <a href="#" class="sidebar-menu">
            <i class="bi bi-question-circle"></i>
            <span>Help Center</span>
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="sidebar-menu logout-btn" type="submit">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>

    </div>

</div>