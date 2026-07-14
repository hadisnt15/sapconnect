<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\OcrdCardController;
use App\Http\Controllers\OcrdController;
use App\Http\Controllers\OdlnController;
use App\Http\Controllers\OdlnReController;
use App\Http\Controllers\OitmController;
use App\Http\Controllers\OrdrController;
use App\Http\Controllers\OslpController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Report\BulananAverageController;
use App\Http\Controllers\Report\BulananAverageLiterController;
use App\Http\Controllers\Report\GrafikPenjualanSalesController;
use App\Http\Controllers\Report\IdsGrupController;
use App\Http\Controllers\Report\JadwalIsiIBCController;
use App\Http\Controllers\Report\JHOutstandinController;
use App\Http\Controllers\Report\KetahananStokController;
use App\Http\Controllers\Report\KontrakIdsController;
use App\Http\Controllers\Report\LubRetailController;
use App\Http\Controllers\Report\PembelianHarianController;
use App\Http\Controllers\Report\PeminjamanBarangController;
use App\Http\Controllers\Report\PenjualanRtlSalesController;
use App\Http\Controllers\Report\PenjualanSprSalesController;
use App\Http\Controllers\Report\PenjualanSprSegmentController;
use App\Http\Controllers\Report\Piutang45HariController;
use App\Http\Controllers\Report\ProgRtlController;
use App\Http\Controllers\Report\StokPtmController;
use App\Http\Controllers\Report\UltahController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::middleware('guest')->group(function () {
    Route::get('/masuk', [LoginController::class, 'index'])->name('login'); //ok
    Route::post('/masuk', [LoginController::class, 'auth']); //ok
});

Route::middleware('auth')->group(function () {
    // logout
    Route::post('/keluar', [LoginController::class, 'logout'])->name('logout'); //ok
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

    // profile
    Route::prefix('profil')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile'); //ok
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit'); //ok
        Route::post('/perbarui', [ProfileController::class, 'update'])->name('profile.update'); //ok
    });

    // password
    Route::prefix('kataSandi')->group(function () {
        Route::get('/perbarui', [PasswordController::class, 'edit'])->name('password.edit'); //ok
        Route::post('/perbarui', [PasswordController::class, 'update'])->name('password.update'); //ok
    });

    // dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard'); //ok
    Route::post('/dasbor/sinkron', [DashboardController::class, 'refresh'])->name('dashboard.refresh')->middleware('can:dashboard.refresh'); //ok

    // item master data
    Route::prefix('barang')->group(function () {
        Route::get('/', [OitmController::class, 'index'])->name('item'); //ok
        Route::get('/api', [OitmController::class, 'api']); //ok
        Route::get('/sinkron', [OitmController::class, 'refresh'])->name('item.refresh')->middleware('role:developer|manager|supervisor'); //ok
    });

    // customer master data
    Route::prefix('pelanggan')->group(function () {
        Route::get('/', [OcrdController::class, 'index'])->name('customer'); //ok
        Route::get('/sinkron', [OcrdController::class, 'refresh'])->name('customer.refresh')->middleware('role:developer|manager|supervisor'); //ok
        Route::get('/buat', [OcrdController::class, 'create'])->name('customer.create')->middleware('role:developer|salesman'); //ok
        Route::post('/simpan', [OcrdController::class, 'store'])->name('customer.store')->middleware('role:developer|salesman'); //ok
        Route::get('/{CardCode}/edit', [OcrdController::class, 'edit'])->name('customer.edit')->middleware('role:developer|salesman'); //ok
        Route::put('/{CardCode}', [OcrdController::class, 'update'])->name('customer.update')->middleware('role:developer|salesman'); //ok
    });

    // customer card
    Route::prefix('kartu')->group(function () {
        Route::get('/api', [OcrdCardController::class, 'api'])->name('card.api')->middleware('role:developer|manager|supervisor_ids|salesman_ids'); //ok
        Route::get('/{id}/penanggungJawab', [OcrdCardController::class, 'persons'])->name('card.persons')->middleware('role:developer|manager|supervisor_ids|salesman_ids');
        Route::get('/{CardCode}', [OcrdCardController::class, 'create'])->name('card.create')->middleware('role:developer|manager|supervisor_ids|salesman_ids'); //ok
        Route::put('/{CardCode}/simpan', [OcrdCardController::class, 'save'])->name('card.save')->middleware('role:developer|manager|supervisor_ids|salesman_ids'); //ok
    });

    // salesman master data
    Route::prefix('penjual')->group(function () {
        Route::get('/', [OslpController::class, 'index'])->name('salesman')->middleware('role:developer|manager|supervisor'); //ok
        Route::get('/sinkron', [OslpController::class, 'refresh'])->name('salesman.refresh')->middleware('role:developer|manager|supervisor'); //ok
        Route::get('/pendaftaran', [OslpController::class, 'create'])->name('salesman.registration')->middleware('role:developer|manager|supervisor'); //ok
        Route::get('/api', [OslpController::class, 'api'])->name('salesman.api')->middleware('role:developer|manager|supervisor'); //ok
        Route::post('/store', [OslpController::class, 'store'])->name('salesman.store')->middleware('role:developer|manager|supervisor'); //ok
    });

    // user master data
    Route::prefix('pengguna')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user')->middleware('role:developer|manager'); //ok
        Route::get('/daftar', [RegisterController::class, 'index'])->name('user.register')->middleware('role:developer'); //ok
        Route::post('/daftar', [RegisterController::class, 'store'])->name('register')->middleware('role:developer');
        Route::get('/aktif', [UserController::class, 'activeUsers'])->name('user.active')->middleware('role:developer'); //ok
        Route::get('/perangkat', [UserController::class, 'userDevice'])->name('user.device')->middleware('role:developer'); //ok
        Route::delete('/hapusPerangkat/{id}', [UserController::class, 'destroyUserDevice'])->name('user.destroyUserDevice')->middleware('role:developer'); //ok
        Route::post('/{id}/tendang', [UserController::class, 'kickUser'])->name('user.kick')->middleware('role:developer'); //ok
        Route::get('/api', [RegisterController::class, 'api'])->name('user.api')->middleware('role:developer|manager|supervisor'); //ok
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit')->middleware('role:developer|manager'); //ok
        Route::put('/{id}/perbarui', [UserController::class, 'update'])->name('user.update')->middleware('role:developer|manager'); //ok
        Route::get('/{id}/divisi', [DivisionController::class, 'editUserDivision'])->name('user.editDivision')->middleware('role:developer|manager');
        Route::post('/{id}/divisi', [DivisionController::class, 'updateUserDivision'])->name('user.updateDivision')->middleware('role:developer|manager');
        Route::get('/{id}/laporan', [ReportController::class, 'editUserReport'])->name('user.editReport')->middleware('role:developer|manager');
        Route::post('/{id}/laporan', [ReportController::class, 'updateUserReport'])->name('user.updateReport')->middleware('role:developer|manager');
        Route::get('/{id}/cabang', [BranchController::class, 'editUserBranch'])->name('user.editBranch')->middleware('role:developer|manager');
        Route::post('/{id}/cabang', [BranchController::class, 'updateUserBranch'])->name('user.updateBranch')->middleware('role:developer|manager');
        Route::get('/apiDiv', [UserController::class, 'api'])->name('user.apiDiv')->middleware('role:developer|manager|supervisor'); //ok
        Route::get('/apiRep', [UserController::class, 'api'])->name('user.apiRep')->middleware('role:developer|manager|supervisor'); //ok
    });
    Route::get('/divisi/apiDiv', [DivisionController::class, 'api'])->name('div.apiDiv')->middleware('role:developer|manager|supervisor'); //ok
    Route::get('/laporan/apiRep', [ReportController::class, 'api'])->name('rep.apiRep')->middleware('role:developer|manager|supervisor'); //ok

    // note
    Route::prefix('agenda')->group(function () {
        Route::get('/', [NoteController::class, 'index'])->name('note');
        Route::get('/list', [NoteController::class, 'list']);
        Route::post('/store', [NoteController::class, 'store']);
        Route::put('/{note}', [NoteController::class, 'update']);
        Route::delete('/{note}', [NoteController::class, 'destroy']);
        Route::patch('/{note}/selesai', [NoteController::class, 'toggle']);
    });

    // order
    Route::prefix('pesanan')->group(function () {
        Route::get('/', [OrdrController::class, 'index'])->name('order')->middleware('role:developer|supervisor|manager|salesman'); //ok
        Route::get('/buat/{CardCode}', [OrdrController::class, 'create'])->name('order.create')->middleware('can:order.create'); //ok
        Route::get('/buat/baru/{RegCardCode}', [OrdrController::class, 'create'])->name('order.create.new')->middleware('role:developer|salesman'); //ok
        Route::post('/simpan', [OrdrController::class, 'store'])->name('order.store')->middleware('role:developer|salesman'); //ok
        Route::get('/kirim', [OrdrController::class, 'push'])->name('order.push')->middleware('role:developer|supervisor'); //ok
        Route::get('/{order}/edit', [OrdrController::class, 'edit'])->name('order.edit'); //ok
        Route::put('/{id}/perbarui', [OrdrController::class, 'update'])->name('order.update')->middleware('role:developer|salesman'); //ok
        Route::patch('/perbaruiPengecekan', [OrdrController::class, 'updateChecked'])->name('order.updateChecked')->middleware('role:developer|salesman'); //ok
        Route::get('/{order}/hapus', [OrdrController::class, 'delete'])->name('order.delete'); //ok
        Route::put('/{id}/lenyapkan', [OrdrController::class, 'destroy'])->name('order.destroy'); //ok
        Route::get('/{id}/detail', [OrdrController::class, 'detail'])->name('order.detail'); //ok
        Route::get('/{id}/prosesPesanan/', [OrdrController::class, 'progress'])->name('order.progress');
        Route::get('/sinkron', [OrdrController::class, 'refresh'])->name('order.refresh')->middleware('role:developer|manager|supervisor'); //ok
        Route::get('/ekspor', [OrdrController::class, 'export'])->name('order.export')->middleware('role:developer|supervisor'); //ok
        Route::get('/{id}/riwayat/', [OrdrController::class, 'history'])->name('order.history')->middleware('role:developer'); //ok
    });

    // delivery
    Route::prefix('suratJalan')->group(function () {
        Route::get('/', [OdlnController::class, 'index'])->name('delivery')->middleware('role:developer|warehouse|manager'); //ok
        Route::patch('/perbaruiPengecekan', [OdlnController::class, 'updateChecked'])->name('delivery.updateChecked')->middleware('role:developer|warehouse'); //ok
        Route::get('/kirim', [OdlnController::class, 'push'])->name('delivery.push')->middleware('role:developer|warehouse'); //ok
        Route::get('/sinkron', [OdlnController::class, 'refresh'])->name('delivery.refresh')->middleware('role:developer|manager|warehouse'); //ok
        Route::patch('/{id}/allow-return', [OdlnController::class, 'allowReturn'])->name('delivery.allowReturn')->middleware('role:developer|manager|warehouse');
    });
    Route::prefix('pengirimanUlang')->group(function () {
        Route::get('/', [OdlnReController::class, 'index'])->name('re.delivery')->middleware('role:developer|warehouse|manager'); //ok
        Route::patch('/perbaruiPengecekan', [OdlnReController::class, 'updateChecked'])->name('reDelivery.updateChecked')->middleware('role:developer|warehouse'); //ok
        Route::get('/kirim', [OdlnReController::class, 'push'])->name('reDelivery.push')->middleware('role:developer|warehouse'); //ok
    });

    // visit
    Route::prefix('kunjungan')->group(function () {
        Route::get('/', [VisitController::class, 'index'])->name('visit')->middleware('role:developer|manager|supervisor_ids|salesman_ids');
        Route::get('/buat', [VisitController::class, 'create'])->name('visit.create')->middleware('can:visit.create');
        Route::post('/simpan', [VisitController::class, 'store'])->name('visit.store')->middleware('can:visit.create'); //ok
        Route::get('/{visit}/edit', [VisitController::class, 'edit'])->name('visit.edit'); //ok
        Route::put('/{visit}/perbarui', [VisitController::class, 'update'])->name('visit.update'); //ok
        Route::get('/{visit}/detail', [VisitController::class, 'show'])->name('visit.detail'); //ok
    });

    // report
    Route::prefix('laporan')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('report');
        Route::get('/buat', [ReportController::class, 'create'])->name('report.create')->middleware('role:developer'); //ok
        Route::post('/simpan', [ReportController::class, 'store'])->name('report.store')->middleware('role:developer');
        Route::get('/{id}/edit', [ReportController::class, 'edit'])->name('report.edit')->middleware('role:developer'); //ok
        Route::put('/{id}/perbarui', [ReportController::class, 'update'])->name('report.update')->middleware('role:developer'); //ok
        // reports
        Route::get('/pencapaian-penjualan-sparepart-per-segment', [PenjualanSprSegmentController::class, 'index'])->name('report.pencapaian-penjualan-sparepart-per-segment');
        Route::post('/sinkron/pencapaian-penjualan-sparepart-per-segment', [PenjualanSprSegmentController::class, 'refresh'])->name('report.refresh.pencapaian-penjualan-sparepart-per-segment');
        Route::get('/pencapaian-penjualan-sparepart-per-sales', [PenjualanSprSalesController::class, 'index'])->name('report.pencapaian-penjualan-sparepart-per-sales');
        Route::post('/sinkron/pencapaian-penjualan-sparepart-per-sales', [PenjualanSprSalesController::class, 'refresh'])->name('report.refresh.pencapaian-penjualan-sparepart-per-sales');
        Route::get('/grafik-penjualan-harian-sales', [GrafikPenjualanSalesController::class, 'index'])->name('report.grafik-penjualan-harian-sales');
        Route::get('/penjualan-lub-retail', [LubRetailController::class, 'index'])->name('report.penjualan-lub-retail');
        Route::post('/sinkron/penjualan-lub-retail', [LubRetailController::class, 'refresh'])->name('report.refresh.penjualan-lub-retail')->middleware('can:dashboard.refresh'); //ok
        Route::get('/bulanan-dan-average', [BulananAverageController::class, 'index'])->name('report.bulanan-dan-average');
        Route::post('/sinkron/bulanan-dan-average', [BulananAverageController::class, 'refresh'])->name('report.refresh.bulanan-dan-average')->middleware('can:dashboard.refresh'); //ok
        Route::get('/program-retail', [ProgRtlController::class, 'index'])->name('report.program-retail');
        Route::post('/sinkron/program-retail', [ProgRtlController::class, 'refresh'])->name('report.refresh.program-retail')->middleware('can:dashboard.refresh'); //ok
        Route::get('/penjualan-industri-per-grup', [IdsGrupController::class, 'index'])->name('report.penjualan-industri-per-grup');
        Route::post('/sinkron/penjualan-industri-per-grup', [IdsGrupController::class, 'refresh'])->name('report.refresh.penjualan-industri-per-grup');
        Route::get('/kalender-ulang-tahun', [UltahController::class, 'index'])->name('report.kalender-ulang-tahun');
        Route::get('/stok-pertamina', [StokPtmController::class, 'index'])->name('report.stok-pertamina');
        Route::get('/sinkron/stok-pertamina', [StokPtmController::class, 'refresh'])->name('report.refresh.stok-pertamina');
        Route::get('/bulanan-dan-average-liter', [BulananAverageLiterController::class, 'index'])->name('report.bulanan-dan-average-liter');
        Route::post('/sinkron/bulanan-dan-average-liter', [BulananAverageLiterController::class, 'refresh'])->name('report.refresh.bulanan-dan-average-liter')->middleware('can:dashboard.refresh'); //ok
        Route::get('/piutang-45-hari', [Piutang45HariController::class, 'index'])->name('report.piutang-45-hari');
        Route::get('/sinkron/piutang-45-hari', [Piutang45HariController::class, 'refresh'])->name('report.refresh.piutang-45-hari');
        Route::get('/pencapaian-penjualan-retail-per-sales', [PenjualanRtlSalesController::class, 'index'])->name('report.pencapaian-penjualan-retail-per-sales');
        Route::post('/sinkron/pencapaian-penjualan-retail-per-sales', [PenjualanRtlSalesController::class, 'refresh'])->name('report.refresh.pencapaian-penjualan-retail-per-sales');
        Route::get('/pembelian-harian', [PembelianHarianController::class, 'index'])->name('report.pembelian-harian');
        Route::get('/sinkron/pembelian-harian', [PembelianHarianController::class, 'refresh'])->name('report.refresh.pembelian-harian');
        Route::get('/peminjaman-barang', [PeminjamanBarangController::class, 'index'])->name('report.peminjaman-barang');
        Route::get('/sinkron/peminjaman-barang', [PeminjamanBarangController::class, 'refresh'])->name('report.refresh.peminjaman-barang');
        Route::get('/jh-outstanding', [JHOutstandinController::class, 'index'])->name('report.jh-outstanding');
        Route::get('/sinkron/jh-outstanding', [JHOutstandinController::class, 'refresh'])->name('report.refresh.jh-outstanding');
        Route::get('/jadwal-isi-ibc', [JadwalIsiIBCController::class, 'index'])->name('report.jadwal-isi-ibc');
        Route::get('/sinkron/jadwal-isi-ibc', [JadwalIsiIBCController::class, 'refresh'])->name('report.refresh.jadwal-isi-ibc');
        Route::get('/ketahanan-stok', [KetahananStokController::class, 'index'])->name('report.ketahanan-stok');
        Route::get('/sinkron/ketahanan-stok', [KetahananStokController::class, 'refresh'])->name('report.refresh.ketahanan-stok');
        Route::get('/kalender-kontrak-grup-ids', [KontrakIdsController::class, 'index'])->name('report.kalender-kontrak-grup-ids');
    });
});