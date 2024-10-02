@extends('layout.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-fluid">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        MONITORING KEHADIRAN KARYAWAN
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
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
                            <div class="row">
                                @role('administrator', 'user')
                                    <div class="col-4">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-calendar">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                                    <path d="M16 3v4" />
                                                    <path d="M8 3v4" />
                                                    <path d="M4 11h16" />
                                                    <path d="M11 15h1" />
                                                    <path d="M12 15v3" />
                                                </svg>
                                            </span>
                                            <input type="text" value="{{ date('Y-m-d') }}" id="tanggal" name="tanggal"
                                                class="form-control" placeholder="" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group">
                                            <select name="kode_cabang" id="kode_cabang" class="form-select">
                                                <option value="">Semua kantor</option>
                                                @foreach ($cabang as $d)
                                                    <option value="{{ $d->kode_cabang }}">
                                                        {{ $d->nama_cabang }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <select name="kode_dept" id="kode_dept" class="form-select">
                                                <option value="">Semua Satuan Kerja</option>
                                                @foreach ($departemen as $d)
                                                    <option value="{{ $d->kode_dept }}">{{ $d->nama_dept }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-calendar">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                                    <path d="M16 3v4" />
                                                    <path d="M8 3v4" />
                                                    <path d="M4 11h16" />
                                                    <path d="M11 15h1" />
                                                    <path d="M12 15v3" />
                                                </svg>
                                            </span>
                                            <input type="text" value="{{ date('Y-m-d') }}" id="tanggal" name="tanggal"
                                                class="form-control" placeholder="Tanggal Absen" autocomplete="off">
                                        </div>
                                    </div>
                                @endrole
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="" style="text-align: center">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nik</th>
                                                    <th>Nama Karyawan</th>
                                                    <th>Kantor</th>
                                                    <th>Kode Bagian</th>
                                                    <th>Jadwal JK</th>
                                                    <th>Jam Masuk</th>
                                                    <th>Foto Masuk</th>
                                                    <th>Jam Pulang</th>
                                                    <th>Foto Pulang</th>
                                                    <th>Status</th>
                                                    <th>Keterangan</th>
                                                    <th>Lokasi Absen</th>
                                                    <th>Aksi</th>

                                                </tr>
                                            </thead>
                                            <tbody id="loadpresensi"></tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-showmap" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lokasi Absensi Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadmap">
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-koreksiAbsen" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Koreksi Absensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadkoreksiabsensi">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(function() {
            $("#tanggal").datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            });

            function loadpresensi() {
                var tanggal = $('#tanggal').val();
                var kode_cabang = $('#kode_cabang').val();
                var kode_dept = $('#kode_dept').val();
                $.ajax({
                    type: 'POST',
                    url: '/getpresensi',
                    data: {
                        _token: '{{ csrf_token() }}',
                        tanggal: tanggal,
                        kode_cabang: kode_cabang,
                        kode_dept: kode_dept
                    },
                    cache: false,
                    success: function(respond) {
                        $("#loadpresensi").html(respond);
                    }
                });
            }
            $("#tanggal").change(function(e) {
                loadpresensi();
            });
            $("#kode_cabang").change(function(e) {
                loadpresensi();
            });
            $("#kode_dept").change(function(e) {
                loadpresensi();
            });

            loadpresensi();

        });
    </script>
@endpush
