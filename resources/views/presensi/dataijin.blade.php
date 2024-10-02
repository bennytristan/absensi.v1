@extends('layout.presensi')
@section('header')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="/" class="headerButton goBack">
                <ion-icon name="chevron-back-circle-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">DATA PENGAJUAN IJIN</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="row"style="margin-top: 70px">
        <div class="col">
            @php
                $massagesuccess = Session::get('success');
                $massageError = Session::get('error');
            @endphp
            @if (Session::get('success'))
                <div class="alert alert-success">
                    {{ $massagesuccess }}
                </div>
            @endif
            @if (Session::get('error'))
                <div class="alert alert-danger">
                    {{ $massageError }}
                </div>
            @endif
        </div>
    </div>

    <div class="row" style="z-index: 0">
        <div class="col">
            <form method="GET" action="/presensi/dataijin">
                <div class="row">
                    <div class="col-7">
                        <div class="form-group">
                            <select name="bulan" id="bulan" class="form-control selectmaterialize"
                                style="border: 1px; ">
                                <option value="">Bulan</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option {{ Request('bulan') == $i ? 'selected' : '' }} value="{{ $i }}">
                                        {{ $namabulan[$i] }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <select name="tahun" id="tahun" class="form-control selectmaterialize"
                                style="border: 1px">
                                <option value="">Tahun</option>
                                @php
                                    $tahun_awal = 2023;
                                    $tahun_sekarang = date('Y');
                                    for ($t = $tahun_awal; $t <= $tahun_sekarang; $t++) {
                                        if (Request('tahun') == $t) {
                                            $selected = 'selected';
                                        } else {
                                            $selected = '';
                                        }
                                        echo "<option $selected value='$t'>$t</option>";
                                    }
                                @endphp
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-12">
                        <button class="btn btn-primary w-100"><ion-icon name="search-outline"></ion-icon>
                            Cari Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="row" style="position: fixed; width: 100%; margin: auto; overflow-y: scroll; height: 600px;">
        <div class="col">
            @foreach ($dataaijin as $k)
                <style>
                    .historicontent {
                        display: flex;
                        margin-top: 8px;
                        margin-right: 7px;
                        font-size: 15px;
                        padding: 9px;
                    }

                    .datapresensi {
                        margin-left: 10px;
                        margin-top: 10px;
                    }

                    .status {
                        position: absolute;
                        top: 10%;
                        text-align: right;
                        right: 14px;
                    }

                    .card {
                        background: #ffffff;
                        border-radius: 6px;
                        border: 1px solid #88c0da;
                        box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.1), 0 1px 3px 0 rgba(0, 0, 0, 0.08);
                    }

                    .card:hover {
                        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
                    }
                </style>
                @php
                    if ($k->status == 'i') {
                        $status = 'Ijin';
                    } elseif ($k->status == 's') {
                        $status = 'Sakit';
                    } elseif ($k->status == 'c') {
                        $status = 'Cuti';
                    } else {
                        $status = 'Tidak Ditemukan';
                    }
                @endphp
                <div class="card mt-1 card_ijin" kode_ijin="{{ $k->kode_ijin }}" status_approved="{{ $k->status_approved }}"
                    data-toggle="modal" data-target="#actionSheetIconed">
                    <div class="card-body-dataijin">
                        <div class="historicontent">
                            <div class="iconpresensi">
                                @if ($k->status == 'i')
                                    <ion-icon name="document-text-outline" style="font-size: 40px; color:blue"></ion-icon>
                                @elseif ($k->status == 's')
                                    <ion-icon name="medkit-outline" style="font-size: 40px; color:red"></ion-icon>
                                @elseif ($k->status == 'c')
                                    <ion-icon name="calendar-outline"
                                        style="font-size: 40px; color:rgb(255, 230, 0)"></ion-icon>
                                @endif
                            </div>
                            <div class="datapresensi">
                                <h3 style="line-height: 2px">{{ date('d-m-Y', strtotime($k->tgl_ijin_dari)) }}
                                    ({{ $status }})
                                </h3>
                                <small>{{ date('d F Y', strtotime($k->tgl_ijin_dari)) }} s/d
                                    {{ date('d F Y', strtotime($k->tgl_ijin_sampai)) }}</small><br>
                                {{ hitunghari($k->tgl_ijin_dari, $k->tgl_ijin_sampai) }} Hari Kerja

                                <p class="ket " style="text-align: justify">{{ $k->keterangan }}<br>
                                    @if ($k->status == 'c')
                                        <span class="badge bg-success">{{ $k->nama_cuti }}</span>
                                    @endif
                                    @if (!empty($k->doc_sid))
                                        <span style="color:blue">
                                            <ion-icon name="document-attach-outline"></ion-icon>
                                            SKD Terlampir
                                        </span>
                                    @endif
                                </p>
                            </div>

                            <div class="status">
                                @if ($k->status_approved == 0)
                                    <span class="badge badge-warning">Menunggu</span>
                                @elseif ($k->status_approved == 1)
                                    <span class="badge badge-success">Disetujui</span>
                                @elseif ($k->status_approved == 2)
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>





                {{-- <ul class="listview image-listview">
                    <li>
                        <div class="item">
                            <div class="in">
                                <div>
                                    <b>{{ date('d-m-Y', strtotime($k->tgl_ijin_dari)) }} |
                                        ({{ $k->status == 's' ? 'Sakit' : 'Ijin' }})
                                    </b><br>
                                    <small class="text-muted">{{ $k->keterangan }}</small>
                                </div>
                                @if ($k->status_approved == 0)
                                    <span class="badge bg-warning">Menunggu</span>
                                @elseif ($k->status_approved == 1)
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif ($k->status_approved == 2)
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </div>
                        </div>
                    </li>
                </ul> --}}
            @endforeach
        </div>
    </div>

    <div class="fab-button animate bottom-right dropdown" style="margin-bottom: 70px">
        <a href="#" class="fab bg-primary-dataijin" data-toggle="dropdown">
            <ion-icon name="add-outline" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item bg-primary-dataijin" href="/ijinabsen">
                <ion-icon name="document-text-outline" role="img" class="md hydrated"
                    aria-label="image outline"></ion-icon>
                <p>Ijin</p>

            </a>
            <a class="dropdown-item bg-primary-dataijin" href="/ijinsakit">
                <ion-icon name="document-text-outline" role="img" class="md hydrated"
                    aria-label="videocam outline"></ion-icon>
                <p>Sakit</p>

            </a>
            <a class="dropdown-item bg-primary-dataijin" href="/ijincuti">
                <ion-icon name="document-text-outline" role="img" class="md hydrated"
                    aria-label="videocam outline"></ion-icon>
                <p>Ajukan Cuti</p>
            </a>
        </div>
    </div>

    <div class="modal fade action-sheet" id="actionSheetIconed" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aksi</h5>
                </div>
                <div class="modal-body" id="showact">

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade dialogbox" id="deleteConfirm" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Yakin Dihapus ?</h5>
                </div>
                <div class="modal-body">
                    Data Pengajuan Ijin Akan Dihapus
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <a href="#" class="btn btn-text-secondary" data-dismiss="modal">Batalkan</a>
                        <a href="" class="btn btn-text-primary" id="hapuspengajuan">Hapus</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(function() {
            $(".card_ijin").click(function(e) {
                var kode_ijin = $(this).attr("kode_ijin");
                var status_approved = $(this).attr("status_approved");

                if (status_approved == 1) {
                    Swal.fire({
                        title: 'Opss!',
                        text: 'Data Sudah Diotorisasi, Tidak Dapat Diubah!!',
                        icon: 'warning'
                    })
                } else {
                    $("#showact").load('/dataijin/' + kode_ijin + '/showact');
                }
            });
        });
    </script>
@endpush
