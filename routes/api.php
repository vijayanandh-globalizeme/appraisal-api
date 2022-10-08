<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\AuthController;


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

Route::group(['namespace' => 'V1', 'prefix' => 'v1', 'as' => 'api.v1.'], function(){

    Route::group(['middleware' => [ 'guest']], function(){
        Route::get('oauth', [AuthController::class, 'connect'])->name('connect');
    });

    // Route::group(['middleware' => ['web']], function(){
    //     Route::get('callback', [AuthController::class, 'callback'])->name('callback');
    //     // Route::middleware('auth:api')->group( function () {
    //         Route::get('profile/{size}/image', [AuthController::class, 'showProfileImg'])->name('showProfile');

            
    //     // });
    // });

});

