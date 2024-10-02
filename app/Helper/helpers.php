<?php
function hitungjamterlambat($jadwal_jam_masuk, $jam_presensi)
{
    $j1 = strtotime($jadwal_jam_masuk);
    $j2 = strtotime($jam_presensi);

    $diffterlambat = $j2 - $j1;

    $jamterlambat = floor($diffterlambat / (60 * 60));
    $menitterlambat = floor(($diffterlambat - ($jamterlambat * (60 * 60))) / 60);

    $jterlambat = $jamterlambat <= 9 ? "0" . $jamterlambat : $jamterlambat;
    $mterlambat = $menitterlambat <= 9 ? "0" . $menitterlambat : $menitterlambat;

    $terlambat = $jterlambat. ":". $mterlambat;
    return $terlambat;

}
//hitung jam terlambat desimal
function hitungjamterlambatdesimal($jam_masuk_desimal, $jam_presensi){

    $j1 = strtotime($jam_masuk_desimal);
    $j2 = strtotime($jam_presensi);

    $diffterlambat = $j2 - $j1;

    $jamterlambat = floor($diffterlambat / (60 * 60));
    $menitterlambat = floor(($diffterlambat - ($jamterlambat * (60 * 60))) / 60);

    $jterlambat = $jamterlambat <= 9 ? "0" . $jamterlambat : $jamterlambat;
    $mterlambat = $menitterlambat <= 9 ? "0" . $menitterlambat : $menitterlambat;

    $desimalterlambat = ROUND(($menitterlambat / 60), 2);
    return $desimalterlambat;
}

//hitung hari
function hitunghari($tgl_mulai, $tgl_akhir){
    $tgl_1 = date_create($tgl_mulai);
    $tgl_2 = date_create($tgl_akhir); //waktu sekarang
    $diff = date_diff($tgl_1, $tgl_2);
    return $diff->days + 1;
}

//Hitung denda
 /*
    Aturan :
    Terlambat < 5 menit = 0
    Terlambat 5 - 9 menit = 5000;
    Terlambat 10 - 14 menit = 10.000
    Terlambat 15 - 59 menit = 15.000
    Terlambat > 1 jam = upah dipotong per jam kerja
    */
function hitungdenda($terlambat){
    $ja_terlambat = explode(":", $terlambat);
    $jam = intval($ja_terlambat[0]) * 1;
    $menit = intval($ja_terlambat[1]) * 1;

    if($jam < 1){
        if($menit >= 5 && $menit < 10){
            $denda = 5000;
        }else if($menit >= 10 && $menit < 16){
            $denda = 10000;
        }else if($menit >= 16){
            $denda = 15000;
        }else{
            $denda = 0;
        }
    }else{
        $denda = 25000;
    }
    return $denda;
}

function formatRupiah($nominal, $prefix = false){

    if($prefix){
        return "Rp. " . number_format($nominal, 0, ',', '.');
    }
    return number_format($nominal, 0, ',', '.');
}


// buat nomor urut otomatis
function buatkode($no_akhir, $kunci, $jml_karakter = 0)
{
$no_baru = intval(substr($no_akhir, strlen($kunci)))+1;
$no_baru1 = str_pad($no_baru, $jml_karakter, "0", STR_PAD_LEFT);
$kode = $kunci . $no_baru1;
return $kode;
}

//hitung jam kerja
function hitungjmljamkerja($tgl_presensi, $jam_mulai, $jam_pulang, $max_total_jam, $lintashari, $jam_awal_istirahat, $jam_akhir_istirahat)
    {

        if($lintashari == '1'){
            $tgl_pulang = date('Y-m-d', strtotime("+1 days", strtotime($tgl_presensi)));
        }else{
            $tgl_pulang = $tgl_presensi;
        }
        $jam_mulai = $tgl_presensi . " " . $jam_mulai;
        $jam_pulang = !empty($jam_berakhir) ? $tgl_pulang . " " . $jam_berakhir : "";

        //dijalankan saat jam istirahat berlaku
        if($jam_awal_istirahat != "NA"){
            $jam_awal_istirahat = $tgl_pulang . " " . $jam_awal_istirahat;
            $jam_akhir_istirahat = $tgl_pulang . " " . $jam_akhir_istirahat;

            if($jam_pulang > $jam_awal_istirahat && $jam_pulang <= $jam_akhir_istirahat){
                $jam_pulang = $jam_awal_istirahat;
            }
        }
        $j_mulai = strtotime($jam_mulai);
        $j_pulang = strtotime($jam_pulang);
        $diff = $j_pulang - $j_mulai;
        if (empty($j_pulang)) {
            $jam = 0;
            $menit = 0;
        } else {
            $jam = floor($diff / (60 * 60)); //Dikurangi 1 Jam Istirahat
            $m = $diff - $jam * (60 * 60);
            $menit =  floor( $m / 60 );
        }
        $menitdesimal = ROUND($menit / 60, 2);
        /*
        komdisi perhitungan :
        Jika Karyawan Pulang setelah jam istirahat maka Total Jam Kerja Dikurangi 1 Jam
        Jika kurang dari 1 jam istirahat Tidak di kurangi 1 jam
        */
        if($jam_awal_istirahat != "NA"){
            if($jam_pulang > $jam_akhir_istirahat){
                $jam_istirahat = 1;
            }else{
                $jam_istirahat = 0;
            }
        }else{
            $jam_istirahat = 0;
        }

        $jamdesimal = $jam - $jam_istirahat + $menitdesimal;
        $totaljam = $jamdesimal > $max_total_jam ? $max_total_jam : $jamdesimal;

        return $totaljam;
    }


    function selisihjk($jam_masuk, $jam_pulang){
        $J_masuk = strtotime($jam_masuk);
        $j_pulang = strtotime($jam_pulang);
        $diff = $j_pulang - $J_masuk;
        if (empty($j_pulang)) {
            $jam = 0;
            $menit = 0;
        } else {
            $jam = floor($diff / (60 * 60));
            $m = $diff - $jam * (60 * 60);
            $menit =  floor( $m / 60 );
        }
        return $jam ." Jam " . $menit. " Menit";
    }


function getkaryawanlibur($dari, $sampai)
{
    $datalibur = DB::table('hari_libur_detail')
    ->join('hari_libur', 'hari_libur_detail.kode_libur', "=", 'hari_libur.kode_libur')
    ->whereBetween('tgl_libur', [$dari, $sampai])
    ->get();

    $karyawanlibur = [];
    foreach($datalibur as $d){
        $karyawanlibur[] = [
            'nik' => $d->nik,
            'tgl_libur' => $d->tgl_libur,
        ];
    }
    return $karyawanlibur;
}

function cetakkaryawanlibur($array, $search_list)
{
    $result = array();
    foreach ($array as $key => $value) {
        foreach ($search_list as $k => $v){
            if(!isset($value[$k]) || $value[$k] != $v){
                continue 2;
            }
        }
        $result[] = $value;
    }
    return $result;
}

function gethari($hari)
    {

        switch ($hari) {
            case 'Sun':
                $hari_ini = "Minggu";
                break;
            case 'Mon':
                $hari_ini = "Senin";
                break;

            case 'Tue':
                $hari_ini = "Selasa";
                break;

            case 'Wed':
                $hari_ini = "Rabu";
                break;

            case 'Thu':
                $hari_ini = "Kamis";
                break;

            case 'Fri':
                $hari_ini = "Jumat";
                break;

            case 'Sat':
                $hari_ini = "Sabtu";
                break;

        }
        return $hari_ini;
    }


    function selisih($jam_masuk, $jam_keluar)
{
    [$h, $m, $s] = explode(':', $jam_masuk);
    $dtAwal = mktime($h, $m, $s, '1', '1', '1');
    [$h, $m, $s] = explode(':', $jam_keluar);
    $dtAkhir = mktime($h, $m, $s, '1', '1', '1');
    $dtSelisih = $dtAkhir - $dtAwal;
    $totalmenit = $dtSelisih / 60;
    $jam = explode('.', $totalmenit / 60);
    $sisamenit = $totalmenit / 60 - $jam[0];
    $sisamenit2 = $sisamenit * 60;
    $jml_jam = $jam[0];
    return $jml_jam . ':' . round($sisamenit2);
}


