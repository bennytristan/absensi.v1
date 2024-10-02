@if ($histori->isEmpty())
    <div class="alert alert-outline-warning" style="text-align: center; font-size: 18px">
        Data Tidak Ditemukan !!
    </div>
@endif

@foreach ($histori as $d)
    <style>
        .historicontent {
            display: flex;
            margin-top: 8px;
            font-size: 15px;
        }

        .datapresensi {
            margin-left: 10px;
            margin-top: 12px;
        }

        .status {
            position: absolute;
            top: 23px;
            text-align: right;
            right: 20px;
        }

        .card {
            background: #ffffff;
            border-radius: 6px;
            border: 1px solid #00a8f3;
            box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.1), 0 1px 3px 0 rgba(0, 0, 0, 0.08);
        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }
    </style>
    @if ($d->status == 'h')
        <div class="card mb-1">
            <div class="card-body-rkp">
                <div class="historicontent">
                    <div class="iconpresensi">
                        <ion-icon name="finger-print-outline" style="font-size: 65px" class="text-success"></ion-icon>
                    </div>

                    <div class="datapresensi">
                        <h3 style="line-height: 2px">HADIR - {{ $d->nama_jam_kerja }}</h3>
                        <h4 style="margin:0px !important">
                            {{ date('d F Y', strtotime($d->tgl_presensi)) }}</h4>
                        <span>Jam Masuk :
                            {!! $d->jam_in != null ? date('H:i', strtotime($d->jam_in)) : '<span class="text-danger">Belum Absen </span>' !!}
                        </span><br>
                        <span>Jam Pulang :
                            {!! $d->jam_out != null ? date('H:i', strtotime($d->jam_out)) : '<span class="text-danger">Belum Absen </span>' !!}
                        </span>
                        <div class="keterangan">
                            @php
                                //Jam Ketika Absen
                                $jam_in = date('H:i', strtotime($d->jam_in));
                                //Jam Jadwal Masuk
                                $jam_masuk = date('H:i', strtotime($d->jam_masuk));

                                $jadwal_jam_masuk = $d->tgl_presensi . ' ' . $jam_masuk;
                                $jam_presensi = $d->tgl_presensi . ' ' . $jam_in;
                            @endphp

                            @if ($jam_in > $jam_masuk)
                                @php
                                    $jmlterlambat = hitungjamterlambat($jadwal_jam_masuk, $jam_presensi);
                                    $jmlterlambatdesimal = hitungjamterlambatdesimal($jadwal_jam_masuk, $jam_presensi);
                                @endphp
                                <span class="danger">Terlambat {{ $jmlterlambat }} </span>
                            @else
                                <span style="color:green">Tepat Waktu</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif ($d->status == 'i')
        <div class="card mb-1">
            <div class="card-body-rkp">
                <div class="historicontent">
                    <div class="iconpresensi">
                        <ion-icon name="document-text-outline" style="font-size: 65px" class="text-warning"></ion-icon>
                    </div>
                    <div class="datapresensi">
                        <h3 style="line-height: 2px">IJIN - Kode Ijin : {{ $d->kode_ijin }}</h3>
                        <h4 style="margin:0px !important">
                            {{ date('d F Y', strtotime($d->tgl_presensi)) }}</h4>
                        <span>{{ $d->keterangan }}</span>
                    </div>
                </div>
            </div>
        </div>
    @elseif ($d->status == 's')
        <div class="card mb-1">
            <div class="card-body-rkp">
                <div class="historicontent">
                    <div class="iconpresensi">
                        <ion-icon name="medkit-outline" style="font-size: 65px" class="text-danger"></ion-icon>
                    </div>
                    <div class="datapresensi">
                        <h3 style="line-height: 2px">SAKIT - Kode Ijin : {{ $d->kode_ijin }}</h3>
                        <h4 style="margin:0px !important">
                            {{ date('d F Y', strtotime($d->tgl_presensi)) }}</h4>
                        <span>{{ $d->keterangan }}</span>
                        <br>
                        @if (!empty($d->doc_sid))
                            <span style="color:blue">
                                <ion-icon name="document-attach-outline"></ion-icon> SKD Terlampir
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @elseif ($d->status == 'c')
        <div class="card mb-1">
            <div class="card-body-rkp">
                <div class="historicontent">
                    <div class="iconpresensi">
                        <ion-icon name="calendar-outline" style="font-size: 65px" class="text-primary"></ion-icon>
                    </div>
                    <div class="datapresensi">
                        <h3 style="line-height: 2px">CUTI - Kode Cuti : {{ $d->kode_ijin }}</h3>
                        <h4 style="margin:0px !important">
                            {{ date('d F Y', strtotime($d->tgl_presensi)) }}</h4>
                        <span class="text-info">{{ $d->nama_cuti }}</span>
                        <br>
                        <span>{{ $d->keterangan }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
