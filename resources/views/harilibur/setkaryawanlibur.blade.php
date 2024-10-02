@extends('layout.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-fluid">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Pengaturan Karyawan Libur
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    @if (Session::get('success'))
                                        <div class="alert alert-success">
                                            {{ Session::get('success') }}
                                        </div>
                                    @endif

                                    @if (Session::get('warning'))
                                        <div class="alert alert-warning">
                                            {{ Session::get('warning') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @role('administrator', 'user')
                                <div class="row">
                                    <div class="col-12">
                                        <a href="#" class="btn btn-primary" id="btnSetkaryawanlibur"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 5l0 14" />
                                                <path d="M5 12l14 0" />
                                            </svg>
                                            Tambah Data
                                        </a>
                                    </div>
                                </div>
                            @endrole

                            <div class="row mt-2">
                                <div class="col-12">
                                    <table class="table">
                                        <tr>
                                            <th>Kode Libur</th>
                                            <td>{{ $harilibur->kode_libur }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Libur</th>
                                            <td>{{ date('d-m-Y', strtotime($harilibur->tgl_libur)) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Kantor</th>
                                            <td>{{ strtoupper($harilibur->nama_cabang) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Keterangan</th>
                                            <td>{{ strtoupper($harilibur->keterangan) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <table class="table table-bordered">
                                        <thead style="text-align: center">
                                            <tr>
                                                <th>No</th>
                                                <th>Nik</th>
                                                <th>Nama Karyawan</th>
                                                <th>Jabatan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="loadkaryawanlibur"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-setkaryawanlibur" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Karyawan Libur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadsetkaryawanlibur">

                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(function() {

            function loadlkaryawanlibur() {
                var kode_libur = "{{ $harilibur->kode_libur }}"
                $("#loadkaryawanlibur").load('/konfigurasi/harilibur/' + kode_libur + '/getkaryawanlibur');
            }
            loadlkaryawanlibur();

            $("#btnSetkaryawanlibur").click(function(e) {
                var kode_libur = "{{ $harilibur->kode_libur }}"
                $("#modal-setkaryawanlibur").modal("show");
                $("#loadsetkaryawanlibur").load('/konfigurasi/harilibur/' + kode_libur +
                    '/setlistkaryawanlibur');
            });
        });
    </script>
@endpush
