@extends('layouts.app')

@section('title', 'Manajemen Target Retribusi')

@section('content')

    <div class="container-fluid py-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Manajemen Target Retribusi</h3>
                <p class="text-muted mb-0">
                    Kelola target penerimaan retribusi daerah (Murni & Perubahan) setiap semester.
                </p>
            </div>
        </div>

        {{-- Alert sukses / error --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal menyimpan target:</strong>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Statistik --}}
        <div class="row mb-4">

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <small class="text-muted text-uppercase">
                            Total Target {{ $tahun }}{{ $jenisAnggaran === 'perubahan' ? 'P (Perubahan)' : ' (Murni)' }}
                        </small>

                        @php
                            $kolomTarget = $jenisAnggaran === 'perubahan' ? 'target_perubahan' : 'target_nominal';
                            $totalTarget = $targets->sum($kolomTarget);
                        @endphp

                        <h3 class="fw-bold text-primary mt-2 mb-0">
                            Rp {{ number_format($totalTarget, 0, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <small class="text-muted text-uppercase">Jumlah Item Rincian</small>

                        <h3 class="fw-bold text-success mt-2 mb-0">
                            {{ $targets->count() }} Item
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Tabel --}}
        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">

                <form method="GET">

                    <div class="row align-items-end g-3">

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Jenis Retribusi
                            </label>

                            <select name="jenis_id" class="form-select" onchange="this.form.submit()">

                                <option value="">
                                    Semua Jenis Retribusi
                                </option>

                                @foreach($jenisRetribusi as $jenis)

                                    <option value="{{ $jenis->id }}" {{ $jenisId == $jenis->id ? 'selected' : '' }}>

                                        {{ $jenis->nama_jenis }}

                                    </option>

                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Tahun Anggaran
                            </label>

                            {{-- Dropdown gabungan Tahun + Jenis: 2026 (Murni) & 2026P (Perubahan) --}}
                            <select name="tahun_anggaran" class="form-select" onchange="this.form.submit()">

                                @php
                                    $tahunSekarang = (int) date('Y');
                                    $tahunMulai = $tahunSekarang + 1;
                                    $tahunSelesai = $tahunSekarang - 5;
                                @endphp

                                @for($tahunOpt = $tahunMulai; $tahunOpt >= $tahunSelesai; $tahunOpt--)

                                    @php
                                        $valueMurni = $tahunOpt . '|murni';
                                        $valuePerubahan = $tahunOpt . '|perubahan';
                                        $selectedMurni = ($tahun == $tahunOpt && $jenisAnggaran === 'murni');
                                        $selectedPerubahan = ($tahun == $tahunOpt && $jenisAnggaran === 'perubahan');
                                    @endphp

                                    <option value="{{ $valueMurni }}" {{ $selectedMurni ? 'selected' : '' }}>
                                        {{ $tahunOpt }}
                                    </option>

                                    <option value="{{ $valuePerubahan }}" {{ $selectedPerubahan ? 'selected' : '' }}>
                                        {{ $tahunOpt }}P (Perubahan)
                                    </option>

                                @endfor

                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Cari
                            </label>

                            <input type="text" name="search" class="form-control" placeholder="Cari rincian objek..."
                                value="{{ request('search') }}">
                        </div>

                    </div>

                </form>

            </div>
            <div class="card-body p-0">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th width="60">No</th>

                            <th>Rincian Objek Retribusi</th>

                            <th width="260">
                                Target {{ $tahun }}{{ $jenisAnggaran === 'perubahan' ? 'P' : '' }}
                            </th>

                            <th width="100" class="text-center">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @php $no = 0; @endphp

                        @forelse($rincians as $rincian)

                            @if($rincian->detail->count())

                                @foreach($rincian->detail as $detail)

                                    @php
                                        $no++;

                                        // Satu baris per (detail, tahun) menyimpan 2 kolom: target (Murni) & target_perubahan
                                        $targetRow = $detail->target->where('tahun', $tahun)->first();

                                        $nominalSekarang = $jenisAnggaran === 'perubahan'
                                            ? ($targetRow->target_perubahan ?? 0)
                                            : ($targetRow->target_nominal ?? 0);

                                        if ($jenisAnggaran === 'perubahan') {
                                            // Perubahan dibandingkan dengan Murni pada tahun yang sama
                                            $nominalLalu = $targetRow->target_nominal ?? 0;
                                            $labelPembanding = 'Target Murni ' . $tahun;
                                        } else {
                                            // Murni dibandingkan dengan Murni tahun sebelumnya
                                            $targetRowLalu = $detail->target->where('tahun', $tahun - 1)->first();
                                            $nominalLalu = $targetRowLalu->target_nominal ?? 0;
                                            $labelPembanding = 'Target Tahun Lalu (' . ($tahun - 1) . ')';
                                        }

                                        $persenPerubahan = $nominalLalu > 0
                                            ? round((($nominalSekarang - $nominalLalu) / $nominalLalu) * 100, 1)
                                            : null;
                                    @endphp

                                    <tr>

                                        <td>{{ $no }}</td>

                                        <td>
                                            <div class="fw-semibold text-primary">
                                                {{ $rincian->nama_rincian }}
                                            </div>
                                            <div class="text-muted small">
                                                {{ $detail->nama_detail }}
                                            </div>
                                        </td>

                                        <td>
                                            <div class="fw-bold">
                                                Rp {{ number_format($nominalSekarang, 0, ',', '.') }}
                                            </div>
                                        </td>

                                        <td class="text-center">

                                            <button type="button" class="btn btn-link btn-sm text-decoration-none btn-edit-target"
                                                data-bs-toggle="modal" data-bs-target="#editTargetModal"
                                                data-rincian-id="{{ $rincian->id }}" data-detail-id="{{ $detail->id }}"
                                                data-tahun="{{ $tahun }}" data-jenis-anggaran="{{ $jenisAnggaran }}"
                                                data-nama="{{ $rincian->nama_rincian }}" data-detail="{{ $detail->nama_detail }}"
                                                data-label-pembanding="{{ $labelPembanding }}" data-nominal-lalu="{{ $nominalLalu }}"
                                                data-nominal-sekarang="{{ $nominalSekarang }}" data-persen="{{ $persenPerubahan }}">
                                                <i class="bi bi-pencil me-1"></i>Edit
                                            </button>

                                        </td>

                                    </tr>

                                @endforeach

                            @else

                                @php
                                    $no++;

                                    $targetRow = $rincian->target->where('tahun', $tahun)->first();

                                    $nominalSekarang = $jenisAnggaran === 'perubahan'
                                        ? ($targetRow->target_perubahan ?? 0)
                                        : ($targetRow->target_nominal ?? 0);

                                    if ($jenisAnggaran === 'perubahan') {
                                        $nominalLalu = $targetRow->target_nominal ?? 0;
                                        $labelPembanding = 'Target Murni ' . $tahun;
                                    } else {
                                        $targetRowLalu = $rincian->target->where('tahun', $tahun - 1)->first();
                                        $nominalLalu = $targetRowLalu->target_nominal ?? 0;
                                        $labelPembanding = 'Target Tahun Lalu (' . ($tahun - 1) . ')';
                                    }

                                    $persenPerubahan = $nominalLalu > 0
                                        ? round((($nominalSekarang - $nominalLalu) / $nominalLalu) * 100, 1)
                                        : null;
                                @endphp

                                <tr>

                                    <td>{{ $no }}</td>

                                    <td>
                                        <div class="fw-semibold text-primary">
                                            {{ $rincian->nama_rincian }}
                                        </div>
                                    </td>

                                    <td>
                                        <div class="fw-bold">
                                            Rp {{ number_format($nominalSekarang, 0, ',', '.') }}
                                        </div>
                                    </td>

                                    <td class="text-center">

                                        <button type="button" class="btn btn-link btn-sm text-decoration-none btn-edit-target"
                                            data-bs-toggle="modal" data-bs-target="#editTargetModal"
                                            data-rincian-id="{{ $rincian->id }}" data-detail-id="" data-tahun="{{ $tahun }}"
                                            data-jenis-anggaran="{{ $jenisAnggaran }}" data-nama="{{ $rincian->nama_rincian }}"
                                            data-detail="" data-label-pembanding="{{ $labelPembanding }}"
                                            data-nominal-lalu="{{ $nominalLalu }}" data-nominal-sekarang="{{ $nominalSekarang }}"
                                            data-persen="{{ $persenPerubahan }}">
                                            <i class="bi bi-pencil me-1"></i>Edit
                                        </button>

                                    </td>

                                </tr>

                            @endif

                        @empty

                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    Tidak ada data rincian retribusi.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- Modal Edit Target --}}
    <div class="modal fade" id="editTargetModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form action="{{ route('admin.data.target.store') }}" method="POST" id="formEditTarget">

                    @csrf

                    <input type="hidden" name="rincian_id" id="input_rincian_id">
                    <input type="hidden" name="detail_id" id="input_detail_id">
                    <input type="hidden" name="tahun" id="input_tahun">
                    <input type="hidden" name="jenis" id="input_jenis_anggaran">
                    <input type="hidden" name="target_nominal" id="input_target_nominal_raw">

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">
                            <i class="bi bi-pencil-square me-2"></i>Edit Target Anggaran
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <p class="text-muted mb-3">Update parameter target penerimaan retribusi.</p>

                        <div class="bg-light rounded p-3 mb-3">

                            <small class="text-muted text-uppercase">Item Retribusi</small>

                            <div class="fw-bold fs-5" id="modal_nama_rincian">-</div>
                            <div class="text-muted small mb-2" id="modal_nama_detail"></div>

                            <hr class="my-2">

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted" id="modal_label_pembanding">Target Pembanding</small>
                                    <div class="fw-semibold" id="modal_nominal_lalu">Rp 0</div>
                                </div>

                                <span class="badge" id="modal_badge_persen"></span>
                            </div>

                        </div>

                        <label class="form-label fw-semibold" id="modal_label_tahun_baru">
                            Target Baru
                        </label>

                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" inputmode="numeric" class="form-control form-control-lg text-end"
                                id="input_target_nominal_display" placeholder="0" autocomplete="off">
                        </div>

                        <div class="form-text">
                            Masukkan nominal target dalam satuan Rupiah (IDR). Jika jenis "Perubahan" dipilih,
                            nilai akan disimpan di kolom <code>target_perubahan</code> pada baris tahun yang sama
                            (kolom <code>target</code> Murni tidak akan tertimpa).
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const inputRincianId = document.getElementById('input_rincian_id');
                const inputDetailId = document.getElementById('input_detail_id');
                const inputTahun = document.getElementById('input_tahun');
                const inputJenisAnggaran = document.getElementById('input_jenis_anggaran');
                const inputRaw = document.getElementById('input_target_nominal_raw');
                const inputDisplay = document.getElementById('input_target_nominal_display');

                const modalNamaRincian = document.getElementById('modal_nama_rincian');
                const modalNamaDetail = document.getElementById('modal_nama_detail');
                const modalLabelPembanding = document.getElementById('modal_label_pembanding');
                const modalNominalLalu = document.getElementById('modal_nominal_lalu');
                const modalBadgePersen = document.getElementById('modal_badge_persen');
                const modalLabelTahunBaru = document.getElementById('modal_label_tahun_baru');

                function formatRupiah(angka) {
                    angka = parseInt(angka || 0, 10);
                    return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                }

                // Isi data modal saat tombol Edit diklik
                document.querySelectorAll('.btn-edit-target').forEach(function (btn) {

                    btn.addEventListener('click', function () {

                        const rincianId = btn.dataset.rincianId;
                        const detailId = btn.dataset.detailId;
                        const tahun = btn.dataset.tahun;
                        const jenisAnggaran = btn.dataset.jenisAnggaran; // 'murni' atau 'perubahan'
                        const nama = btn.dataset.nama;
                        const detail = btn.dataset.detail;
                        const labelPembanding = btn.dataset.labelPembanding;
                        const nominalLalu = btn.dataset.nominalLalu;
                        const nominalSekarang = btn.dataset.nominalSekarang;
                        const persen = btn.dataset.persen;

                        if (detailId) {
                            // Item level detail: ikuti konvensi data lama, rincian_id dikosongkan
                            inputRincianId.value = '';
                            inputDetailId.value = detailId;
                        } else {
                            // Item level rincian langsung (tanpa detail)
                            inputRincianId.value = rincianId;
                            inputDetailId.value = '';
                        }
                        inputTahun.value = tahun;
                        inputJenisAnggaran.value = jenisAnggaran;
                        inputRaw.value = nominalSekarang;
                        inputDisplay.value = formatRupiah(nominalSekarang);

                        modalNamaRincian.textContent = nama;
                        modalNamaDetail.textContent = detail || '';
                        modalLabelPembanding.textContent = labelPembanding;
                        modalNominalLalu.textContent = 'Rp ' + formatRupiah(nominalLalu);

                        const labelTahun = jenisAnggaran === 'perubahan' ? (tahun + 'P (Perubahan)') : tahun;
                        modalLabelTahunBaru.textContent = 'Target Baru (' + labelTahun + ')';

                        if (persen !== '' && persen !== 'null' && persen !== undefined) {
                            const persenNum = parseFloat(persen);
                            const naik = persenNum >= 0;

                            modalBadgePersen.textContent = (naik ? '+' : '') + persenNum + '%';
                            modalBadgePersen.className = 'badge ' + (naik ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger');
                            modalBadgePersen.style.display = 'inline-block';
                        } else {
                            modalBadgePersen.style.display = 'none';
                        }
                    });
                });

                // Format ribuan otomatis saat mengetik nominal baru
                inputDisplay.addEventListener('input', function () {
                    const digits = inputDisplay.value.replace(/[^0-9]/g, '');
                    inputDisplay.value = formatRupiah(digits);
                    inputRaw.value = digits || '0';
                });

                // Jaga-jaga sebelum submit
                document.getElementById('formEditTarget').addEventListener('submit', function () {
                    inputRaw.value = inputDisplay.value.replace(/[^0-9]/g, '') || '0';
                });

            });
        </script>
    @endpush

@endsection