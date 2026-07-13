@extends('layouts.app')

@section('title', 'Input Laporan Retribusi - Step 4')

@section('content')

    <div class="laporan-wizard-page">

        <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-1">Input Laporan Retribusi</h4>
                 <p class="text-muted small mb-0">Lengkapi form berikut untuk memproses laporan retribusi daerah bulanan.</p>
            </div>

            <div class="d-flex align-items-center step-wizard-top">
                <div class="step-top-item active"><div class="step-top-circle">1</div><span class="step-top-label">Jenis</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item active"><div class="step-top-circle">2</div><span class="step-top-label">Objek</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item active"><div class="step-top-circle">3</div><span class="step-top-label">Nominal</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item"><div class="step-top-circle">4</div><span class="step-top-label">Ringkasan</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item"><div class="step-top-circle">5</div><span class="step-top-label">Selesai</span></div>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-warning alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Ringkasan pilihan dari step sebelumnya --}}
        <div class="ringkasan-card mb-4">
            <h6 class="section-title mb-3">
                <i class="bi bi-clipboard-check me-2"></i>
                Ringkasan Objek Retribusi
            </h6>

            <div class="ringkasan-box">
                <div class="ringkasan-row">
                    <div class="ringkasan-key">Objek</div>
                    <div class="ringkasan-val">{{ $objek->nama_objek }}</div>
                </div>
                <div class="ringkasan-row">
                    <div class="ringkasan-key">Rincian Objek</div>
                    <div class="ringkasan-val">{{ $rincian->nama_rincian }}</div>
                </div>
                <div class="ringkasan-row">
                    <div class="ringkasan-key">Detail Objek</div>
                    <div class="ringkasan-val">{{ $detail->nama_detail ?? '—' }}</div>
                </div>
            </div>

            <a href="{{ route('perangkat.laporan.create.objek.show') }}?objek_id={{ $objek->id }}&rincian_id={{ $rincian->id }}"
               class="ringkasan-edit-link">
                <i class="bi bi-pencil me-1"></i> Ubah pilihan objek/rincian/detail
            </a>
        </div>

        {{-- Form nominal --}}
        <form method="POST" action="{{ route('perangkat.laporan.create.nominal.store') }}" id="formNominal">
            @csrf
            <input type="hidden" name="objek_id" value="{{ $objek->id }}">
            <input type="hidden" name="rincian_id" value="{{ $rincian->id }}">
            <input type="hidden" name="detail_retribusi_id" value="{{ $detail->id ?? '' }}">

            <div class="nominal-card mb-4">
                <div class="nominal-card-header">
                    <h6 class="fw-bold mb-1 judul-realisasi">Nominal Realisasi</h6>
                    <p class="text-muted small mb-0">
                        Masukkan rincian nominal realisasi untuk setiap objek retribusi yang telah dipilih.
                    </p>
                </div>

                <div class="nominal-card-body">
                    <div class="nominal-item">
                        <div class="nominal-item-info">
                            <div class="nominal-item-title">{{ $objek->nama_objek }}</div>
                            <div class="nominal-item-sub">{{ $rincian->nama_rincian }}</div>
                            @if($detail)
                                <div class="nominal-item-sub">{{ $detail->nama_detail }}</div>
                            @endif
                        </div>
                        <div class="nominal-item-input">
                            <label class="form-label fw-semibold small mb-1">Nominal Realisasi (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" id="nominal_display"
                                       class="form-control"
                                       value="{{ old('realisasi_bulan_ini') ? number_format(old('realisasi_bulan_ini'), 0, ',', '.') : '' }}"
                                       placeholder="Masukkan nominal tanpa titik (contoh: 1000000)">
                                <input type="hidden" name="realisasi_bulan_ini" id="realisasi_bulan_ini"
                                       value="{{ old('realisasi_bulan_ini') }}">
                            </div>
                        </div>
                    </div>

                    <hr class="nominal-divider">

                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" name="konfirmasi" id="konfirmasi" required>
                        <label class="form-check-label small" for="konfirmasi">
                            Saya menyatakan bahwa data yang dikirim sudah sesuai dengan data yang sebenarnya dan dapat dipertanggungjawabkan kebenarannya.
                        </label>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end align-items-center">
                <div class="d-flex gap-2">
                    <a href="{{ route('perangkat.laporan.create.objek.show') }}?objek_id={{ $objek->id }}&rincian_id={{ $rincian->id }}"
                       class="btn btn-batal">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-lanjut" id="btnLanjut" disabled>
                        Selanjutnya <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </div>
            </div>
        </form>

    </div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const nominalDisplay = document.getElementById('nominal_display');
    const nominalHidden = document.getElementById('realisasi_bulan_ini');
    const btnLanjut = document.getElementById('btnLanjut');

    function checkReady() {
        if (btnLanjut) btnLanjut.disabled = !(nominalHidden && nominalHidden.value);
    }

    if (nominalDisplay) {
        nominalDisplay.addEventListener('input', function () {
            const raw = this.value.replace(/\D/g, '');
            this.value = raw ? new Intl.NumberFormat('id-ID').format(raw) : '';
            nominalHidden.value = raw;
            checkReady();
        });
    }

    checkReady();
});
</script>
@endpush
@endsection