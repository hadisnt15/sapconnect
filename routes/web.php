<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OcrdController;
use App\Http\Controllers\OitmController;
use App\Http\Controllers\OrdrController;
use App\Http\Controllers\OslpController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BranchController;
// use App\Http\Controllers\UserDivisionController;
use App\Exports\OrdrCombinedExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Controllers\Report\PenjualanSprSegmentController;
use App\Http\Controllers\Report\PenjualanSprSalesController;
use App\Http\Controllers\Report\GrafikPenjualanSalesController;
use App\Http\Controllers\Report\LubRetailController;
use App\Http\Controllers\Report\Top10LubRtlController;
use App\Http\Controllers\Report\BulananAverageController;
use App\Http\Controllers\Report\ProgRtlController;

Route::get('/pengguna/daftar', [RegisterController::class, 'index'])->name('user.register')->middleware('auth'); //ok
Route::post('/daftar', [RegisterController::class, 'store'])->name('register')->middleware('auth'); //ok
Route::get('/masuk', [LoginController::class, 'index'])->name('login')->middleware('guest'); //ok
Route::post('/masuk', [LoginController::class, 'auth'])->middleware('guest'); //ok
Route::post('/keluar', [LoginController::class, 'logout'])->name('logout')->middleware('auth'); //ok
// routes/web.php
Route::get('/cek/sesi', function () {
    if (!Auth::check()) {
        return response()->json(['status' => 'logged_out']);
    }

    $sessionId = session()->getId();
    $device = \App\Models\UserDevice::where('user_id', Auth::id())->first();

    if ($device && $device->session_id !== $sessionId) {
        return response()->json(['status' => 'kicked']);
    }

    return response()->json(['status' => 'ok']);
})->name('check.session');



Route::get('/profil', [ProfileController::class, 'index'])->name('profile')->middleware('auth'); //ok
Route::get('/profil/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth'); //ok
Route::post('/profil/perbarui', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth'); //ok

Route::get('/kataSandi/perbarui', [PasswordController::class, 'edit'])->name('password.edit')->middleware('auth'); //ok
Route::post('/kataSandi/perbarui', [PasswordController::class, 'update'])->name('password.update')->middleware('auth'); //ok

Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth'); //ok
Route::post('/dasbor/sinkron', [DashboardController::class, 'refresh'])->name('dashboard.refresh')->middleware('can:dashboard.refresh'); //ok

Route::get('/barang', [OitmController::class, 'index'])->name('item')->middleware('auth'); //ok
Route::get('/barang/api', [OitmController::class, 'api'])->middleware('auth'); //ok
Route::get('/barang/sinkron', [OitmController::class, 'refresh'])->name('item.refresh')->middleware('role:developer|manager|supervisor'); //ok

Route::get('/pelanggan', [OcrdController::class, 'index'])->name('customer')->middleware('auth'); //ok
Route::get('/pelanggan/sinkron', [OcrdController::class, 'refresh'])->name('customer.refresh')->middleware('role:developer|manager|supervisor'); //ok
Route::get('/pelanggan/buat', [OcrdController::class, 'create'])->name('customer.create')->middleware('role:developer|salesman'); //ok
Route::post('/pelanggan/simpan', [OcrdController::class, 'store'])->name('customer.store')->middleware('role:developer|salesman'); //ok
Route::get('/pelanggan/{CardCode}/edit', [OcrdController::class, 'edit'])->name('customer.edit')->middleware('role:developer|salesman'); //ok
Route::put('/pelanggan/{CardCode}', [OcrdController::class, 'update'])->name('customer.update')->middleware('role:developer|salesman'); //ok

Route::get('/pesanan', [OrdrController::class, 'index'])->name('order')->middleware('auth'); //ok
Route::get('/pesanan/buat/{CardCode}', [OrdrController::class, 'create'])->name('order.create')->middleware('can:order.create'); //ok
Route::get('/pesanan/buat/baru/{RegCardCode}', [OrdrController::class, 'create'])->name('order.create.new')->middleware('role:developer|salesman'); //ok
Route::post('/pesanan/simpan', [OrdrController::class, 'store'])->name('order.store')->middleware('role:developer|salesman'); //ok
Route::get('/pesanan/kirim', [OrdrController::class, 'push'])->name('order.push')->middleware('role:developer|supervisor'); //ok
Route::get('/pesanan/{order}/edit', [OrdrController::class, 'edit'])->name('order.edit'); //ok
Route::put('/pesanan/{id}/perbarui', [OrdrController::class, 'update'])->name('order.update')->middleware('role:developer|salesman'); //ok
Route::patch('/pesanan/perbaruiPengecekan', [OrdrController::class, 'updateChecked'])->name('order.updateChecked')->middleware('role:developer|salesman'); //ok
Route::get('/pesanan/{order}/hapus', [OrdrController::class, 'delete'])->name('order.delete'); //ok
Route::put('/pesanan/{id}/lenyapkan', [OrdrController::class, 'destroy'])->name('order.destroy'); //ok
Route::get('/pesanan/{id}/detail', [OrdrController::class, 'detail'])->name('order.detail')->middleware('auth'); //ok
Route::get('/pesanan/{id}/prosesPesanan/', [OrdrController::class, 'progress'])->name('order.progress');
Route::get('/pesanan/sinkron', [OrdrController::class, 'refresh'])->name('order.refresh')->middleware('role:developer|manager|supervisor'); //ok
// Route::get('/pesanan/ekspor', function () {
//     return Excel::download(new OrdrCombinedExport, 'ORDR_COMBINED.xlsx');
// })->name('order.export')->middleware('role:developer|supervisor'); //ok

Route::get('/kunjungan', [VisitController::class, 'index'])->name('visit')->middleware('auth');
Route::post('/kunjungan/unggah', [VisitController::class, 'store'])->name('visit.store');

Route::get('/penjual', [OslpController::class, 'index'])->name('salesman')->middleware('role:developer|manager|supervisor'); //ok
Route::get('/penjual/sinkron', [OslpController::class, 'refresh'])->name('salesman.refresh')->middleware('role:developer|manager|supervisor'); //ok
Route::get('/penjual/pendaftaran', [OslpController::class, 'create'])->name('salesman.registration')->middleware('role:developer|manager|supervisor'); //ok
Route::get('/penjual/api', [OslpController::class, 'api'])->name('salesman.api')->middleware('role:developer|manager|supervisor'); //ok
Route::post('/penjual/store', [OslpController::class, 'store'])->name('salesman.store')->middleware('role:developer|manager|supervisor'); //ok

Route::get('/pengguna', [UserController::class, 'index'])->name('user')->middleware('role:developer|manager'); //ok
Route::get('/pengguna/aktif', [UserController::class, 'activeUsers'])->name('user.active')->middleware('role:developer'); //ok
Route::get('/pengguna/perangkat', [UserController::class, 'userDevice'])->name('user.device')->middleware('role:developer'); //ok
Route::delete('/pengguna/hapusPerangkat/{id}', [UserController::class, 'destroyUserDevice'])->name('user.destroyUserDevice')->middleware('role:developer'); //ok
Route::post('/pengguna/{id}/tendang', [UserController::class, 'kickUser'])->name('user.kick')->middleware('role:developer'); //ok
Route::get('/pengguna/api', [RegisterController::class, 'api'])->name('user.api')->middleware('role:developer|manager|supervisor'); //ok
Route::get('/pengguna/{id}/edit', [UserController::class, 'edit'])->name('user.edit')->middleware('role:developer|manager'); //ok
Route::put('/pengguna/{id}/perbarui', [UserController::class, 'update'])->name('user.update')->middleware('role:developer|manager'); //ok
Route::get('/pengguna/{id}/divisi', [DivisionController::class, 'editUserDivision'])->name('user.editDivision')->middleware('role:developer|manager');
Route::post('/pengguna/{id}/divisi', [DivisionController::class, 'updateUserDivision'])->name('user.updateDivision')->middleware('role:developer|manager');
Route::get('/pengguna/{id}/laporan', [ReportController::class, 'editUserReport'])->name('user.editReport')->middleware('role:developer|manager');
Route::post('/pengguna/{id}/laporan', [ReportController::class, 'updateUserReport'])->name('user.updateReport')->middleware('role:developer|manager');
Route::get('/pengguna/{id}/cabang', [BranchController::class, 'editUserBranch'])->name('user.editBranch')->middleware('role:developer|manager');
Route::post('/pengguna/{id}/cabang', [BranchController::class, 'updateUserBranch'])->name('user.updateBranch')->middleware('role:developer|manager');

Route::get('/pengguna/apiDiv', [UserController::class, 'api'])->name('user.apiDiv')->middleware('role:developer|manager|supervisor'); //ok
Route::get('/divisi/apiDiv', [DivisionController::class, 'api'])->name('div.apiDiv')->middleware('role:developer|manager|supervisor'); //ok
// Route::get('/divisi/pendaftaran', [UserDivisionController::class, 'create'])->name('userDiv.registration')->middleware('role:developer|manager|supervisor'); //ok
Route::get('/pengguna/apiRep', [UserController::class, 'api'])->name('user.apiRep')->middleware('role:developer|manager|supervisor'); //ok
Route::get('/laporan/apiRep', [ReportController::class, 'api'])->name('rep.apiRep')->middleware('role:developer|manager|supervisor'); //ok
// Route::get('/laporan/pendaftaran', [UserReportController::class, 'create'])->name('userRep.registration')->middleware('role:developer|manager|supervisor'); //ok

Route::get('/laporan', [ReportController::class, 'index'])->name('report')->middleware('auth');
Route::get('/laporan/buat', [ReportController::class, 'create'])->name('report.create')->middleware('role:developer'); //ok
Route::post('/laporan/simpan', [ReportController::class, 'store'])->name('report.store')->middleware('role:developer');
Route::get('/laporan/pencapaian-penjualan-sparepart-per-segment', [PenjualanSprSegmentController::class, 'index'])->name('report.pencapaian-penjualan-sparepart-per-segment')->middleware('auth');
Route::get('/laporan/pencapaian-penjualan-sparepart-per-sales', [PenjualanSprSalesController::class, 'index'])->name('report.pencapaian-penjualan-sparepart-per-sales')->middleware('auth');
Route::get('/laporan/grafik-penjualan-harian-sales', [GrafikPenjualanSalesController::class, 'index'])->name('report.grafik-penjualan-harian-sales')->middleware('auth');
Route::get('/laporan/penjualan-lub-retail', [LubRetailController::class, 'index'])->name('report.penjualan-lub-retail')->middleware('auth');
Route::post('/laporan/sinkron/penjualan-lub-retail', [LubRetailController::class, 'refresh'])->name('report.refresh.penjualan-lub-retail')->middleware('can:dashboard.refresh'); //ok
// Route::get('/laporan/top-10-lub-retail', [Top10LubRtlController::class, 'index'])->name('report.top-10-lub-retail')->middleware('auth');
// Route::post('/laporan/sinkron/top-10-lub-retail', [Top10LubRtlController::class, 'refresh'])->name('report.refresh.top-10-lub-retail')->middleware('can:dashboard.refresh'); //ok
Route::get('/laporan/bulanan-dan-average', [BulananAverageController::class, 'index'])->name('report.bulanan-dan-average')->middleware('auth');
Route::post('/laporan/sinkron/bulanan-dan-average', [BulananAverageController::class, 'refresh'])->name('report.refresh.bulanan-dan-average')->middleware('can:dashboard.refresh'); //ok
Route::get('/laporan/program-retail', [ProgRtlController::class, 'index'])->name('report.program-retail')->middleware('auth');
Route::post('/laporan/sinkron/program-retail', [ProgRtlController::class, 'refresh'])->name('report.refresh.program-retail')->middleware('can:dashboard.refresh'); //ok


// Route::get('/test-hana', function () {
//     try {
//         $result = DB::connection('hana')->select('SELECT "DocNum","DocDate","CardCode","CardName" FROM "OINV" WHERE "DocDate" = \'12.08.2025\'');
//         return response()->json($result);
//     } catch (\Throwable $e) {
//         return response()->json(['error' => $e->getMessage()], 500);
//     }
// });