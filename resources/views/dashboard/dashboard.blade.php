@extends('layout.presensi')

@section('content')
    <style>
        .logout {
            position: absolute;
            color: white;
            margin-top: 9px;
            font-size: 30px;
            text-decoration: none;
            right: 11px;
        }

        .logout:hover {
            color: white;
        }

        .avatar-wrapper {
            position: relative;
            margin-top: 0px;
            margin-left: 7px;
            height: 60px;
            width: 60px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 1px 1px 15px -5px rgb(248, 247, 247);
            transition: all .3s ease;
        }

        .profile-pic {
            height: 100%;
            width: 100%;
            transition: all .3s ease;

            &:after {
                font-family: FontAwesome;
                content: "\f007";
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                position: absolute;
                font-size: 190px;
                background: #ecf0f1;
                color: #34495e;
                text-align: center;
            }
        }
    </style>
    <div id="appCapsule">
        <div class="section" id="user-section">
            <a href="/proseslogout" class="logout">
                <ion-icon name="exit-outline"></ion-icon>
            </a>
            <div id="user-detail">
                <div class="avatar-wrapper">
                    @if (!empty(Auth::guard('karyawan')->user()->foto))
                        @php
                            $path = Storage::url('uploads/karyawan/' . Auth::guard('karyawan')->user()->foto);
                        @endphp
                        <img class="profile-pic" src="{{ url($path) }}" alt="avatar" class="imaged w64"
                            style="height: 60px">
                    @else
                        <img class="profile-pic" src="assets/img/sample/avatar/avatar1.jpg" alt="avatar"
                            class="imaged w76">
                    @endif
                </div>
                <div id="user-info" class="mt-1">
                    <h3 class="user-name-dash" id="user-name">{{ Auth::guard('karyawan')->user()->nama_lengkap }}</h3>
                    <span id="user-role">{{ Auth::guard('karyawan')->user()->jabatan }} -</span>
                    <span id="user-role">{{ $cabang->nama_cabang }}</span>
                    <br>
                    <span id="user-role">{{ $departemen->nama_dept }}</span>
                </div>
            </div>
        </div>

        <div class="section" id="menu-section">
            <div class="card">
                <div class="card-body text-center">
                    <div class="list-menu">
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="/editprofil" class="green" style="font-size: 40px;">
                                    <ion-icon name="person-sharp"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Profil</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="/presensi/dataijin" class="danger" style="font-size: 40px;">
                                    <ion-icon name="calendar-number"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Cuti</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="/presensi/historis" class="warning" style="font-size: 40px;">
                                    <ion-icon name="document-text"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Histori</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="" class="orange" style="font-size: 40px;">
                                    <ion-icon name="location"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                Lokasi
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section mt3" id="presence-section">
            <div class="todaypresence">
                <div class="row">
                    <div class="col-6">
                        <div class="card gradasigreen">
                            <div class="card-body-absen">
                                <div class="presencecontent">
                                    <div class="iconpresence">
                                        @if ($presensihariini != null)
                                            @if ($presensihariini->foto_in != null)
                                                @php
                                                    $path = Storage::url(
                                                        'uploads/absensi/' . $presensihariini->foto_in,
                                                    );
                                                @endphp
                                                <img src="{{ url($path) }}" alt="" class="imaged w64">
                                            @else
                                                <ion-icon name="camera"></ion-icon>
                                            @endif
                                        @else
                                            <ion-icon name="camera"></ion-icon>
                                        @endif
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="presencetitle">MASUK</h4>
                                        <span
                                            class="absensi">{{ $presensihariini != null ? $presensihariini->jam_in : 'Belum Absen' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="card gradasired">
                            <div class="card-body-absen">
                                <div class="presencecontent">
                                    <div class="iconpresence">
                                        @if ($presensihariini != null && $presensihariini->jam_out != null)
                                            @if ($presensihariini->foto_out != null)
                                                @php
                                                    $path = Storage::url(
                                                        'uploads/absensi/' . $presensihariini->foto_out,
                                                    );
                                                @endphp
                                                <img src="{{ url($path) }}" alt="" class="imaged w64">
                                            @else
                                                <ion-icon name="camera"></ion-icon>
                                            @endif
                                        @else
                                            <ion-icon name="camera"></ion-icon>
                                        @endif
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="presencetitle">PULANG</h4>
                                        <span
                                            class="absensi">{{ $presensihariini != null && $presensihariini->jam_out != null ? $presensihariini->jam_out : 'Belum Absen' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="rekappresensi">
                <h1 style="font-size: 13px">Rekapitulasi Absensi Bulan {{ $namabulan[$bulanini] }} Tahun
                    {{ $tahunini }} :</h1>
                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem">
                                <span class="badge bg-danger"
                                    style="position: absolute; top:3px; right:2px; font-size: 0.6rem;
                                    z-index:999">{{ $rekappresensi->jmlhadir }}</span>
                                <ion-icon name="accessibility-outline" style="font-size: 1.6rem"
                                    class="text-primary mb-1"></ion-icon>
                                <br>
                                <span style="font-size: 0.8rem; font-weight: 500">Hadir</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem">
                                <span class="badge bg-danger"
                                    style="position: absolute; top:3px; right:2px; font-size: 0.6rem;
                                z-index:999">{{ $rekappresensi->jmlijin }}</span>
                                <ion-icon name="newspaper-outline" style="font-size: 1.6rem"
                                    class="text-success mb-1"></ion-icon>
                                <br>
                                <span style="font-size: 0.8rem">Ijin</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem">
                                <span class="badge bg-danger"
                                    style="position: absolute; top:3px; right:2px; font-size: 0.6rem;
                                z-index:999">{{ $rekappresensi->jmlsakit }}</span>
                                <ion-icon name="medkit-outline" style="font-size: 1.6rem"
                                    class="text-warning mb-1"></ion-icon>
                                <br>
                                <span style="font-size: 0.8rem">Sakit</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem">
                                <span class="badge bg-danger"
                                    style="position: absolute; top:3px; right:2px; font-size: 0.6rem;
                                z-index:999">{{ $rekappresensi->jmlcuti }}</span>
                                <ion-icon name="calendar-outline" style="font-size: 1.6rem"
                                    class="text-danger mb-1"></ion-icon>
                                <br>
                                <span style="font-size: 0.8rem">Cuti</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="presencetab mt-1">
                <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                    <ul class="nav nav-tabs style1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                Bulan Ini
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                Leaderboard
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-1" style="margin-bottom:100px;">
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        @foreach ($historibulanini as $d)
                            <style>
                                .historicontent {
                                    display: flex;
                                    font-size: 15px;
                                    margin-top: 12px;
                                }

                                .datapresensi {
                                    margin-left: 10px;
                                }
                            </style>
                            @if ($d->status == 'h')
                                <div class="card mb-1" style="border: 1px solid rgb(98, 163, 224)">
                                    <div class="card-body-rkp">
                                        <div class="historicontent">
                                            <div class="iconpresensi-h">
                                                <ion-icon name="finger-print-outline" style="font-size: 45px"
                                                    class="text-success"></ion-icon>
                                            </div>

                                            <div class="datapresensi">
                                                <h3 style="line-height: 2px">HADIR - {{ $d->nama_jam_kerja }}
                                                </h3>
                                                <h4 style="margin:0px !important">
                                                    {{ date('d F Y', strtotime($d->tgl_presensi)) }}</h4>
                                                <span>Masuk :
                                                    {!! $d->jam_in != null ? date('H:i', strtotime($d->jam_in)) : '<span class="text-danger">Belum Absen </span>' !!}
                                                </span> |
                                                <span>Pulang :
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
                                                            $jmlterlambat = hitungjamterlambat(
                                                                $jadwal_jam_masuk,
                                                                $jam_presensi,
                                                            );
                                                        @endphp
                                                        <span class="danger">Terlambat : {{ $jmlterlambat }}</span>
                                                    @else
                                                        <span style="color:green">Tepat Waktu</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif ($d->status == 'i')
                                <div class="card mb-1"style="border: 1px solid rgb(98, 163, 224)">
                                    <div class="card-body-rkp">
                                        <div class="historicontent">
                                            <div class="iconpresensi-h">
                                                <ion-icon name="document-text-outline" style="font-size: 45px"
                                                    class="text-warning"></ion-icon>
                                            </div>
                                            <div class="datapresensi">
                                                <h3 style="line-height: 2px">IJIN - Kode Ijin :
                                                    {{ $d->kode_ijin }}
                                                </h3>
                                                <h4 style="margin:0px !important">
                                                    {{ date('d F Y', strtotime($d->tgl_presensi)) }}</h4>
                                                <span>{{ $d->keterangan }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif ($d->status == 's')
                                <div class="card mb-1" style="border: 1px solid rgb(98, 163, 224)">
                                    <div class="card-body-rkp">
                                        <div class="historicontent">
                                            <div class="iconpresensi-h">
                                                <ion-icon name="medkit-outline" style="font-size: 45px"
                                                    class="text-danger"></ion-icon>
                                            </div>
                                            <div class="datapresensi">
                                                <h3 style="line-height: 2px">SAKIT - Kode Ijin :
                                                    {{ $d->kode_ijin }}
                                                </h3>
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
                                <div class="card mb-1" style="border: 1px solid rgb(98, 163, 224)">
                                    <div class="card-body-rkp">
                                        <div class="historicontent">
                                            <div class="iconpresensi-h">
                                                <ion-icon name="calendar-outline" style="font-size: 45px"
                                                    class="text-primary"></ion-icon>
                                            </div>
                                            <div class="datapresensi">
                                                <h3 style="line-height: 2px">CUTI - Kode Cuti :
                                                    {{ $d->kode_ijin }}
                                                </h3>
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
                    </div>

                    <div class="tab-pane fade" id="profile" role="tabpanel">
                        <ul class="listview image-listview">
                            @foreach ($leaderboard as $b)
                                <li>
                                    <div class="item">
                                        {{-- <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image"> --}}
                                        <div class="in">
                                            <div>
                                                <b>{{ $b->nama_lengkap }}</b><br>
                                                <small class="text-muted">Jabatan : {{ $b->jabatan }}</small><br>
                                                <small class="text-muted">Devisi : {{ $b->nama_dept }}</small>
                                            </div>
                                            <span
                                                class="badge {{ $b->jam_in < '08:00' ? 'badge-success' : 'badge-danger' }}"
                                                style="font-size: 0.8rem">
                                                {{ $b->jam_in }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach


                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->
@endsection
