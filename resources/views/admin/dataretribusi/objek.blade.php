@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')

    <div class="jr-page">

        {{-- ================= HEADER ================= --}}
        <div class="jr-header">
            <h3 class="jr-title">{{ $jenis->nama_jenis }}</h3>
            <p class="jr-subtitle">Kelola hierarki data retribusi daerah mulai dari jenis hingga detail objek.</p>
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
                    <h5 class="jr-table-title">Objek Retribusi</h5>
                    <p class="jr-table-subtitle">Menampilkan sub-kategori dari objek retribusi aktif.</p>
                </div>

                <button type="button" class="btn jr-btn-add" data-bs-toggle="modal" data-bs-target="#modalObjek">
                    <i class="bi bi-plus-lg"></i> Tambah Objek
                </button>
            </div>

            {{-- Dropdown filter objek retribusi --}}
            @if($objekList->isNotEmpty())
                <div class="jr-filter-dropdown dropdown mb-3">
                    <button class="btn jr-dropdown-toggle dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        {{ $selectedObjek->nama_objek ?? 'Pilih Objek Retribusi' }}
                    </button>
                    <ul class="dropdown-menu">
                        @foreach($objekList as $objek)
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('admin.data.jenis', ['jenis' => $jenis->id, 'objek' => $objek->id]) }}">
                                    {{ $objek->nama_objek }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Tabel Rincian & Detail --}}
            <div class="table-responsive">
                <table class="table jr-table align-middle">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>OBJEK RETRIBUSI</th>
                            <th>NAMA RINCIAN</th>
                            <th>DETAIL</th>
                            <th class="text-end">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $i => $rincian)
                            <tr>
                                <td>{{ $data->firstItem() + $i }}</td>
                                <td>
                                    <a href="{{ route('admin.data.jenis', ['jenis' => $jenis->id, 'objek' => $rincian->objek->id ?? '']) }}"
                                        class="jr-table-link">
                                        {{ $rincian->objek->nama_objek ?? '-' }}
                                    </a>
                                </td>
                                <td class="fw-semibold">{{ $rincian->nama_rincian ?? '-' }}</td>
                                <td>
                                    @if($rincian->detail->isNotEmpty())
                                        {{ $rincian->detail->pluck('nama_detail')->implode(', ') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-end">
                                    <button type="button" class="jr-icon-btn jr-icon-btn-edit" data-bs-toggle="modal"
                                        data-bs-target="#modalEditRincian{{ $rincian->id }}" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="jr-icon-btn jr-icon-btn-delete" data-bs-toggle="modal"
                                        data-bs-target="#modalDeleteRincian{{ $rincian->id }}" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            {{-- Modal Edit Rincian --}}
                            {{-- Modal Edit Rincian --}}
                            <div class="modal fade" id="modalEditRincian{{ $rincian->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="{{ route('admin.rincian.update', $rincian->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content jr-modal-content">
                                            <div class="modal-header">
                                                <div>
                                                    <h5 class="modal-title">Edit Rincian Objek Retribusi</h5>
                                                    <p class="jr-modal-subtitle mb-0">Lengkapi informasi rincian objek pajak di
                                                        bawah ini.</p>
                                                </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <label class="form-label">Nama Objek Retribusi</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $rincian->objek->nama_objek ?? '-' }}" disabled>

                                                <label class="form-label mt-3">Nama Rincian</label>
                                                <input type="text" name="nama_rincian" class="form-control"
                                                    value="{{ $rincian->nama_rincian }}" required>

                                                <label class="form-label mt-3">
                                                    Detail Objek
                                                </label>

                                                <div class="form-check mb-2">

                                                    <input class="form-check-input" type="checkbox"
                                                        id="punyaDetail{{ $rincian->id }}" {{ $rincian->detail->isNotEmpty() ? 'checked' : '' }}>

                                                    <label class="form-check-label">
                                                        Memiliki Detail Objek
                                                    </label>

                                                </div>

                                                <textarea id="detail{{ $rincian->id }}" name="nama_detail" class="form-control"
                                                    rows="4" {{ $rincian->detail->isEmpty() ? 'style=display:none;' : '' }}>{{ optional($rincian->detail->first())->nama_detail }}</textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-save"></i> Simpan Perubahan
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- Modal Hapus Rincian --}}
                            <div class="modal fade" id="modalDeleteRincian{{ $rincian->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="{{ route('admin.rincian.destroy', $rincian->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-content jr-modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Hapus Rincian</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Apakah Anda yakin ingin menghapus rincian
                                                    <strong>{{ $rincian->nama_rincian ?? '-' }}</strong>?
                                                </p>
                                                <p class="text-danger small mb-0">
                                                    Semua detail di bawah rincian ini juga akan ikut terhapus.
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Belum ada data untuk objek ini.
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
    <div class="modal fade" id="modalObjek" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.objek.storeFull') }}" method="POST">
                @csrf
                <input type="hidden" name="jenis_id" value="{{ $jenis->id }}">
                <div class="modal-content jr-modal-content">
                    <div class="modal-header">
                        <div>
                            <h5 class="modal-title">Tambah Objek Retribusi</h5>
                            <p class="jr-modal-subtitle mb-0">Tambahkan jenis objek retribusi daerah baru.</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Nama Objek Retribusi <span class="text-danger">*</span></label>
                        <input type="text" name="nama_objek" class="form-control"
                            placeholder="Masukkan nama objek retribusi" required>

                        <label class="form-label mt-3">Nama Rincian <span class="text-danger">*</span></label>
                        <input type="text" name="nama_rincian" class="form-control" placeholder="Masukkan nama rincian"
                            required>

                        <label class="form-label mt-3">
                            Detail Objek
                        </label>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="punyaDetailTambah">

                            <label class="form-check-label">
                                Rincian ini memiliki detail
                            </label>
                        </div>

                        <input type="text" id="nama_detail_tambah" name="nama_detail" class="form-control"
                            placeholder="Masukkan detail objek" style="display:none;">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            // Tambah
            const tambah = document.getElementById('punyaDetailTambah');

            if (tambah) {

                tambah.addEventListener('change', function () {

                    let input = document.getElementById('nama_detail_tambah');

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

            // Edit
            document.querySelectorAll('.form-check-input').forEach(function (item) {

                item.addEventListener('change', function () {

                    let id = this.id.replace('punyaDetail', '');

                    let textarea = document.getElementById('detail' + id);

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