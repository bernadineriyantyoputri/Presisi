@extends('layouts.app')

@section('title', 'Manajemen Target Retribusi')

@section('content')

    <div class="tgt-page">

        {{-- Header --}}
        <div class="tgt-header page-header">
            <h1>Manajemen Target Retribusi</h1>
            <p>Kelola target penerimaan retribusi daerah (Murni & Perubahan) setiap tahun.</p>
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
        @php
            $totalMurni = $targets->sum('target_nominal');
            $totalPerubahan = $targets->sum('target_perubahan');
        @endphp

        <div class="tgt-summary-grid">

            <div class="tgt-summary-card">
                <div class="tgt-summary-icon tgt-icon-navy">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                    <div class="tgt-summary-label">Total Target Murni {{ $tahun }}</div>
                    <div class="tgt-summary-value">Rp {{ number_format($totalMurni, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="tgt-summary-card">
                <div class="tgt-summary-icon tgt-icon-gold">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <div>
                    <div class="tgt-summary-label">Total Target Perubahan {{ $tahun }}</div>
                    <div class="tgt-summary-value">Rp {{ number_format($totalPerubahan, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="tgt-summary-card">
                <div class="tgt-summary-icon tgt-icon-green">
                    <i class="bi bi-list-check"></i>
                </div>
                <div>
                    <div class="tgt-summary-label">Jumlah Item Rincian</div>
                    <div class="tgt-summary-value">{{ $targets->count() }} Item</div>
                </div>
            </div>

        </div>

        {{-- Filter --}}
        <div class="tgt-filter-card">
            <form method="GET">
                <div class="row align-items-end g-3">

                    <div class="col-md-4">
                        <label class="tgt-filter-label">Jenis Retribusi</label>
                        <select name="jenis_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Jenis Retribusi</option>
                            @foreach($jenisRetribusi as $jenis)
                                <option value="{{ $jenis->id }}" {{ $jenisId == $jenis->id ? 'selected' : '' }}>
                                    {{ $jenis->nama_jenis }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="tgt-filter-label">Tahun Anggaran</label>
                        <select name="tahun" class="form-select" onchange="this.form.submit()">
                            @php
                                $tahunSekarang = (int) date('Y');
                                $tahunMulai = $tahunSekarang + 1;
                                $tahunSelesai = $tahunSekarang - 5;
                            @endphp

                            @for($tahunOpt = $tahunMulai; $tahunOpt >= $tahunSelesai; $tahunOpt--)
                                <option value="{{ $tahunOpt }}" {{ $tahun == $tahunOpt ? 'selected' : '' }}>
                                    {{ $tahunOpt }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="tgt-filter-label">Cari</label>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari rincian objek..."
                                value="{{ request('search') }}">

                            <button type="submit" class="btn tgt-btn-search" title="Cari">
                                <i class="bi bi-search"></i>
                            </button>

                            <a href="{{ route('admin.target.index') }}" class="btn tgt-btn-reset" title="Reset filter">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </form>
        </div>

        {{-- Tabel --}}
        <div class="tgt-table-card">

            <div class="tgt-table-wrap">
                <table class="table tgt-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Rincian Objek Retribusi</th>
                            <th width="200">Target Murni {{ $tahun }}</th>
                            <th width="200">Target Perubahan {{ $tahun }}</th>
                            <th width="120" class="text-center">Status Aktif</th>
                            <th width="90" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $no = 0; @endphp

                        @forelse($rincians as $rincian)

                            @if($rincian->detail->count())

                                @foreach($rincian->detail as $detail)

                                    @php
                                        $no++;
                                        $targetRow = $detail->target->where('tahun', $tahun)->first();
                                        $nominalMurni = $targetRow->target_nominal ?? 0;
                                        $nominalPerubahan = $targetRow->target_perubahan ?? 0;
                                        $targetAktifRow = $targetRow->target_aktif ?? 'murni';
                                    @endphp

                                    <tr>
                                        <td>{{ $no }}</td>

                                        <td>
                                            <div class="tgt-cell-strong">{{ $rincian->nama_rincian }}</div>
                                            <div class="tgt-cell-muted">{{ $detail->nama_detail }}</div>
                                        </td>

                                        <td>
                                            <div class="tgt-cell-nominal {{ $targetAktifRow === 'murni' ? '' : 'is-inactive' }}">
                                                Rp {{ number_format($nominalMurni, 0, ',', '.') }}
                                            </div>
                                        </td>

                                        <td>
                                            <div class="tgt-cell-nominal {{ $targetAktifRow === 'perubahan' ? '' : 'is-inactive' }}">
                                                Rp {{ number_format($nominalPerubahan, 0, ',', '.') }}
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <span class="tgt-badge {{ $targetAktifRow === 'perubahan' ? 'tgt-badge-perubahan' : 'tgt-badge-murni' }}">
                                                <span class="tgt-dot"></span>
                                                {{ $targetAktifRow === 'perubahan' ? 'Perubahan' : 'Murni' }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <button type="button" class="tgt-btn-edit btn-edit-target"
                                                data-bs-toggle="modal" data-bs-target="#editTargetModal"
                                                data-rincian-id="{{ $rincian->id }}" data-detail-id="{{ $detail->id }}"
                                                data-tahun="{{ $tahun }}" data-nama="{{ $rincian->nama_rincian }}"
                                                data-detail="{{ $detail->nama_detail }}" data-nominal-murni="{{ $nominalMurni }}"
                                                data-nominal-perubahan="{{ $nominalPerubahan }}"
                                                data-target-aktif="{{ $targetAktifRow }}">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                        </td>
                                    </tr>

                                @endforeach

                            @else

                                @php
                                    $no++;
                                    $targetRow = $rincian->target->where('tahun', $tahun)->first();
                                    $nominalMurni = $targetRow->target_nominal ?? 0;
                                    $nominalPerubahan = $targetRow->target_perubahan ?? 0;
                                    $targetAktifRow = $targetRow->target_aktif ?? 'murni';
                                @endphp

                                <tr>
                                    <td>{{ $no }}</td>

                                    <td>
                                        <div class="tgt-cell-strong">{{ $rincian->nama_rincian }}</div>
                                    </td>

                                    <td>
                                        <div class="tgt-cell-nominal {{ $targetAktifRow === 'murni' ? '' : 'is-inactive' }}">
                                            Rp {{ number_format($nominalMurni, 0, ',', '.') }}
                                        </div>
                                    </td>

                                    <td>
                                        <div class="tgt-cell-nominal {{ $targetAktifRow === 'perubahan' ? '' : 'is-inactive' }}">
                                            Rp {{ number_format($nominalPerubahan, 0, ',', '.') }}
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <span class="tgt-badge {{ $targetAktifRow === 'perubahan' ? 'tgt-badge-perubahan' : 'tgt-badge-murni' }}">
                                            <span class="tgt-dot"></span>
                                            {{ $targetAktifRow === 'perubahan' ? 'Perubahan' : 'Murni' }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <button type="button" class="tgt-btn-edit btn-edit-target"
                                            data-bs-toggle="modal" data-bs-target="#editTargetModal"
                                            data-rincian-id="{{ $rincian->id }}" data-detail-id="" data-tahun="{{ $tahun }}"
                                            data-nama="{{ $rincian->nama_rincian }}" data-detail=""
                                            data-nominal-murni="{{ $nominalMurni }}"
                                            data-nominal-perubahan="{{ $nominalPerubahan }}"
                                            data-target-aktif="{{ $targetAktifRow }}">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                    </td>
                                </tr>

                            @endif

                        @empty

                            <tr>
                                <td colspan="6" class="tgt-empty">
                                    <i class="bi bi-inbox"></i>
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
    <div class="modal fade tgt-page" id="editTargetModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form action="{{ route('admin.target.store') }}" method="POST" id="formEditTarget">

                    @csrf

                    <input type="hidden" name="rincian_id" id="input_rincian_id">
                    <input type="hidden" name="detail_id" id="input_detail_id">
                    <input type="hidden" name="tahun" id="input_tahun">
                    <input type="hidden" name="target_nominal" id="input_target_murni_raw">
                    <input type="hidden" name="target_perubahan" id="input_target_perubahan_raw">
                    <input type="hidden" name="target_aktif" id="input_target_aktif">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-pencil-square me-2"></i>Edit Target Anggaran
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <p class="text-muted mb-3">Update target penerimaan retribusi untuk tahun berjalan.</p>

                        <div class="tgt-item-box">
                            <small>Item Retribusi</small>
                            <div class="tgt-item-nama" id="modal_nama_rincian">-</div>
                            <div class="tgt-item-detail" id="modal_nama_detail"></div>
                        </div>

                        <div class="row g-3 mb-3">

                            <div class="col-6">
                                <label class="form-label fw-semibold">Target Murni</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" inputmode="numeric" class="form-control text-end"
                                        id="input_target_murni_display" placeholder="0" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-label fw-semibold">Target Perubahan</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" inputmode="numeric" class="form-control text-end"
                                        id="input_target_perubahan_display" placeholder="0" autocomplete="off">
                                </div>
                            </div>

                        </div>

                        <div class="form-text mb-3">
                            Kedua kolom bisa diisi/diubah sekaligus. Kosongkan salah satu jika tidak ingin
                            mengubah nilainya.
                        </div>

                        <label class="form-label fw-semibold">Target Aktif</label>

                        <div class="btn-group w-100" role="group" aria-label="Pilih target aktif">
                            <input type="radio" class="btn-check" name="target_aktif_radio" id="radio_aktif_murni"
                                value="murni" autocomplete="off">
                            <label class="btn btn-outline-primary" for="radio_aktif_murni">Murni</label>

                            <input type="radio" class="btn-check" name="target_aktif_radio" id="radio_aktif_perubahan"
                                value="perubahan" autocomplete="off">
                            <label class="btn btn-outline-warning" for="radio_aktif_perubahan">Perubahan</label>
                        </div>

                        <div class="form-text">
                            Tentukan target mana yang dipakai sebagai <strong>target aktif</strong> untuk
                            perhitungan/realisasi tahun ini.
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn tgt-btn-cancel" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn tgt-btn-save">
                            <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
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

                const inputMurniRaw = document.getElementById('input_target_murni_raw');
                const inputMurniDisplay = document.getElementById('input_target_murni_display');

                const inputPerubahanRaw = document.getElementById('input_target_perubahan_raw');
                const inputPerubahanDisplay = document.getElementById('input_target_perubahan_display');

                const inputTargetAktif = document.getElementById('input_target_aktif');
                const radioAktifMurni = document.getElementById('radio_aktif_murni');
                const radioAktifPerubahan = document.getElementById('radio_aktif_perubahan');

                const modalNamaRincian = document.getElementById('modal_nama_rincian');
                const modalNamaDetail = document.getElementById('modal_nama_detail');

                function formatRupiah(angka) {
                    angka = parseInt(angka || 0, 10);
                    return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                }

                function setTargetAktifRadio(value) {
                    inputTargetAktif.value = value;
                    radioAktifMurni.checked = (value !== 'perubahan');
                    radioAktifPerubahan.checked = (value === 'perubahan');
                }

                [radioAktifMurni, radioAktifPerubahan].forEach(function (radio) {
                    radio.addEventListener('change', function () {
                        inputTargetAktif.value = this.value;
                    });
                });

                function bindRupiahInput(displayEl, rawEl) {
                    displayEl.addEventListener('input', function () {
                        const digits = displayEl.value.replace(/[^0-9]/g, '');
                        displayEl.value = formatRupiah(digits);
                        rawEl.value = digits || '0';
                    });
                }

                bindRupiahInput(inputMurniDisplay, inputMurniRaw);
                bindRupiahInput(inputPerubahanDisplay, inputPerubahanRaw);

                document.querySelectorAll('.btn-edit-target').forEach(function (btn) {

                    btn.addEventListener('click', function () {

                        const rincianId = btn.dataset.rincianId;
                        const detailId = btn.dataset.detailId;
                        const tahun = btn.dataset.tahun;
                        const nama = btn.dataset.nama;
                        const detail = btn.dataset.detail;
                        const nominalMurni = btn.dataset.nominalMurni || '0';
                        const nominalPerubahan = btn.dataset.nominalPerubahan || '0';
                        const targetAktif = btn.dataset.targetAktif || 'murni';

                        if (detailId) {
                            inputRincianId.value = '';
                            inputDetailId.value = detailId;
                        } else {
                            inputRincianId.value = rincianId;
                            inputDetailId.value = '';
                        }
                        inputTahun.value = tahun;

                        inputMurniRaw.value = nominalMurni;
                        inputMurniDisplay.value = formatRupiah(nominalMurni);

                        inputPerubahanRaw.value = nominalPerubahan;
                        inputPerubahanDisplay.value = formatRupiah(nominalPerubahan);

                        setTargetAktifRadio(targetAktif);

                        modalNamaRincian.textContent = nama;
                        modalNamaDetail.textContent = detail || '';
                    });
                });

                document.getElementById('formEditTarget').addEventListener('submit', function () {
                    inputMurniRaw.value = inputMurniDisplay.value.replace(/[^0-9]/g, '') || '0';
                    inputPerubahanRaw.value = inputPerubahanDisplay.value.replace(/[^0-9]/g, '') || '0';
                });

            });
        </script>
    @endpush

@endsection