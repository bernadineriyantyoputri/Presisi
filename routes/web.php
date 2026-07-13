<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\VerifikasiController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\DataRetribusiController;
use App\Http\Controllers\Admin\PengaturanController as AdminPengaturanController;
use App\Http\Controllers\Perangkat\LaporanRetribusiController;
use App\Http\Controllers\Perangkat\PengaturanController as PerangkatPengaturanController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/login');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::controller(AuthController::class)->group(function () {

    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');

    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');

    Route::post('/logout', 'logout')->name('logout');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::view('/perangkat', 'perangkat.dashboard')
        ->name('perangkat');

    Route::redirect('/admin', '/admin/verifikasi')
        ->name('admin');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->controller(VerifikasiController::class)
    ->group(function () {

        Route::get('/verifikasi', 'index')
            ->name('verifikasi');

        Route::get('/verifikasi/{id}', 'detail')
            ->name('verifikasi.detail');

        Route::post('/verifikasi/{id}', 'verifikasi')
            ->name('verifikasi.proses');

        Route::post('/verifikasi/{id}/tolak', 'tolak')
            ->name('verifikasi.tolak');

    });

Route::middleware('auth')
    ->prefix('admin/laporan')
    ->name('admin.laporan.')
    ->controller(LaporanController::class)
    ->group(function () {

        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'detail')->name('detail');
        Route::post('/{id}/verifikasi', 'verifikasi')->name('verifikasi');
        Route::post('/{id}/tolak', 'tolak')->name('tolak');

    });

/*LAPORAN RETRIBUSI PERANGKAT DAERAH*/

Route::middleware('auth')
    ->prefix('perangkat/laporan')
    ->name('perangkat.laporan.')
    ->controller(LaporanRetribusiController::class)
    ->group(function () {

        Route::get('/', 'index')->name('index');

        Route::get('/create', 'create')->name('create');
        Route::post('/create/jenis', 'pilihJenis')->name('create.jenis');

        Route::get('/create/objek', 'showObjek')->name('create.objek.show');
        Route::post('/create/objek', 'pilihObjek')->name('create.objek');

        Route::get('/create/nominal', 'nominalShow')->name('create.nominal.show');
        Route::post('/create/nominal', 'nominalStore')->name('create.nominal.store');

        Route::get('/create/confirm', 'confirmShow')->name('create.confirm.show');

        Route::post('/store', 'store')->name('store');

        Route::get('/{id}/selesai', 'selesai')->name('selesai');
        Route::get('/{id}/pdf', 'cetakPdf')->name('pdf');

        Route::get('/{id}', 'show')->name('show');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::post('/{id}/submit', 'submit')->name('submit');
    });
Route::middleware('auth')
    ->prefix('perangkat')
    ->name('perangkat.')
    ->controller(LaporanRetribusiController::class)
    ->group(function () {

        Route::get('/riwayat', 'riwayat')->name('riwayat');
    });
/*
|--------------------------------------------------------------------------
| PENGATURAN PERANGKAT
|--------------------------------------------------------------------------
*/
Route::middleware('auth')
    ->prefix('perangkat/pengaturan')
    ->name('perangkat.pengaturan.')
    ->controller(PerangkatPengaturanController::class)
    ->group(function () {

        Route::get('/profil', 'profil')
            ->name('profil');
        Route::put('/profil', 'updateProfil')
            ->name('profil.update');
        Route::get('/password', 'password')
            ->name('password');
        Route::put('/password', 'updatePassword')
            ->name('password.update');
    });

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/data-retribusi', [DataRetribusiController::class, 'index'])->name('data.index');
        Route::get('/data-retribusi/{jenis}', [DataRetribusiController::class, 'showJenis'])->name('data.jenis');
        Route::get('/objek/{objek}', [DataRetribusiController::class, 'showObjek'])->name('data.objek');
        Route::get('/rincian/{rincian}', [DataRetribusiController::class, 'showRincian'])->name('data.rincian');
        Route::post('/jenis', [DataRetribusiController::class, 'storeJenis'])->name('jenis.store');
        Route::post('/objek', [DataRetribusiController::class, 'storeObjek'])->name('objek.store');
        Route::post('/rincian', [DataRetribusiController::class, 'storeRincian'])->name('rincian.store');
        Route::post('/detail', [DataRetribusiController::class, 'storeDetail'])->name('detail.store');

    });

/*
|--------------------------------------------------------------------------
| PENGATURAN ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware('auth')
    ->prefix('admin/pengaturan')
    ->name('admin.pengaturan.')
    ->controller(AdminPengaturanController::class)
    ->group(function () {

        Route::get('/profil', 'profil')
            ->name('profil');
        Route::put('/profil', 'updateProfil')
            ->name('profil.update');
        Route::get('/password', 'password')
            ->name('password');
        Route::put('/password', 'updatePassword')
            ->name('password.update');
    });