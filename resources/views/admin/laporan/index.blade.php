@extends('layouts.app')

@section('title', 'Verifikasi Laporan')

@section('content')

    <div class="container-fluid p-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h2 class="fw-bold mb-1">
                    Verifikasi Laporan Realisasi
                </h2>

                <p class="text-muted mb-0">
                    Review dan kelola laporan retribusi dari berbagai Perangkat Daerah di Provinsi Lampung.
                </p>
            </div>

            <div>
                <button class="btn btn-outline-secondary me-2">
                    <i class="bi bi-download"></i>
                    Export Data
                </button>

                <a href="{{ route('admin.laporan.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-clockwise"></i>
                    Refresh Data
                </a>
            </div>

        </div>

        {{-- Filter --}}
        <div class="card shadow-sm border-0 mb-4">

            <div class="card-body">

                <form method="GET">

                    <div class="row g-3">

                        <div class="col-md-4">

                            <label class="form-label">
                                Cari Perangkat Daerah
                            </label>

                            <input type="text" class="form-control" name="search" placeholder="Masukkan nama perangkat..."
                                value="{{ request('search') }}">

                        </div>

                        <div class="col-md-2">

                            <label class="form-label">
                                Tahun
                            </label>

                            <select class="form-select" name="tahun">

                                <option value="">Semua</option>

                                @for($i = date('Y'); $i >= 2024; $i--)

                                    <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>

                                @endfor

                            </select>

                        </div>

                        <div class="col-md-3">

                            <label class="form-label">
                                Status
                            </label>

                            <select class="form-select" name="status">

                                <option value="">Semua Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Disetujui">Disetujui</option>
                                <option value="Ditolak">Ditolak</option>

                            </select>

                        </div>

                        <div class="col-md-3 d-flex align-items-end">

                            <button class="btn btn-primary w-100">
                                <i class="bi bi-funnel"></i>
                                Terapkan Filter
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        {{-- Data --}}
        <div class="card shadow-sm border-0">

            <div class="card-header bg-white fw-bold">
                Daftar Laporan Masuk
            </div>

            <div class="card-body p-0">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th width="60">No</th>
                            <th>Nama Perangkat Daerah</th>
                            <th>Email Instansi</th>
                            <th>Bulan</th>
                            <th>Tahun</th>
                            <th>PDF</th>
                            <th width="120">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($laporan as $item)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>

                                    <strong>
                                        {{ $item->perangkatDaerah->nama_perangkat ?? '-' }}
                                    </strong>

                                </td>

                                <td>
                                    {{ $item->perangkatDaerah->email ?? '-' }}
                                </td>

                                <td>{{ $item->bulan }}</td>

                                <td>{{ $item->tahun }}</td>

                                <td>

                                    <a href="{{ route('perangkat.laporan.pdf', $item->id) }}" target="_blank"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                        Lihat PDF
                                    </a>

                                </td>

                                <td>

                                    <a href="{{ route('admin.laporan.detail', $item->id) }}"
                                        class="btn btn-outline-secondary btn-sm">

                                        <i class="bi bi-eye"></i>
                                        Detail

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="text-center py-5">
                                    Tidak ada data laporan.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            @if(method_exists($laporan, 'links'))

                <div class="card-footer bg-white">
                    {{ $laporan->links() }}
                </div>

            @endif

        </div>

    </div>

@endsection