@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div>

    {{-- ================= BACK LINK ================= --}}
    <a href="{{ route('admin.data.index') }}" class="jr-back-link">
        <i class="bi bi-arrow-left"></i> Kembali ke Jenis Retribusi
    </a>

    {{-- ================= HEADER ================= --}}
    <div class="tgt-header page-header">
        <h1>{{ $jenis->nama_jenis }}</h1>
        <p>Kelola hierarki data retribusi daerah mulai dari jenis hingga detail objek.</p>
    </div>

    @if(session('success'))
        <div class="jr-alert jr-alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="jr-alert jr-alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- ================= SECTION: OBJEK RETRIBUSI ================= --}}
    <div class="jr-table-card">

        <div class="jr-table-card-header">
            <div>
                <h5 class="jr-table-title">
                    Objek Retribusi
                    <span class="jr-table-badge">{{ $data->total() ?? $data->count() }} rincian</span>
                </h5>
                <p class="jr-table-subtitle">Menampilkan sub-kategori dari objek retribusi aktif.</p>
            </div>

            <button type="button" class="btn jr-btn-add" data-bs-toggle="modal" data-bs-target="#modalObjek">
                <i class="bi bi-plus-lg"></i> Tambah Objek
            </button>
        </div>

        {{-- Dropdown filter objek + tombol tambah rincian --}}
        @if($objekList->isNotEmpty())
            <div class="d-flex align-items-center justify-content-between gap-2 mb-3 w-100">

                {{-- Dropdown Objek --}}
                <div class="jr-filter-dropdown dropdown">
                    <button class="btn jr-dropdown-toggle dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <span>
                            <i class="bi bi-funnel me-1"></i>
                            {{ $selectedObjek->nama_objek ?? 'Pilih Objek Retribusi' }}
                        </span>
                    </button>

                    <ul class="dropdown-menu jr-objek-dropdown-menu">
                        @foreach($objekList as $objek)
                            <li>
                                <a class="dropdown-item {{ ($selectedObjek->id ?? null) == $objek->id ? 'active' : '' }}"
                                   href="{{ route('admin.data.jenis', ['jenis' => $jenis->id, 'objek' => $objek->id]) }}">
                                    {{ $objek->nama_objek }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Tombol Tambah Rincian --}}
                @if($selectedObjek)
                    <button type="button" class="btn jr-btn-add" data-bs-toggle="modal" data-bs-target="#modalTambahRincian">
                        <i class="bi bi-plus-lg"></i> Tambah Rincian
                    </button>
                @endif

            </div>
        @endif

        {{-- Tabel Rincian & Detail --}}
        <div class="table-responsive">
            <table class="table jr-table align-top mb-0">
                <thead>
    <tr>
        <th>NO</th>
        <th>NAMA RINCIAN</th>
        <th>DETAIL</th>
        <th class="text-center">AKSI DETAIL</th>
        <th class="text-end">AKSI RINCIAN</th>
    </tr>
</thead>
                <tbody>
    @forelse($data as $i => $rincian)
        <tr>
            {{-- NO --}}
            <td>
                {{ $data->firstItem() + $i }}
            </td>

            {{-- NAMA RINCIAN --}}
            <td class="fw-semibold">
                {{ $rincian->nama_rincian ?? '-' }}
            </td>

            {{-- DETAIL --}}
            <td>
                @if($rincian->detail->isNotEmpty())
                    <div class="detail-list">
                        @foreach($rincian->detail as $detail)
                            <div class="detail-item">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="detail-dot"></span>
                                    <span>{{ $detail->nama_detail }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <span class="text-muted fst-italic">
                        Tidak memiliki detail
                    </span>
                @endif
            </td>

            {{-- AKSI DETAIL --}}
            <td class="text-center">
                @if($rincian->detail->isNotEmpty())
                    <div class="detail-action-list">
                        @foreach($rincian->detail as $detail)
                            <div class="detail-action-item">

                                {{-- EDIT DETAIL --}}
                                <button type="button"
                                        class="jr-icon-btn jr-icon-btn-edit"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditDetail{{ $detail->id }}"
                                        title="Edit Detail">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                {{-- HAPUS DETAIL --}}
                                <button type="button"
                                        class="jr-icon-btn jr-icon-btn-delete"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalDeleteDetail{{ $detail->id }}"
                                        title="Hapus Detail">
                                    <i class="bi bi-trash"></i>
                                </button>

                            </div>
                        @endforeach
                    </div>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>

            {{-- AKSI RINCIAN --}}
            <td class="text-end">
                
                {{-- TAMBAH DETAIL --}}
                <button type="button"
                        class="jr-icon-btn jr-icon-btn-add"
                        data-bs-toggle="modal"
                        data-bs-target="#modalTambahDetail{{ $rincian->id }}"
                        title="Tambah Detail">
                    <i class="bi bi-plus-lg"></i>
                </button>

                {{-- EDIT RINCIAN --}}
                <button type="button"
                        class="jr-icon-btn jr-icon-btn-edit"
                        data-bs-toggle="modal"
                        data-bs-target="#modalEditRincian{{ $rincian->id }}"
                        title="Edit Rincian">
                    <i class="bi bi-pencil"></i>
                </button>

                {{-- HAPUS RINCIAN --}}
                <button type="button"
                        class="jr-icon-btn jr-icon-btn-delete"
                        data-bs-toggle="modal"
                        data-bs-target="#modalDeleteRincian{{ $rincian->id }}"
                        title="Hapus Rincian">
                    <i class="bi bi-trash"></i>
                </button>

            </td>
        </tr>


        {{-- =========================================================
             MODAL EDIT DETAIL
        ========================================================== --}}
        @foreach($rincian->detail as $detail)

            <div class="modal fade"
                 id="modalEditDetail{{ $detail->id }}"
                 tabindex="-1">

                <div class="modal-dialog">

                    <form action="{{ route('admin.detail.update', $detail->id) }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <div class="modal-content jr-modal-content">

                            <div class="modal-header">
                                <div>
                                    <h5 class="modal-title">
                                        Edit Detail Retribusi
                                    </h5>

                                    <p class="jr-modal-subtitle mb-0">
                                        Perbarui detail pada rincian yang dipilih.
                                    </p>
                                </div>

                                <button type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal">
                                </button>
                            </div>

                            <div class="modal-body">

                                <label class="form-label">
                                    Nama Rincian
                                </label>

                                <input type="text"
                                       class="form-control"
                                       value="{{ $rincian->nama_rincian }}"
                                       readonly>

                                <label class="form-label mt-3">
                                    Nama Detail
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                       name="nama_detail"
                                       class="form-control"
                                       value="{{ $detail->nama_detail }}"
                                       required>

                            </div>

                            <div class="modal-footer">

                                <button type="button"
                                        class="btn jr-btn-cancel"
                                        data-bs-dismiss="modal">

                                    <i class="bi bi-x-circle me-1"></i>
                                    Batal

                                </button>

                                <button type="submit"
                                        class="btn jr-btn-save">

                                    <i class="bi bi-check-circle me-1"></i>
                                    Simpan Perubahan

                                </button>

                            </div>

                        </div>

                    </form>

                </div>
            </div>


            {{-- =====================================================
                 MODAL HAPUS DETAIL
            ====================================================== --}}
            <div class="modal fade"
                 id="modalDeleteDetail{{ $detail->id }}"
                 tabindex="-1">

                <div class="modal-dialog">

                    <form action="{{ route('admin.detail.destroy', $detail->id) }}"
                          method="POST">

                        @csrf
                        @method('DELETE')

                        <div class="modal-content jr-modal-content">

                            <div class="modal-header">

                                <div>
                                    <h5 class="modal-title">
                                        Hapus Detail
                                    </h5>

                                    <p class="jr-modal-subtitle mb-0">
                                        Tindakan ini tidak dapat dibatalkan.
                                    </p>
                                </div>

                                <button type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal">
                                </button>

                            </div>

                            <div class="modal-body">

                                <p>
                                    Apakah Anda yakin ingin menghapus detail
                                    <strong>{{ $detail->nama_detail }}</strong>?
                                </p>

                            </div>

                            <div class="modal-footer">

                                <button type="button"
                                        class="btn jr-btn-cancel"
                                        data-bs-dismiss="modal">

                                    <i class="bi bi-x-circle me-1"></i>
                                    Batal

                                </button>

                                <button type="submit"
                                        class="btn btn-danger">

                                    <i class="bi bi-trash me-1"></i>
                                    Ya, Hapus

                                </button>

                            </div>

                        </div>

                    </form>

                </div>
            </div>

        @endforeach


        {{-- =========================================================
             MODAL EDIT RINCIAN
        ========================================================== --}}
        <div class="modal fade"
             id="modalEditRincian{{ $rincian->id }}"
             tabindex="-1">

            <div class="modal-dialog">

                <form action="{{ route('admin.rincian.update', $rincian->id) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    <div class="modal-content jr-modal-content">

                        <div class="modal-header">

                            <div>
                                <h5 class="modal-title">
                                    Edit Rincian Objek Retribusi
                                </h5>

                                <p class="jr-modal-subtitle mb-0">
                                    Lengkapi informasi rincian objek retribusi di bawah ini.
                                </p>
                            </div>

                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal">
                            </button>

                        </div>

                        <div class="modal-body">

                            <label class="form-label">
                                Nama Objek Retribusi
                            </label>

                            <input type="text"
                                   name="nama_objek"
                                   class="form-control"
                                   value="{{ $rincian->objek->nama_objek ?? '-' }}"
                                   required>

                            <label class="form-label mt-3">
                                Nama Rincian
                            </label>

                            <input type="text"
                                   name="nama_rincian"
                                   class="form-control"
                                   value="{{ $rincian->nama_rincian }}"
                                   required>

                        </div>

                        <div class="modal-footer">

                            <button type="button"
                                    class="btn jr-btn-cancel"
                                    data-bs-dismiss="modal">

                                <i class="bi bi-x-circle me-1"></i>
                                Batal

                            </button>

                            <button type="submit"
                                    class="btn jr-btn-save">

                                <i class="bi bi-check-circle me-1"></i>
                                Simpan Perubahan

                            </button>

                        </div>

                    </div>

                </form>

            </div>
        </div>


        {{-- =========================================================
             MODAL HAPUS RINCIAN
        ========================================================== --}}
        <div class="modal fade"
             id="modalDeleteRincian{{ $rincian->id }}"
             tabindex="-1">

            <div class="modal-dialog">

                <form action="{{ route('admin.rincian.destroy', $rincian->id) }}"
                      method="POST">

                    @csrf
                    @method('DELETE')

                    <div class="modal-content jr-modal-content">

                        <div class="modal-header">

                            <div>
                                <h5 class="modal-title">
                                    Hapus Rincian
                                </h5>

                                <p class="jr-modal-subtitle mb-0">
                                    Tindakan ini tidak dapat dibatalkan.
                                </p>
                            </div>

                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal">
                            </button>

                        </div>

                        <div class="modal-body">

                            <p>
                                Apakah Anda yakin ingin menghapus rincian
                                <strong>{{ $rincian->nama_rincian ?? '-' }}</strong>?
                            </p>

                            <p class="text-danger small mb-0">
                                Semua detail di bawah rincian ini juga akan ikut terhapus.
                            </p>

                        </div>

                        <div class="modal-footer">

                            <button type="button"
                                    class="btn jr-btn-cancel"
                                    data-bs-dismiss="modal">

                                <i class="bi bi-x-circle me-1"></i>
                                Batal

                            </button>

                            <button type="submit"
                                    class="btn btn-danger">

                                <i class="bi bi-trash me-1"></i>
                                Ya, Hapus

                            </button>

                        </div>

                    </div>

                </form>

            </div>
        </div>


        {{-- =========================================================
             MODAL TAMBAH DETAIL
        ========================================================== --}}
        <div class="modal fade"
             id="modalTambahDetail{{ $rincian->id }}"
             tabindex="-1">

            <div class="modal-dialog">

                <form action="{{ route('admin.detail.store') }}"
                      method="POST">

                    @csrf

                    <input type="hidden"
                           name="rincian_id"
                           value="{{ $rincian->id }}">

                    <div class="modal-content jr-modal-content">

                        <div class="modal-header">

                            <div>
                                <h5 class="modal-title">
                                    Tambah Detail Retribusi
                                </h5>

                                <p class="jr-modal-subtitle mb-0">
                                    Tambahkan detail pada rincian yang dipilih.
                                </p>
                            </div>

                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal">
                            </button>

                        </div>

                        <div class="modal-body">

                            <label class="form-label">
                                Nama Rincian
                            </label>

                            <input type="text"
                                   class="form-control"
                                   value="{{ $rincian->nama_rincian }}"
                                   readonly>

                            <label class="form-label mt-3">
                                Nama Detail
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="nama_detail"
                                   class="form-control"
                                   placeholder="Masukkan nama detail"
                                   required>

                        </div>

                        <div class="modal-footer">

                            <button type="button"
                                    class="btn jr-btn-cancel"
                                    data-bs-dismiss="modal">

                                <i class="bi bi-x-circle me-1"></i>
                                Batal

                            </button>

                            <button type="submit"
                                    class="btn jr-btn-save">

                                <i class="bi bi-check-circle me-1"></i>
                                Simpan

                            </button>

                        </div>

                    </div>

                </form>

            </div>
        </div>

    @empty

        <tr>
            <td colspan="5" class="jr-empty-state">
                <i class="bi bi-inbox"></i>
                <span>Belum ada data untuk objek ini.</span>
            </td>
        </tr>

    @endforelse
</tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($data->hasPages())
            <div class="d-flex justify-content-end mt-3">
                {{ $data->appends(['objek' => $selectedObjek->id ?? null])->links() }}
            </div>
        @endif

    </div>
</div>

{{-- ================= MODAL: TAMBAH OBJEK RETRIBUSI ================= --}}
<div class="modal fade" id="modalObjek" tabindex="-1" aria-labelledby="modalObjekLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.objek.storeFull') }}" method="POST">
            @csrf

            <input type="hidden" name="jenis_id" value="{{ $jenis->id }}">

            <div class="modal-content jr-modal-content">

                {{-- HEADER --}}
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title" id="modalObjekLabel">
                            Tambah Objek Retribusi
                        </h5>

                        <p class="jr-modal-subtitle mb-0">
                            Tambahkan jenis objek retribusi daerah baru.
                        </p>
                    </div>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>
                </div>

                {{-- BODY --}}
                <div class="modal-body">

                    <label class="form-label">
                        Nama Objek Retribusi
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="nama_objek"
                           class="form-control @error('nama_objek') is-invalid @enderror"
                           value="{{ old('nama_objek') }}"
                           placeholder="Masukkan nama objek retribusi"
                           required>

                    @error('nama_objek')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror


                    <label class="form-label mt-3">
                        Nama Rincian
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="nama_rincian"
                           class="form-control @error('nama_rincian') is-invalid @enderror"
                           value="{{ old('nama_rincian') }}"
                           placeholder="Masukkan nama rincian"
                           required>

                    @error('nama_rincian')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- FOOTER --}}
                <div class="modal-footer">

                    <button type="button"
                            class="btn jr-btn-cancel"
                            data-bs-dismiss="modal">

                        <i class="bi bi-x-circle me-1"></i>
                        Batal

                    </button>

                    <button type="submit"
                            class="btn jr-btn-save">

                        <i class="bi bi-check-circle me-1"></i>
                        Simpan

                    </button>

                </div>

            </div>
        </form>
    </div>
</div>



{{-- ================= MODAL: TAMBAH RINCIAN ================= --}}
@if($selectedObjek)
    <div class="modal fade" id="modalTambahRincian" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.rincian.store') }}" method="POST">
                @csrf
                <input type="hidden" name="objek_id" value="{{ $selectedObjek->id }}">
                <div class="modal-content jr-modal-content">
                    <div class="modal-header">
                        <div>
                            <h5 class="modal-title">Tambah Rincian Objek Retribusi</h5>
                            <p class="jr-modal-subtitle mb-0">Tambahkan rincian baru pada objek retribusi yang dipilih.</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Objek Retribusi</label>
                        <input type="text" class="form-control" value="{{ $selectedObjek->nama_objek }}" readonly>

                        <label class="form-label mt-3">
                            Nama Rincian <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_rincian" class="form-control @error('nama_rincian') is-invalid @enderror"
                               value="{{ old('nama_rincian') }}" placeholder="Masukkan nama rincian" required>
                        @error('nama_rincian')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn jr-btn-cancel" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn jr-btn-save">
                            <i class="bi bi-check-circle me-1"></i> Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {

        // Toggle input detail pada modal "Tambah Objek"
        const tambah = document.getElementById('punyaDetailTambah');
        if (tambah) {
            tambah.addEventListener('change', function () {
                const input = document.getElementById('nama_detail_tambah');
                if (this.checked) {
                    input.style.display = 'block';
                    input.required = true;
                } else {
                    input.style.display = 'none';
                    input.required = false;
                    input.value = '';
                }
            });
        }

        // Toggle textarea detail pada tiap modal "Edit Rincian"
        document.querySelectorAll('.punya-detail-toggle').forEach(function (item) {
            item.addEventListener('change', function () {
                const id = this.id.replace('punyaDetail', '');
                const textarea = document.getElementById('detail' + id);
                if (!textarea) return;

                if (this.checked) {
                    textarea.style.display = 'block';
                    textarea.required = true;
                } else {
                    textarea.style.display = 'none';
                    textarea.required = false;
                    textarea.value = '';
                }
            });
        });

    });
</script>
@endsection