@extends('layouts.app')

@section('title', 'Input Laporan Retribusi - Step 2')

@section('content')

    <div class="laporan-wizard-page">

        <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-1">Input Laporan Retribusi</h4>
                <p class="text-muted small mb-0">
                    Lengkapi form berikut untuk memproses laporan retribusi daerah bulanan.
                </p>
            </div>

            <div class="d-flex align-items-center step-wizard-top">
                <div class="step-top-item active"><div class="step-top-circle">1</div><span class="step-top-label">Jenis</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item active"><div class="step-top-circle">2</div><span class="step-top-label">Objek</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item"><div class="step-top-circle">3</div><span class="step-top-label">Nominal</span></div>
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
            <div class="alert alert-warning">{{ session('error') }}</div>
        @endif

        <div class="row g-4">
            <div class="col-md-12">
                <form method="GET" action="{{ route('perangkat.laporan.create.objek.show') }}" id="formCascading">

                    <div class="wizard-card mb-3">
                        <h6 class="section-title mb-3">
                            <i class="bi bi-diagram-3 me-2"></i>
                            Objek Retribusi Daerah
                        </h6>

                        @if($objekList->isEmpty())
                            <div class="alert alert-warning mb-0">
                                Belum ada objek retribusi untuk jenis ini. Hubungi admin untuk menambahkan data master.
                            </div>
                        @else
                            {{-- LEVEL 1: OBJEK --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Pilih Objek</label>
                                <select name="objek_id" class="form-select" required
                                        onchange="this.form.submit()">
                                    <option value="">Pilih Objek</option>
                                    @foreach($objekList as $o)
                                        <option value="{{ $o->id }}" {{ (string) $selectedObjekId === (string) $o->id ? 'selected' : '' }}>
                                            {{ $o->nama_objek }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- LEVEL 2: RINCIAN OBJEK RETRIBUSI --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Rincian Objek Retribusi</label>
                                @if($selectedObjekId && $rincianList->isNotEmpty())
                                    <select name="rincian_id" class="form-select" required
                                            onchange="this.form.submit()">
                                        <option value="">Pilih Rincian Objek</option>
                                        @foreach($rincianList as $r)
                                            <option value="{{ $r->id }}" {{ (string) $selectedRincianId === (string) $r->id ? 'selected' : '' }}>
                                                {{ $r->nama_rincian }}
                                            </option>
                                        @endforeach
                                    </select>
                                @elseif($selectedObjekId && $rincianList->isEmpty())
                                    <select class="form-select" disabled>
                                        <option>Belum ada rincian objek untuk objek ini</option>
                                    </select>
                                @else
                                    <select class="form-select" disabled>
                                        <option>Pilih objek terlebih dahulu</option>
                                    </select>
                                @endif
                            </div>

                            {{-- LEVEL 3: DETAIL OBJEK RETRIBUSI --}}
                            <div class="mb-0">
                                <label class="form-label fw-semibold small">Detail Objek Retribusi</label>
                                @if($selectedRincianId && $detailList->isNotEmpty())
                                    <select name="detail_retribusi_id" id="detail_retribusi_id" class="form-select">
                                        <option value="">Pilih Detail Objek</option>
                                        @foreach($detailList as $d)
                                            <option value="{{ $d->id }}">
                                                {{ $d->nama_detail }}
                                            </option>
                                        @endforeach
                                    </select>
                                @elseif($selectedRincianId && $detailList->isEmpty())
                                    <div class="form-text text-muted mt-1">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Rincian ini tidak memiliki detail objek. Kamu bisa langsung lanjut ke step nominal.
                                    </div>
                                @else
                                    <select class="form-select" disabled>
                                        <option>Pilih rincian objek terlebih dahulu</option>
                                    </select>
                                @endif
                            </div>
                        @endif
                    </div>
                </form>

                @if($selectedObjekId && $selectedRincianId)
                    <form method="POST" action="{{ route('perangkat.laporan.create.objek') }}" id="formLanjut">
                        @csrf
                        <input type="hidden" name="objek_id" value="{{ $selectedObjekId }}">
                        <input type="hidden" name="rincian_id" value="{{ $selectedRincianId }}">
                        <input type="hidden" name="detail_retribusi_id" id="hiddenDetailId" value="">

                        <div class="wizard-footer">
                            <a href="{{ route('perangkat.laporan.create') }}" class="btn btn-batal">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-lanjut" id="btnLanjut" disabled>
                                Lanjut Isi Nominal <i class="bi bi-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </form>
                @endif

            </div>
        </div>
    </div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const detailSelect = document.getElementById('detail_retribusi_id');
    const hiddenDetailId = document.getElementById('hiddenDetailId');
    const btnLanjut = document.getElementById('btnLanjut');

    // Kalau tidak ada dropdown detail (rincian tidak punya detail), tombol lanjut langsung aktif
    const hasDetailOptions = !!detailSelect;

    function checkReady() {
        const hasDetail = !hasDetailOptions || (hiddenDetailId && hiddenDetailId.value);
        if (btnLanjut) btnLanjut.disabled = !hasDetail;
    }

    if (detailSelect) {
        detailSelect.addEventListener('change', function () {
            hiddenDetailId.value = this.value;
            checkReady();
        });
    }

    checkReady();
});
</script>
@endpush
@endsection