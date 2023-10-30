<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Admin\CategoryController;
use App\Http\Controllers\Api\V1\Admin\AttributeController;
use App\Http\Controllers\Api\V1\Admin\BrandController;
use App\Http\Controllers\Api\V1\Admin\ModelProductController;
use App\Http\Controllers\Api\V1\Admin\AttributeTemporaryValueController;
use App\Http\Controllers\Api\V1\Auth\CaptchaImageController;
use App\Http\Controllers\Api\V1\General\RegionController;
use App\Http\Controllers\Api\V1\General\AreaController;
use App\Http\Controllers\Api\V1\SimpleUser\Product\ProductController;
use App\Http\Controllers\Api\V1\SimpleUser\SimpleUserCategoryController;
use App\Http\Controllers\Api\V1\SimpleUser\SimpleUserBrandController;
use App\Http\Controllers\Api\V1\SimpleUser\SimpleUserModelProductController;
use App\Http\Controllers\Api\V1\SimpleUser\SimpleUserRegionController;
use App\Http\Controllers\Api\V1\SimpleUser\SimpleUserAreaController;
use App\Http\Controllers\Api\V1\SimpleUser\MediaFile\MediaFileController;

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


Route::group(['prefix' => 'admin'], function () {
    Route::post('auth/login', [AuthController::class, 'loginAdmin']);
});

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

        Route::post('/attribute-temporary-value/{attribute}', [AttributeTemporaryValueController::class, 'store']);
        Route::put('/attribute-temporary-value/{attributeTemporaryValue}', [AttributeTemporaryValueController::class, 'update']);
        Route::delete('/attribute-temporary-value/{attributeTemporaryValue}', [AttributeTemporaryValueController::class, 'destroy']);

        Route::get('/brand', [BrandController::class, 'index'])->middleware('permission:brand-delete');
        Route::post('/brand', [BrandController::class, 'store'])->middleware('permission:brand-delete');
        Route::post('/brand-update/{brand}', [BrandController::class, 'update'])->middleware('permission:brand-delete');
        Route::delete('/brand/{brand}', [BrandController::class, 'destroy'])->middleware('permission:brand-delete');


        Route::get('/model', [ModelProductController::class, 'index']);
        Route::get('/model/{model_product}', [ModelProductController::class, 'show']);
        Route::post('/model', [ModelProductController::class, 'store']);
        Route::put('/model/{model_product}', [ModelProductController::class, 'update']);
        Route::delete('/model/{model_product}', [ModelProductController::class, 'destroy']);
    });
    Route::group(['prefix' => 'simple-user'], function () {
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::group(['prefix' => 'product'], function () {
            Route::get('/', [ProductController::class, 'index'])->middleware('permission:product-index');
            Route::get('/{product}', [ProductController::class, 'show'])->middleware('permission:product-show');
            Route::post('/{product}', [ProductController::class, 'update'])->middleware('permission:product-update');
            Route::post('/', [ProductController::class, 'store'])->middleware('permission:product-store');
        });
        Route::group(['prefix' => 'media-file'], function () {
            Route::post('/product-image' , [MediaFileController::class,'store_product_image']);
        });
    });


});
//simple user routes

Route::group(['prefix' => 'simple-user'], function () {
    Route::post('/auth/check', [AuthController::class, 'check']);
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/send-sms-code', [AuthController::class, 'send_sms_code']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/resend', [AuthController::class, 'resend']);


    Route::get('/get-captcha', [CaptchaImageController::class, 'get_captcha']);
    Route::get('/category', [SimpleUserCategoryController::class, 'index']);
    Route::get('/brand', [SimpleUserBrandController::class, 'index']);
    Route::get('/model', [SimpleUserModelProductController::class, 'index']);
    Route::get('/model/{model_product}', [SimpleUserModelProductController::class, 'show']);
    Route::get('/regions', [SimpleUserRegionController::class, 'index']);
    Route::get('/areas', [SimpleUserAreaController::class, 'index']);
});

