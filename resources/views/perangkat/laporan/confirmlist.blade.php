@extends('layouts.app')

@section('title', 'Input Laporan Retribusi - Daftar Uraian')

@section('content')

    <div class="laporan-wizard-page">

        <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-1">Input Laporan Retribusi</h4>
                <p class="text-muted small mb-0">Periode: {{ $bulanNama }} {{ $tahun }}</p>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-warning alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="alert alert-success d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2"></i>
            Uraian berhasil ditambahkan. Saat ini ada {{ $items->count() }} uraian dalam laporan ini.
        </div>

        <div class="ringkasan-card mb-4">
            <h6 class="section-title mb-3">
                <i class="bi bi-list-check me-2"></i>
                Daftar Uraian
            </h6>

            {{--
                Header & baris data memakai grid 3 kolom yang sama persis:
                1) Objek Retribusi   -> mengisi sisa ruang
                2) Nominal Realisasi -> lebar tetap, rata kanan (sejajar dgn header)
                3) Slot tombol aksi  -> lebar tetap, kosong di header, berisi tombol hapus di baris data
            --}}
            <div class="laporan-table-box">
                <div class="laporan-table-header laporan-table-grid">
                    <div>Objek Retribusi</div>
                    <div class="text-end">Nominal Realisasi (Rp)</div>
                    <div></div>
                </div>

                @foreach($items as $item)
                    <div class="laporan-table-row laporan-table-grid">
                        <div>
                            @if($item['detail'])
                                <div class="laporan-table-title">{{ $item['detail']->nama_detail }}</div>
                                <div class="laporan-table-sub">{{ $item['rincian']->nama_rincian ?? '-' }}</div>
                            @else
                                <div class="laporan-table-title">{{ $item['rincian']->nama_rincian ?? '-' }}</div>
                            @endif
                        </div>
                        <div class="laporan-table-nominal text-end">
                            {{ number_format($item['nominal'], 0, ',', '.') }}
                        </div>
                        <div class="text-end">
                            <form method="POST" action="{{ route('perangkat.laporan.create.uraian.hapus', $item['index']) }}"
                                onsubmit="return confirm('Hapus uraian ini dari laporan?')" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

                <div class="laporan-table-total laporan-table-grid">
                    <div>Total Realisasi</div>
                    <div class="text-end">Rp {{ number_format($total, 0, ',', '.') }}</div>
                    <div></div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('perangkat.laporan.create.tambah-uraian') }}" class="btn btn-batal">
                <i class="bi bi-plus me-1"></i> Tambah Uraian Lagi
            </a>
            <a href="{{ route('perangkat.laporan.create.ringkasan.show') }}" class="btn btn-lanjut">
                Lanjut ke Ringkasan <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

    </div>

@push('styles')
<style>
    /* Grid 3 kolom: Objek (fleksibel) | Nominal (lebar tetap, rata kanan) | Aksi (lebar tetap) */
    .laporan-table-grid {
        display: grid;
        grid-template-columns: 1fr 180px 60px;
        align-items: center;
        column-gap: 1rem;
    }
</style>
@endpush
@endsection