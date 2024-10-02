<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Setjamkerja;
use Illuminate\Http\Request;

use App\Models\Setjamkerjadept;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KonfigurasiController extends Controller
{
    public function lokasikantor()
    {
        $lok_kantor = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
        return view('konfigurasi.lokasikantor', compact('lok_kantor'));
    }

    public function updatelokasikantor(Request $request)
    {
        $lokasi_kantor = $request->lokasi_kantor;
        $radius = $request->radius;

        $update = DB::table('konfigurasi_lokasi')->where('id', 1)->update([
            'lokasi_kantor' => $lokasi_kantor,
            'radius' => $radius
        ]);

        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Diubah']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Diubah']);
        }
    }

    public function jamkerja(){

        $jam_kerja = DB::table('jam_kerja')->orderBy('kode_jam_kerja')->get();
        return view('konfigurasi.jamkerja', compact('jam_kerja'));

    }

    public function storejamkerja(Request $request){

        $kode_jam_kerja = $request->kode_jam_kerja;
        $nama_jam_kerja = $request->nama_jam_kerja;
        $awal_jam_masuk = $request->awal_jam_masuk;
        $jam_masuk = $request->jam_masuk;
        $akhir_jam_masuk = $request->akhir_jam_masuk;
        $status_rehat = $request->status_rehat;
        $awal_rehat = $request->awal_rehat;
        $akhir_rehat = $request->akhir_rehat;
        $jam_pulang = $request->jam_pulang;
        $total_jam = $request->total_jam;
        $lintashari = $request->lintashari;
        $data = [
            'kode_jam_kerja' => $kode_jam_kerja,
            'nama_jam_kerja' => $nama_jam_kerja,
            'awal_jam_masuk' => $awal_jam_masuk,
            'jam_masuk' => $jam_masuk,
            'akhir_jam_masuk' => $akhir_jam_masuk,
            'status_istirahat' =>$status_rehat,
            'awal_jam_istirahat' => $awal_rehat,
            'akhir_jam_istirahat' => $akhir_rehat,
            'jam_pulang' => $jam_pulang,
            'total_jam' => $total_jam,
            'lintashari' => $lintashari

        ];
        try {
            DB::table('jam_kerja')->insert($data);
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        } catch (Exception $e) {
            dd($e);
            if ($e->getCode() == 23000) {
                $pesan = "kode_jam_kerja ". $kode_jam_kerja. " Sudah Ada!!";
            }
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan'. $pesan]);
        }
    }

    public function editjamkerja(Request $request){
        $kode_jam_kerja = $request->kode_jam_kerja;
        $jamkerja = DB::table('jam_kerja')->where('kode_jam_kerja', $kode_jam_kerja)->first();
        return view('konfigurasi.editjamkerja', compact('jamkerja'));
    }

    public function updatejamkerja(Request $request){

        $kode_jam_kerja = $request->kode_jam_kerja;
        $nama_jam_kerja = $request->nama_jam_kerja;
        $awal_jam_masuk = $request->awal_jam_masuk;
        $jam_masuk = $request->jam_masuk;
        $akhir_jam_masuk = $request->akhir_jam_masuk;
        $status_rehat = $request->status_rehat;
        $awal_rehat = $request->awal_rehat;
        $akhir_rehat = $request->akhir_rehat;
        $jam_pulang = $request->jam_pulang;
        $total_jam = $request->total_jam;
        $lintashari = $request->lintashari;
        $data = [
            'nama_jam_kerja' => $nama_jam_kerja,
            'awal_jam_masuk' => $awal_jam_masuk,
            'jam_masuk' => $jam_masuk,
            'akhir_jam_masuk' => $akhir_jam_masuk,
            'status_istirahat' =>$status_rehat,
            'awal_jam_istirahat' => $awal_rehat,
            'akhir_jam_istirahat' => $akhir_rehat,
            'jam_pulang' => $jam_pulang,
            'total_jam' => $total_jam,
            'lintashari' => $lintashari
        ];
        try {
            DB::table('jam_kerja')->where('kode_jam_kerja', $kode_jam_kerja)->update($data);
            return Redirect::back()->with (['success' => 'Data Berhasil Diubah']);
        } catch (\Exception $e) {
            // dd($e);
            return Redirect::back()->with (['warning' => 'Data Gagal Diubah']);
        }
    }

    public function deletejamkerja($kode_jam_kerja)
    {
        $hapus = DB::table('jam_kerja')->where('kode_jam_kerja', $kode_jam_kerja)->delete();
        if ($hapus) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
    }

    public function setjamkerja($nik){

        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        $jamkerja = DB::table('jam_kerja')->orderBy('nama_jam_kerja')->get();
        $cekjamkerja = DB::table('konfigurasi_jamkerja')->where('nik', $nik)->count();
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        if ($cekjamkerja > 0){
            $setjamkerja = DB::table('konfigurasi_jamkerja')->where('nik', $nik)->get();
            return view('konfigurasi.editsetjamkerja', compact('karyawan', 'jamkerja', 'setjamkerja', 'namabulan'));
        }else{
            return view('konfigurasi.setjamkerja', compact('karyawan', 'jamkerja', 'namabulan'));
        }
    }

    public function storesetsamkerja(Request $request){
        $nik = $request->nik;
        $hari = $request->hari;
        $kode_jam_kerja = $request->kode_jam_kerja;

        for($i=0; $i < count($hari); $i++){
            $data[] = [
                'nik' => $nik,
                'hari' => $hari[$i],
                'kode_jam_kerja' => $kode_jam_kerja[$i]
            ];
          }

         try {
            Setjamkerja::insert($data);
            return Redirect("/karyawan")->with(['success' => 'Set Jam Kerja Karyawan Berhasil']);
         } catch (\Exception $e) {
            return Redirect('/karyawan')->with(['warning' => 'Set Jam Kerja Karyawan Gagal']);
         }
    }

    public function updatesetjamkerja(Request $request){
        $nik = $request->nik;
        $hari = $request->hari;
        $kode_jam_kerja = $request->kode_jam_kerja;

        for($i=0; $i < count($hari); $i++){
            $data[] = [
                'nik' => $nik,
                'hari' => $hari[$i],
                'kode_jam_kerja' => $kode_jam_kerja[$i]
            ];
          }

          DB::beginTransaction();
         try {
            DB::table('konfigurasi_jamkerja')->where('nik', $nik)->delete();
            Setjamkerja::insert($data);
            DB::commit();
            return Redirect("/karyawan")->with(['success' => 'Perubahan Jam Kerja Berhasil']);
         } catch (\Exception $e) {
            DB::rollBack();
            return Redirect('/karyawan')->with(['warning' => 'Perubahan Jam Kerja Gagal']);
         }
    }

    public function jamkerjadept()
    {
        $jamkerjadept = DB::table('konfigurasi_jk_dept')
        ->join('cabang', 'konfigurasi_jk_dept.kode_cabang', "=", 'cabang.kode_cabang')
        ->join('departemen', 'konfigurasi_jk_dept.kode_dept', "=", 'departemen.kode_dept')
        ->get();
        return view('konfigurasi.jamkerjadept', compact('jamkerjadept'));
    }

    public function createjamkerjadept()
    {
        $jamkerja = DB::table('jam_kerja')->orderBy('nama_jam_kerja')->get();
        $cabang = DB::table('cabang')->get();
        $departemen = DB::table('departemen')->get();
        return view('konfigurasi.createjamkerjadept', compact('jamkerja', 'cabang', 'departemen'));
    }

    public function storejamkerjadept(Request $request){
        $kode_cabang = $request->kode_cabang;
        $kode_dept = $request->kode_dept;
        $hari = $request->hari;
        $kode_jam_kerja = $request->kode_jam_kerja;
        $kode_jk_dept = "T". $kode_cabang . $kode_dept;

        DB::beginTransaction();
        try {
            //menyimpan ke tabel konfigurasi_jk_dept
            DB::table('konfigurasi_jk_dept')->insert([
                'kode_jk_dept' => $kode_jk_dept,
                'kode_cabang' => $kode_cabang,
                'kode_dept' => $kode_dept
            ]);

            for($i=0; $i < count($hari); $i++){
                $data[] = [
                    'kode_jk_dept' => $kode_jk_dept,
                    'hari' => $hari[$i],
                    'kode_jam_kerja' => $kode_jam_kerja[$i]
                ];
            }
            Setjamkerjadept::insert($data);
            DB::commit();
            return redirect('/konfigurasi/jamkerjadept')->with(['success' =>'Data Berhasil DiSimpan']);
            } catch (\Exception $e) {
           DB::rollBack();
           return redirect('/konfigurasi/jamkerjadept')->with(['warning' =>'Data Gagal DiSimpan']);
            }
        }


        public function editjamkerjadept($kode_jk_dept)
        {
            $jamkerja = DB::table('jam_kerja')->orderBy('nama_jam_kerja')->get();
            $cabang = DB::table('cabang')->get();
            $departemen = DB::table('departemen')->get();
            $jamkerjadept = DB::table('konfigurasi_jk_dept')->where('kode_jk_dept', $kode_jk_dept)->first();
            $jamkerjadetail = DB::table('konfigurasi_jk_dept_detail')->where('kode_jk_dept', $kode_jk_dept)->get();
            return view('konfigurasi.editjamkerjadept', compact('jamkerja', 'cabang', 'departemen', 'jamkerjadept', 'jamkerjadetail'));
        }

        public function updatejamkerjadept($kode_jk_dept, Request $request){

            $hari = $request->hari;
            $kode_jam_kerja = $request->kode_jam_kerja;

            DB::beginTransaction();
            try {

                //Hapus data jk sebelumnya
                DB::table('konfigurasi_jk_dept_detail')->where('kode_jk_dept', $kode_jk_dept)->delete();
                for($i=0; $i < count($hari); $i++){
                    $data[] = [
                        'kode_jk_dept' => $kode_jk_dept,
                        'hari' => $hari[$i],
                        'kode_jam_kerja' => $kode_jam_kerja[$i]
                    ];
                }
                Setjamkerjadept::insert($data);
                DB::commit();
                return redirect('/konfigurasi/jamkerjadept')->with(['success' =>'Data Berhasil DiSimpan']);
                } catch (\Exception $e) {
               DB::rollBack();
               return redirect('/konfigurasi/jamkerjadept')->with(['warning' =>'Data Gagal DiSimpan']);
                }
            }

            public function showjamkerjadept($kode_jk_dept)
        {
            $jamkerja = DB::table('jam_kerja')->orderBy('nama_jam_kerja')->get();
            $cabang = DB::table('cabang')->get();
            $departemen = DB::table('departemen')->get();
            $jamkerjadept = DB::table('konfigurasi_jk_dept')->where('kode_jk_dept', $kode_jk_dept)->first();
            $jamkerjadetail = DB::table('konfigurasi_jk_dept_detail')
            ->join ('jam_kerja', 'konfigurasi_jk_dept_detail.kode_jam_kerja', "=", 'jam_kerja.kode_jam_kerja')
            ->where('kode_jk_dept', $kode_jk_dept)->get();
            return view('konfigurasi.showjamkerjadept', compact('jamkerja','cabang', 'departemen', 'jamkerjadept', 'jamkerjadetail'));
        }

        public function deletejamkerjadept($kode_jk_dept)
        {
            try {
                DB::table('konfigurasi_jk_dept')->where('kode_jk_dept', $kode_jk_dept)->delete();
                return Redirect::back()->with(['success' =>'Data Berhasil Dihapus']);
            } catch (\Exception $th) {
                return Redirect::back()->with(['warning' =>'Data Gagal Dihapus']);
            }
        }

        public function storesetjamkerjabytgl(Request $request){

            $nik = $request->nik;
            $tanggal = $request->tanggal;
            $kode_jam_kerja = $request->kode_jam_kerja;
            $data = [
                'nik' => $nik,
                'tanggal' => $tanggal,
                'kode_jam_kerja' => $kode_jam_kerja
            ];

             try {
                DB::table('konfigurasi_jamkerja_by_tgl')->insert($data);
                return 0;
             } catch (\Exception $e) {
                return 1;
             }
        }

        public function getjamkerjabytgl($nik,$bulan,$tahun){

            $konfigurasijamkerjabytgl = DB::table('konfigurasi_jamkerja_by_tgl')
            ->join('jam_kerja', 'konfigurasi_jamkerja_by_tgl.kode_jam_kerja', "=", 'jam_kerja.kode_jam_kerja')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tanggal) = "' . $bulan . '"')
            ->whereRaw('YEAR(tanggal)="' . $tahun . '"')
            ->get();
            return view('konfigurasi.getjamkerjabytgl', compact('konfigurasijamkerjabytgl', 'nik'));
        }

        public function deletejamkerjabytgl(Request $request){

            $nik = $request->nik;
            $tanggal = $request->tanggal;

            try {
                DB::table('konfigurasi_jamkerja_by_tgl')->where('nik', $nik)->where('tanggal', $tanggal)->delete();
                return 0;
             } catch (\Exception $e) {
                return 1;
             }
        }

    }
