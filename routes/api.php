<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\V1\Backend\CategoryController;
use App\Http\Controllers\Api\V1\Backend\ProductController;
use App\Http\Controllers\Api\V1\Backend\CouponController;
use App\Http\Controllers\Api\V1\Backend\SliderController;
use App\Http\Controllers\Api\V1\Backend\UserController;
use App\Http\Controllers\Api\V1\Frontend\HomeController;
use App\Http\Controllers\Api\V1\Frontend\FavoriteController;


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

//Auth Routes
Route::middleware(['json.header'])->group(function () {
Route::prefix('/Auth')->controller(AuthenticationController::class)->group(function(){

    Route::post('/login' , 'loginUser');
    Route::post('/register' , 'createUser');
    Route::post('/forgot' , 'forgotPassword');
    Route::post('/reset' , 'resetPassword')->name('password.reset');

});

Route::get('/home/page', [HomeController::class, 'Home']);

});

//Backend Routes
Route::group(['middleware' => ['json.header','auth:sanctum','Admin']], function () {
    Route::prefix('/v1')->group(function(){
        
        Route::apiResource('/categories', CategoryController::class);
        Route::apiResource('/products', ProductController::class);
        Route::apiResource('/Coupons', CouponController::class);
        Route::apiResource('/sliders', SliderController::class);
        Route::post('/products/img/{id}', [ProductController::class, 'updateImages']);
        Route::post('/slider/update/{id}', [SliderController::class, 'update']);
        Route::post('/Category/update/{id}', [CategoryController::class, 'update']);


        //user update 
        Route::controller(UserController::class)->group(function(){

            Route::post('/Update/user' , 'UserProfileUpdate');
            Route::post('/Update/password' , 'userPasswordUpdate');
            Route::post('/Update/role' , 'AdminRoleUpdate');
            Route::get('/all/users' , 'AllUser');
                   
        });

});
});

//Frontend Routes
Route::group(['middleware' => ['auth:sanctum','json.header']], function () {

//Favorite Routes  
Route::prefix('/favorite')->controller(FavoriteController::class)->group(function(){
    Route::post('/add/{product_id}','addToFavorite');
    Route::delete('/remove/{id}','removeFromFavorite');
    Route::get('/','getFavorite');   
});



    Route::post('/logout', [AuthenticationController::class, 'logout']);
});

// Route::post('/EmailOrderPlaced', [Products::class, 'SendMailForOrderPlaced']);



