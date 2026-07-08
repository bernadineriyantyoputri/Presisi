@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold">{{ $jenis->nama_jenis }}</h3>
            <p class="text-muted mb-0">Daftar Objek Retribusi</p>
        </div>

        <button class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#modalObjek">
            + Tambah Objek
        </button>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">

        @forelse($jenis->objekRetribusi as $objek)

        <div class="col-lg-4 col-md-6 mb-4">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-folder2-open text-primary"
                       style="font-size:50px;"></i>

                    <h5 class="mt-3">
                        {{ $objek->nama_objek }}
                    </h5>

                    <a href="{{ route('admin.data.objek', $objek->id) }}"
                       class="btn btn-outline-primary mt-3">
                        Kelola
                    </a>

                </div>

            </div>

        </div>

        @empty

        <div class="col-12">
            <div class="alert alert-warning">
                Belum ada objek retribusi.
            </div>
        </div>

        @endforelse

    </div>

</div>

{{-- Modal Tambah Objek --}}
<div class="modal fade" id="modalObjek" tabindex="-1">

    <div class="modal-dialog">

        <form action="{{ route('admin.objek.store') }}" method="POST">

            @csrf

            <input type="hidden"
                   name="jenis_id"
                   value="{{ $jenis->id }}">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Tambah Objek Retribusi
                    </h5>

                    <button class="btn-close"
                            data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <label class="form-label">
                        Nama Objek Retribusi
                    </label>

                    <input type="text"
                           name="nama_objek"
                           class="form-control"
                           required>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button class="btn btn-primary">
                        Simpan
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection