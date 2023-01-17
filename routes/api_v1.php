<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Admin\CategoryController;
use App\Http\Controllers\Api\V1\Admin\BrandController;

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
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/category', [CategoryController::class, 'index']);
        Route::post('/category', [CategoryController::class, 'store']);
        Route::post('/category-update/{category}', [CategoryController::class, 'update']);
        Route::delete('/category/{category}', [CategoryController::class, 'destroy']);

        Route::get('/brand', [BrandController::class, 'index']);
        Route::post('/brand', [BrandController::class, 'store']);
        Route::post('/brand-update/{brand}', [BrandController::class, 'update']);
        Route::delete('/brand/{brand}', [BrandController::class, 'destroy']);
    });
});

