<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PeminjamController;
use Illuminate\Support\Facades\Auth;

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


Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/', [LoginController::class, 'authenticate']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/dashboard', function () {
    if (Auth::user()->role_id == 1) {
        return redirect('/admin');
    } else {
        return redirect('/nasabah');
    }
})->middleware(['auth']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->middleware('auth');

    Route::get('/semuanasabah', [AdminController::class, 'semuaNasabah']);
    Route::put('/nasabah/toggle-status/{id}', [AdminController::class, 'toggleNasabahStatus']);
    Route::post('/tambahnasabah', [AdminController::class, 'storeNasabah']);
    Route::put('/updatenasabah/{id}', [AdminController::class, 'updateNasabah']);
    Route::get('/hapusnasabah/{id}', [AdminController::class, 'hapusNasabah']);
    
    Route::get('/pinjamandiproses', [AdminController::class, 'pinjamandiproses']);
    Route::get('/pinjamanditolak', [AdminController::class, 'pinjamanditolak']);
    Route::get('/pinjamanditerima', [AdminController::class, 'pinjamanditerima']);

    Route::get('/kelolatanggapan/{id}', [AdminController::class, 'kelolatanggapan']);
    Route::post('/kelolatanggapan', [AdminController::class, 'storetanggapan']);
    Route::get('/hapustanggapan/{id}', [AdminController::class, 'hapustanggapan']);

    Route::get('/semuatabungan', [AdminController::class, 'semuatabungan']);
    Route::post('/semuatabungan', [AdminController::class, 'storeTabungan']);
    Route::put('/semuatabungan/{id}', [AdminController::class, 'updateTabungan']);
    Route::get('/hapustabungan/{id}', [AdminController::class, 'destroyTabungan']);
});

Route::middleware(['auth', 'nasabah'])->group(function () {
    Route::get('/nasabah', [NasabahController::class, 'index']);
    
    Route::get('/ajukanpinjaman', [NasabahController::class, 'ajukanpinjaman']);
    Route::post('/ajukanpinjaman', [NasabahController::class, 'storepinjaman']);
    Route::get('/historypinjaman', [NasabahController::class, 'historypinjaman']);
    Route::get('/notapinjaman/{id}', [NasabahController::class, 'notapinjaman']);
    Route::put('/editpinjaman/{id}', [NasabahController::class, 'storeedit']);
    Route::get('/hapuspinjaman/{id}', [NasabahController::class, 'hapuspinjaman']);

    Route::get('/tabungansaya', [NasabahController::class, 'semuatabungan']);
    Route::post('/tabungansaya', [NasabahController::class, 'storeTabungan']);
});

Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth');
Route::post('/profile', [ProfileController::class, 'edit'])->middleware('auth');
Route::post('/changepass', [ProfileController::class, 'changepass'])->middleware('auth');