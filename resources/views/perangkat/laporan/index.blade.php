@extends('layouts.app')

@section('title', 'Laporan Retribusi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/perangkat.css') }}">
@endpush

@section('content')

<div class="container-fluid py-4 px-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Laporan Retribusi</h4>
            <p class="text-muted small mb-0">Daftar laporan retribusi yang telah diinput.</p>
        </div>
        <a href="{{ route('perangkat.laporan.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Input Laporan
        </a>
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
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
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
                                    <span class="fw-semibold">
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
                                        Rp {{ number_format($item->details->sum('realisasi_bulan_ini'), 0, ',', '.') }}
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $badge = match($item->status) {
                                            'submit'        => 'primary',
                                            'terverifikasi' => 'success',
                                            'ditolak'       => 'danger',
                                            default         => 'secondary',
                                        };
                                        $label = match($item->status) {
                                            'submit'        => 'Menunggu Verifikasi',
                                            'terverifikasi' => 'Terverifikasi',
                                            'ditolak'       => 'Ditolak',
                                            default         => ucfirst($item->status),
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badge }}-subtle text-{{ $badge }} border border-{{ $badge }}-subtle">
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
                                       class="btn btn-sm btn-outline-secondary me-1" title="Detail">
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