<?php

use App\Http\Controllers\HomePageController;
use App\Http\Controllers\PetaController;
use App\Http\Controllers\SpatialController;
use App\Http\Controllers\FaskesController;
use Illuminate\Support\Facades\Route;

// ── Homepage ──
Route::get('/', [HomePageController::class, 'index'])->name('homepage');
Route::get('/profil', [HomePageController::class, 'profil'])->name('profil');

// ── Peta Interaktif ──
Route::get('/peta', [PetaController::class, 'index'])->name('peta');

// ── CRUD Fasilitas Kesehatan ──
Route::resource('faskes', FaskesController::class);

// ── Query Spasial (API) ──
Route::prefix('api/spasial')->group(function () {
    Route::get('/terdekat', [SpatialController::class, 'terdekat']);
    Route::get('/radius', [SpatialController::class, 'dalamRadius']);
    Route::get('/jarak', [SpatialController::class, 'jarakDuaFaskes']);
    Route::get('/geojson', [SpatialController::class, 'geojson']);
    Route::get('/statistik-kecamatan', [SpatialController::class, 'statistikKecamatan']);
});

