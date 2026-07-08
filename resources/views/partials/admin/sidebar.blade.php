<div class="sidebar">

    <div class="sidebar-menu-wrap">

        <a href="{{ route('admin') }}" class="sidebar-menu {{ request()->routeIs('admin') ? 'active' : '' }}">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.verifikasi') }}"
            class="sidebar-menu {{ request()->routeIs('admin.verifikasi*') ? 'active' : '' }}">
            <i class="bi bi-card-checklist"></i>
            <span>Verifikasi Admin</span>
        </a>

        <a href="{{ route('admin.laporan.index') }}"
            class="sidebar-menu {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i>
            <span>Verifikasi Laporan</span>
        </a>

        <a href="{{ route('admin.data.index') }}"
            class="sidebar-menu {{ request()->routeIs('admin.data.*') ? 'active' : '' }}">
            <i class="bi bi-diagram-3"></i>
            <span>Data Retribusi</span>
        </a>

        <a href="#" class="sidebar-menu">
            <i class="bi bi-gear"></i>
            <span>Pengaturan</span>
        </a>

    </div>

    <div class="sidebar-bottom">

        <a href="#" class="sidebar-menu sidebar-help">
            <i class="bi bi-question-circle"></i>
            <span>Help Center</span>
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="sidebar-menu sidebar-logout w-100 border-0 bg-transparent text-start">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>

    </div>

</div>