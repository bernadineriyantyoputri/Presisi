@extends('layouts.app')

@section('title', 'Pengaturan - Pengaturan Notifikasi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
@endpush

@section('content')

<div class="peng-page">
    <div class="peng-container">

        {{-- Header --}}
        <div class="peng-header">
            <h1 class="peng-title">Pengaturan</h1>
            <p class="peng-subtitle">Kelola profil, keamanan akun, serta konfigurasi sistem PRESISI.</p>
        </div>

        {{-- Alert --}}
        @if(session('success'))
            <div class="peng-alert peng-alert-success">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Tabs --}}
        <div class="peng-tabs peng-tabs-pill">
            <a href="{{ route('admin.pengaturan.profil') }}" class="peng-tab">
                <i class="bi bi-person-circle"></i> Profil Admin
            </a>
            <a href="{{ route('admin.pengaturan.password') }}" class="peng-tab">
                <i class="bi bi-shield-lock"></i> Keamanan Akun
            </a>
            <a href="{{ route('admin.pengaturan.sistem') }}" class="peng-tab">
                <i class="bi bi-gear"></i> Pengaturan Sistem
            </a>
            <a href="{{ route('admin.pengaturan.tentang') }}" class="peng-tab">
                <i class="bi bi-info-circle"></i> Tentang Sistem
            </a>
            <a href="{{ route('admin.pengaturan.notifikasi') }}" class="peng-tab active">
                <i class="bi bi-bell"></i> Pengaturan Notifikasi
            </a>
        </div>

        {{-- Card --}}
        <div class="peng-card">

            <form action="{{ route('admin.pengaturan.notifikasi.update') }}" method="POST">
                @csrf
                @method('PUT')

                {{-- ===== Bagian atas: foto + nama + badge + lokasi + tombol simpan ===== --}}
                <div class="peng-profile-top">
                    <div class="peng-profile-left">
                        <div class="peng-profile-photo-wrap">
                            @if($user->foto)
                                <img src="{{ asset('storage/'.$user->foto) }}" alt="{{ $user->name }}" class="peng-avatar-photo">
                            @else
                                <div class="peng-avatar-photo peng-avatar-fallback">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="peng-photo-upload-btn" title="Ganti foto">
                                <i class="bi bi-camera-fill"></i>
                            </span>
                        </div>

                        <div class="peng-profile-info">
                            <div class="peng-profile-name">{{ $user->name }}</div>
                            <span class="peng-profile-badge">{{ $user->unit_kerja ?? 'Pusat Data' }}</span>
                            <div class="peng-profile-location">
                                <i class="bi bi-geo-alt-fill"></i>
                                {{ $user->lokasi_kantor ?? 'Kantor Pusat Bapenda, Bandar Lampung' }}
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="peng-btn-save">
                        <i class="bi bi-check-circle"></i> Simpan Perubahan
                    </button>
                </div>

                {{-- ===== Bagian bawah: daftar notifikasi ===== --}}
                <div class="peng-card-body">
                    <div class="peng-notif-list">

                        @php
                            $notif = $notifikasi ?? [
                                'laporan_masuk' => true,
                                'target_belum_tercapai' => true,
                                'perubahan_data' => true,
                                'pengingat_laporan' => false,
                            ];
                        @endphp

                        <div class="peng-notif-item">
                            <div class="peng-notif-left">
                                <div class="peng-notif-icon">
                                    <i class="bi bi-file-earmark-text-fill"></i>
                                </div>
                                <div class="peng-notif-text">
                                    <div class="peng-notif-title">Notifikasi Laporan Masuk</div>
                                    <div class="peng-notif-desc">Menerima notifikasi ketika perangkat daerah mengirimkan laporan realisasi retribusi.</div>
                                </div>
                            </div>
                            <div class="peng-notif-right">
                                <label class="peng-switch">
                                    <input type="checkbox" name="laporan_masuk" value="1" {{ !empty($notif['laporan_masuk']) ? 'checked' : '' }}>
                                    <span class="peng-switch-slider"></span>
                                </label>
                                <span class="peng-switch-label">{{ !empty($notif['laporan_masuk']) ? 'Aktif' : 'Tidak Aktif' }}</span>
                            </div>
                        </div>

                        <div class="peng-notif-item">
                            <div class="peng-notif-left">
                                <div class="peng-notif-icon">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                </div>
                                <div class="peng-notif-text">
                                    <div class="peng-notif-title">Notifikasi Target Belum Tercapai</div>
                                    <div class="peng-notif-desc">Menerima notifikasi ketika realisasi retribusi belum mencapai target.</div>
                                </div>
                            </div>
                            <div class="peng-notif-right">
                                <label class="peng-switch">
                                    <input type="checkbox" name="target_belum_tercapai" value="1" {{ !empty($notif['target_belum_tercapai']) ? 'checked' : '' }}>
                                    <span class="peng-switch-slider"></span>
                                </label>
                                <span class="peng-switch-label">{{ !empty($notif['target_belum_tercapai']) ? 'Aktif' : 'Tidak Aktif' }}</span>
                            </div>
                        </div>

                        <div class="peng-notif-item">
                            <div class="peng-notif-left">
                                <div class="peng-notif-icon">
                                    <i class="bi bi-arrow-repeat"></i>
                                </div>
                                <div class="peng-notif-text">
                                    <div class="peng-notif-title">Notifikasi Perubahan Data</div>
                                    <div class="peng-notif-desc">Menerima notifikasi ketika ada perubahan data penting.</div>
                                </div>
                            </div>
                            <div class="peng-notif-right">
                                <label class="peng-switch">
                                    <input type="checkbox" name="perubahan_data" value="1" {{ !empty($notif['perubahan_data']) ? 'checked' : '' }}>
                                    <span class="peng-switch-slider"></span>
                                </label>
                                <span class="peng-switch-label">{{ !empty($notif['perubahan_data']) ? 'Aktif' : 'Tidak Aktif' }}</span>
                            </div>
                        </div>

                        <div class="peng-notif-item">
                            <div class="peng-notif-left">
                                <div class="peng-notif-icon">
                                    <i class="bi bi-calendar2-event-fill"></i>
                                </div>
                                <div class="peng-notif-text">
                                    <div class="peng-notif-title">Notifikasi Pengingat Laporan</div>
                                    <div class="peng-notif-desc">Menerima pengingat untuk mengirimkan laporan realisasi.</div>
                                </div>
                            </div>
                            <div class="peng-notif-right">
                                <label class="peng-switch">
                                    <input type="checkbox" name="pengingat_laporan" value="1" {{ !empty($notif['pengingat_laporan']) ? 'checked' : '' }}>
                                    <span class="peng-switch-slider"></span>
                                </label>
                                <span class="peng-switch-label">{{ !empty($notif['pengingat_laporan']) ? 'Aktif' : 'Tidak Aktif' }}</span>
                            </div>
                        </div>

                    </div>
                </div>

            </form>

        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    document.querySelectorAll('.peng-switch input[type="checkbox"]').forEach(function (input) {
        const label = input.closest('.peng-notif-right').querySelector('.peng-switch-label');
        input.addEventListener('change', function () {
            label.textContent = input.checked ? 'Aktif' : 'Tidak Aktif';
        });
    });
})();
</script>
@endpush