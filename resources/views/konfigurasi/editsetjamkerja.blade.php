@extends('layout.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-fluid">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Perubahan Jam Kerja
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-5">
                    <table class="table">
                        <tr>
                            <th>Nik </th>
                            <th>:</th>
                            <th>{{ $karyawan->nik }}</th>
                        </tr>
                        <tr>
                            <th>Nama Lengkap </th>
                            <th>:</th>
                            <th>{{ $karyawan->nama_lengkap }}</th>
                        </tr>
                        <tr>
                            <th>Kode Kantor</th>
                            <th>:</th>
                            <th>{{ $karyawan->kode_cabang }}</th>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a href="#jamkerja_harian" class="nav-link active" data-bs-toggle="tab"
                                        aria-selected="true"
                                        role="tab"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-clock-24">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M3 12a9 9 0 0 0 5.998 8.485m12.002 -8.485a9 9 0 1 0 -18 0" />
                                            <path d="M12 7v5" />
                                            <path
                                                d="M12 15h2a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-1a1 1 0 0 0 -1 1v1a1 1 0 0 0 1 1h2" />
                                            <path d="M18 15v2a1 1 0 0 0 1 1h1" />
                                            <path d="M21 15v6" />
                                        </svg> Jam Kerja Sesuai Hari</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#jamkerja_tgl" class="nav-link" data-bs-toggle="tab" aria-selected="false"
                                        tabindex="-1"
                                        role="tab"><!-- Download SVG icon from http://tabler-icons.io/i/user -->
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
                                        Jam Kerja Sesuai Tanggal</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active show" id="jamkerja_harian" role="tabpanel">
                                    <form action="/konfigurasi/updatesetjamkerja" method="POST">
                                        @csrf
                                        <input type="hidden" name="nik" value="{{ $karyawan->nik }}">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Hari</th>
                                                    <th>Jam Kerja</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($setjamkerja as $s)
                                                    <tr>
                                                        <td>
                                                            {{ $s->hari }}
                                                            <input type="hidden" name="hari[]"
                                                                value="{{ $s->hari }}">
                                                        </td>
                                                        <td>
                                                            <select name="kode_jam_kerja[]" id="kode_jam_kerja"
                                                                class="form-select">
                                                                <option value="">Pilih Jam Kerja</option>
                                                                @foreach ($jamkerja as $d)
                                                                    <option
                                                                        {{ $d->kode_jam_kerja == $s->kode_jam_kerja ? 'selected' : '' }}
                                                                        value="{{ $d->kode_jam_kerja }}">
                                                                        {{ $d->nama_jam_kerja }}</option>
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <button class="btn btn-primary w-100" type="submit">Ubah</button>
                                    </form>
                                </div>
                                <div class="tab-pane" id="jamkerja_tgl" role="tabpanel">
                                    @include('konfigurasi.setjamkerjabytgl')
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="8">Master Jam Kerja</th>
                            </tr>
                            <tr>
                                <th>Kode Kerja</th>
                                <th>Nama Jam Kerja</th>
                                <th>Awal Jam Masuk</th>
                                <th>Jam Masuk</th>
                                <th>Akhir Jam Masuk</th>
                                <th>Jam Pulang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jamkerja as $d)
                                <tr>
                                    <td>{{ $d->kode_jam_kerja }}</td>
                                    <td>{{ $d->nama_jam_kerja }}</td>
                                    <td>{{ $d->awal_jam_masuk }}</td>
                                    <td>{{ $d->jam_masuk }}</td>
                                    <td>{{ $d->akhir_jam_masuk }}</td>
                                    <td>{{ $d->jam_pulang }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                format: "yyyy-mm-dd"
            });

            $("#tambahjamkerja").click(function(e) {
                e.preventDefault();
                var nik = "{{ $karyawan->nik }}";
                var tanggal = $("#tanggal").val();
                var kode_jam_kerja = $("#jamkerja_tgl").find("#kode_jam_kerja").val();

                if (tanggal == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Tanggal Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#tanggal").focus();
                    });
                } else if (kode_jam_kerja == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Jam Kerja Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#jamkerja_tgl").find("#kode_jam_kerja").focus();
                    });
                } else {
                    $.ajax({
                        type: 'POST',
                        url: '/konfigurasi/storesetjamkerjabytgl',
                        data: {
                            _token: '{{ csrf_token() }}',
                            nik: nik,
                            tanggal: tanggal,
                            kode_jam_kerja: kode_jam_kerja

                        },
                        cache: false,
                        success: function(respond) {
                            $("#loadpresensi").html(respond);
                            if (respond == 0) {
                                Swal.fire({
                                    title: 'Berhasil',
                                    text: 'Data Berhasil Disimpan',
                                    icon: 'success',
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    loadsetjamkerjabydate();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal',
                                    text: 'Data Gagal Disimpan',
                                    icon: 'error',
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    loadsetjamkerjabydate();
                                });
                            }
                        }
                    });
                }
            });

            function loadsetjamkerjabydate() {
                var nik = "{{ $karyawan->nik }}";
                var bulan = $("#bulan").val();
                var tahun = $("#tahun").val();
                $("#loadsetjamkerjabydate").load('/konfigurasi/' + nik + '/' + bulan + '/' + tahun +
                    '/getjamkerjabytgl');
            }
            $("#bulan, #tahun").change(function(e) {
                loadsetjamkerjabydate();
            });

        });
    </script>
@endpush
