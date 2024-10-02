<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>A4</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4
        }

        #title {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 17px;
            font-weight: bold;
        }

        .kopatas td {
            padding-inline-end: 15px;
        }

        .tabeldatakaryawan {
            font-family: Arial, Helvetica, sans-serif;
            margin-top: 40px;
            border-collapse: collapse;

        }

        .tabeldatakaryawan td {
            padding-inline-end: 15px;
        }

        .tabelpresensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .tabelpresensi th {
            border: 1px solid black;
            background-color: rgb(204, 209, 204);
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            padding: 10px 10px;

        }

        .tabelpresensi td {
            border: 1px solid black;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            text-align: center;
            padding-top: 5px;
        }

        .foto {
            width: 55px;
            height: 55px;
        }

        .judul {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 20px;
            margin-top: 1pc;
        }

        .ttd {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4">


    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <table class="kopatas" style="width: 100%">
            <tr>
                <td style="width: 100px">
                    <img src="{{ asset('assets/img/logo2.png') }}" style="width: 210px; height: 70px;">
                </td>
            </tr>
        </table>

        <table class="judul" style="width: 100%">
            <tr>
                <td class="judul" style="text-align: center">
                    <b>Laporan Absensi Karyawan</b><br>
                    Periode Bulan : {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }}<br>
                </td>
            </tr>
        </table>

        <table class="tabeldatakaryawan">
            <tr>
                <td rowspan="6">
                    @php
                        $path = Storage::url('uploads/karyawan/' . $karyawan->foto);
                    @endphp
                    <img src="{{ url($path) }}" width="100" height="130">
                </td>
            </tr>
            <tr>
                <td>Nomor Induk Karyawan</td>
                <td>:</td>
                <td>{{ $karyawan->nik }}</td>
            </tr>
            <tr>
                <td>Nama Karyawan</td>
                <td>:</td>
                <td>{{ $karyawan->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $karyawan->jabatan }}</td>
            </tr>
            <tr>
                <td>Departemen</td>
                <td>:</td>
                <td>{{ $karyawan->nama_dept }}</td>
            </tr>
            <tr>
                <td>Nomor Handphone</td>
                <td>:</td>
                <td>{{ $karyawan->no_hp }}</td>
            </tr>
        </table>

        <table class="tabelpresensi">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Foto Masuk</th>
                <th>Jam Pulang</th>
                <th>Foto Pulang</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Total Jam Kerja</th>
            </tr>
            @foreach ($presensi as $d)
                @if ($d->status == 'h')
                    @php
                        $path_in = Storage::url('uploads/absensi/' . $d->foto_in);
                        $path_out = Storage::url('uploads/absensi/' . $d->foto_out);
                        $terlambat = hitungjamterlambat($d->jam_masuk, $d->jam_in);
                        $terlambat_desimal = hitungjamterlambatdesimal($d->jam_masuk, $d->jam_in);
                        $j_terlambat = explode(':', $terlambat);
                        $jam_terlambat = intVal($j_terlambat[0]);
                        if ($jam_terlambat < 1) {
                            $jam_mulai = $d->jam_masuk;
                        } else {
                            $jam_mulai = $d->jam_in > $d->jam_masuk ? $d->jam_in : $d->jam_masuk;
                        }
                        $jam_berakhir = $d->jam_out > $d->jam_pulang ? $d->jam_pulang : $d->jam_out;
                        $total_jam = hitungjmljamkerja(
                            $d->tgl_presensi,
                            date('H:i', strtotime($jam_mulai)),
                            date('H:i', strtotime($jam_berakhir)),
                            $d->total_jam,
                            $d->lintashari,
                            date('H:i', strtotime($d->awal_jam_istirahat)),
                            date('H:i', strtotime($d->akhir_jam_istirahat)),
                        );
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</td>
                        <td>{{ $d->jam_in }}</td>
                        <td><img src="{{ url($path_in) }}" alt="" class="foto"></td>
                        <td>{{ $d->jam_out != null ? $d->jam_out : 'Belum Absen' }}</td>
                        <td>
                            @if ($d->jam_out != null)
                                <img src="{{ url($path_out) }}" alt="" class="foto">
                            @else
                                <img src="{{ asset('assets/img/sinfoto.png') }}" alt="" class="foto">
                            @endif
                        </td>
                        <td style="text-align: center">{{ $d->status }}</td>
                        <td>
                            @if ($d->jam_in > $d->jam_masuk)
                                Terlambat {{ $terlambat }}
                            @else
                                Tepat Waktu
                            @endif
                        </td>
                        <td>
                            {{ $total_jam }}
                        </td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: center">{{ $d->status }}</td>
                        <td>{{ $d->keterangan }}</td>
                        <td></td>
                    </tr>
                @endif
            @endforeach
        </table>
        <table class="ttd" width=100% style="margin-top: 40px">
            <tr>
                <th width=245px>
                <td style="text-align: center">
                    <b>Tomohon, {{ date('d-m-Y') }}</b><br>
                    <p>
                        Kepala Bagian Personalia<br><br><br><br><br>
                        <u><b> Aldrin Wagey</b></u>
                </td>
                </th>
            </tr>
        </table>
    </section>
</body>

</html>
