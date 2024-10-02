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
        <div class="pageTitle">Ubah Ijin Sakit</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="row" style="margin-top: 70px">
        <div class="col">
            <form method="POST" action="/ijinsakit/{{ $dataijin->kode_ijin }}/update" id="frmIjin"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="text" id="tgl_ijin_dari" value="{{ $dataijin->tgl_ijin_dari }}" autocomplete="off"
                        name="tgl_ijin_dari" class="form-control datepicker" placeholder="Dari">
                </div>
                <div class="form-group">
                    <input type="text" id="tgl_ijin_sampai" value="{{ $dataijin->tgl_ijin_sampai }}" autocomplete="off"
                        name="tgl_ijin_sampai" class="form-control datepicker" placeholder="Sampai">
                </div>
                <div class="form-group">
                    <input type="text" id="jml_hari" name="jml_hari" class="form-control" autocomplete="off"
                        placeholder="Jumlah Hari" readonly>
                </div>
                <div class="form-group">
                    <input type="text" id="keterangan" value="{{ $dataijin->keterangan }}" name="keterangan"
                        class="form-control" autocomplete="off" placeholder="Keterangan">
                </div>

                @if ($dataijin->doc_sid != null)
                    <div class="row">
                        <div class="col-12">
                            @php
                                $docsid = Storage::url('/uploads/sid/' . $dataijin->doc_sid);
                            @endphp
                            <img src="{{ url($docsid) }}" alt="" width="100">
                        </div>
                    </div>
                @endif
                <div class="custom-file-upload" id="fileUpload1" style="height: 100px !important">
                    <input type="file" name="sid" id="fileUploadInput" accept=".png, .jpg, .jpeg">
                    <label for="fileUploadInput">
                        <span>
                            <strong>
                                <ion-icon name="cloud-upload-outline" role="img" class="md hydrated"
                                    aria-label="cloud-upload-outline"></ion-icon>
                                <i>Upload Surat Keterangan Dokter</i>
                            </strong>
                        </span>
                    </label>
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

                $('#jml_hari').val(jmlhari + " Hari");

            }
            loadjumlahhari();
            $('#tgl_ijin_dari, #tgl_ijin_sampai').change(function(e) {
                loadjumlahhari();
            });


            // $("#tgl_ijin").change(function(e) {
            //     var tgl_ijin = $(this).val();
            //     $.ajax({
            //         type: 'POST',
            //         url: '/presensi/cekpengajuanijin',
            //         data: {
            //             _token: "{{ csrf_token() }}",
            //             tgl_ijin: tgl_ijin
            //         },
            //         cache: false,
            //         success: function(respond) {
            //             if (respond == 1) {
            //                 Swal.fire({
            //                     title: 'Opss',
            //                     text: 'Anda telah mengajukan ijin pada tanggal tersebut !',
            //                     icon: 'warning'
            //                 }).then((result) => {
            //                     $("tgl_ijin").val("");
            //                 });
            //             }
            //         }
            //     });
            // });


            $("#frmIjin").submit(function() {
                var tgl_ijin_dari = $('#tgl_ijin_dari').val();
                var tgl_ijin_sampai = $('#tgl_ijin_sampai').val();
                var keterangan = $("#keterangan").val();
                if (tgl_ijin_dari == "" || tgl_ijin_sampai == "") {
                    Swal.fire({
                        title: 'Opss',
                        text: 'Tanggal Harus Diisi !',
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
