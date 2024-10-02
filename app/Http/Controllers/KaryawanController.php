<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $kode_dept = Auth::guard('user')->user()->kode_dept;
        $kode_cabang = Auth::guard('user')->user()->kode_cabang;
        $user = User::find(Auth::guard('user')->user()->id);

        $query = Karyawan::query();
        $query->select('karyawan.*', 'nama_dept','nama_cabang');
        $query->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept');
        $query->join('cabang', 'karyawan.kode_cabang', '=', 'cabang.kode_cabang');
        $query->orderBy('nik', 'desc');

        if (!empty($request->nama_karyawan)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_karyawan . '%');
        }
        if (!empty($request->kode_dept)) {
            $query->where('karyawan.kode_dept', $request->kode_dept);
        }
        if (!empty($request->kode_cabang)) {
            $query->where('karyawan.kode_cabang', $request->kode_cabang);
        }

        if($user->hasRole('admin departemen')){
            $query->where('karyawan.kode_dept', $kode_dept);
            $query->where('karyawan.kode_cabang', $kode_cabang);
        }
        $karyawan = $query->paginate(10);
        $departemen = DB::table('departemen')->get();
        $cabang = DB::table('cabang')->get();

        return view('karyawan.index', compact('karyawan', 'departemen', 'cabang'));
    }

    public function store(Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $password = Hash::make('12345');
        $kode_cabang = $request->kode_cabang;
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = null;
        }

        try {
            $data = [
                'nik' => $nik,
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'kode_dept' => $kode_dept,
                'foto' => $foto,
                'password' => $password,
                'kode_cabang' => $kode_cabang
            ];
            $simpan = DB::table('karyawan')->insert($data);
            if ($simpan) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/karyawan/";
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
            }
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                $pesan = "Data Dengan Nik ". $nik. " Sudah Ada !!";
            }else{
                $pesan = "Data Gagal Disimpan Harap Hubungi IT";
            }
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan '. $pesan]);
        }
    }

    public function edit(Request $request)
    {
        $nik = $request->nik;
        $departemen = DB::table('departemen')->get();
        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('karyawan.edit', compact('departemen', 'karyawan', 'cabang'));
    }

    public function update($nik, Request $request)
    {
        $nik = Crypt::decrypt($nik);
        $nik_baru = $request->nik_baru;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $password = Hash::make('12345');
        $kode_cabang = $request->kode_cabang;
        $old_foto = $request->old_foto;
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $old_foto;
        }
        $cek = DB::table('karyawan')
        ->where('nik', $nik_baru)
        ->where('nik', '!=', $nik)
        ->count();
        if($cek > 0){
            return Redirect::back()->with(['warning' => 'Data Gagal Diubah!! Nik Tersebut Sudah Digunakan']);
        }
        try {
            $data = [
                'nik' => $nik_baru,
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'kode_dept' => $kode_dept,
                'foto' => $foto,
                'kode_cabang' => $kode_cabang,
                'password' => $password
            ];
            $update = DB::table('karyawan')->where('nik', $nik)->update($data);
            if ($update) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/karyawan/";
                    $folderPathOld = "public/uploads/karyawan/" . $old_foto;
                    Storage::delete($folderPathOld);
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Diubah']);
            }
        } catch (\Exception $e) {

            return Redirect::back()->with(['warning' => 'Data Gagal Diubah']);
        }
    }

    public function delete($nik)
    {
        $delete = DB::table('karyawan')->where('nik', $nik)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
    }

    public function resetpass($nik)
    {
        $nik = Crypt::decrypt($nik);
        $password = Hash::make('12345');
        $reset = DB::table('karyawan')->where('nik', $nik)->update([
                'password' => $password
        ]);

        if($reset){
            return Redirect::back()->with(['success' => 'Password Berhasil Dipulihkan']);
        }else{
        return Redirect::back()->with(['warning' => 'Password Gagal Dipulihkan']);
        }
    }

    public function locklokasi($nik)
    {
        try {
            $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
            $status_lokasi = $karyawan->status_lokasi;
            if($status_lokasi == '1'){
                DB::table('karyawan')->where('nik', $nik)->update([
                    'status_lokasi' => '0'
                ]);
            }else{
                DB::table('karyawan')->where('nik', $nik)->update([
                    'status_lokasi' => '1'
            ]);
            }
            return Redirect::back()->with(['success' => 'Status Lokasi Berhasil Diubah']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Status Lokasi Gagal Diubah !!']);
        }
    }

    public function lockjamkerja($nik)
    {
        try {
            $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
            $status_jamkerja = $karyawan->status_jamkerja;
            if($status_jamkerja == '1'){
                DB::table('karyawan')->where('nik', $nik)->update([
                    'status_jamkerja' => '0'
                ]);
            }else{
                DB::table('karyawan')->where('nik', $nik)->update([
                    'status_jamkerja' => '1'
            ]);
            }
            return Redirect::back()->with(['success' => 'Status Jam Kerja Berhasil Diubah']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Status Jam Kerja Gagal Diubah !!']);
        }
    }


}
