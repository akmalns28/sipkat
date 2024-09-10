<?php

use App\Models\Monitoring;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\SumurPantauController;

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

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/preview', [LaporanController::class, 'preview'])->name('laporan.preview');
});

Route::middleware('role:super admin')->group(function () {
    Route::resource('user', UserController::class)->except('show');
    Route::get('/get-users', [UserController::class, 'getUsers'])->name('user.getUsers');
    Route::get('/setting/ubah-profil', [UserController::class, 'setting'])->name('user.setting');
    Route::put('setting/akun/update-password/{id}', [UserController::class, 'updatePassword'])->name('user.updatePassword');

    Route::resource('sumur-pantau', SumurPantauController::class);
    Route::get('/get-sumur-pantau', [SumurPantauController::class, 'getSumurPantau'])->name('sumur-pantau.getSumurPantau');
    Route::get('/provinsi', [SumurPantauController::class, 'getProvinsi']);
    Route::get('/kota/{provinsiId}', [SumurPantauController::class, 'getKota']);
    Route::get('/kecamatan/{kotaId}', [SumurPantauController::class, 'getKecamatan']);
    Route::get('/kelurahan/{kecamatanId}', [SumurPantauController::class, 'getKelurahan']);
});

Route::middleware('role:admin,super admin')->group(function () {
    Route::resource('monitoring', MonitoringController::class)->except('edit', 'update', 'destroy');
    Route::get('/get-monitoring', [MonitoringController::class, 'getMonitoring'])->name('monitoring.getMonitoring');
    Route::post('/monitoring/{hashid}/filter', [MonitoringController::class, 'filter'])->name('monitoring.filter');
    Route::get('/insert-monitoring-data', [MonitoringController::class, 'insertMonitoringData']);
});
