<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Admin\CategoryController;
use App\Http\Controllers\Api\V1\Admin\AttributeController;
use App\Http\Controllers\Api\V1\Admin\BrandController;
use App\Http\Controllers\Api\V1\Admin\ModelProductController;

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
Route::post('/auth/check', [AuthController::class, 'check']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::group(['prefix' => 'admin'], function () {
    Route::post('auth/login', [AuthController::class, 'loginAdmin']);
});
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/resend', [AuthController::class, 'resend']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/category', [CategoryController::class, 'index'])->middleware('permission:category-index');
        Route::post('/category', [CategoryController::class, 'store'])->middleware('permission:category-store');
        Route::post('/category-update/{category}', [CategoryController::class, 'update'])->middleware('permission:category-update');
        Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->middleware('permission:category-delete');

        Route::get('/attribute', [AttributeController::class, 'index']);
        Route::post('/attribute', [AttributeController::class, 'store']);
        Route::put('/attribute/{attribute}', [AttributeController::class, 'update']);
        Route::get('/attribute/{attribute}', [AttributeController::class, 'show']);
        Route::delete('/attribute/{attribute}', [AttributeController::class, 'destroy']);

        Route::get('/brand', [BrandController::class, 'index'])->middleware('permission:brand-delete');
        Route::post('/brand', [BrandController::class, 'store'])->middleware('permission:brand-delete');
        Route::post('/brand-update/{brand}', [BrandController::class, 'update'])->middleware('permission:brand-delete');
        Route::delete('/brand/{brand}', [BrandController::class, 'destroy'])->middleware('permission:brand-delete');


        Route::get('/model', [ModelProductController::class, 'index']);
        Route::post('/model', [ModelProductController::class, 'store']);
        Route::put('/model/{model_product}', [ModelProductController::class, 'update']);
        Route::delete('/model/{model_product}', [ModelProductController::class, 'destroy']);
    });

});
//simple user routes
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/brand', [BrandController::class, 'index']);

