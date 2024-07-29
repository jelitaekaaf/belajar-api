<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LigaController;
use App\Http\Controllers\Api\KlubController;
use App\Http\Controllers\Api\PemainController;
use App\Http\Controllers\Api\FansController;
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

//LIGA
Route::get('liga', [LigaController::class, 'index']);
Route::post('liga', [LigaController::class, 'store']);
Route::get('liga/{id}', [LigaController::class, 'show']);
Route::put('liga/{id}', [LigaController::class, 'update']);
Route::delete('liga/{id}', [LigaController::class, 'destroy']);

//KLUB
Route::get('klub', [KlubController::class, 'index']);
Route::post('klub', [KlubController::class, 'store']);
Route::get('klub/{id}', [KlubController::class, 'show']);
Route::put('klub/{id}', [KlubController::class, 'update']);
Route::delete('klub/{id}', [KlubController::class, 'destroy']);

//PEMAIN
Route::get('pemain', [PemainController::class, 'index']);
Route::post('pemain', [PemainController::class, 'store']);
Route::get('pemain/{id}', [PemainController::class, 'show']);
Route::put('pemain/{id}', [PemainController::class, 'update']);
Route::delete('pemain/{id}', [PemainController::class, 'destroy']);

//FANS
Route::get('fans', [FansController::class, 'index']);
Route::post('fans', [FansController::class, 'store']);
Route::get('fans/{id}', [FansController::class, 'show']);
Route::put('fans/{id}', [FansController::class, 'update']);
Route::delete('fans/{id}', [FansController::class, 'destroy']);
