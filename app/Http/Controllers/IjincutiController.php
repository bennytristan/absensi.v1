<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IjincutiController extends Controller
{
    public function create()
    {
        $mastercuti = DB::table('master_cuti')->orderBy('kode_cuti')->get();
        return view('ijincuti.create', compact('mastercuti'));
    }

    public function storeijincuti(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_ijin_dari = $request->tgl_ijin_dari;
        $tgl_ijin_sampai = $request->tgl_ijin_sampai;
        $status = "c";
        $kode_cuti = $request->kode_cuti;
        $keterangan = $request->keterangan;

        $bulan = date("m", strtotime($tgl_ijin_dari));
        $tahun = date("Y", strtotime($tgl_ijin_dari));
        $thn = substr($tahun, 2,2);

        $noakhir = DB::table('pengajuan_ijin')
        ->whereRaw('MONTH(tgl_ijin_dari)="'. $bulan. '"')
        ->whereRaw('YEAR(tgl_ijin_dari)="'. $tahun. '"')
        ->orderBy('kode_ijin', 'desc')
        ->first();

        $noijinakhir = $noakhir != null ? $noakhir->kode_ijin : "";
        $format = "IJ".$bulan.$thn;
        $kode_ijin = buatkode($noijinakhir, $format,3);
        $data = [
            'kode_ijin' => $kode_ijin,
            'nik' => $nik,
            'tgl_ijin_dari' => $tgl_ijin_dari,
            'tgl_ijin_sampai' => $tgl_ijin_sampai,
            'status' => $status,
            'kode_cuti' => $kode_cuti,
            'keterangan' => $keterangan
        ];
        //Hitung Selisih Hari
        $jmlhari = hitunghari($tgl_ijin_dari, $tgl_ijin_sampai);
        //cek max hari cuti
        $cuti = DB::table('master_cuti')->where('kode_cuti', $kode_cuti)->first();
        $jmlharicuti = $cuti->jml_hari;
        //Cek jml cuti dalam 1 tahun aktif
        $cutidigunakan = DB::table('presensi')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
        ->where('status', 'c')
        ->where('nik', $nik)
        ->count();
        //Sisa Cuti
        $sisacuti = $jmlharicuti - $cutidigunakan;

        //Cek Sdh Absen atau Belum
        $cekpresensi = DB::table('presensi')
        ->whereBetween('tgl_presensi', [$tgl_ijin_dari, $tgl_ijin_sampai])
        ->where('nik', $nik);
        //Cek Pengajuan Ijin
        $cekpengajuan = DB::table('pengajuan_ijin')
        ->where('nik', $nik)
        ->whereRaw('"'.$tgl_ijin_dari. '"BETWEEN Tgl_ijin_dari AND tgl_ijin_sampai');
        $datapresensi = $cekpresensi->get();

        if($jmlhari > $sisacuti){
            return redirect('presensi/dataijin')->with(['error' => 'Pengajuan Anda Melebihi Batas Hari Cuti Dalam 1 Tahun : Sisa Hari Cuti Anda '.$sisacuti. ' Hari']);
        }else if($cekpresensi->count() > 0){
            $tglpenuh = "";
            foreach($datapresensi as $d){
                $tglpenuh .= date('d-m-Y', strtotime($d->tgl_presensi)) .", " ;
            }
            return redirect('presensi/dataijin')->with(['error' => 'Anda sudah pernah mengajukan CUTI di tanggal : '.$tglpenuh.' tersebut. Maaf pengajuan Anda tidak bisa dilanjutkan!!']);
        }else if($cekpengajuan->count() > 0){
            return redirect('presensi/dataijin')->with(['error' => 'Anda Sudah Pernah Mengajukan di tanggal dan bulan..Maaf !!']);
        }
        else{
        $simpan = DB::table('pengajuan_ijin')->insert($data);
        if ($simpan) {
            return redirect('presensi/dataijin')->with(['success' => 'Data Berhasil Dikirim']);
        } else {
            return redirect('presensi/dataijin')->with(['error' => 'Data Gagal Dikirim']);
        }
    }
    }

    public function edit($kode_ijin)
    {
        $mastercuti = DB::table('master_cuti')->orderBy('kode_cuti')->get();
        $dataijin = DB::table('pengajuan_ijin')->where('kode_ijin', $kode_ijin)->first();
        return view('ijincuti.edit', compact('dataijin', 'mastercuti'));

    }

    public function update ($kode_ijin, Request $request)
    {
        $tgl_ijin_dari = $request->tgl_ijin_dari;
        $tgl_ijin_sampai = $request->tgl_ijin_sampai;
        $keterangan = $request->keterangan;
        $kode_cuti = $request->kode_cuti;

        try {
            $data = [
                'tgl_ijin_dari' => $tgl_ijin_dari,
                'tgl_ijin_sampai' => $tgl_ijin_sampai,
                'kode_cuti' => $kode_cuti,
                'keterangan' => $keterangan
            ];
            DB::table('pengajuan_ijin')->where('kode_ijin', $kode_ijin)->update($data);
            return redirect('presensi/dataijin')->with(['success' => 'Data Berhasil Diubah']);

        } catch (\Exception $e) {
            return redirect('presensi/dataijin')->with(['error' => 'Data Gagal Diubah']);
        }
    }

    public function getmaxcuti(Request $request){
        $nik = Auth::guard('karyawan')->user()->nik;
        $kode_cuti = $request->kode_cuti;
        $tgl_ijin_dari = $request->tgl_ijin_dari;
        $tahun_cuti = date('Y', strtotime($tgl_ijin_dari));
        $cuti = DB::table('master_cuti')->where('kode_cuti', $kode_cuti)->first();

        if($kode_cuti == "C01"){
            $cuti_digunakan = DB::table('presensi')
            ->join('pengajuan_ijin', 'presensi.kode_ijin', "=", 'pengajuan_ijin.kode_ijin')
            ->where('presensi.status', 'c')
            ->where('kode_cuti', 'C01')
            ->whereRaw('YEAR(tgl_presensi)="' .$tahun_cuti. '"')
            ->where('presensi.nik', $nik)
            ->count();
            $max_cuti = $cuti->jml_hari - $cuti_digunakan;
        }else{
            $max_cuti = $cuti->jml_hari;
        }
        return $max_cuti;
    }
}
