<?php

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\API\BusquedaController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


 
// Route::post('/tokens/create', function (Request $request) {
//     $token = $request->user()->createToken($request->token_name);
 
//     return ['token' => $token->plainTextToken];
// });

Route::post('login', [App\Http\Controllers\API\BaseController::class, 'login'])->name('api.login');

// Route::middleware(['auth:sanctum','throttle:1,1'])->group( function () {
Route::middleware(['auth:sanctum'])->group( function () {
    Route::get('busqueda', [BusquedaController::class,'index']);
    Route::get('busqueda-test', [BusquedaController::class,'busquedaTest']);
    
});

// Route::controller(BaseController::class)->group(function(){
//     Route::post('login', 'login');
// });
