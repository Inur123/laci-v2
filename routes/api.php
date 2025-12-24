<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KegiatanController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('restrict.api')->prefix('kegiatan')->group(function () {
    Route::get('/', [KegiatanController::class, 'index']);
    Route::get('/filter/upcoming', [KegiatanController::class, 'upcoming']);
    Route::get('/filter/past', [KegiatanController::class, 'past']);
    Route::get('/filter/month/{year}/{month}', [KegiatanController::class, 'month']);
    Route::get('/filter/periode/{periodeId}', [KegiatanController::class, 'byPeriode']);
    Route::get('/stats/summary', [KegiatanController::class, 'stats']);
    Route::get('/{id}', [KegiatanController::class, 'show']);
});
