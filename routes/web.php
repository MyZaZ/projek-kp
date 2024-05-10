<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaOperatorController;
use App\Http\Controllers\BerandaWaliController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WaliController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\WaliSiswaController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\KwitansiPembayaranController;
use App\Http\Controllers\KartuSppController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WaliMuridSiswaController;
use App\Http\Controllers\WaliMuridTagihanController;
use App\Http\Controllers\WaliMuridPembayaranController;
use App\Http\Controllers\PembayaranRekeningController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\LaporanFormController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// routes/web.php




Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);

Route::prefix('operator')->middleware(['auth', 'auth.operator'])->group(function () {
    //ini route khusus untuk operator
    Route::get('beranda', [BerandaOperatorController::class, 'index'])->name('operator.beranda');
    Route::resource('user', UserController::class);
    Route::resource('wali', WaliController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('walisiswa', WaliSiswaController::class);
    Route::resource('biaya', BiayaController::class);
    Route::resource('tagihan', TagihanController::class);
    Route::resource('pembayaran', PembayaranController::class);
    Route::resource('rekening', PembayaranRekeningController::class);
    Route::get('kwitansi-pembayaran/{id}', [KwitansiPembayaranController::class, 'show'])->name('kwitansipembayaran.show');
    Route::get('kartuspp', [KartuSppController::class, 'index'])->name('kartuspp.index');
    Route::resource('bank', BankController::class);
    Route::post('/users', [UserController::class, 'store'])->name('userstore');
    Route::post('/wali', [WaliController::class, 'store'])->name('walistore');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswastore');
    Route::post('/biaya', [BiayaController::class, 'store'])->name('biayastore');
    Route::post('/rekening', [PembayaranRekeningController::class, 'store'])->name('rekeningstore');
    Route::post('/tagihan', [TagihanController::class, 'store'])->name('tagihanstore'); 
    //ini route laporan
    Route::get('laporan/create',[LaporanFormController::class,'create'])->name('laporanform.create');
});

Route::get('login-wali',[LoginController::class,'showLoginFormWali'])->name('login.wali');
Route::prefix('wali')->middleware(['auth', 'auth.wali'])->name('wali.')->group(function () {
    //ini route khusus untuk wali-murid
    Route::get('beranda', [BerandaWaliController::class, 'index'])->name('beranda');
    Route::get('/wali/pembayaran/create', [WaliMuridPembayaranController::class, 'create'])->name('wali.pembayaran.create');
    Route::resource('siswa', WaliMuridSiswaController::class);
    Route::resource('tagihan', WaliMuridTagihanController::class);
    Route::resource('pembayaran', WaliMuridPembayaranController::class);
    Route::resource('bank', BankController::class);
});


Route::prefix('admin')->middleware(['auth', 'auth.admin'])->group(function () {
    //ini route khusus untuk admin
});

Route::get('logout', function () {
    Auth::logout();
    return redirect('login');
})->name('logout');
