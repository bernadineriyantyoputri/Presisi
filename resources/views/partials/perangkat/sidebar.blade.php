<div class="sidebar">

    <!-- Logo -->
    <div class="sidebar-header text-center">
        <img src="{{ asset('images/logopresisi.png') }}" alt="Logo" class="logo">
    </div>

    <!-- Menu -->
    <div class="sidebar-menu-list">

        <a href="{{ route('perangkat.laporan.index') }}"
            class="sidebar-menu {{ request()->routeIs('perangkat.laporan.*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart"></i>
            <span>Laporan Retribusi</span>
        </a>

        <a href="{{ route('perangkat.riwayat') }}"
            class="sidebar-menu {{ request()->routeIs('perangkat.riwayat') ? 'active' : '' }}">
            <i class="bi bi-wallet2"></i>
            <span>Riwayat Laporan</span>
        </a>

        <a href="{{ route('perangkat.pengaturan.profil') }}"
            class="sidebar-menu {{ request()->routeIs('perangkat.pengaturan.*') ? 'active' : '' }}">
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