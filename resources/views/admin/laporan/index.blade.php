@extends('layouts.app')

@section('title', 'Verifikasi Laporan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/laporan.css') }}">
@endpush

@section('content')

    <div class="container-fluid p-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h2 class="fw-bold mb-1">
                    Verifikasi Laporan Realisasi
                </h2>

                <p class="text-muted mb-0">
                    Review dan kelola laporan retribusi dari berbagai Perangkat Daerah di lingkungan
                    Pemerintah Provinsi Lampung secara terintegrasi.
                </p>
            </div>

            <div>
                <button class="btn btn-outline-secondary me-2">
                    <i class="bi bi-download"></i>
                    Export Data
                </button>

                <a href="{{ route('admin.laporan.index') }}" class="btn btn-navy">
                    <i class="bi bi-arrow-clockwise"></i>
                    Refresh Data
                </a>
            </div>

        </div>

        {{-- Filter --}}
        <div class="card shadow-sm border-0 mb-4">

            <div class="card-body">

                <form method="GET" id="filterForm">

                    <div class="row g-3 align-items-end">

                        <div class="col-md-4">
                            <div class="filter-label">Cari Perangkat Daerah</div>

                            <div class="input-group">
                                <input type="text" class="form-control" name="search"
                                    id="searchInput"
                                    placeholder="Masukkan nama perangkat..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-secondary">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="filter-label">Jenis Retribusi</div>

                            <select class="form-select filter-auto" name="jenis_retribusi">
                                <option value="">Semua Jenis Retribusi</option>
                                @foreach($jenisRetribusiList ?? [] as $jenis)
                                    <option value="{{ $jenis->id }}" {{ request('jenis_retribusi') == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->nama_jenis }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <div class="filter-label">Bulan</div>

                            <select class="form-select filter-auto" name="bulan">
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

                        <div class="col-md-2">
                            <div class="filter-label">Tahun</div>

                            <select class="form-select filter-auto" name="tahun">
                                <option value="">Semua Tahun</option>
                                @for($i = date('Y'); $i >= 2024; $i--)
                                    <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-1">
                            <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-secondary w-100">
                                Reset
                            </a>
                        </div>

                    </div>

                </form>

            </div>

        </div>

        {{-- Data --}}
        <div class="card shadow-sm border-0">

            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-bold">Daftar Laporan Masuk</span>
                <span class="text-muted small">
                    Menampilkan {{ $laporan->count() }} dari {{ $laporan->total() ?? $laporan->count() }} laporan
                </span>
            </div>

            <div class="card-body p-0">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th width="60">No</th>
                            <th>Nama Perangkat Daerah</th>
                            <th>Email Instansi</th>
                            <th>Bulan/Tahun</th>
                            <th>Jenis Retribusi</th>
                            <th>Status</th>
                            <th>PDF</th>
                            <th width="140">Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($laporan as $item)

                            <tr>

                                <td class="text-muted">{{ $loop->iteration }}</td>

                                <td>
                                    <strong>{{ $item->perangkatDaerah->nama_perangkat ?? '-' }}</strong>
                                    <div class="id-label">
                                        ID: PD-{{ $item->tahun }}-{{ str_pad($item->perangkatDaerah->id ?? $item->id, 3, '0', STR_PAD_LEFT) }}
                                    </div>
                                </td>

                                <td>{{ $item->perangkatDaerah->email ?? '-' }}</td>

                                <td>{{ $item->bulan }} / {{ $item->tahun }}</td>

                                <td>
                                    @php
                                        $namaJenis = $item->laporanDetail
                                            ->pluck('rincian.objek.jenis.nama_jenis')
                                            ->filter()
                                            ->unique();
                                    @endphp

                                    @forelse($namaJenis as $nj)
                                        <span class="badge-kategori">{{ $nj }}</span>
                                    @empty
                                        <span class="text-muted">-</span>
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

                                    <span class="badge-status {{ $statusInfo['class'] }}">
                                        <span class="dot"></span>
                                        {{ $statusInfo['label'] }}
                                    </span>
                                </td>

                                <td>
                                    <a href="{{ route('perangkat.laporan.pdf', $item->id) }}" target="_blank"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                        Lihat PDF
                                    </a>
                                </td>

                                <td>
                                    @if($item->status === 'pending')
                                        <a href="{{ route('admin.laporan.detail', $item->id) }}"
                                            class="btn btn-navy btn-sm">
                                            <i class="bi bi-eye"></i>
                                            Detail &amp; Verifikasi
                                        </a>
                                    @elseif($item->status === 'ditolak')
                                        <a href="{{ route('admin.laporan.detail', $item->id) }}"
                                            class="btn btn-navy btn-sm">
                                            <i class="bi bi-pencil"></i>
                                            Detail &amp; Revisi
                                        </a>
                                    @else
                                        <a href="{{ route('admin.laporan.detail', $item->id) }}"
                                            class="btn btn-outline-secondary btn-sm">
                                            Lihat Detail
                                        </a>
                                    @endif
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    Tidak ada data laporan.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            @if(method_exists($laporan, 'links'))

                <div class="card-footer bg-white d-flex justify-content-between align-items-center">

                    <span class="text-muted small">
                        Menampilkan {{ $laporan->firstItem() }} - {{ $laporan->lastItem() }} dari {{ $laporan->total() }} data
                    </span>

                    <div class="d-flex gap-2">

                        {{-- Previous --}}
                        @if($laporan->onFirstPage())
                            <span class="page-link-custom disabled opacity-50">
                                <i class="bi bi-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $laporan->previousPageUrl() }}" class="page-link-custom">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        @endif

                        {{-- Page numbers --}}
                        @foreach($laporan->getUrlRange(1, $laporan->lastPage()) as $page => $url)
                            @if($page == 1 || $page == $laporan->lastPage() || abs($page - $laporan->currentPage()) <= 1)
                                <a href="{{ $url }}"
                                    class="page-link-custom {{ $page == $laporan->currentPage() ? 'active' : '' }}">
                                    {{ $page }}
                                </a>
                            @elseif(abs($page - $laporan->currentPage()) == 2)
                                <span class="page-link-custom border-0">...</span>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if($laporan->hasMorePages())
                            <a href="{{ $laporan->nextPageUrl() }}" class="page-link-custom">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        @else
                            <span class="page-link-custom disabled opacity-50">
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