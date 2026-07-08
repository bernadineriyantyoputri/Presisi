<div class="sidebar d-flex flex-column justify-content-between">

    <!-- Atas -->
    <div>

        <div class="sidebar-logo text-center">
            <img src="{{ asset('images/logo-presisi.png') }}" class="img-fluid" alt="PRESISI">
        </div>

        <div class="sidebar-menu-wrap">

            <a href="{{ route('perangkat') }}"
                class="sidebar-menu {{ request()->routeIs('perangkat') ? 'active' : '' }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('perangkat.laporan.index') }}"
                class="sidebar-menu {{ request()->routeIs('perangkat.laporan.*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart"></i>
                <span>Laporan Retribusi</span>
            </a>

            <a href="{{ route('perangkat.laporan.riwayat') }}"
                class="sidebar-menu {{ request()->routeIs('perangkat.laporan.riwayat') ? 'active' : '' }}">
                <i class="bi bi-wallet2"></i>
                <span>Riwayat Laporan</span>
            </a>

            <a href="{{ route('perangkat.pengaturan.profil') }}"
                class="sidebar-menu {{ request()->routeIs('perangkat.pengaturan.*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i>
                <span>Pengaturan</span>
            </a>

        </div>

    </div>

    <!-- Bawah -->
    <div class="sidebar-bottom">

        <a href="#" class="sidebar-menu">
            <i class="bi bi-question-circle"></i>
            <span>Help Center</span>
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="sidebar-menu sidebar-logout border-0 bg-transparent w-100 text-start">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>

    </div>

</div>