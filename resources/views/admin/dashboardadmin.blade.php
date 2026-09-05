@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="db-page">
    <div class="db-card db-mb">
        <div class="db-card-inner">
            <h2 class="db-section-title">Ringkasan Aktivitas</h2>

            <div class="db-summary-grid">

                <div class="db-summary-item">
                    <div class="db-icon-box db-icon-blue">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="db-summary-label">Akun Terdaftar Baru</div>
                    <div class="db-summary-value">
                        {{ $akunBaruCount ?? 15 }} <span>Akun</span>
                    </div>
                    <div class="db-summary-caption">7 hari terakhir</div>
                </div>

                <div class="db-summary-item">
                    <div class="db-icon-box db-icon-green">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="db-summary-label">Akun Terverifikasi</div>
                    <div class="db-summary-value">
                        {{ $akunTerverifikasiCount ?? 23 }} <span>Akun</span>
                    </div>
                    <div class="db-summary-caption">7 hari terakhir</div>
                </div>

                <div class="db-summary-item">
                    <div class="db-icon-box db-icon-purple">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>
                    <div class="db-summary-label">Laporan Diverifikasi</div>
                    <div class="db-summary-value">
                        {{ $laporanDiverifikasiCount ?? 18 }} <span>Laporan</span>
                    </div>
                    <div class="db-summary-caption">7 hari terakhir</div>
                </div>

                <div class="db-summary-item">
                    <div class="db-icon-box db-icon-orange">
                        <i class="bi bi-database-fill"></i>
                    </div>
                    <div class="db-summary-label">Data Retribusi</div>
                    <div class="db-summary-value">
                        {{ $dataRetribusiCount ?? 52 }} <span>Jenis</span>
                    </div>
                    <div class="db-summary-caption">Total data</div>
                </div>

                <div class="db-summary-item">
                    <div class="db-icon-box db-icon-teal">
                        <i class="bi bi-bullseye"></i>
                    </div>
                    <div class="db-summary-label">Target Tercapai</div>
                    <div class="db-summary-value">
                        {{ $targetPersen ?? 68 }}<span>%</span>
                    </div>
                    <div class="db-summary-caption">Bulan ini</div>
                </div>

            </div>
        </div>
    </div>

        <div class="db-card-inner">
            <h2 class="db-section-title">Aksi Cepat</h2>

            <div class="db-action-grid">

                <a href="#" class="db-action-item db-bg-blue">
                    <div class="db-icon-box db-icon-blue">
                        <i class="bi bi-gear-fill"></i>
                    </div>
                    <div class="db-action-text">
                        <div class="db-action-title">Pengaturan</div>
                        <div class="db-action-desc">Kelola sistem dan konfigurasi aplikasi</div>
                    </div>
                    <i class="bi bi-arrow-right db-action-arrow"></i>
                </a>

                <a href="{{ route('admin.target.index') }}" class="db-action-item db-bg-green">
                    <div class="db-icon-box db-icon-green">
                        <i class="bi bi-bullseye"></i>
                    </div>
                    <div class="db-action-text">
                        <div class="db-action-title">Lihat Target</div>
                        <div class="db-action-desc">Lihat capaian dan target retribusi</div>
                    </div>
                    <i class="bi bi-arrow-right db-action-arrow"></i>
                </a>

                <a href="{{ route('admin.data.index') }}" class="db-action-item db-bg-purple">
                    <div class="db-icon-box db-icon-purple">
                        <i class="bi bi-database-fill"></i>
                    </div>
                    <div class="db-action-text">
                        <div class="db-action-title">Tambah Data Retribusi</div>
                        <div class="db-action-desc">Tambah jenis retribusi baru</div>
                    </div>
                    <i class="bi bi-arrow-right db-action-arrow"></i>
                </a>

                <a href="{{ route('admin.laporan.index') }}" class="db-action-item db-bg-orange">
                    <div class="db-icon-box db-icon-orange">
                        <i class="bi bi-file-earmark-check-fill"></i>
                    </div>
                    <div class="db-action-text">
                        <div class="db-action-title">Verifikasi Laporan</div>
                        <div class="db-action-desc">Review dan verifikasi laporan retribusi</div>
                    </div>
                    <i class="bi bi-arrow-right db-action-arrow"></i>
                </a>

                <a href="{{ route('admin.verifikasi') }}" class="db-action-item db-bg-teal">
                    <div class="db-icon-box db-icon-teal">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                    <div class="db-action-text">
                        <div class="db-action-title">Verifikasi Admin</div>
                        <div class="db-action-desc">Verifikasi akun administrator</div>
                    </div>
                    <i class="bi bi-arrow-right db-action-arrow"></i>
                </a>

            </div>
        </div>
    </div>
</div>
@endsection