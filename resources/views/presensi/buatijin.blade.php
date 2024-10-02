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
        <div class="left">
            <a href="" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Pengajuan Ijin</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="row" style="margin-top: 70px">
        <div class="col">
            <form method="POST" action="/presensi/storeijin" id="frmIjin">
                @csrf
                <div class="form-group">
                    <input type="text" id="tgl_ijin" name="tgl_ijin" class="form-control datepicker"
                        placeholder="Tanggal">
                </div>
                <div class="form-group">
                    <select name="status" id="status" class="form-control">
                        <option value="">Ijin/Sakit</option>
                        <option value="i">ijin</option>
                        <option value="s">Sakit</option>
                    </select>
                </div>
                <div class="form-group">
                    <textarea name="keterangan" id="keterangan" cols="30" rows="6" class="form-control" placeholder="Keterangan"></textarea>
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
                format: "dd-mm-yyyy"
            });

            $("#tgl_ijin").change(function(e) {
                var tgl_ijin = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: '/presensi/cekpengajuanijin',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tgl_ijin: tgl_ijin
                    },
                    cache: false,
                    success: function(respond) {

                        if (respond == 1) {
                            Swal.fire({
                                title: 'Opss',
                                text: 'Anda telah mengajukan ijin pada tanggal tersebut !',
                                icon: 'warning'
                            }).then((result) => {
                                $("tgl_ijin").val("");
                            });
                        }
                    }
                });
            });

            $("#frmIjin").submit(function() {
                var tgl_ijin = $('#tgl_ijin').val();
                var status = $("#status").val();
                var keterangan = $("#keterangan").val();
                if (tgl_ijin == "") {
                    Swal.fire({
                        title: 'Opss',
                        text: 'Tanggal Harus Diisi !',
                        icon: 'warning',

                    });
                    return false;
                } else if (status == "") {
                    Swal.fire({
                        title: 'Opss !',
                        text: 'status[1] Harus Diisi !',
                        icon: 'warning',

                    });
                    return false;
                } else if (keterangan == "") {
                    Swal.fire({
                        title: 'Opss',
                        text: 'Keterangan Harus Diisi !',
                        icon: 'warning',

                    });
                    return false;
                }
            });
        });
    </script>
@endpush
