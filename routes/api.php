<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Auth\SocialAuthController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    $token = $request->user()->createToken('token-name', ['api:get'])->plainTextToken;
    $data  = $request->user();
    $data->token = $token;
    return $data;
});

Route::get('auth', [SocialAuthController::class, 'redirectToAuth']);

Route::get('auth/callback', [SocialAuthController::class, 'handleAuthCallback']);

Route::middleware(['auth:sanctum'])->group(function() {
   Route::controller(ClientController::class)->group(function() {
     Route::post('client-profile','updateProfile');
   });
});

Route::middleware(['auth'])->group(function() {
  Route::controller(ProfileController::class)->group(function(){
     Route::post('/password','updatePassword');
  });
});

Route::middleware(['auth:sanctum','admin'])->group(function() {
    Route::controller(CategoryController::class)->group(function() {
      //Route::get('/categories','getCategory');
    });
  });

  Route::apiResources([
      'categories' => CategoryController::class,
      'products' => ProductController::class
  ]);
