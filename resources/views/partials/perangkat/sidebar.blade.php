<div class="sidebar bg-white border-end d-flex flex-column justify-content-between shadow-sm">
    <div>

        <!-- Logo -->
        <div class="p-4 text-center border-bottom">
            <img src="https://via.placeholder.com/150x45?text=PRESISI"
                 class="img-fluid"
                 alt="Logo">
        </div>

        <!-- Menu -->
        <div class="p-3">

            <a href="{{ url('/perangkat') }}"
               class="sidebar-menu {{ request()->is('perangkat') ? 'active' : '' }}">
                <span>📊</span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('perangkat.laporan.index') }}"
               class="sidebar-menu {{ request()->routeIs('perangkat.laporan.*') ? 'active' : '' }}">
                <span>📄</span>
                <span>Laporan Retribusi</span>
            </a>

            <a href="#" class="sidebar-menu">
                <span>📁</span>
                <span>Data Retribusi</span>
            </a>

            <a href="#" class="sidebar-menu">
                <span>✔️</span>
                <span>Verifikasi</span>
            </a>

            <a href="#" class="sidebar-menu">
                <span>⚙️</span>
                <span>Pengaturan</span>
            </a>

        </div>

    </div>

    <div class="p-3 border-top">

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button class="btn btn-danger w-100">
                🚪 Logout
            </button>
        </form>

    </div>

</div>