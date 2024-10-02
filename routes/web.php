<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\HariliburController;
use App\Http\Controllers\IjinabsenController;
use App\Http\Controllers\IjincutiController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KonfigurasiController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\SakitController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

Route::middleware(['guest:karyawan'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/proseslogin', [AuthController::class, 'proseslogin']);
});

Route::middleware(['guest:user'])->group(function () {
    Route::get('/panel', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');
    Route::post('/prosesloginadmin', [AuthController::class, 'prosesloginadmin']);
});

Route::middleware('auth:karyawan')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/proseslogout', [AuthController::class, 'proseslogout']);

    //presensi absen
    Route::get('/presensi/{kode_jam_kerja}/create', [PresensiController::class, 'create']);
    Route::get('/presensi/pilihjamkerja', [PresensiController::class, 'pilihjamkerja']);
    Route::post('/presensi/store', [PresensiController::class, 'store']);

    //edit profil
    Route::get('/editprofil', [PresensiController::class, 'editprofil']);
    Route::post('/presensi/{nik}/updateprofil', [PresensiController::class, 'updateprofil']);

    //Historis
    Route::get('/presensi/historis', [PresensiController::class, 'historis']);
    Route::post('/gethistori', [PresensiController::class, 'gethistori']);

    //Ijin
    Route::get('/presensi/dataijin', [PresensiController::class, 'dataijin']);
    Route::get('/presensi/buatijin', [PresensiController::class, 'buatijin']);
    Route::post('/presensi/storeijin', [PresensiController::class, 'storeijin']);
    Route::post('/presensi/cekpengajuanijin', [PresensiController::class, 'cekpengajuanijin']);

    //Ijin Absaen
    Route::get('/ijinabsen', [IjinabsenController::class, 'create']);
    Route::post('/ijinabsen/storeijinabsen', [IjinabsenController::class, 'storeijinabsen']);
    Route::get('/ijinabsen/{kode_ijin}/edit', [IjinabsenController::class, 'edit']);
    Route::post('/ijinabsen/{kode_ijin}/update', [IjinabsenController::class, 'update']);

    //Sakit
    Route::get('/ijinsakit', [SakitController::class, 'create']);
    Route::post('/ijinsakit/storeijinsakit', [SakitController::class, 'storeijinsakit']);
    Route::get('/ijinsakit/{kode_ijin}/edit', [SakitController::class, 'edit']);
    Route::post('/ijinsakit/{kode_ijin}/update', [SakitController::class, 'update']);

    //Ijin Cuti
    Route::get('/ijincuti', [IjincutiController::class, 'create']);
    Route::post('/ijincuti/storeijincuti', [IjincutiController::class, 'storeijincuti']);
    Route::get('/ijincuti/{kode_ijin}/edit', [IjincutiController::class, 'edit']);
    Route::get('/ijincuti/{kode_ijin}/edit', [IjincutiController::class, 'edit']);
    Route::post('/ijincuti/{kode_ijin}/update', [IjincutiController::class, 'update']);
    Route::post('/ijincuti/getmaxcuti', [IjincutiController::class, 'getmaxcuti']);

    //Act
    Route::get('/dataijin/{kode_ijin}/showact', [PresensiController::class, 'showact']);
    Route::get('/dataijin/{kode_ijin}/delete', [PresensiController::class, 'deleteijin']);

});

//Route Hanya Untuk Administrator dan Admin Departemen
Route::group(['middleware' => ['role:administrator|admin departemen,user']], function () {
    Route::get('/proseslogoutadmin', [AuthController::class, 'proseslogoutadmin']);
    Route::get('/panel/dashboardadmin', [DashboardController::class, 'dashboardadmin']);

    //Karyawan
    Route::get('/karyawan', [KaryawanController::class, 'index']);
    Route::get('/karyawan/{nik}/resetpass', [KaryawanController::class, 'resetpass']);

    //Konfigurasi Jam Kerja
    Route::get('/konfigurasi/{nik}/setjamkerja', [KonfigurasiController::class, 'setjamkerja']);
    Route::post('/konfigurasi/storesetjamkerja', [KonfigurasiController::class, 'storesetsamkerja']);
    Route::post('/konfigurasi/updatesetjamkerja', [KonfigurasiController::class, 'updatesetjamkerja']);

    //Monitoring Presensi / Ijin
    Route::get('/presensi/monitoring', [PresensiController::class, 'monitoring']);
    Route::post('/getpresensi', [PresensiController::class, 'getpresensi']);
    Route::post('/showmaps', [PresensiController::class, 'showmaps']);
    Route::get('/presensi/laporan', [PresensiController::class, 'laporan']);
    Route::post('/presensi/cetaklaporan', [PresensiController::class, 'cetaklaporan']);
    Route::get('/presensi/rekap', [PresensiController::class, 'rekap']);
    Route::post('/presensi/cetakrekap', [PresensiController::class, 'cetakrekap']);

    Route::get('/presensi/ijinsakit', [PresensiController::class, 'ijinsakit']);

    Route::post('/koreksiabsensi', [PresensiController::class, 'koreksiabsensi']);
    Route::post('/storekoreksiabsensi', [PresensiController::class, 'storekoreksiabsensi']);
});

//Route Hanya Untuk Administrator
Route::group(['middleware' => ['role:administrator,user']], function () {

    //Karyawan
    Route::post('/karyawan/store', [KaryawanController::class, 'store']);
    Route::post('/karyawan/edit', [KaryawanController::class, 'edit']);
    Route::post('/karyawan/{nik}/update', [KaryawanController::class, 'update']);
    Route::post('/karyawan/{nik}/delete', [KaryawanController::class, 'delete']);
    Route::get('/karyawan/{nik}/locklokasi', [KaryawanController::class, 'locklokasi']);
    Route::get('/karyawan/{nik}/lockjamkerja', [KaryawanController::class, 'lockjamkerja']);

    //Departemen
    Route::get('/departemen', [DepartemenController::class, 'index']);
    Route::post('/departemen/store', [DepartemenController::class, 'store']);
    Route::post('/departemen/edit', [DepartemenController::class, 'edit']);
    Route::post('/departemen/{kode_dept}/update', [DepartemenController::class, 'update']);
    Route::post('/departemen/{kode_dept}/delete', [DepartemenController::class, 'delete']);

    //Presensi Monitoring
    Route::post('/presensi/approveijinsakit', [PresensiController::class, 'approveijinsakit']);
    Route::get('/presensi/{kode_ijin}/batalkanijinsakit', [PresensiController::class, 'batalkanijinsakit']);

    //Cabang
    Route::get('/cabang', [CabangController::class, 'index']);
    Route::post('/cabang/store', [CabangController::class, 'store']);
    Route::post('/cabang/edit', [CabangController::class, 'edit']);
    Route::post('/cabang/update', [CabangController::class, 'update']);
    Route::post('/cabang/{kode_cabang}/delete', [CabangController::class, 'delete']);

    //Konfigurasi
    Route::get('/konfigurasi/lokasikantor', [KonfigurasiController::class, 'lokasikantor']);
    Route::post('/konfigurasi/updatelokasikantor', [KonfigurasiController::class, 'updatelokasikantor']);

    //Konfigurasi Jam Kerja
    Route::get('/konfigurasi/jamkerja', [KonfigurasiController::class, 'jamkerja']);
    Route::post('/konfigurasi/storejamkerja', [KonfigurasiController::class, 'storejamkerja']);
    Route::post('/konfigurasi/editjamkerja', [KonfigurasiController::class, 'editjamkerja']);
    Route::post('/konfigurasi/updatejamkerja', [KonfigurasiController::class, 'updatejamkerja']);
    Route::post('/konfigurasi/{kode_jam_kerja}/delete', [KonfigurasiController::class, 'delete']);
    Route::post('/konfigurasi/storesetjamkerjabytgl', [KonfigurasiController::class, 'storesetjamkerjabytgl']);
    Route::get('/konfigurasi/{nik}/{bulan}/{tahun}/getjamkerjabytgl', [KonfigurasiController::class, 'getjamkerjabytgl']);
    Route::post('/konfigurasi/deletejamkerjabytgl', [KonfigurasiController::class, 'deletejamkerjabytgl']);

    Route::post('/konfigurasi/jamkerja/{kode_jam_kerja}/delete', [KonfigurasiController::class, 'deletejamkerja']);

    //Konfigurasi JK Departemen
    Route::get('/konfigurasi/jamkerjadept', [KonfigurasiController::class, 'jamkerjadept']);
    Route::get('/konfigurasi/jamkerjadept/create', [KonfigurasiController::class, 'createjamkerjadept']);
    Route::post('/konfigurasi/jamkerjadept/store', [KonfigurasiController::class, 'storejamkerjadept']);
    Route::get('/konfigurasi/jamkerjadept/{kode_jk_dept}/edit', [KonfigurasiController::class, 'editjamkerjadept']);
    Route::post('/konfigurasi/jamkerjadept/{kode_jk_dept}/update', [KonfigurasiController::class, 'updatejamkerjadept']);
    Route::get('/konfigurasi/jamkerjadept/{kode_jk_dept}/show', [KonfigurasiController::class, 'showjamkerjadept']);
    Route::get('/konfigurasi/jamkerjadept/{kode_jk_dept}/delete', [KonfigurasiController::class, 'deletejamkerjadept']);

    //Konfigurasi User Role
    Route::get('/konfigurasi/users', [UserController::class, 'index']);
    Route::post('/konfigurasi/users/store', [UserController::class, 'store']);
    Route::post('/konfigurasi/users/edit', [UserController::class, 'edit']);
    Route::post('/konfigurasi/users/{id_user}/update', [UserController::class, 'update']);
    Route::post('/konfigurasi/users/{id_user}/delete', [UserController::class, 'delete']);

    //Hari Libur
    Route::get('/konfigurasi/harilibur', [HariliburController::class, 'index']);
    Route::get('/konfigurasi/harilibur/create', [HariliburController::class, 'create']);
    Route::post('/konfigurasi/harilibur/store', [HariliburController::class, 'store']);
    Route::post('/konfigurasi/harilibur/edit', [HariliburController::class, 'edit']);
    Route::post('/konfigurasi/harilibur/{kode_libur}/update', [HariliburController::class, 'update']);
    Route::post('/konfigurasi/harilibur/{kode_libur}/delete', [HariliburController::class, 'delete']);
    Route::get('/konfigurasi/harilibur/{kode_libur}/setkaryawanlibur', [HariliburController::class, 'setkaryawanlibur']);
    Route::get('/konfigurasi/harilibur/{kode_libur}/setlistkaryawanlibur', [HariliburController::class, 'setlistkaryawanlibur']);
    Route::get('/konfigurasi/harilibur/{kode_libur}/getsetlistkaryawanlibur', [HariliburController::class, 'getsetlistkaryawanlibur']);
    Route::post('/konfigurasi/harilibur/storekaryawanlibur', [HariliburController::class, 'storekaryawanlibur']);
    Route::post('/konfigurasi/harilibur/batallibur', [HariliburController::class, 'batallibur']);
    Route::get('/konfigurasi/harilibur/{kode_libur}/getkaryawanlibur', [HariliburController::class, 'getkaryawanlibur']);

    //Cuti
    Route::get('/cuti', [CutiController::class, 'index']);
    Route::post('/cuti/store', [CutiController::class, 'store']);
    Route::post('/cuti/edit', [CutiController::class, 'edit']);
    Route::post('/cuti/{kode_cuti}/update', [CutiController::class, 'update']);
    Route::post('/cuti/{kode_cuti}/delete', [CutiController::class, 'delete']);

});

Route::get('/create_rolepermission', function () {

    try {
        Role::create(['name' => 'admin departemen']);
        // Permission::create(['name' => 'view-karyawan']);
        // Permission::create(['name' => 'view-departemen']);
        echo "Sukses";
    } catch (\Exception $e) {
        echo "Gagal";
    }
});

Route::get('/give-user-role', function () {
    try {
        $user = User::findorfail(1);
        $user->assignRole('administrator');
        echo "Sukses";
    } catch (\Exception $e) {
        echo "Gagal";
    }
});

Route::get('/give-user-permissrion', function () {
    try {

        $role = Role::findorfail(1);
        $role->givePermissionTo('view-karyawan');
        echo "Sukses";
    } catch (\Exception $e) {
        echo "Gagal";
    }
});
