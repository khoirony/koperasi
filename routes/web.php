<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
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
Route::get('/pegawai', [PegawaiController::class, 'index'])->middleware('auth');
Route::get('/peminjam', [PeminjamController::class, 'index'])->middleware('auth');

Route::get('/tambahpegawai', [AdminController::class, 'tambahpegawai'])->middleware('auth');
Route::post('/tambahpegawai', [AdminController::class, 'storepegawai'])->middleware('auth');
Route::get('/editpegawai/{id}', [AdminController::class, 'editpegawai'])->middleware('auth');
Route::post('/editpegawai', [AdminController::class, 'updatepegawai'])->middleware('auth');
Route::get('/hapuspegawai/{id}', [AdminController::class, 'hapuspegawai'])->middleware('auth');

Route::get('/tambahpeminjam', [PegawaiController::class, 'tambahpeminjam'])->middleware('auth');
Route::post('/tambahpeminjam', [PegawaiController::class, 'storepeminjam'])->middleware('auth');
Route::get('/editpeminjam/{id}', [PegawaiController::class, 'editpeminjam'])->middleware('auth');
Route::post('/editpeminjam', [PegawaiController::class, 'updatepeminjam'])->middleware('auth');
Route::get('/hapuspeminjam/{id}', [PegawaiController::class, 'hapuspeminjam'])->middleware('auth');

Route::get('/pinjamandiproses', [PegawaiController::class, 'pinjamandiproses'])->middleware('auth');
Route::get('/pinjamanditolak', [PegawaiController::class, 'pinjamanditolak'])->middleware('auth');
Route::get('/pinjamanditerima', [PegawaiController::class, 'pinjamanditerima'])->middleware('auth');

Route::get('/kelolatanggapan/{id}', [PegawaiController::class, 'kelolatanggapan'])->middleware('auth');
Route::post('/kelolatanggapan', [PegawaiController::class, 'storetanggapan'])->middleware('auth');
Route::get('/hapustanggapan/{id}', [PegawaiController::class, 'hapustanggapan'])->middleware('auth');

Route::get('/ajukanpinjaman', [PeminjamController::class, 'ajukanpinjaman'])->middleware('auth');
Route::post('/ajukanpinjaman', [PeminjamController::class, 'storepinjaman'])->middleware('auth');
Route::get('/historypinjaman', [PeminjamController::class, 'historypinjaman'])->middleware('auth');
Route::get('/notapinjaman/{id}', [PeminjamController::class, 'notapinjaman'])->middleware('auth');
Route::get('/editpinjaman/{id}', [PeminjamController::class, 'editpinjaman'])->middleware('auth');
Route::post('/editpinjaman/', [PeminjamController::class, 'storeedit'])->middleware('auth');
Route::get('/hapuspinjaman/{id}', [PeminjamController::class, 'hapuspinjaman'])->middleware('auth');

Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth');
Route::post('/profile', [ProfileController::class, 'edit'])->middleware('auth');
Route::post('/changepass', [ProfileController::class, 'changepass'])->middleware('auth');