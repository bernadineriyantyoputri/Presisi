@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Data Retribusi
            </h3>

            <p class="text-muted mb-0">
                Kelola Data Retribusi Daerah
            </p>
        </div>

        <button class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#modalJenis">

            + Tambah Jenis

        </button>

    </div>


    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif


    <div class="row">

        @foreach($data as $jenis)

        <div class="col-lg-4 col-md-6 mb-4">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body text-center">

                    <div class="mb-3">

                        <i class="bi bi-folder-fill text-primary"
                           style="font-size:55px;"></i>

                    </div>

                    <h5 class="fw-bold">

                        {{ $jenis->nama_jenis }}

                    </h5>

                    <p class="text-muted">

                        {{ $jenis->objek_retribusi_count }}
                        Objek Retribusi

                    </p>

                    <a href="{{ route('admin.data.jenis',$jenis->id) }}"
                       class="btn btn-outline-primary">

                        Kelola

                    </a>

                </div>

            </div>

        </div>

        @endforeach

    </div>

</div>


{{-- Modal Tambah Jenis --}}

<div class="modal fade"
     id="modalJenis"
     tabindex="-1">

    <div class="modal-dialog">

        <form action="{{ route('admin.jenis.store') }}"
              method="POST">

            @csrf

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Tambah Jenis Retribusi

                    </h5>

                    <button class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <label class="form-label">

                        Nama Jenis Retribusi

                    </label>

                    <input type="text"
                           name="nama_jenis"
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