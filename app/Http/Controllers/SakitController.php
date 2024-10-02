<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SakitController extends Controller
{
    public function create()
    {
        return view('sakit.create');
    }

    public function storeijinsakit(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_ijin_dari = $request->tgl_ijin_dari;
        $tgl_ijin_sampai = $request->tgl_ijin_sampai;
        $status = "s";
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

        if($request->hasFile('sid')){
            $sid = $kode_ijin. "." .$request->file('sid')->getClientOriginalExtension();
        }else{
            $sid = null;
        }

        $data = [
            'kode_ijin' => $kode_ijin,
            'nik' => $nik,
            'tgl_ijin_dari' => $tgl_ijin_dari,
            'tgl_ijin_sampai' => $tgl_ijin_sampai,
            'status' => $status,
            'keterangan' => $keterangan,
            'doc_sid' => $sid
        ];
        //Cek Sdh Absen atau Belum
        $cekpresensi = DB::table('presensi')
        ->whereBetween('tgl_presensi', [$tgl_ijin_dari, $tgl_ijin_sampai])
        ->where('nik', $nik);
        //Cek Pengajuan Ijin
        $cekpengajuan = DB::table('pengajuan_ijin')
        ->where('nik', $nik)
        ->whereRaw('"'.$tgl_ijin_dari. '"BETWEEN Tgl_ijin_dari AND tgl_ijin_sampai');
        $datapresensi = $cekpresensi->get();

        if($cekpresensi->count() > 0){
            $tglpenuh = "";
            foreach($datapresensi as $d){
                $tglpenuh .= date('d-m-Y', strtotime($d->tgl_presensi)) .", " ;
            }
            return redirect('presensi/dataijin')->with(['error' => 'Anda sudah pernah mengajukan IJIN di tanggal : '.$tglpenuh.' tersebut. Maaf pengajuan Anda tidak bisa dilanjutkan!!']);
        }else if($cekpengajuan->count() > 0){
            return redirect('presensi/dataijin')->with(['error' => 'Tidak Bisa Melakukan Pengajuan Karena Ada Tanggal Sebelumnya Sudah Digunakan!!']);
        }
        else{

        $simpan = DB::table('pengajuan_ijin')->insert($data);
        if ($simpan) {
            if($request->hasFile('sid')){
                $sid = $kode_ijin. "." .$request->file('sid')->getClientOriginalExtension();
                $folderPath = "public/uploads/sid/";
                $request->file('sid')->storeAs($folderPath, $sid);
                }
            return redirect('presensi/dataijin')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return redirect('presensi/dataijin')->with(['error' => 'Data Gagal Disimpan']);
        }
    }
    }

    public function edit($kode_ijin)
    {
        $dataijin = DB::table('pengajuan_ijin')->where('kode_ijin', $kode_ijin)->first();
        return view('sakit.edit', compact('dataijin'));
    }


    public function update($kode_ijin, Request $request)
    {
        $tgl_ijin_dari = $request->tgl_ijin_dari;
        $tgl_ijin_sampai = $request->tgl_ijin_sampai;
        $keterangan = $request->keterangan;

        if($request->hasFile('sid')){
            $sid = $kode_ijin. "." .$request->file('sid')->getClientOriginalExtension();
        }else{
            $sid = null;
        }
        $data = [
            'tgl_ijin_dari' => $tgl_ijin_dari,
            'tgl_ijin_sampai' => $tgl_ijin_sampai,
            'keterangan' => $keterangan,
            'doc_sid' => $sid
        ];

        try {
            DB::table('pengajuan_ijin')
            ->where('kode_ijin', $kode_ijin)
            ->update($data);
                if($request->hasFile('sid')){
                    $sid = $kode_ijin. "." .$request->file('sid')->getClientOriginalExtension();
                    $folderPath = "public/uploads/sid/";
                    $request->file('sid')->storeAs($folderPath, $sid);
                    }
                return redirect('presensi/dataijin')->with(['success' => 'Data Berhasil Diubah']);
        } catch (\Exception $e) {
            return redirect('presensi/dataijin')->with(['error' => 'Data Gagal Diubah']);
        }
    }


}
