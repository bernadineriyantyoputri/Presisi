@extends('layouts.app')

@section('title', 'Pengaturan - Tentang Sistem')

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
            <a href="{{ route('admin.pengaturan.tentang') }}" class="peng-tab active">
                <i class="bi bi-info-circle"></i> Tentang Sistem
            </a>
            <a href="{{ route('admin.pengaturan.notifikasi') }}" class="peng-tab">
                <i class="bi bi-bell"></i> Pengaturan Notifikasi
            </a>
        </div>

        {{-- Card --}}
        <div class="peng-card">
            <div class="peng-card-body">

                <div class="peng-about-grid">

                    {{-- Kolom kiri: brand card --}}
                    <div class="peng-about-brand">
                        <div class="peng-about-logo">
                            <img src="{{ asset('images/logo-presisi.png') }}" alt="PRESISI">
                        </div>
                        <div class="peng-about-name">{{ $namaSistem ?? 'PRESISI' }}</div>
                        <div class="peng-about-tagline">
                            {{ $taglineSistem ?? 'Pelaporan Realisasi Penerimaan Retribusi Daerah' }}
                        </div>
                        <span class="peng-about-divider"></span>
                        <p class="peng-about-desc">
                            {{ $deskripsiSistem ?? 'Sistem informasi terintegrasi untuk pengelolaan dan pelaporan realisasi penerimaan retribusi daerah secara digital, akurat, dan transparan.' }}
                        </p>
                    </div>

                    {{-- Kolom kanan: statistik, banner instansi, info tambahan --}}
                    <div class="peng-about-right">

                        <div class="peng-about-stats-grid">
                            <div class="peng-about-stat-box">
                                <div class="peng-about-stat-icon">
                                    <i class="bi bi-display"></i>
                                </div>
                                <div class="peng-about-stat-text">
                                    <span class="peng-about-stat-label">Nama Sistem</span>
                                    <span class="peng-about-stat-value">{{ $namaSistem ?? 'PRESISI' }}</span>
                                </div>
                            </div>

                            <div class="peng-about-stat-box">
                                <div class="peng-about-stat-icon">
                                    <i class="bi bi-gear-fill"></i>
                                </div>
                                <div class="peng-about-stat-text">
                                    <span class="peng-about-stat-label">Versi Sistem</span>
                                    <span class="peng-about-stat-value">{{ $versiSistem ?? 'v1.0.0' }}</span>
                                </div>
                            </div>

                            <div class="peng-about-stat-box">
                                <div class="peng-about-stat-icon">
                                    <i class="bi bi-calendar3"></i>
                                </div>
                                <div class="peng-about-stat-text">
                                    <span class="peng-about-stat-label">Tahun Pembuatan</span>
                                    <span class="peng-about-stat-value">{{ $tahunPembuatan ?? '2024' }}</span>
                                </div>
                            </div>

                            <div class="peng-about-stat-box">
                                <div class="peng-about-stat-icon">
                                    <i class="bi bi-code-slash"></i>
                                </div>
                                <div class="peng-about-stat-text">
                                    <span class="peng-about-stat-label">Pengembang</span>
                                    <span class="peng-about-stat-value">{{ $pengembang ?? 'Tim IT Bapenda' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="peng-about-banner">
                            <div class="peng-about-banner-bg">
                                <span>{{ $provinsi ?? 'Provinsi Lampung' }}</span>
                                <span>Hak Cipta Dilindungi</span>
                                <span>Undang-Undang</span>
                            </div>
                            <div class="peng-about-banner-content">
                                <div class="peng-about-banner-label">Instansi Penanggung Jawab</div>
                                <div class="peng-about-banner-title">{{ $instansi ?? 'Badan Pendapatan Daerah Provinsi Lampung' }}</div>
                            </div>
                            <div class="peng-about-banner-icon">
                                <i class="bi bi-bank2"></i>
                            </div>
                        </div>

                        <div class="peng-about-mini-grid">
                            <div class="peng-about-mini-box">
                                <i class="bi bi-shield-lock-fill"></i>
                                <span class="peng-about-mini-label">Enkripsi Data</span>
                                <span class="peng-about-mini-value">{{ $enkripsiData ?? 'AES-256 Bit' }}</span>
                            </div>
                            <div class="peng-about-mini-box">
                                <i class="bi bi-hdd-network-fill"></i>
                                <span class="peng-about-mini-label">Infrastruktur</span>
                                <span class="peng-about-mini-value">{{ $infrastruktur ?? 'Cloud Hosted' }}</span>
                            </div>
                            <div class="peng-about-mini-box">
                                <i class="bi bi-arrow-repeat"></i>
                                <span class="peng-about-mini-label">Last Update</span>
                                <span class="peng-about-mini-value">{{ $lastUpdate ?? 'July 2026' }}</span>
                            </div>
                        </div>

                    </div>

                </div>

                {{-- Kutipan --}}
                <div class="peng-about-quote">
                    "{{ $kutipanSistem ?? 'PRESISI merupakan bagian dari transformasi digital Pemerintah Provinsi Lampung untuk mewujudkan tata kelola pemerintahan yang bersih, efektif, transparan, dan akuntabel melalui penguatan sistem pengawasan dan pelaporan retribusi daerah.' }}"
                </div>

            </div>
        </div>

    </div>
</div>

@endsection