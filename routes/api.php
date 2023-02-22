<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\ReviewQuestionController;
use App\Http\Controllers\API\V1\UserReviewController;
use Illuminate\Support\Str;

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



    Route::group(['middleware' => ['guest']], function(){
        Route::get('oauth', [AuthController::class, 'connect'])->name('connect');
        Route::get('callback', [AuthController::class, 'callback'])->name('callback');
    });

    Route::get('uuid', function(){
        return Str::uuid()->toString();
    });
    Route::get('user/{id}/avatar', [AuthController::class, 'userPics'])->name('userPics');

    Route::group(['middleware' => ['auth:api']], function(){

        Route::get('user-details', [AuthController::class, 'getUserData'])->name('getUserData');
        // Common routes
        Route::post('validate-token', function(){
            return response()->json(['tokenValid' => true]);
        })->name('tokenValidation');
        Route::get('get-users', [ReviewQuestionController::class, 'getUsers'])->name('getUsers');
        Route::get('review-question', [ReviewQuestionController::class, 'index'])->name('getRevQuestion');

        Route::post('save-review', [UserReviewController::class, 'store'])->name('storeReview');
        
        Route::group(['middleware' => 'role:admin'], function() {
            Route::get('get-reviews/{uuid}', [UserReviewController::class, 'index'])->name('getReviews');
            Route::post('validate-access', function(){
                return true;
            })->name('validateAccess');
            Route::get('/download-report/{id}/{type}', [UserReviewController::class, 'downloadReport']);
        });
    });


});

