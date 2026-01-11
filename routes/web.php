<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PeminjamController;

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

Route::get('/admin', [AdminController::class, 'index'])->middleware('auth');
Route::get('/nasabah', [NasabahController::class, 'index'])->middleware('auth');


Route::middleware(['auth'])->group(function () {
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


Route::get('/ajukanpinjaman', [NasabahController::class, 'ajukanpinjaman'])->middleware('auth');
Route::post('/ajukanpinjaman', [NasabahController::class, 'storepinjaman'])->middleware('auth');
Route::get('/historypinjaman', [NasabahController::class, 'historypinjaman'])->middleware('auth');
Route::get('/notapinjaman/{id}', [NasabahController::class, 'notapinjaman'])->middleware('auth');
Route::get('/editpinjaman/{id}', [NasabahController::class, 'editpinjaman'])->middleware('auth');
Route::post('/editpinjaman/', [NasabahController::class, 'storeedit'])->middleware('auth');
Route::get('/hapuspinjaman/{id}', [NasabahController::class, 'hapuspinjaman'])->middleware('auth');

Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth');
Route::post('/profile', [ProfileController::class, 'edit'])->middleware('auth');
Route::post('/changepass', [ProfileController::class, 'changepass'])->middleware('auth');