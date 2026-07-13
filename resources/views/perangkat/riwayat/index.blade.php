@extends('layouts.app')

@section('title', 'Laporan Retribusi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/perangkat.css') }}">
@endpush

@section('content')

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-1 judul-halaman">Riwayat Laporan</h4>
                <p class="text-muted small mb-0">Daftar laporan retribusi yang telah diinput.</p>
            </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tabel --}}
    <div class="card riwayat-card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table riwayat-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Periode</th>
                            <th>Objek Retribusi</th>
                            <th>Realisasi</th>
                            <th>Status</th>
                            <th>Tanggal Submit</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporan as $item)
                            <tr>
                                <td class="ps-4 text-muted small">
                                    {{ $laporan->firstItem() + $loop->index }}
                                </td>
                                <td>
                                    <span class="fw-semibold periode-text">
                                        {{ DateTime::createFromFormat('!m', $item->bulan)->format('F') }}
                                        {{ $item->tahun }}
                                    </span>
                                </td>
                                <td>
                                    @if($item->details->isNotEmpty())
                                        @php
                                            $d = $item->details->first();
                                            $namaObjek = optional(optional(optional($d->detailRetribusi)->rincian)->objek)->nama_objek
                                                ?? optional(optional($d->rincian)->objek)->nama_objek
                                                ?? optional($d->rincian)->nama_rincian
                                                ?? '—';
                                        @endphp
                                        <span class="small">
                                            {{ $namaObjek }}
                                        </span>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->details->isNotEmpty())
                                        <span class="fw-semibold realisasi-text">
                                            Rp {{ number_format($item->details->sum('realisasi_bulan_ini'), 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusClass = match($item->status) {
                                            'submit'        => 'status-menunggu',
                                            'terverifikasi' => 'status-terverifikasi',
                                            'ditolak'       => 'status-ditolak',
                                            default         => 'status-default',
                                        };
                                        $label = match($item->status) {
                                            'submit'        => 'Menunggu Verifikasi',
                                            'terverifikasi' => 'Terverifikasi',
                                            'ditolak'       => 'Ditolak',
                                            default         => ucfirst($item->status),
                                        };
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td class="text-muted small">
                                    {{ $item->tanggal_submit
                                        ? \Carbon\Carbon::parse($item->tanggal_submit)->format('d M Y')
                                        : '—' }}
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('perangkat.laporan.selesai', $item->id) }}"
                                       class="btn-aksi-eye" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    Belum ada laporan.
                                    <a href="{{ route('perangkat.laporan.create') }}">Input sekarang</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($laporan->hasPages())
            <div class="card-footer bg-white border-top-0 pb-3 px-4">
                {{ $laporan->links() }}
            </div>
        @endif
    </div>

</div>

@endsection