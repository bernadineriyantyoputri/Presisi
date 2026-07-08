<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Realisasi Retribusi - {{ $laporan->id }}</title>
    <style>
        {!! file_get_contents(public_path('css/perangkat.css')) !!}
    </style>
</head>

<body class="laporan-pdf">

    <div class="judul-laporan">
        <h2>Laporan Realisasi Penerimaan Retribusi Daerah</h2>
        <h3>{{ $laporan->perangkatDaerah->nama_perangkat ?? '-' }}</h3>
    </div>

    <div class="masa-retribusi">
        Masa Retribusi&nbsp;: {{ $bulanNama ?? '' }} {{ $laporan->tahun }}
    </div>

    <table class="tabel-realisasi">
        <thead>
            <tr>
                <th class="no" rowspan="2">No.</th>
                <th rowspan="2">Uraian</th>
                <th colspan="4">Realisasi</th>
            </tr>
            <tr>
                <th style="width:90px;">S.D. Bulan<br>Lalu (Rp)</th>
                <th style="width:90px;">Bulan Ini<br>(Rp)</th>
                <th style="width:100px;">Total S.D.<br>Bulan Ini (Rp)</th>
                <th style="width:90px;">Persentase<br>S.D. Bulan Ini (%)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grandTotal = 0;
                $no = 1;
            @endphp
            @foreach($laporan->details as $d)
                @php
                    $grandTotal += $d->total_realisasi;

                    $namaObjekUtama = $d->detailRetribusi?->nama_detail
                        ?? $d->rincian?->nama_rincian
                        ?? '-';
                    $namaRincianSub = $d->detailRetribusi ? $d->detailRetribusi?->rincian?->nama_rincian : null;

                    // Persentase realisasi s.d. bulan ini terhadap target, jika tersedia
                    $persentase = $d->realisasi_bulan_lalu > 0
                        ? round(($d->realisasi_bulan_ini / $d->realisasi_bulan_lalu) * 100, 2)
                        : null;
                @endphp
                <tr>
                    <td class="no">{{ $no++ }}</td>
                    <td class="uraian">
                        {{ $namaObjekUtama }}
                        @if($namaRincianSub)
                            <br><span style="color:#777;">{{ $namaRincianSub }}</span>
                        @endif
                    </td>
                    <td class="angka">{{ number_format($d->realisasi_bulan_lalu, 0, ',', '.') }}</td>
                    <td class="angka">{{ number_format($d->realisasi_bulan_ini, 0, ',', '.') }}</td>
                    <td class="angka">{{ number_format($d->total_realisasi, 0, ',', '.') }}</td>
                    <td class="persen">{{ $persentase !== null ? number_format($persentase, 2, ',', '.') . ' %' : '-' }}
                    </td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="4" class="uraian">TOTAL REALISASI</td>
                <td class="angka">{{ number_format($grandTotal, 0, ',', '.') }}</td>
                <td class="persen">-</td>
            </tr>
        </tbody>
    </table>

    <table class="blok-ttd">
        <tr>
            <td>
                <div class="kotak-ttd">
                    {{ $lokasiLaporan ?? 'Bandar Lampung' }}, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                    Kepala {{ $laporan->perangkatDaerah->nama_perangkat ?? 'Perangkat Daerah' }}

                    <div class="spasi-ttd"></div>

                    <span
                        class="nama-kepala">{{ $laporan->perangkatDaerah->kepala_perangkat ?? '(.....................................)' }}</span><br>
                    {{ $laporan->perangkatDaerah->pangkat_golongan ?? '-' }}<br>
                    {{ $laporan->perangkatDaerah->nip ?? '-' }}
                </div>
            </td>
        </tr>
    </table>

</body>

</html>