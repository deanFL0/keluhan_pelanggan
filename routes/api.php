<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeluhanPelangganController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::apiResource('keluhan-pelanggan', KeluhanPelangganController::class);

Route::get('keluhan-pelanggan/export/{format}', [KeluhanPelangganController::class, 'export'])
    ->name('keluhan-pelanggan.export')
    ->where('format', 'txt|csv|xls|pdf');

Route::post('keluhan-pelanggan/{id}/status', [KeluhanPelangganController::class, 'updateStatus'])
    ->name('keluhan-pelanggan.update-status');

Route::delete('keluhan-pelanggan/{id}/status', [KeluhanPelangganController::class, 'revertStatus'])
    ->name('keluhan-pelanggan.revert-status');