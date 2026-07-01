<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Retribusi - {{ $laporan->id }}</title>
    <style>
        {!! file_get_contents(public_path('css/perangkat.css')) !!}
    </style>
</head>

<body class="laporan-pdf">

    <div class="header">
        <h2>LAPORAN REALISASI RETRIBUSI DAERAH</h2>
        <p>Badan Pendapatan Daerah Provinsi Lampung</p>
    </div>

    <table class="info">
        <tr>
            <td class="label">Bulan Masa Retribusi</td>
            <td>: {{ $bulanNama ?? '' }} {{ $laporan->tahun }}</td>
            <td class="label">Jenis Retribusi</td>
            <td>: {{ $laporan->details->first()?->detailRetribusi?->rincian?->objek?->jenis?->nama_jenis
    ?? $laporan->details->first()?->rincian?->objek?->jenis?->nama_jenis
    ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Perangkat Daerah</td>
            <td colspan="3">: {{ $laporan->perangkatDaerah->nama_perangkat ?? '-' }}</td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th>Objek Retribusi</th>
                <th class="text-end">Realisasi Bln Lalu</th>
                <th class="text-end">Realisasi Bln Ini</th>
                <th class="text-end">Total Realisasi</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($laporan->details as $d)
                @php $grandTotal += $d->total_realisasi; @endphp
                <tr>
                    @php
                        $namaObjekUtama = $d->detailRetribusi?->nama_detail
                            ?? $d->rincian?->nama_rincian
                            ?? '-';
                        $namaRincianSub = $d->detailRetribusi ? $d->detailRetribusi?->rincian?->nama_rincian : null;
                    @endphp
                    <td>
                        <strong>{{ $namaObjekUtama }}</strong>
                        @if($namaRincianSub)
                            <br><span style="color:#777;">{{ $namaRincianSub }}</span>
                        @endif
                    </td>
                    <td class="text-end">Rp {{ number_format($d->realisasi_bulan_lalu, 0, ',', '.') }}</td>
                    <td class="text-end">Rp {{ number_format($d->realisasi_bulan_ini, 0, ',', '.') }}</td>
                    <td class="text-end">Rp {{ number_format($d->total_realisasi, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="3">TOTAL REALISASI</td>
                <td class="text-end">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <table class="footer-sign">
        <tr>
            <td>
                Dibuat oleh,<br>
                <div class="sign-space"></div>
                {{ auth()->user()->name ?? '-' }}
            </td>
            <td>
                Lampung, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                Mengetahui,<br>
                <div class="sign-space"></div>
                ( ..................................... )
            </td>
        </tr>
    </table>

</body>

</html>