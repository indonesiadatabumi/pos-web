<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\PermohonanFakturController;
use App\Http\Controllers\DaftarUsahaController;
use App\Http\Controllers\VerifikasiPermohonanController;
use App\Http\Controllers\LaporanPermohonanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InputSsrdController;
use App\Http\Controllers\LaporanPenerimaanController;
use App\Http\Controllers\LaporanStrukController;
use App\Http\Controllers\StsController;
use App\Http\Controllers\LaporanPersediaanController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('auth.redirect');
Route::post('/login', [AuthController::class, 'login'])->middleware('auth.redirect');

Route::get('/get-tarif', [InputSsrdController::class, 'getTarif']);

Route::get('/get-kelurahan/{kd_kecamatan}', [RegistrasiController::class, 'getKelurahan']);
Route::get('/kecamatan', [RegistrasiController::class, 'allKecamatan']);

Route::get('/jenis-retribusi', [DaftarUsahaController::class, 'getJenisRetribusi'])->name('pages.daftar.usaha.jenis-retribusi');
Route::get('/get-npwrd-sequence/{kd_kecamatan}', [DaftarUsahaController::class, 'getNpwrdSequence']);

Route::get('/permohonan/faktur/retribusi/{daftar_id}', [PermohonanFakturController::class, 'getRetribusiByNpwrd']);
Route::get('/permohonan/faktur/get-data/{npwrd}', [PermohonanFakturController::class, 'getData'])->name('permohonan-faktur.getData');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    // Manajemen Level / Roles
    Route::get('/roles', [LevelController::class, 'index'])->name('roles.index')->middleware('can:read-manajemen-level');
    Route::get('/manajemen-level', [LevelController::class, 'index'])->name('manajemen-level')->middleware('can:read-manajemen-level');
    Route::get('/roles/{roleId}/menus', [LevelController::class, 'getMenus'])->middleware('can:read-manajemen-level');
    Route::get('/roles/{roleId}/permissions', [LevelController::class, 'getPermissions'])->middleware('can:read-manajemen-level');
    Route::get('/roles/create', [LevelController::class, 'create'])->name('roles.create')->middleware('can:create-manajemen-level');
    Route::post('/roles/store', [LevelController::class, 'store'])->name('roles.store')->middleware('can:create-manajemen-level');
    Route::get('/roles/{id}/edit', [LevelController::class, 'edit'])->name('roles.edit')->middleware('can:edit-manajemen-level');
    Route::put('/roles/{id}', [LevelController::class, 'update'])->name('roles.update')->middleware('can:edit-manajemen-level');
    Route::post('/roles/{roleId}/save-permissions', [LevelController::class, 'savePermission'])->name('roles.savePermissions')->middleware('can:edit-manajemen-level');
    Route::post('/roles/{role}/permissions/update', [LevelController::class, 'updatePermissions'])->name('roles.permissions.update')->middleware('can:edit-manajemen-level');
    Route::delete('/roles/{id}', [LevelController::class, 'destroy'])->name('roles.destroy')->middleware('can:delete-manajemen-level');

    // Manajemen User
    Route::get('/manajemen-user', [UserController::class, 'index'])->name('manajemen-user')->middleware('can:read-manajemen-user');
    Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('can:read-manajemen-user');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('can:create-manajemen-user');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store')->middleware('can:create-manajemen-user');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('can:edit-manajemen-user');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update')->middleware('can:edit-manajemen-user');
    Route::put('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status')->middleware('can:edit-manajemen-user');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('can:delete-manajemen-user');

    //Manajemen Berita
    Route::get('/manajemen-berita', [NewsController::class, 'index'])->name('manajemen-berita')->middleware('can:read-manajemen-berita');
    Route::post('news', [NewsController::class, 'store'])->name('news.store')->middleware('can:create-manajemen-berita');
    Route::get('news/{id}', [NewsController::class, 'show'])->name('news.show')->middleware('can:edit-manajemen-berita');
    Route::put('news/{id}', [NewsController::class, 'update'])->name('news.update')->middleware('can:edit-manajemen-berita');
    Route::put('news/{id}/toggle-status', [NewsController::class, 'toggleStatus'])->name('news.toggle-status')->middleware('can:edit-manajemen-berita');
    Route::delete('news/{id}', [NewsController::class, 'destroy'])->name('news.destroy')->middleware('can:delete-manajemen-berita');

    //Sts / rekap setor struk
    Route::get('/rekap/setor/struk', [StsController::class, 'index'])->name('pages.sts.index')->middleware('can:read-rekap-setor-struk');
    Route::get('/prn-ba-sts', [StsController::class, 'cetakPdf'])->name('cetak.sts.pdf')->middleware('can:print-rekap-setor-struk');

    //Laporan Penerimaan
    Route::get('/laporan/penerimaan', [LaporanPenerimaanController::class, 'index'])->name('pages.laporan.penerimaan.index')->middleware('can:read-laporan-penerimaan');
    Route::get('/prn-ba-lap/{id}', [LaporanPenerimaanController::class, 'cetakPdf'])->name('cetak.laporan.penerimaan.pdf')->middleware('can:print-laporan-penerimaan');

    //Laporan Persediaan
    route::get('/laporan/persediaan/struk', [LaporanPersediaanController::class, 'index'])->name('pages.laporan.persediaan.index')->middleware('can:read-laporan-persediaan');

    //Laporan Permohonan
    Route::get('/laporan/permohonan', [LaporanPermohonanController::class, 'index'])->name('pages.laporan.permohonan.index')->middleware('can:read-laporan-permohonan');

    //Laporan Struk
    Route::get('/laporan/stok/struk', [LaporanStrukController::class, 'index'])->name('pages.laporan.struk.index')->middleware('can:read-laporan-stok-struk');

    //Verifikasi Permohonan
    Route::get('/verifikasi/permohonan', [VerifikasiPermohonanController::class, 'index'])->name('pages.verifikasi.permohonan.index')->middleware('can:read-verifikasi-permohonan');
    Route::post('/verifikasi/permohonan/store', [VerifikasiPermohonanController::class, 'store'])->name('verifikasi.permohonan.store');
    Route::get('/permohonan/{id}/validasi', [VerifikasiPermohonanController::class, 'showValidationForm'])->name('pages.verifikasi.permohonan.validasi')->middleware('can:read-verfikasi-permohonan');
    Route::put('/verifikasi/permohonan/{id}', [VerifikasiPermohonanController::class, 'update'])->name('verifikasi.permohonan.update')->middleware('can:edit-verifikasi-permohonan');
    Route::post('/permohonan/update-status', [VerifikasiPermohonanController::class, 'updateStatus'])->middleware('can:edit-verifikasi-permohonan');
    Route::get('/verifikasi/permohonan/cetak/{id}', [VerifikasiPermohonanController::class, 'cetak'])->name('pages.verifikasi.permohonan.cetak')->middleware('can:print-verifikasi-permohonan');
    Route::get('/prn-ba-karcis', [VerifikasiPermohonanController::class, 'cetakPdf'])->name('cetak.karcis.pdf')->middleware('can:print-verifikasi-permohonan');

    //Daftar Usaha
    Route::get('/daftar/usaha', [DaftarUsahaController::class, 'index'])->name('pages.daftar.usaha.index')->middleware('can:read-daftar-usaha');
    Route::post('/daftar/usaha/store', [DaftarUsahaController::class, 'store'])->name('daftar.usaha.store')->middleware('can:create-daftar-usaha');
    Route::get('/daftar/usaha/edit/{id}', [DaftarUsahaController::class, 'edit'])->name('daftar.usaha.edit')->middleware('can:edit-daftar-usaha');
    Route::put('/daftar/usaha/update/{id}', [DaftarUsahaController::class, 'update'])->name('daftar.usaha.update')->middleware('can:edit-daftar-usaha');
    Route::get('/daftar/usaha/cetak/{id}', [DaftarUsahaController::class, 'cetak'])->name('pages.daftar.usaha.cetak')->middleware('can:print-daftar-usaha');
    Route::get('/daftar/usaha/cetak/{id}/pdf', [DaftarUsahaController::class, 'cetakPdf'])->name('pages.daftar.usaha.cetak')->middleware('can:print-daftar-usaha');
    Route::delete('/daftar/usaha/{id}', [DaftarUsahaController::class, 'destroy'])->name('daftar.usaha.destroy')->middleware('can:delete-daftar-usaha');
    Route::get('/daftar/usaha/{id}/lihat', [DaftarUsahaController::class, 'lihat'])->name('pages.daftar.usaha.lihat')->middleware('can:edit-daftar-usaha');

    //Permohonan Faktur
    Route::get('/permohonan/faktur', [PermohonanFakturController::class, 'index'])->name('pages.permohonan.faktur.index')->middleware('can:read-permohonan-faktur');
    Route::post('/permohonan/faktur/store', [PermohonanFakturController::class, 'store'])->name('permohonan-faktur.store')->middleware('can:create-permohonan-faktur');

    //Registrasi
    Route::get('/registrasi', [RegistrasiController::class, 'index'])->name('pages.registrasi.index')->middleware('can:read-registrasi');

    //Daftar Penetapan Billing
    Route::get('/penetapan/billing', [BillingController::class, 'index'])->name('penetapan.billing.index')->middleware('can:read-penetapan-billing');
    Route::get('/penetapan/billing/cetak/{id}', [BillingController::class, 'cetak'])->name('pages.penetapan.billing.cetak')->middleware('can:print-penetapan-billing');
    Route::get('/billing/cetak/{id}', [BillingController::class, 'cetak'])->name('billing.cetak')->middleware('can:print-penetapan-billing');
    Route::post('/penetapan/billing/store', [BillingController::class, 'store'])->name('billing.store')->middleware('can:create-penetapan-billing');

    //Input SSRD
    Route::get('/input/ssrd', [InputSsrdController::class, 'index'])->name('pages.input.ssrd.index')->middleware('can:read-input-ssrd');
    Route::post('/store', [InputSsrdController::class, 'store'])->name('ssrd.store')->middleware('can:create-input-ssrd');
});




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});
Route::get('/dashboard', 'MainController@dashboard')->name('dashboard');
Route::get('/permohonan/retur/usaha', 'MainController@permohonanReturUsaha')->name('permohonan-retur-usaha');
Route::get('/laporan/retur/struk', 'MainController@laporanReturStruk')->name('laporan-retur-struk');
Route::get('/manajemen/user', 'MainController@manajemenUser')->name('manajemen-user');
Route::get('/manajemen/struk', 'MainController@manajemenStruk')->name('manajemen-struk');
Route::get('/manajemen/pejabat', 'MainController@manajemenPejabat')->name('manajemen-pejabat');
