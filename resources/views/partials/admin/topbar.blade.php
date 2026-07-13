<div class="topbar">
    <div class="topbar-text">
        <h1 class="topbar-title">{{ $title ?? 'PRESISI' }}</h1>
        @if(isset($subtitle))
            <p class="topbar-subtitle">{{ $subtitle }}</p>
        @endif
    </div>

    <a href="{{ route('admin.pengaturan.profil') }}" class="topbar-user">
        <span class="topbar-user-name">{{ auth()->user()->name ?? 'Admin' }}</span>

        <div class="topbar-avatar">
            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
        </div>
    </a>
</div>