<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CepController;

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


//Route::get('/search/{cep}', [CepController::class, 'search']);

Route::controller(CepController::class)->group(function () {
    Route::get('/cep-search/{cep}', 'show')->name('show');
    Route::post('cep-update', [CepController::class, 'update']);
    Route::delete('/cep-delete/{id}', [CepController::class, 'destroy']);
    Route::post('cep-fuzzy-search', [CepController::class, 'fuzzySearch']);
});

