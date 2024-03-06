<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\V1\{
Backend\CategoryController,
Backend\ProductController,
Backend\CouponController,
Backend\SliderController,
Backend\UserController,
Backend\OrderProcessController,
Frontend\HomeController,
Frontend\FavoriteController,
Frontend\CheckoutController,
Frontend\ReviewController,
Frontend\OrdersController,
};

// /
// |--------------------------------------------------------------------------
// | API Routes
// |--------------------------------------------------------------------------

//Auth Routes
Route::middleware(['json.header'])->group(function () {
Route::prefix('/Auth')->controller(AuthenticationController::class)->group(function(){
    Route::post('/login' , 'loginUser');
    Route::post('/register' , 'createUser');
    Route::post('/forgot' , 'forgotPassword');
    Route::post('/reset' , 'resetPassword')->name('password.reset');
});
// Get Products and categories api
Route::get('/home/page', [HomeController::class, 'getAllPC']);
Route::get('/home/products', [HomeController::class, 'HomeProduct']);
Route::get('/home/categories', [HomeController::class, 'HomeCategory']);
});

//Backend Routes
Route::group(['middleware' => ['json.header','auth:sanctum','Admin']], function () {
Route::prefix('/v1')->group(function(){
        //API Routes
        Route::apiResource('/categories', CategoryController::class);
        Route::apiResource('/products', ProductController::class);
        Route::apiResource('/Coupons', CouponController::class);
        Route::apiResource('/sliders', SliderController::class);
        Route::post('/products/img/{id}', [ProductController::class, 'updateImages']);
        Route::post('/slider/update/{id}', [SliderController::class, 'update']);
        Route::post('/Category/update/{id}', [CategoryController::class, 'update']);
});
    //Order process
    Route::controller(OrderProcessController::class)->group(function(){
       Route::post('/order/status/{order}' , 'StatusOrderProcess');
       Route::get('/get/all/order' , 'GetAllOrders');
    });
});

//Frontend Routes
Route::group(['middleware' => ['auth:sanctum','json.header']], function () {
//ReviewAPI Routes
Route::apiResource('/reviews', ReviewController::class)->only(['index', 'show','store']);
//FavoriteAPI Routes
Route::apiResource('/favorite', FavoriteController::class)->only(['index', 'destroy','store']);


//checkout and get order Routes
Route::controller(CheckoutController::class)->group(function(){
    Route::post('/checkout/order' , 'checkoutOrders');
    Route::post('/order/remove/{orderId}' , 'declineOrder');
    Route::get('/get/order' , 'viewPastOrders');
});
//logout Routes
Route::get('/logout/{id}', [AuthenticationController::class, 'logout']);
  //user update routes protected by policy
  Route::controller(UserController::class)->group(function(){
    Route::post('/Update/user' , 'UserProfileUpdate');
    Route::post('/Update/password' , 'userPasswordUpdate');
    Route::get('/Update/role/{user}' , 'AdminRoleUpdate');
    Route::get('/all/users' , 'index');
});
});


