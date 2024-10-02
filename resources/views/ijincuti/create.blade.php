@extends('layout.presensi')
@section('header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <style>
        .datepicker-modal {
            max-height: 430px !important;
        }

        .datepicker-date-display {
            background-color: #0f3a7e
        }
    </style>

    <div class="appHeader bg-primary text-light">
        <div class="pageTitle">Form Pengajuan Cuti</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="row" style="margin-top: 70px">
        <div class="col">
            <form method="POST" action="/ijincuti/storeijincuti" id="frmijin">
                @csrf
                <div class="form-group">
                    <input type="text" id="tgl_ijin_dari" autocomplete="off" name="tgl_ijin_dari"
                        class="form-control datepicker" placeholder="Dari">
                </div>
                <div class="form-group">
                    <input type="text" id="tgl_ijin_sampai" autocomplete="off" name="tgl_ijin_sampai"
                        class="form-control datepicker" placeholder="Sampai">
                </div>
                <div class="form-group">
                    <input type="hidden" id="jml_hari" name="jml_hari" class="form-control" autocomplete="off"
                        placeholder="Jumlah Hari" readonly>
                    <p id="info_jmlhari_cuti"></p>
                </div>
                <div class="form-group">
                    <select name="kode_cuti" id="kode_cuti" class="form-control selectmaterialize">
                        <option value="">Pilih Jenis Cuti</option>
                        @foreach ($mastercuti as $d)
                            <option value="{{ $d->kode_cuti }}">{{ $d->nama_cuti }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="hidden" id="max_cuti" name="max_cuti" class="form-control" autocomplete="off"
                        placeholder="Sisa Cuti" readonly>
                    <p id="info_max_cuti"></p>
                </div>
                <div class="form-group">
                    <input type="text" id="keterangan" name="keterangan" class="form-control" autocomplete="off"
                        placeholder="Keterangan">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Kirim</button>
                </div>
            </form>
        </div>
    </div>

    </div>
    </div>
@endsection

@push('myscript')
    <script>
        var currYear = (new Date()).getFullYear();

        $(document).ready(function() {
            $(".datepicker").datepicker({
                format: "yyyy-mm-dd"
            });

            function loadjumlahhari() {
                var dari = $("#tgl_ijin_dari").val();
                var sampai = $("#tgl_ijin_sampai").val();
                var date1 = new Date(dari);
                var date2 = new Date(sampai);

                var Difference_In_Time = date2.getTime() - date1.getTime();
                var Difference_In_Day = Difference_In_Time / (1000 * 3600 * 24);

                if (dari == "" || sampai == "") {
                    var jmlhari = "0";
                } else {
                    var jmlhari = Difference_In_Day + 1;
                }
                $('#jml_hari').val(jmlhari);
                $("#info_jmlhari_cuti").html(
                    "<b>Jumlah Hari Cuti Yang Diambil : " + jmlhari +
                    " Hari</b>");
            }

            $('#tgl_ijin_dari, #tgl_ijin_sampai').change(function(e) {
                loadjumlahhari();
            });

            $("#frmijin").submit(function() {
                var tgl_ijin_dari = $("#tgl_ijin_dari").val();
                var tgl_ijin_sampai = $("#tgl_ijin_sampai").val();
                var jml_hari = $("#jml_hari").val();
                var max_cuti = $("#max_cuti").val();
                var kode_cuti = $("#kode_cuti").val();
                var keterangan = $("#keterangan").val();
                if (tgl_ijin_dari == "" || tgl_ijin_sampai == "") {
                    Swal.fire({
                        title: 'Opss',
                        text: 'Tanggal Harus Diisi !',
                        icon: 'warning'
                    });
                    return false;

                } else if (kode_cuti == "") {
                    Swal.fire({
                        title: 'Opss',
                        text: 'Jenis Cuti Belum Dipilih!',
                        icon: 'warning'
                    });
                    return false;

                } else if (keterangan == "") {
                    Swal.fire({
                        title: 'Opss',
                        text: 'Keterangan Harus Diisi !',
                        icon: 'warning'
                    });
                    return false;

                } else if (parseInt(jml_hari) > parseInt(max_cuti)) {
                    Swal.fire({
                        title: 'Opss',
                        text: 'Jumlah Hari Cuti Tidak Boleh Melebihi ' + maxcuti + ' Hari',
                        icon: 'warning'
                    });
                    return false;

                }
            });

            $("#kode_cuti").change(function(e) {
                var kode_cuti = $(this).val();
                var tgl_ijin_dari = $("#tgl_ijin_dari").val();
                if (tgl_ijin_dari == "") {
                    Swal.fire({
                        title: 'Opss',
                        text: 'Silahkan isikan tanggal Cuti Dahulu!!',
                        icon: 'warning',
                    });
                    $("#kode_cuti").val("");
                } else {
                    $.ajax({
                        url: '/ijincuti/getmaxcuti',
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            kode_cuti: kode_cuti,
                            tgl_ijin_dari: tgl_ijin_dari
                        },
                        cache: false,
                        success: function(respond) {
                            $("#max_cuti").val(respond);
                            $("#info_max_cuti").html(
                                "<b>Maksimal Cuti Yang Bisa Diambil : " + respond +
                                " Hari</b>");

                        }
                    });
                }

            });
        });
    </script>
@endpush
