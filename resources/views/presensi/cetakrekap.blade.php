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

        .tabelpresensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .tabelpresensi th {
            border: 1px solid black;
            background-color: rgb(227, 233, 227);
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;

        }

        .tabelpresensi td {
            border: 1px solid black;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            font-weight: bold;
        }

        .foto {
            width: 55px;
            height: 55px;
        }

        .judul {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 20px;
        }

        .ttd {
            font-family: Arial, Helvetica, sans-serif;
        }

        .foot {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
        }

        body.A4.landscape .sheer {
            width: 297mm !important;
            height: auto !important;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4 landscape">

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
                    <b>Laporan Rekapitulasi Absensi Karyawan</b><br>
                    Periode Bulan : {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }}<br>
                </td>
            </tr>
        </table>

        <table class="tabelpresensi" border="1">
            <tr>
                <th rowspan="2">NIK</th>
                <th rowspan="2">Nama Karyawan</th>
                <th colspan="{{ $jmlhari }}">Bulan {{ $namabulan[$bulan] }} {{ $tahun }}</th>
                <th rowspan="2">H</th>
                <th rowspan="2">I</th>
                <th rowspan="2">S</th>
                <th rowspan="2">C</th>
                <th rowspan="2">A</th>
            </tr>
            <tr>
                @foreach ($rangetgl as $d)
                    @if ($d != null)
                        <th>{{ date('d', strtotime($d)) }}</th>
                    @endif
                @endforeach
            </tr>
            @foreach ($rekap as $r)
                <tr>
                    <td td style="text-align: center">{{ $r->nik }}</td>
                    <td>{{ $r->nama_lengkap }}</td>

                    <?php
                    $jml_hadir = 0;
                    $jml_ijin = 0;
                    $jml_sakit = 0;
                    $jml_cuti = 0;
                    $jml_alpa = 0;
                    $color = "";
                    for ($i = 1; $i <= $jmlhari; $i++) {
                        $tgl = 'tgl_' . $i;
                        $tgl_presensi = $rangetgl[$i -1];
                        $search_items = [
                            'nik' => $r->nik,
                            'tgl_libur' => $tgl_presensi
                    ];
                    $ceklibur = cetakkaryawanlibur($datalibur, $search_items);

                    $datapresensi = explode("|", $r->$tgl);
                        if($r->$tgl != NULL){
                            $status = $datapresensi[2];
                        }else {
                            $status = "";
                        }
                        $cekhari = gethari(date("D", strtotime($tgl_presensi)));
                        if($status == "h"){
                           $jml_hadir += 1;
                           $color = "white";
                        }
                        if($status == "i"){
                           $jml_ijin += 1;
                           $color = "#ffdb4d";
                        }
                        if($status == "s"){
                           $jml_sakit += 1;
                           $color = "#ff6699";
                        }
                        if($status == "c"){
                           $jml_cuti += 1;
                           $color = "#7070db";
                        }
                        if(empty($status) && empty($ceklibur) && $cekhari != "Minggu" && $cekhari !="Sabtu"){
                            $jml_alpa += 1;
                            $color = "orange";
                        }
                        if(!empty($ceklibur)){
                            $color = "black";
                        }
                        if($cekhari == "Minggu"){
                            $color = "red";
                        }
                        if($cekhari == "Sabtu"){
                            $color = "red";
                        }
                    ?>
                    <td style="background-color: {{ $color }}">
                        {{ $status }}
                        {{-- @if ($status == 'h')
                            <span style="font-weight:bold">
                                {{ $nama_jam_kerja }}
                            </span>
                            <br>
                            <span style="color: green">
                                {{ $jam_masuk }} - {{ $jam_pulang }}
                            </span>
                            <br>
                            <span style="color: orange">
                                {{ $jam_in }} - {{ $jam_out }}
                            </span>
                            <br>
                            <span style="color: blue">
                                Total Jam = {{ $total_jam_kerja }}
                            </span>
                        @endif --}}
                    </td>
                    <?php
                    }
                    ?>
                    <td style="text-align: center">{{ !empty($jml_hadir) ? $jml_hadir : '' }}</td>
                    <td style="text-align: center">{{ !empty($jml_ijin) ? $jml_ijin : '' }}</td>
                    <td style="text-align: center">{{ !empty($jml_sakit) ? $jml_sakit : '' }}</td>
                    <td style="text-align: center">{{ !empty($jml_cuti) ? $jml_cuti : '' }}</td>
                    <td style="text-align: center">{{ !empty($jml_alpa) ? $jml_alpa : '' }}</td>
                </tr>
            @endforeach
        </table>
        {{-- <h4>Keterangan Libur :</h4>
        <ol>
            @foreach ($harilibur as $h)
                <li>{{ date('d-m-Y', strtotime($h->tgl_libur)) }} - {{ $h->keterangan }}</li>
            @endforeach
        </ol> --}}

        <table class="ttd" width=100% style="margin-top: 40px">
            <tr>
                <th width=420px>
                <td style="text-align: center">
                    <b>Tomohon, {{ date('d-m-Y') }}</b><br>
                    <p>
                        Kepala Bagian Personalia<br><br><br><br><br>
                        <u><b> Aldrin Wagey</b></u>
                </td>
                </th>
            </tr>
        </table>

        <table class="foot" width=100%>
            <tr>
                <td>Keterangan :</td>
            </tr>
            <tr>
                <td>H = HADIR</td>
            </tr>
            <tr>
                <td>I = IJIN</td>
            </tr>
            <tr>
                <td>S = SAKIT</td>
            </tr>
            <tr>
                <td>C = CUTI</td>
            </tr>
            <tr>
                <td>A = ALPA / TANPA KABAR</td>
            </tr>
        </table>

    </section>

</body>

</html>
