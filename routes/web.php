<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengaduanController;




Route::get('/login', [AuthController::class, 'login']);
Route::post('/actionlogin', [AuthController::class, 'actionLogin']);


Route::get('/register', [AuthController::class, 'register']);
Route::post('/actionregister', [AuthController::class, 'actionRegister']);

Route::get('/pengaduan', function () {
    return view('pengaduan');
})->middleware('auth.login');
Route::post('/pengaduan/store', [PengaduanController::class, 'store'])->name('pengaduan.store')->middleware('auth.login');
Route::get('/pengaduan/{id}/edit', [PengaduanController::class, 'edit'])->middleware('auth.login');
Route::put('/pengaduan/{id}', [PengaduanController::class, 'update'])->middleware('auth.login');
Route::delete('/pengaduan/{id}', [PengaduanController::class, 'destroy'])->middleware('auth.login');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware('auth.login');

Route::get('/admin/pengaduan/{id}/tanggapi', [App\Http\Controllers\PengaduanController::class, 'tanggapi'])->middleware('auth.login');
Route::post('/admin/pengaduan/{id}/tanggapi', [App\Http\Controllers\PengaduanController::class, 'storeTanggapan'])->middleware('auth.login');
Route::get('/admin/tanggapan/{id}/edit', [App\Http\Controllers\PengaduanController::class, 'editTanggapan'])->middleware('auth.login');
Route::put('/admin/tanggapan/{id}', [App\Http\Controllers\PengaduanController::class, 'updateTanggapan'])->middleware('auth.login');

Route::get('/logout', [AuthController::class, 'logout']);


Route::get('/', function () {
    return view('login');
});