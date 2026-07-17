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

    @php
        // Ambil semua target untuk tahun laporan sekaligus (hindari query berulang per baris)
        $detailIds = $laporan->details->pluck('detail_retribusi_id')->filter()->unique()->values();
        $rincianIds = $laporan->details->pluck('rincian_id')->filter()->unique()->values();

        $targetByDetail = \App\Models\TargetRetribusi::whereIn('detail_id', $detailIds)
            ->where('tahun', $laporan->tahun)
            ->get()
            ->keyBy('detail_id');

        $targetByRincian = \App\Models\TargetRetribusi::whereIn('rincian_id', $rincianIds)
            ->whereNull('detail_id')
            ->where('tahun', $laporan->tahun)
            ->get()
            ->keyBy('rincian_id');
    @endphp

    <table class="tabel-realisasi">
        <thead>
            <tr>
                <th class="no" rowspan="2">No.</th>
                <th rowspan="2">Uraian</th>
                <th rowspan="2" style="width:100px;">Target Tahun Ini<br>(Rp)</th>
                <th colspan="4">Realisasi</th>
            </tr>
            <tr>
                <th style="width:90px;">S.D. Bulan<br>Lalu (Rp)</th>
                <th style="width:90px;">Bulan Ini<br>(Rp)</th>
                <th style="width:100px;">Total S.D.<br>Bulan Ini (Rp)</th>
                <th style="width:90px;">Capaian Thd<br>Target (%)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grandTotal = 0;
                $grandTarget = 0;
                $no = 1;
            @endphp
            @foreach($laporan->details as $d)
                @php
                        $grandTotal += $d->total_realisasi;

                        $namaObjekUtama = $d->detailRetribusi?->nama_detail
                            ?? $d->rincian?->nama_rincian
                            ?? '-';
                        $namaRincianSub = $d->detailRetribusi ? $d->detailRetribusi?->rincian?->nama_rincian : null;

                        // Ambil target: prioritas dari detail_retribusi_id, fallback ke rincian_id
                        $targetRow = $d->detail_retribusi_id
                            ? ($targetByDetail[$d->detail_retribusi_id] ?? null)
                            : ($targetByRincian[$d->rincian_id] ?? null);

                        // Bulan 1-6 (Jan-Jun) pakai target Murni (2026)
                        // Bulan 7-12 (Jul-Des) pakai target Perubahan (2026P)
                        $targetNominal = $laporan->bulan >= 7
                            ? ($targetRow->target_perubahan ?? 0)
                            : ($targetRow->target_nominal ?? 0);
                        $grandTarget += $targetNominal;

                        // Capaian realisasi s.d. bulan ini terhadap target tahunan
                        $capaian = $targetNominal > 0
                            ? round(($d->total_realisasi / $targetNominal) * 100, 2)
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
                    <td class="angka">{{ number_format($targetNominal, 0, ',', '.') }}</td>
                    <td class="angka">{{ number_format($d->realisasi_bulan_lalu, 0, ',', '.') }}</td>
                    <td class="angka">{{ number_format($d->realisasi_bulan_ini, 0, ',', '.') }}</td>
                    <td class="angka">{{ number_format($d->total_realisasi, 0, ',', '.') }}</td>
                    <td class="persen">{{ $capaian !== null ? number_format($capaian, 2, ',', '.') . ' %' : '-' }}
                    </td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="2" class="uraian">TOTAL REALISASI</td>
                <td class="angka">{{ number_format($grandTarget, 0, ',', '.') }}</td>
                <td colspan="2" class="angka">&nbsp;</td>
                <td class="angka">{{ number_format($grandTotal, 0, ',', '.') }}</td>
                <td class="persen">
                    @php
                        $capaianTotal = $grandTarget > 0 ? round(($grandTotal / $grandTarget) * 100, 2) : null;
                    @endphp
                    {{ $capaianTotal !== null ? number_format($capaianTotal, 2, ',', '.') . ' %' : '-' }}
                </td>
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