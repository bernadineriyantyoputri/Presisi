@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1>Verifikasi Pendaftaran Akun</h1>
            <p>Review dan kelola permohonan pendaftaran akun baru dari Perangkat Daerah.</p>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-card-top">
                <h5>MENUNGGU ACC</h5>
                <div class="stat-icon icon-yellow"><i class="bi bi-clock"></i></div>
            </div>
            <h2>
                {{ $perangkat->where('status_verifikasi', 'Pending')->count() }}
                <span>Akun</span>
            </h2>
            <small class="text-danger-soft">Membutuhkan tindakan segera</small>
        </div>

        <div class="stat-card">
            <div class="stat-card-top">
                <h5>AKUN TERVERIFIKASI</h5>
                <div class="stat-icon icon-green"><i class="bi bi-shield-check"></i></div>
            </div>
            <h2>
                {{ $perangkat->where('status_verifikasi', 'Terverifikasi')->count() }}
                <span>Akun</span>
            </h2>
            <small class="text-muted-soft">Total akun aktif dalam sistem</small>
        </div>

        <div class="stat-card">
            <div class="stat-card-top">
                <h5>PENDAFTARAN HARI INI</h5>
                <div class="stat-icon icon-blue"><i class="bi bi-person-check"></i></div>
            </div>
            <h2>
                {{ $perangkat->where('created_at', '>=', now()->startOfDay())->count() }}
                <span>Permohonan</span>
            </h2>
            <small class="text-muted-soft">Update terbaru</small>
        </div>

    </div>

    {{-- Tabel --}}
    <div class="table-card">
        <div class="table-card-header">
            <h3>Daftar Permohonan Pendaftaran</h3>

            <div class="table-card-actions">
                <button type="button" class="btn-outline">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                <button type="button" class="btn-outline">
                    <i class="bi bi-download"></i> Ekspor
                </button>
            </div>
        </div>

        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>Nama Perangkat Daerah</th>
                        <th>Tanggal Daftar</th>
                        <th>Status</th>
                        <th width="220">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($perangkat as $item)

                        <tr>
                            <td><strong>{{ $item->nama_perangkat ?? '-' }}</strong></td>

                            <td>{{ $item->created_at ? $item->created_at->format('d M Y, H:i') : '-' }}</td>

                            <td>
                                @if($item->status_verifikasi == 'Terverifikasi')
                                    <span class="badge-status badge-verified"><i class="bi bi-circle-fill"></i> Terverifikasi</span>
                                @elseif($item->status_verifikasi == 'Ditolak')
                                    <span class="badge-status badge-rejected"><i class="bi bi-circle-fill"></i> Ditolak</span>
                                @else
                                    <span class="badge-status badge-pending"><i class="bi bi-circle-fill"></i> Menunggu
                                        Verifikasi</span>
                                @endif
                            </td>

                            <td class="aksi-cell">
                                <a href="{{ route('admin.verifikasi.detail', $item->id) }}" class="btn-detail">Detail</a>

                                @if($item->status_verifikasi == 'Terverifikasi')
                                    @if($item->is_active)
                                        <form action="{{ route('admin.verifikasi.nonaktifkan', $item->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Nonaktifkan akun ini? Perangkat Daerah tidak akan bisa login.')">
                                            @csrf
                                            <button type="submit" class="btn-reject">Nonaktifkan</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.verifikasi.aktifkan', $item->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Aktifkan kembali akun ini?')">
                                            @csrf
                                            <button type="submit" class="btn-approve">Aktifkan</button>
                                        </form>
                                    @endif
                                @elseif($item->status_verifikasi == 'Ditolak')
                                    {{-- tidak ada aksi tambahan --}}
                                @else
                                    <form action="{{ route('admin.verifikasi.proses', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn-approve">Verifikasi</button>
                                    </form>

                                    <form action="{{ route('admin.verifikasi.tolak', $item->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Tolak permohonan ini?')">
                                        @csrf
                                        <button type="submit" class="btn-reject">Tolak</button>
                                    </form>
                                @endif
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" style="text-align:center;">Tidak ada data</td>
                        </tr>

                    @endforelse

                </tbody>
            </table>
        </div>

        <div class="table-footer">
            @if(method_exists($perangkat, 'total'))
                <span>Menampilkan {{ $perangkat->count() }} dari {{ $perangkat->total() }} permohonan</span>
            @else
                <span>Menampilkan {{ $perangkat->count() }} permohonan</span>
            @endif

            @if(method_exists($perangkat, 'links'))
                <div class="pagination-wrap">
                    {{ $perangkat->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Footer Info --}}
    <div class="audit-banner">
        <div class="audit-left">
            <div class="audit-icon"><i class="bi bi-patch-check-fill"></i></div>
            <div>
                <h4>Integritas Data Terjamin</h4>
                <p>Seluruh pendaftaran diproses melalui enkripsi 256-bit dan validasi NIP Kepala Daerah.</p>
            </div>
        </div>
        <button type="button" class="btn-audit">Lihat Laporan Audit</button>
    </div>

@endsection