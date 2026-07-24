
@extends('layouts.app')

@section('title', 'Detail Laporan Realisasi')

@section('content')

<div class="lapd-page">
<div class="lapd-container">

    {{-- ===================================================
         TOP BAR
    =================================================== --}}
    <div class="lapd-topbar">
        <div>
            <a href="{{ route('admin.laporan.index') }}" class="lapd-back">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Laporan
            </a>
            <h1 class="lapd-title">Detail Laporan Realisasi Retribusi</h1>
            <p class="lapd-subtitle">
                Verifikasi kesesuaian data realisasi retribusi yang dilaporkan oleh Perangkat Daerah.
            </p>
        </div>

        <div class="lapd-actions">

            @if(!empty($laporan->file_pdf ?? $laporan->pdf ?? null))
                <a href="{{ asset('storage/'.($laporan->file_pdf ?? $laporan->pdf)) }}" target="_blank" class="lapd-btn lapd-btn-outline">
                    <i class="bi bi-file-earmark-pdf"></i> Lihat PDF
                </a>
            @endif

        </div>
    </div>

    {{-- ===================================================
         LETTERHEAD
    =================================================== --}}
    <div class="lapd-letterhead">
        <div class="lapd-letterhead-rule"></div>
        <div class="lapd-letterhead-body">

            <div class="lapd-identity">
                <div class="lapd-emblem">
                    <i class="bi bi-bank2"></i>
                </div>
                <div>
                    <p class="lapd-instansi-name">
                        {{ $laporan->perangkatDaerah->nama_perangkat ?? '-' }}
                    </p>
                    <p class="lapd-instansi-label">Perangkat Daerah Pelapor</p>
                </div>
            </div>

            <div class="lapd-stamp-wrap">
                @php $status = $laporan->status ?? 'submit'; @endphp

                @if($status === 'disetujui')
                    <span class="lapd-stamp lapd-stamp-success">DISETUJUI</span>
                @elseif($status === 'ditolak')
                    <span class="lapd-stamp lapd-stamp-danger">DITOLAK</span>
                @endif
            </div>

        </div>
    </div>

    {{-- ===================================================
         INFO LAPORAN
    =================================================== --}}
    <div class="lapd-card" style="margin-bottom:24px;">
        <div class="lapd-card-header">
            <i class="bi bi-info-circle"></i> Informasi Laporan
        </div>
        <div class="lapd-card-body">
            <div class="lapd-grid">

                <div>
                    <div class="lapd-field">
                        <label>Periode Laporan</label>
                        <div class="lapd-value">
                            {{ \Carbon\Carbon::create()->month($laporan->bulan)->translatedFormat('F') }}
                            {{ $laporan->tahun }}
                        </div>
                    </div>

                    <div class="lapd-field">
                        <label>Email Instansi</label>
                        <div class="lapd-value">
                            {{ $laporan->perangkatDaerah->email ?? '-' }}
                        </div>
                    </div>

                    <div class="lapd-field">
                        <label>Bendahara Penerimaan</label>
                        <div class="lapd-value">
                            {{ $laporan->perangkatDaerah->bendahara_penerimaan ?? '-' }}
                        </div>
                    </div>
                </div>

                <div class="lapd-divider"></div>

                <div>
                    <div class="lapd-field">
                        <label>Tanggal Submit</label>
                        <div class="lapd-value">
                            {{ optional($laporan->tanggal_submit)->translatedFormat('d F Y') ?? '-' }}
                        </div>
                    </div>

                    <div class="lapd-field">
                        <label>Kepala Perangkat Daerah</label>
                        <div class="lapd-value">
                            {{ $laporan->perangkatDaerah->kepala_perangkat ?? '-' }}
                        </div>
                    </div>

                    <div class="lapd-field">
                        <label>Nomor HP</label>
                        <div class="lapd-value lapd-value-mono">
                            {{ $laporan->perangkatDaerah->no_hp ?? '-' }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ===================================================
         RINCIAN REALISASI RETRIBUSI
    =================================================== --}}
    <div class="lapd-card">
        <div class="lapd-card-header">
            <i class="bi bi-list-columns-reverse"></i> Rincian Realisasi Retribusi
        </div>

        <div class="lapd-table-wrap">
            <table class="lapd-table">
                <thead>
                    <tr>
                        <th>Rincian Objek Retribusi</th>
                        <th>Realisasi Bulan Lalu</th>
                        <th>Realisasi Bulan Ini</th>
                        <th>Total Realisasi</th>
                        <th>Target</th>
                        <th>% Capaian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($laporan->details ?? $laporan->laporanDetail ?? []) as $item)
                        <tr>
                            <td>
                                <div class="lapd-cell-strong">
                                    {{ $item->rincian->nama_rincian ?? '-' }}
                                </div>
                                @if(!empty($item->detailRetribusi->nama_detail ?? null))
                                    <div class="lapd-cell-muted">{{ $item->detailRetribusi->nama_detail }}</div>
                                @endif
                            </td>
                            <td>Rp {{ number_format($item->realisasi_bulan_lalu ?? 0, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->realisasi_bulan_ini ?? 0, 0, ',', '.') }}</td>
                            <td class="lapd-cell-strong">Rp {{ number_format($item->total_realisasi ?? 0, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->target_snapshot ?? 0, 0, ',', '.') }}</td>
                            <td>
                                @php $persen = $item->persentase ?? 0; @endphp
                                <span class="lapd-badge-persen {{ $persen >= 100 ? 'lapd-persen-success' : ($persen >= 50 ? 'lapd-persen-warning' : 'lapd-persen-danger') }}">
                                    {{ number_format($persen, 1) }}%
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="lapd-empty">Belum ada rincian realisasi pada laporan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="lapd-card-footer">
            <i class="bi bi-shield-check"></i>
            Data ini bersifat resmi dan akan tercatat dalam sistem setelah diverifikasi oleh Bapenda.
        </div>
    </div>

</div>
</div>

@endsection