<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Models\Pengajuanijin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class PresensiController extends Controller
{
    public function gethari($hari)
    {
        // $hari = date("D");
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

            default;
                $hari_ini = "Tidak di ketahui";
                break;
        }
        return $hari_ini;
    }

    public function create($kode_jam_kerja)
    {
        $kode_jam_kerja = $kode_jam_kerja != "null" ? Crypt::decrypt($kode_jam_kerja) : $kode_jam_kerja;
        $nik = Auth::guard('karyawan')->user()->nik;
        $hariini = date("Y-m-d");
        $jamsekarang = date("H:i");
        $tgl_sebelumnya = date('Y-m-d', strtotime("-1 days", strtotime($hariini)));
        $cekpresensi_sebelumnya = DB::table('presensi')
            ->join('jam_kerja', 'presensi.kode_jam_kerja', "=", 'jam_kerja.kode_jam_kerja')
            ->where('tgl_presensi', $tgl_sebelumnya)
            ->where('nik', $nik)
            ->first();

        $ceklintashari_presensi = $cekpresensi_sebelumnya != null ? $cekpresensi_sebelumnya->lintashari : 0;
        if ($ceklintashari_presensi == 1) {
            if ($jamsekarang < "08:00") {
                $hariini = $tgl_sebelumnya;
            }
        }
        $namahari = $this->gethari(date('D', strtotime($hariini)));

        $kode_dept = Auth::guard('karyawan')->user()->kode_dept;
        $presensi = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nik', $nik);
        $cek = $presensi->count();
        $datacek = $presensi->first();
        $kode_cabang = Auth::guard('karyawan')->user()->kode_cabang;
        $lok_kantor = DB::table('cabang')->where('kode_cabang', $kode_cabang)->first();

        if($kode_jam_kerja == "null"){
            //cek jam kerja per tanggal
            $jamkerja = DB::table('konfigurasi_jamkerja_by_tgl')
            ->join('jam_kerja', 'konfigurasi_jamkerja_by_tgl.kode_jam_kerja', "=", 'jam_kerja.kode_jam_kerja')
            ->where('nik', $nik)
            ->where('tanggal', $hariini)
            ->first();

            if ($jamkerja == null) {
            //cek jam kerja harian perorangan
                $jamkerja = DB::table('konfigurasi_jamkerja')
                ->join('jam_kerja', 'konfigurasi_jamkerja.kode_jam_kerja', "=", 'jam_kerja.kode_jam_kerja')
                ->where('nik', $nik)->where('hari', $namahari)->first();

            if ($jamkerja == null) {
                //cek jam kerja departemen
                $jamkerja = DB::table('konfigurasi_jk_dept_detail')
                ->join('konfigurasi_jk_dept', 'konfigurasi_jk_dept_detail.kode_jk_dept', "=", 'konfigurasi_jk_dept.kode_jk_dept')
                ->join('jam_kerja', 'konfigurasi_jk_dept_detail.kode_jam_kerja', "=", 'jam_kerja.kode_jam_kerja')
                ->where('kode_dept', $kode_dept)
                ->where('kode_cabang', $kode_cabang)
                ->where('hari', $namahari)->first();
            }
            }
        }else {
            $jamkerja = DB::table('jam_kerja')->where('kode_jam_kerja', $kode_jam_kerja)->first();
        }
        if ($datacek != null && $datacek->status != "h") {
            return view('presensi.notifijin');
        } else if ($jamkerja == null) {
            return view('presensi.notifjadwal');
        } else {
            return view('presensi.create', compact('cek', 'lok_kantor', 'jamkerja', 'hariini', 'kode_jam_kerja'));
        }
    }

    public function store(Request $request)
    {
        $kode_jam_kerja = $request->kode_jam_kerja;
        $nik = Auth::guard('karyawan')->user()->nik;
        $status_lokasi = Auth::guard('karyawan')->user()->status_lokasi;
        $hariini = date("Y-m-d)");
        $jamsekarang = date("H:i");
        $tgl_sebelumnya = date('Y-m-d', strtotime("-1 days", strtotime($hariini)));
        $cekpresensi_sebelumnya = DB::table('presensi')
            ->join('jam_kerja', 'presensi.kode_jam_kerja', "=", 'jam_kerja.kode_jam_kerja')
            ->where('tgl_presensi', $tgl_sebelumnya)
            ->where('nik', $nik)
            ->first();

        $ceklintashari_presensi = $cekpresensi_sebelumnya != null ? $cekpresensi_sebelumnya->lintashari : 0;

        $kode_cabang = Auth::guard('karyawan')->user()->kode_cabang;
        $kode_dept = Auth::guard('karyawan')->user()->kode_dept;
        $tgl_presensi = $ceklintashari_presensi == 1 && $jamsekarang < "08:00" ? $tgl_sebelumnya : date("Y-m-d");
        $jam = date('H:i:s');
        $lok_kantor = DB::table('cabang')->where('kode_cabang', $kode_cabang)->first();
        $lok = explode(",", $lok_kantor->lokasi_cabang);
        $latitudekantor = $lok[0];
        $longtitudekantor = $lok[1];
        $lokasi = $request->lokasi;
        $lokasiuser = explode(',', $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longtitudeuser = $lokasiuser[1];

        $jarak = $this->distance($latitudekantor, $longtitudekantor, $latitudeuser, $longtitudeuser);
        $radius = round($jarak["meters"]);

        //cek hari dan jam kerja karyawan
        $namahari = $this->gethari(date('D', strtotime($tgl_presensi)));

        if($kode_jam_kerja == "null"){
            //cek jam kerja per tanggal
            $jamkerja = DB::table('konfigurasi_jamkerja_by_tgl')
            ->join('jam_kerja', 'konfigurasi_jamkerja_by_tgl.kode_jam_kerja', "=", 'jam_kerja.kode_jam_kerja')
            ->where('nik', $nik)
            ->where('tanggal', $hariini)
            ->first();

            if ($jamkerja == null) {
                //cek jam kerja harian perorangan
                $jamkerja = DB::table('konfigurasi_jamkerja')
                ->join('jam_kerja', 'konfigurasi_jamkerja.kode_jam_kerja', "=", 'jam_kerja.kode_jam_kerja')
                ->where('nik', $nik)->where('hari', $namahari)->first();

            if ($jamkerja == null) {
                //cek jam kerja departemen
                $jamkerja = DB::table('konfigurasi_jk_dept_detail')
                ->join('konfigurasi_jk_dept', 'konfigurasi_jk_dept_detail.kode_jk_dept', "=", 'konfigurasi_jk_dept.kode_jk_dept')
                ->join('jam_kerja', 'konfigurasi_jk_dept_detail.kode_jam_kerja', "=", 'jam_kerja.kode_jam_kerja')
                ->where('kode_dept', $kode_dept)
                ->where('kode_cabang', $kode_cabang)
                ->where('hari', $namahari)->first();
                }
            }
        }else{
            $jamkerja = DB::table('jam_kerja')->where('kode_jam_kerja', $kode_jam_kerja)->first();
        }

        $presensi = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik);
        $cek = $presensi->count();
        $datapresensi = $presensi->first();
        if ($cek > 0) {
            $ket = "out";
        } else {
            $ket = "in";
        }
        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formatName = $nik . "-" . $tgl_presensi . '-' . $ket;
        $image_parts = explode(";base64,", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . '.png';
        $file = $folderPath . $fileName;

        $tgl_pulang = $jamkerja->lintashari == 1 ? date('Y-m-d', strtotime("+ 1 days", strtotime($tgl_presensi))) : $tgl_presensi;
        $jam_pulang = $tgl_presensi . " " . $jam;
        $jamkerja_pulang = $tgl_pulang . " " . $jamkerja->jam_pulang;
        // $datakaryawan = DB::table('karyawan')->where('nik', $nik)->first();
        // $no_hp - $datakaryawan->no_hp;
        if ($status_lokasi == 1 && $radius > $lok_kantor->radius_cabang) {
            echo "error|Maaf Anda berada diluar Radius Kantor, Jarak Anda " . $radius . " Meter|radius";
        } else {
            if ($cek > 0) {
                if ($jam_pulang < $jamkerja_pulang) {
                    echo "error|Maaf.. Belum Waktunya Pulang|out";
                } else if (!empty($datapresensi->jam_out)) {
                    echo "error|Maaf.. Anda Telah Melakukan Absen Pulang Sebelumnya|out";
                } else {
                    $data_pulang = [
                        'jam_out' => $jam,
                        'foto_out' => $fileName,
                        'lokasi_out' => $lokasi,
                    ];
                    $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($data_pulang);
                    if ($update) {
                        echo "success|Terima Kasih, Hati-hati Dijalan|out";
                        Storage::put($file, $image_base64);
                    } else {
                        echo "error|Gagal Absen Harap Hubungi Tim IT|out";
                    }
                }
            } else {
                if ($jam < $jamkerja->awal_jam_masuk) {
                    echo "error|Maaf.. Belum Waktunya Melakukan Absensi|in";
                } else if ($jam > $jamkerja->akhir_jam_masuk) {
                    echo "error|Maaf.. Waktu Absensi Sudah Habis!!|in";
                } else {
                    $data = [
                        'nik' => $nik,
                        'tgl_presensi' => $tgl_presensi,
                        'jam_in' => $jam,
                        'foto_in' => $fileName,
                        'lokasi_in' => $lokasi,
                        'kode_jam_kerja' => $jamkerja->kode_jam_kerja,
                        'status' => 'h',
                    ];
                    $simpan = DB::table('presensi')->insert($data);
                    if ($simpan) {
                        echo "success|Terima Kasih, Selamat Bekerja|in";
                        Storage::put($file, $image_base64);
                    } else {
                        echo "error|Gagal Absen  Harap Hubungi Tim IT|in";
                    }
                }
            }
        }
    }

    //Menghitung jarak titik koordinat pada 2 titik
    public function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editprofil()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('presensi.editprofil', compact('karyawan'));
    }

    public function updateprofil(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        $request->validate([
            'foto' => 'image|mimes:png,jpg,jpeg|max:1024',
        ]);

        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $karyawan->foto;
        }

        if (empty($password)) {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'foto' => $foto,
            ];
        } else {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'password' => $password,
                'foto' => $foto,
            ];
        }

        $update = DB::table('karyawan')->where('nik', $nik)->update($data);
        if ($update) {
            if ($request->hasFile('foto')) {
                $folderPath = "public/uploads/karyawan/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return Redirect::back()->with(['error' => 'Data Gagal Diupdate']);
        }
    }

    public function historis()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.historis', compact('namabulan'));
    }

    public function gethistori(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;

        $histori = DB::table('presensi')
            ->select('presensi.*', 'keterangan', 'jam_kerja.*', 'doc_sid', 'nama_cuti')
            ->leftJoin('jam_kerja', 'presensi.kode_jam_kerja', '=', 'Jam_kerja.kode_jam_kerja')
            ->leftJoin('pengajuan_ijin', 'presensi.kode_ijin', '=', 'pengajuan_ijin.kode_ijin')
            ->leftJoin('master_cuti', 'pengajuan_ijin.kode_cuti', '=', 'master_cuti.kode_cuti')
            ->where('presensi.nik', $nik)
            ->whereRaw('MONTH(tgl_presensi) = "' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->orderBy('tgl_presensi')
            ->get();

        return view('presensi.gethistori', compact('histori'));
    }

    public function dataijin(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;

        if (!empty($request->bulan) && !empty($request->tahun)) {
            $dataaijin = DB::table('pengajuan_ijin')
                ->leftJoin('master_cuti', 'pengajuan_ijin.kode_cuti', "=", 'master_cuti.kode_cuti')
                ->orderBy('tgl_ijin_dari', 'desc')
                ->where('nik', $nik)
                ->whereRaw('MONTH(tgl_ijin_dari)="' . $request->bulan . '"')
                ->whereRaw('YEAR(tgl_ijin_dari)="' . $request->tahun . '"')
                ->get();
        } else {
            $dataaijin = DB::table('pengajuan_ijin')
                ->leftJoin('master_cuti', 'pengajuan_ijin.kode_cuti', "=", 'master_cuti.kode_cuti')
                ->orderBy('tgl_ijin_dari', 'desc')
                ->where('nik', $nik)->limit(5)->orderBy('tgl_ijin_dari', 'desc')
                ->get();
        }
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.dataijin', compact('dataaijin', 'namabulan'));
    }

    public function buatijin()
    {
        return view('presensi.buatijin');
    }

    public function storeijin(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_ijin_dari = $request->tgl_ijin_dari;
        $status = $request->status;
        $keterangan = $request->keterangan;
        $data = [
            'nik' => $nik,
            'tgl_ijindari' => $tgl_ijin_dari,
            'status' => $status,
            'keterangan' => $keterangan,
        ];
        $simpan = DB::table('pengajuan_ijin')->insert($data);
        if ($simpan) {
            return redirect('presensi/dataijin')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return redirect('presensi/dataijin')->with(['error' => 'Data Gagal Disimpan']);
        }
    }

    public function monitoring()
    {
        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        $departemen = DB::table('departemen')->orderBy('kode_dept')->get();
        return view('presensi.monitoring', compact('cabang', 'departemen'));
    }

    public function getpresensi(Request $request)
    {
        $kode_dept = Auth::guard('user')->user()->kode_dept;
        $kode_cabang = Auth::guard('user')->user()->kode_cabang;
        $user = User::find(Auth::guard('user')->user()->id);
        $tanggal = $request->tanggal;
        $query = Karyawan::query();
        $query->selectRaw('karyawan.nik, dataabsen.id, nama_lengkap, karyawan.kode_dept, karyawan.kode_cabang, jam_in, jam_out, foto_in, foto_out, lokasi_in, dataabsen.kode_ijin, lokasi_out, dataabsen.status, jam_masuk, nama_jam_kerja, jam_pulang, keterangan'
        );
        $query->leftJoin(
            DB::raw("(
            SELECT
            presensi.nik, presensi.id, jam_in, jam_out, foto_in, foto_out, lokasi_in, lokasi_out, presensi.status, jam_masuk, nama_jam_kerja, jam_pulang, keterangan, presensi.kode_ijin
            FROM presensi
            LEFT JOIN jam_kerja ON presensi.kode_jam_kerja = jam_kerja.kode_jam_kerja
            LEFT JOIN pengajuan_ijin ON presensi.kode_ijin = pengajuan_ijin.kode_ijin

            WHERE tgl_presensi = '$tanggal'
            ) dataabsen"),
            function ($join) {
                $join->on('karyawan.nik', '=', 'dataabsen.nik');
            }
        );
        if (!empty($request->kode_cabang)) {
            $query->where('karyawan.kode_cabang', $request->kode_cabang);
        }
        if (!empty($request->kode_dept)) {
            $query->where('karyawan.kode_dept', $request->kode_dept);
        }
        if ($user->hasRole('admin departemen')) {
            $query->where('kode_cabang', $kode_cabang);
            $query->where('kode_dept', $kode_dept);
        }
        $query->orderBy('nik', 'desc');
        $presensi = $query->get();

        //Query langsung ke Tabel db
        // if($user->hasRole('admin departemen')){
        //     $presensi = DB::table('presensi')
        //     ->select('presensi.*', 'nama_lengkap', 'nama_dept', 'jam_masuk', 'nama_jam_kerja','jam_masuk', 'jam_pulang', 'keterangan')
        //     ->leftJoin('jam_kerja', 'presensi.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
        //     ->leftJoin('pengajuan_ijin', 'presensi.kode_ijin', '=', 'pengajuan_ijin.kode_ijin')
        //     ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
        //     ->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept')
        //     ->where('tgl_presensi', $tanggal)
        //     ->where('karyawan.kode_dept', $kode_dept)
        //     ->where('karyawan.kode_cabang', $kode_cabang)
        //     ->get();
        // }else if($user->hasRole('administrator')){
        //     $presensi = DB::table('presensi')
        //     ->select('presensi.*', 'nama_lengkap', 'nama_dept', 'jam_masuk', 'nama_jam_kerja','jam_masuk', 'jam_pulang', 'keterangan')
        //     ->leftJoin('jam_kerja', 'presensi.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
        //     ->leftJoin('pengajuan_ijin', 'presensi.kode_ijin', '=', 'pengajuan_ijin.kode_ijin')
        //     ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
        //     ->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept')
        //     ->where('tgl_presensi', $tanggal)
        //     ->get();
        // }
        return view('presensi.getpresensi', compact('presensi', 'tanggal'));
    }

    public function showmaps(Request $request)
    {
        $id = $request->id;
        $presensi = DB::table('presensi')->where('id', $id)
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->first();
        return view('presensi.showmaps', compact('presensi'));
    }

    public function laporan()
    {
        $kode_dept = Auth::guard('user')->user()->kode_dept;
        $kode_cabang = Auth::guard('user')->user()->kode_cabang;
        $user = User::find(Auth::guard('user')->user()->id);

        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        if ($user->hasRole('admin departemen')) {
            $karyawan = DB::table('karyawan')
                ->where('karyawan.kode_dept', $kode_dept)
                ->where('karyawan.kode_cabang', $kode_cabang)
                ->orderBy('nama_lengkap')->get();
        } else if ($user->hasRole('administrator')) {
            $karyawan = DB::table('karyawan')
                ->orderBy('nama_lengkap')->get();
        }
        return view('presensi.laporan', compact('namabulan', 'karyawan'));
    }

    public function cetaklaporan(Request $request)
    {
        $nik = $request->nik;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = DB::table('karyawan')->where('nik', $nik)
            ->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept')
            ->first();

        $presensi = DB::table('presensi')
            ->select('presensi.*', 'keterangan', 'jam_kerja.*')
            ->leftJoin('jam_kerja', 'presensi.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->leftJoin('pengajuan_ijin', 'presensi.kode_ijin', '=', 'pengajuan_ijin.kode_ijin')
            ->where('presensi.nik', $nik)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->orderBy('tgl_presensi', )
            ->get();

        if (isset($_POST['exportxml'])) {
            $time = date("d-m-Y H:i:s");
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");
            //Mendefinisikan nama file eksport "hasi-esport.xls"
            header("Content-Disposition: attacment; filename= Laporan Absensi Karyawan $time.xls");
            return view('presensi.cetaklaporanexcel', compact('bulan', 'tahun', 'namabulan', 'karyawan', 'presensi'));
        }
        return view('presensi.cetaklaporan', compact('bulan', 'tahun', 'namabulan', 'karyawan', 'presensi'));
    }

    public function rekap()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $departemen = DB::table('departemen')->get();
        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        return view('presensi.rekap', compact('namabulan', 'departemen', 'cabang'));
    }

    public function cetakrekap(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $kode_dept = $request->kode_dept;
        $kode_cabang = $request->kode_cabang;
        // $dari = $tahun . "-" . $bulan . "-01";
        // $sampai = date('Y-m-t', strtotime($dari));

        // cetak laporan per periode 21 Jan s/d 20 Feb tahun berjalan
        if($bulan == 1){
            $blnlalu = 12;
            $thnlalu = $tahun -1;
        }else{
            $blnlalu = $bulan -1;
            $thnlalu = $tahun;
        }
        $dari = $thnlalu."-". $blnlalu. "-21";
        $sampai = $tahun. "-". $bulan. "-20";

        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $datalibur = getkaryawanlibur($dari, $sampai);
        $harilibur = DB::table('hari_libur')->whereBetWeen('tgl_libur', [$dari, $sampai])->get();

        $select_date = "";
        $field_date = "";
        $t = 1;
        while (strtotime($dari) <= strtotime($sampai)) {
            $rangetgl[] = $dari;

            $select_date .= "MAX(IF(tgl_presensi = '$dari',
		    CONCAT(
		    IFNULL(jam_in, 'NA'),'|',
		    IFNULL(jam_out, 'NA'),'|',
		    IFNULL(presensi.status, 'NA'),'|',
            IFNULL(nama_jam_kerja, 'NA'),'|',
		    IFNULL(jam_masuk, 'NA'),'|',
		    IFNULL(jam_pulang, 'NA'),'|',
		    IFNULL(presensi.kode_ijin, 'NA'),'|',
		    IFNULL(keterangan, 'NA'),'|',
            IFNULL(total_jam, 'NA'),'|',
            IFNULL(lintashari, 'NA'),'|',
            IFNULL(awal_jam_istirahat, 'NA'),'|',
            IFNULL(akhir_jam_istirahat, 'NA'),'|'
		    ),NULL)) as tgl_" . $t . ",";

            $field_date .= "tgl_" . $t . ",";
            $t++;
            $dari = date("Y-m-d", strtotime("+1 day", strtotime($dari)));

        }

        $jmlhari = count($rangetgl);
        $lastrange = $jmlhari - 1;
        $sampai = $rangetgl[$lastrange];

        if ($jmlhari == 30) {
            array_push($rangetgl, null);
        } else if ($jmlhari == 29) {
            array_push($rangetgl, null, null);
        } else if ($jmlhari == 28) {
            array_push($rangetgl, null, null, null);
        }
        $query = Karyawan::query();
        $query->selectRaw(
            "$field_date karyawan.nik, nama_lengkap, jabatan"
        );

        $query->leftJoin(
            DB::raw("(
        SELECT
        $select_date
        presensi.nik
		FROM presensi
		LEFT JOIN jam_kerja ON presensi.kode_jam_kerja = jam_kerja.kode_jam_kerja
		LEFT JOIN pengajuan_ijin ON presensi.kode_ijin = pengajuan_ijin.kode_ijin
        WHERE tgl_presensi BETWEEN '$rangetgl[0]' AND '$sampai'
		GROUP BY nik
        ) presensi"),
            function ($join) {
                $join->on('karyawan.nik', '=', 'presensi.nik');
            }
        );
        if (!empty($kode_dept)) {
            $query->where('kode_dept', $kode_dept);
        }
        if (!empty($kode_cabang)) {
            $query->where('kode_cabang', $kode_cabang);
        }

        $query->orderBy('nama_lengkap');
        $rekap = $query->get();

        if (isset($_POST['exportxml'])) {
            $time = date("d-m-Y H:i:s");
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");
            //Mendefinisikan nama file eksport "hasi-esport.xls"
            header("Content-Disposition: attacment; filename= Laporan Rekap $time.xls");
        }
        $data = ['bulan', 'tahun', 'namabulan', 'rekap', 'rangetgl', 'jmlhari', 'datalibur', 'harilibur'];

        if ($request->jenis_laporan == 1) {
            return view('presensi.cetakrekap', compact($data));
        } else if ($request->jenis_laporan == 2) {
            return view('presensi.cetakrekap_detail', compact($data));
        }

    }

    public function ijinsakit(Request $request)
    {

        $kode_dept = Auth::guard('user')->user()->kode_dept;
        $kode_cabang = Auth::guard('user')->user()->kode_cabang;
        $user = User::find(Auth::guard('user')->user()->id);

        $query = Pengajuanijin::query();
        $query->select('kode_ijin', 'tgl_ijin_dari', 'tgl_ijin_sampai', 'pengajuan_ijin.nik', 'nama_lengkap', 'karyawan.kode_cabang', 'karyawan.kode_dept', 'jabatan', 'status', 'status_approved', 'keterangan', 'doc_sid');
        $query->join('karyawan', 'pengajuan_ijin.nik', '=', 'karyawan.nik');
        if (!empty($request->dari) && !empty($request->sampai)) {
            $query->whereBetween('tgl_ijin_dari', [$request->dari, $request->sampai]);
        }

        if (!empty($request->nik)) {
            $query->where('pengajuan_ijin.nik', $request->nik);
        }

        if (!empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }

        if ($request->status_approved == '0' || $request->status_approved == '1' || $request->status_approved == '2') {
            $query->where('status_approved', $request->status_approved);
        }
        if ($user->hasRole('admin departemen')) {
            $query->where('karyawan.kode_dept', $kode_dept);
            $query->where('karyawan.kode_cabang', $kode_cabang);
        }
        if (!empty($request->kode_cabang)) {
            $query->where('karyawan.kode_cabang', $request->kode_cabang);
        }
        if (!empty($request->kode_dept)) {
            $query->where('karyawan.kode_dept', $request->kode_dept);
        }

        $query->orderBy('tgl_ijin_dari', 'desc');
        $ijinsakit = $query->paginate(10);
        $ijinsakit->appends($request->all());
        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        $departemen = DB::table('departemen')->orderBy('kode_dept')->get();

        return view('presensi.ijinsakit', compact('ijinsakit', 'cabang', 'departemen'));
    }

    public function approveijinsakit(Request $request)
    {
        $status_approved = $request->status_approved;
        $kode_ijin = $request->kode_ijin_form;
        $dataijin = DB::table('pengajuan_ijin')->where('kode_ijin', $kode_ijin)->first();
        $nik = $dataijin->nik;
        $tgl_dari = $dataijin->tgl_ijin_dari;
        $tgl_sampai = $dataijin->tgl_ijin_sampai;
        $status = $dataijin->status;

        DB::beginTransaction();
        try {
            if ($status_approved == 1) {
                while (strtotime($tgl_dari) <= strtotime($tgl_sampai)) {

                    DB::table('presensi')->insert([
                        'nik' => $nik,
                        'tgl_presensi' => $tgl_dari,
                        'status' => $status,
                        'kode_ijin' => $kode_ijin,
                    ]);
                    $tgl_dari = date("Y-m-d", strtotime("+1 days", strtotime($tgl_dari)));
                }
            }
            DB::table('pengajuan_ijin')->where('kode_ijin', $kode_ijin)->update([
                'status_approved' => $status_approved,
            ]);
            DB::commit();
            return Redirect::back()->with(['success' => 'Data Pengajuan Ijin Berhasil Diproses']);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(['warning' => 'Data Pengajuan Ijin Gagal Diproses']);
        }
    }

    public function batalkanijinsakit($kode_ijin)
    {
        DB::beginTransaction();
        try {
            DB::table('pengajuan_ijin')->where('kode_ijin', $kode_ijin)->update([
                'status_approved' => 0,
            ]);
            DB::table('presensi')->where('kode_ijin', $kode_ijin)->delete();
            DB::commit();
            return Redirect::back()->with(['success' => 'Data Berhasil Dibatalkan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(['warning' => 'Data Gagal Dibatalkan']);
        }

        $update = DB::table('pengajuan_ijin')->where('id', $id)->update([
            'status_approved' => 0,
        ]);
        if ($update) {
            return Redirect::back()->with(['success' => 'Pengajuan Telah Dikonfirmasi']);
        } else {
            return Redirect::back()->with(['warning' => 'Pengajuan Gagal Dikonfirmasi']);
        }
    }

    public function cekpengajuanijin(Request $request)
    {
        $tgl_ijin_dari = $request->tgl_ijin_dari;
        $nik = Auth::guard('karyawan')->user()->nik;

        $cek = DB::table('pengajuan_ijin')->where('nik', $nik)->where('tgl_ijin_dari', $tgl_ijin_dari)->count();
        return $cek;
    }

    public function showact($kode_ijin)
    {

        $dataijin = DB::table('pengajuan_ijin')->where('kode_ijin', $kode_ijin)->first();
        return view('presensi.showact', compact('dataijin'));
    }

    public function deleteijin($kode_ijin)
    {
        $cekdataijin = DB::table('pengajuan_ijin')->where('kode_ijin', $kode_ijin)->first();
        $doc_sid = $cekdataijin->doc_sid;
        try {
            DB::table('pengajuan_ijin')->where('kode_ijin', $kode_ijin)->delete();
            if ($doc_sid != null) {

                Storage::delete('/public/uploads/sid/' . $doc_sid);
            }
            return redirect('presensi/dataijin')->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return redirect('presensi/dataijin')->with(['error' => 'Data Gagal Dihapus']);
        }
    }

    public function koreksiabsensi(Request $request)
    {

        $nik = $request->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        $tanggal = $request->tanggal;
        $cekpresensi = DB::table('presensi')->where('nik', $nik)->where('tgl_presensi', $tanggal)->first();
        $jamkerja = DB::table('jam_kerja')->orderBy('kode_jam_kerja')->get();

        return view('presensi.koreksiabsensi', compact('karyawan', 'tanggal', 'jamkerja', 'cekpresensi'));
    }

    public function storekoreksiabsensi(Request $request)
    {

        $status = $request->status;
        $nik = $request->nik;
        $tanggal = $request->tanggal;
        $jam_in = $status == "a" ? null : $request->jam_in;
        $jam_out = $status == "a" ? null : $request->jam_out;
        $kode_jam_kerja = $status == "a" ? null : $request->kode_jam_kerja;

        try {
            $cekpresensi = DB::table('presensi')->where('nik', $nik)->where('tgl_presensi', $tanggal)->count();
            if ($cekpresensi > 0) {
                DB::table('presensi')
                    ->where('nik', $nik)
                    ->where('tgl_presensi', $tanggal)
                    ->update([
                        'jam_in' => $jam_in,
                        'jam_out' => $jam_out,
                        'kode_jam_kerja' => $kode_jam_kerja,
                        'status' => $status,
                    ]);
            } else {
                DB::table('presensi')->insert([
                    'nik' => $nik,
                    'tgl_presensi' => $tanggal,
                    'jam_in' => $jam_in,
                    'jam_out' => $jam_out,
                    'kode_jam_kerja' => $kode_jam_kerja,
                    'status' => $status,
                ]);
            }
            return redirect::back()->with(['success' => 'Data Berhasil Disimapan']);
        } catch (\Exception $e) {
            return redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    public function pilihjamkerja()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $hariini = date("Y-m-d");
        $cekpresensi = DB::table('presensi')->where('nik', $nik)->where('tgl_presensi', $hariini)->first();
        if(!empty($cekpresensi)){
            $kode_jam_kerja = Crypt::encrypt($cekpresensi->kode_jam_kerja);
            return redirect('/presensi/'. $kode_jam_kerja . '/create');
        }
        $jamkerja = DB::table('jam_kerja')->get();
        return view('presensi.pilihjamkerja', compact('jamkerja'));
    }

}
