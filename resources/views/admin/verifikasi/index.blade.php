@extends('layouts.app')

@section('content')

    <div class="container-fluid p-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <small class="text-muted">Dashboard > User Verification</small>
                <h2 class="fw-bold mt-2">Verifikasi Pendaftaran Akun</h2>
                <p class="text-muted">
                    Kelola dan tinjau pendaftaran akun perangkat daerah baru dalam sistem PRESISI.
                </p>
            </div>

            <div>
                <button class="btn btn-light border me-2">
                    Export Data
                </button>

                <button class="btn btn-primary">
                    Refresh Data
                </button>
            </div>
        </div>

        {{-- Statistik --}}
        <div class="row mb-4">

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Total Menunggu ACC</h6>
                        <h1 class="fw-bold">
                            {{ $perangkat->where('status_verifikasi', 'Pending')->count() }}
                        </h1>
                        <small class="text-danger">
                            Membutuhkan tindakan segera
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Akun Terverifikasi</h6>
                        <h1 class="fw-bold">
                            {{ $perangkat->where('status_verifikasi', 'Terverifikasi')->count() }}
                        </h1>
                        <small class="text-muted">
                            Total akun aktif dalam sistem
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Pendaftaran Hari Ini</h6>
                        <h1 class="fw-bold">
                            {{ $perangkat->where('created_at', '>=', now()->startOfDay())->count() }}
                        </h1>
                        <small class="text-muted">
                            Update terbaru
                        </small>
                    </div>
                </div>
            </div>

        </div>

        {{-- Tabel --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <h5 class="fw-bold mb-0">
                        Data Verifikasi
                    </h5>

                    <span class="text-muted">
                        Total {{ $perangkat->count() }} Data
                    </span>
                </div>

                <table class="table align-middle">

                    <thead>
                        <tr>
                            <th>Nama Perangkat Daerah</th>
                            <th>Nama Kepala</th>
                            <th>Nama Bendahara</th>
                            <th>Tanggal Daftar</th>
                            <th>Status</th>
                            <th width="220">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($perangkat as $item)

                            <tr>

                                <td>
                                    <strong>
                                        {{ $item->nama_perangkat ?? '-' }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $item->kepala_perangkat ?? '-' }}
                                </td>

                                <td>
                                    {{ $item->bendahara_penerimaan ?? '-' }}
                                </td>

                                <td>
                                    {{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}
                                </td>

                                <td>

                                    @if($item->status_verifikasi)
                                        <span class="badge bg-success">Terverifikasi</span>
                                    @else
                                        <span class="badge bg-warning">Belum Diverifikasi</span>
                                    @endif

                                </td>

                                <td>

                                    <a href="{{ route('admin.verifikasi.detail', $item->id) }}"
                                        class="btn btn-outline-secondary btn-sm">
                                        Lihat Detail
                                    </a>

                                    @if($item->status_verifikasi != 'Terverifikasi')

                                        <form action="{{ route('admin.verifikasi.proses', $item->id) }}" method="POST"
                                            class="d-inline">

                                            @csrf

                                            <button type="submit" class="btn btn-primary btn-sm">
                                                Verifikasi (ACC)
                                            </button>

                                        </form>

                                    @else

                                        <button class="btn btn-success btn-sm" disabled>
                                            Verified
                                        </button>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center">
                                    Tidak ada data
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>
        </div>

    </div>

@endsection