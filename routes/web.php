<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\VerifikasiController;
use App\Http\Controllers\Perangkat\LaporanRetribusiController;

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

/*
|--------------------------------------------------------------------------
| LAPORAN RETRIBUSI PERANGKAT DAERAH
|--------------------------------------------------------------------------
| Wizard: create/jenis -> create/objek (cascading objek->rincian->detail)
|         -> create/nominal (step terpisah) -> confirm -> store
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->prefix('perangkat/laporan')
    ->name('perangkat.laporan.')
    ->controller(LaporanRetribusiController::class)
    ->group(function () {

        Route::get('/', 'index')->name('index');
        Route::get('/riwayat', 'riwayat')->name('riwayat');


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