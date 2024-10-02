<?php

namespace App\Http\Controllers;

use App\Models\Harilibur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class HariliburController extends Controller
{
   public function index(){

    $query = Harilibur::query();
    $query->orderBy('kode_libur', 'desc');
    $harilibur = $query->paginate(10);
    $harilibur = DB::table('hari_libur')->orderBy('kode_libur', 'desc')
    ->paginate(10);
    return view('harilibur.index', compact('harilibur'));
   }

   public function create(){
    $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
    return view('harilibur.create', compact('cabang'));
   }

   public function store(Request $request){
    //format Kode Libur = HL->kode 24->tahun 001->no urut -> HL24001
    $tahun = date("Y", strtotime($request->tanggal_libur));
    $thn = substr($tahun, 2,2);
    $noakhirlibur = DB::table('hari_libur')
    ->whereRaw('YEAR(tgl_libur)="'. $tahun. '"')
    ->orderBy('kode_libur', 'desc')
    ->first();
    $noakhir = $noakhirlibur != null ? $noakhirlibur->kode_libur : "";
    $format = "HL".$thn;
    $kode_libur = buatkode($noakhir, $format,3);

    try {
       DB::table('hari_libur')
       ->insert([
            'kode_libur' =>$kode_libur,
            'tgl_libur' => $request->tanggal_libur,
            'kode_cabang' => $request->kode_cabang,
            'keterangan' => $request->keterangan
       ]);
       return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        } catch (\Exception $e) {
        return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
        }
   }

   public function edit(Request $request){

    $kode_libur = $request->kode_libur;
    $harilibur = DB::table('hari_libur')->where('kode_libur', $kode_libur)->first();
    $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
    return view('harilibur.edit', compact('cabang','harilibur'));
   }

   public function update($kode_libur, Request $request){

    try {
       DB::table('hari_libur')->where('kode_libur', $kode_libur)
       ->update([
            'tgl_libur' => $request->tanggal_libur,
            'kode_cabang' => $request->kode_cabang,
            'keterangan' => $request->keterangan
       ]);
       return Redirect::back()->with(['success' => 'Data Berhasil Diubah']);
        } catch (\Exception $e) {
        return Redirect::back()->with(['warning' => 'Data Gagal Diubah']);
        }
   }

   public function delete($kode_libur){

    try {
        DB::table('hari_libur')->where('kode_libur', $kode_libur)
        ->delete();
        return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
         } catch (\Exception $e) {
         return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
         }
   }

   public function setkaryawanlibur($kode_libur){

    $harilibur = DB::table('hari_libur')
    ->join('cabang', 'hari_libur.kode_cabang', "=", 'cabang.kode_cabang')
    ->where('kode_libur', $kode_libur)->first();
    return view('harilibur.setkaryawanlibur', compact ('harilibur'));
   }

   public function setlistkaryawanlibur($kode_libur){
       return view('harilibur.setlistkaryawanlibur', compact('kode_libur'));
   }

   public function getsetlistkaryawanlibur($kode_libur){

    $harilibur = DB::table('hari_libur')->where('kode_libur', $kode_libur)->first();
    $karyawan = DB::table('karyawan')
    ->select('karyawan.*', 'hariliburdetail.nik as ceknik')
    ->leftJoin(
        DB::raw("(
        SELECT nik FROM hari_libur_detail
        WHERE kode_libur = '$kode_libur'
        ) hariliburdetail"),
        function ($join) {
            $join->on('karyawan.nik', '=', 'hariliburdetail.nik');
        }
    )
    ->where('kode_cabang', $harilibur->kode_cabang)
    ->orderBy('nama_lengkap')
    ->get();
    return view('harilibur.getsetlistkaryawanlibur', compact('karyawan','kode_libur'));
   }

   public function storekaryawanlibur(Request $request){

    try {
        $cek = DB::table('hari_libur_detail')->where('kode_libur', $request->kode_libur)->where('nik', $request->nik)->count();
        if($cek > 0){
            return 1;
        }
        DB::table('hari_libur_detail')->insert([
        'kode_libur' => $request->kode_libur,
        'nik' => $request->nik,
       ]);
       return 0;
        } catch (\Exception $e) {
       return $e->getMessage();
        }
   }

   public function batallibur(Request $request){
    try {
        DB::table('hari_libur_detail')
        ->where('kode_libur', $request->kode_libur)
        ->where('nik', $request->nik)
        ->delete();
       return 0;
        } catch (\Exception $e) {
       return $e->getMessage();
        }
   }

   public function getkaryawanlibur($kode_libur){
    $karyawanlibur = DB::table('hari_libur_detail')
    ->join('karyawan', 'hari_libur_detail.nik', "=", 'karyawan.nik')
    ->where('kode_libur', $kode_libur)
    ->get();

    return view('harilibur.getkaryawanlibur', compact('karyawanlibur', 'kode_libur'));
   }

}
