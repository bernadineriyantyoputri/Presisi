@extends('layouts.app')

@section('title', 'Verifikasi Laporan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
@endpush

@section('content')

<div class="lap-page">
    <div class="tgt-header page-header">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
                <h1>Verifikasi Laporan Realisasi</h1>
                <p>
                    Review dan kelola laporan retribusi dari berbagai Perangkat Daerah
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
    </div>

    <div class="lap-card lap-filter-card">
        <div class="lap-card-body">

            <form method="GET" id="filterForm">
                <div class="row g-3 align-items-end mx-0">

                    <div class="col-12 col-lg-4">
                        <div class="lap-filter-label">Cari Perangkat Daerah</div>

                        <div class="input-group">
                            <input type="text" class="form-control lap-input" name="search" id="searchInput"
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
                                    1 => 'Januari',
                                    2 => 'Februari',
                                    3 => 'Maret',
                                    4 => 'April',
                                    5 => 'Mei',
                                    6 => 'Juni',
                                    7 => 'Juli',
                                    8 => 'Agustus',
                                    9 => 'September',
                                    10 => 'Oktober',
                                    11 => 'November',
                                    12 => 'Desember',
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
    @php
        $lapJenisColors = ['#4338CA', '#16A34A', '#EA580C', '#0D9488', '#B8860B', '#C0392B', '#2563EB', '#9333EA', '#DB2777', '#65A30D'];
        $lapJenisColorMap = [];
        foreach (($jenisRetribusiList ?? []) as $lapIdx => $lapJenis) {
            $lapJenisColorMap[$lapJenis->nama_jenis] = $lapJenisColors[$lapIdx % count($lapJenisColors)];
        }
    @endphp

    <div class="lap-card">

        <div class="lap-table-wrap">
            <table class="table lap-table align-middle mb-0">

                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Perangkat Daerah</th>
                        <th>Email Instansi</th>
                        <th>Bulan/Tahun</th>
                        <th>Jenis Retribusi</th>
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
                                    <span class="lap-jenis-dot" title="{{ $nj }}" style="background-color: {{ $lapJenisColorMap[$nj] ?? '#94a3b8' }};"></span>
                                @empty
                                    <span class="lap-cell-muted">-</span>
                                @endforelse
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
                            <td colspan="7" class="lap-empty">
                                Tidak ada data laporan.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

        @if(($jenisRetribusiList ?? collect())->count())
            <div class="lap-legend">
                @foreach($jenisRetribusiList as $jenis)
                    <span class="lap-legend-item">
                        <span class="lap-legend-dot" style="background-color: {{ $lapJenisColorMap[$jenis->nama_jenis] ?? '#94a3b8' }};"></span>
                        {{ $jenis->nama_jenis }}
                    </span>
                @endforeach
            </div>
        @endif

        @if(method_exists($laporan, 'links'))

            <div class="lap-card-footer">

                <span class="lap-footer-meta">
                    Menampilkan {{ $laporan->firstItem() }} - {{ $laporan->lastItem() }} dari {{ $laporan->total() }}
                    data
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
                            <a href="{{ $url }}" class="lap-page-link {{ $page == $laporan->currentPage() ? 'active' : '' }}">
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