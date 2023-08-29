<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FarmaciaController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/farmacias', [FarmaciaController::class, 'list']);
Route::put('/farmacias', [FarmaciaController::class, 'search']);
Route::post('/farmacias', [FarmaciaController::class, 'insert']);
Route::post('/farmacias{farmacia}', [FarmaciaController::class, 'update']);
Route::get('/farmacias/{farmacia}', [FarmaciaController::class, 'get']);
Route::delete('/farmacias/{farmacia}', [FarmaciaController::class, 'delete']);