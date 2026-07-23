{{-- ============================================================
     FILE: resources/views/admin/laporan/index.blade.php
     Halaman: Verifikasi Laporan Realisasi (Daftar Laporan Masuk)
     Catatan: CSS ada di file terpisah (public/css/admin.css),
              cari blok "VERIFIKASI LAPORAN" di file admin.css Anda.
     ============================================================ --}}

@extends('layouts.app')

@section('title', 'Verifikasi Laporan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
@endpush

@section('content')

<div class="lap-page">
    <div class="lap-container">

        {{-- ============ HEADER ============ --}}
        <div class="lap-header">
            <div>
                <h1 class="lap-title">Verifikasi Laporan Realisasi</h1>
                <p class="lap-subtitle">
                    Review dan kelola laporan retribusi dari berbagai Perangkat Daerah di lingkungan
                    Pemerintah Provinsi Lampung secara terintegrasi.
                </p>
            </div>

            <div class="lap-actions">
                <button class="lap-btn lap-btn-outline">
                    <i class="bi bi-download"></i>
                    Export Data
                </button>

                <a href="{{ route('admin.laporan.index') }}" class="lap-btn lap-btn-navy">
                    <i class="bi bi-arrow-clockwise"></i>
                    Refresh Data
                </a>
            </div>
        </div>

        {{-- ============ FILTER ============ --}}
        <div class="lap-card lap-filter-card">
            <div class="lap-card-body">

                <form method="GET" id="filterForm">
                    <div class="row g-3 align-items-end">

                        <div class="col-12 col-lg-4">
                            <div class="lap-filter-label">Cari Perangkat Daerah</div>

                            <div class="input-group">
                                <input type="text" class="form-control lap-input" name="search"
                                    id="searchInput"
                                    placeholder="Masukkan nama perangkat..." value="{{ request('search') }}">
                                <button type="submit" class="lap-btn lap-btn-outline lap-btn-icon">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3">
                            <div class="lap-filter-label">Jenis Retribusi</div>

                            <select class="form-select lap-input filter-auto" name="jenis_retribusi">
                                <option value="">Semua Jenis Retribusi</option>
                                @foreach($jenisRetribusiList ?? [] as $jenis)
                                    <option value="{{ $jenis->id }}" {{ request('jenis_retribusi') == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->nama_jenis }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 col-lg-2">
                            <div class="lap-filter-label">Bulan</div>

                            <select class="form-select lap-input filter-auto" name="bulan">
                                <option value="">Semua Bulan</option>
                                @php
                                    $namaBulan = [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                                    ];
                                @endphp
                                @foreach($namaBulan as $num => $label)
                                    <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 col-lg-2">
                            <div class="lap-filter-label">Tahun</div>

                            <select class="form-select lap-input filter-auto" name="tahun">
                                <option value="">Semua Tahun</option>
                                @for($i = date('Y'); $i >= 2024; $i--)
                                    <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-6 col-lg-1">
                            <a href="{{ route('admin.laporan.index') }}" class="lap-btn lap-btn-outline w-100 btn-reset-filter">
                                Reset
                            </a>
                        </div>

                    </div>
                </form>

            </div>
        </div>

        {{-- ============ DATA ============ --}}
        <div class="lap-card">

            <div class="lap-card-header">
                <span class="lap-card-header-title">Daftar Laporan Masuk</span>
                <span class="lap-card-header-meta">
                    Menampilkan {{ $laporan->count() }} dari {{ $laporan->total() ?? $laporan->count() }} laporan
                </span>
            </div>

            <div class="lap-table-wrap">
                <table class="table lap-table align-middle mb-0">

                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th>Nama Perangkat Daerah</th>
                            <th>Email Instansi</th>
                            <th>Bulan/Tahun</th>
                            <th>Jenis Retribusi</th>
                            <th>Status</th>
                            <th>PDF</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($laporan as $item)

                            <tr>

                                <td class="lap-cell-muted">{{ $loop->iteration }}</td>

                                <td>
                                    <strong class="lap-cell-strong">{{ $item->perangkatDaerah->nama_perangkat ?? '-' }}</strong>
                                    <div class="lap-id-label">
                                        ID: PD-{{ $item->tahun }}-{{ str_pad($item->perangkatDaerah->id ?? $item->id, 3, '0', STR_PAD_LEFT) }}
                                    </div>
                                </td>

                                <td class="lap-cell-muted">{{ $item->perangkatDaerah->email ?? '-' }}</td>

                                <td>{{ $item->bulan }} / {{ $item->tahun }}</td>

                                <td>
                                    @php
                                        $namaJenis = $item->laporanDetail
                                            ->pluck('rincian.objek.jenis.nama_jenis')
                                            ->filter()
                                            ->unique();
                                    @endphp

                                    @forelse($namaJenis as $nj)
                                        <span class="lap-badge-kategori">{{ $nj }}</span>
                                    @empty
                                        <span class="lap-cell-muted">-</span>
                                    @endforelse
                                </td>

                                <td>
                                    @php
                                        $statusMap = [
                                            'pending'   => ['label' => 'Menunggu Verifikasi', 'class' => 'pending'],
                                            'disetujui' => ['label' => 'Disetujui', 'class' => 'disetujui'],
                                            'ditolak'   => ['label' => 'Ditolak', 'class' => 'ditolak'],
                                        ];
                                        $statusInfo = $statusMap[$item->status] ?? ['label' => $item->status, 'class' => 'pending'];
                                    @endphp

                                    <span class="lap-badge-status {{ $statusInfo['class'] }}">
                                        <span class="lap-dot"></span>
                                        {{ $statusInfo['label'] }}
                                    </span>
                                </td>

                                <td>
                                    <a href="{{ route('perangkat.laporan.pdf', $item->id) }}" target="_blank"
                                        class="lap-btn lap-btn-outline lap-btn-sm">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                        Lihat PDF
                                    </a>
                                </td>

                                <td>
                                    @if($item->status === 'pending')
                                        <a href="{{ route('admin.laporan.detail', $item->id) }}"
                                            class="lap-btn lap-btn-navy lap-btn-sm">
                                            <i class="bi bi-eye"></i>
                                            Detail &amp; Verifikasi
                                        </a>
                                    @elseif($item->status === 'ditolak')
                                        <a href="{{ route('admin.laporan.detail', $item->id) }}"
                                            class="lap-btn lap-btn-navy lap-btn-sm">
                                            <i class="bi bi-pencil"></i>
                                            Detail &amp; Revisi
                                        </a>
                                    @else
                                        <a href="{{ route('admin.laporan.detail', $item->id) }}"
                                            class="lap-btn lap-btn-outline lap-btn-sm">
                                            Lihat Detail
                                        </a>
                                    @endif
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="lap-empty">
                                    Tidak ada data laporan.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

            @if(method_exists($laporan, 'links'))

                <div class="lap-card-footer">

                    <span class="lap-footer-meta">
                        Menampilkan {{ $laporan->firstItem() }} - {{ $laporan->lastItem() }} dari {{ $laporan->total() }} data
                    </span>

                    <div class="lap-pagination">

                        {{-- Previous --}}
                        @if($laporan->onFirstPage())
                            <span class="lap-page-link disabled">
                                <i class="bi bi-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $laporan->previousPageUrl() }}" class="lap-page-link">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        @endif

                        {{-- Page numbers --}}
                        @foreach($laporan->getUrlRange(1, $laporan->lastPage()) as $page => $url)
                            @if($page == 1 || $page == $laporan->lastPage() || abs($page - $laporan->currentPage()) <= 1)
                                <a href="{{ $url }}"
                                    class="lap-page-link {{ $page == $laporan->currentPage() ? 'active' : '' }}">
                                    {{ $page }}
                                </a>
                            @elseif(abs($page - $laporan->currentPage()) == 2)
                                <span class="lap-page-link lap-page-ellipsis">...</span>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if($laporan->hasMorePages())
                            <a href="{{ $laporan->nextPageUrl() }}" class="lap-page-link">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        @else
                            <span class="lap-page-link disabled">
                                <i class="bi bi-chevron-right"></i>
                            </span>
                        @endif

                    </div>

                </div>

            @endif

        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    (function () {
        const form = document.getElementById('filterForm');
        const autoSelects = form.querySelectorAll('.filter-auto');

        // Auto-submit langsung saat dropdown berubah
        autoSelects.forEach(function (el) {
            el.addEventListener('change', function () {
                form.submit();
            });
        });

        // Search nama TIDAK auto-submit, harus klik tombol atau tekan Enter (default form behavior)
    })();
</script>
@endpush