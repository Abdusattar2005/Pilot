<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\Company\OrderController;
use App\Http\Controllers\Api\V1\OrderController as OC;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\AdvertisementController;
/*
'middleware' => 'throttle:3,10'
Этот код позволяет пользователю с одного IP-адреса выполнять по 3 запроса в течении каждых 10 минут // 429 код
'middleware' => ['auth:api', 'throttle:60'] // 60 запросов в минуту
*/

Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);        
        Route::post('password/reset', [AuthController::class, 'password_reset']);
        Route::post('resend_email_code', [AuthController::class, 'resend_email_code']);

        Route::group(['middleware' => ['auth:sanctum']], function(){
            Route::get('info', [AuthController::class, 'info']);
            Route::post('logout', [AuthController::class, 'logout']);
            Route::post('password/edit', [AuthController::class, 'password_edit']);          
        });
});

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'account'], function(){   
    Route::put('status_subscription', [UserController::class, 'updateStatusSubscription']);
});


Route::group(['middleware' => ['auth:sanctum','role:tech_staff|company|pilot|flight_attendant','userban']], function(){    

    Route::group(['prefix' => 'account'], function(){        
        Route::put('edit', [UserController::class, 'editUser']);        
    });

    Route::group(['prefix' => 'push_token'], function(){        
        Route::put('', [UserController::class, 'editPushToken']);
        Route::get('user/{id}', [UserController::class, 'showPushToken'])->where('id', '[0-9]+');
    });
    

    //для компании
    Route::group(['middleware' => ['role:company']], function(){ 
        
        //заказы
        Route::group(['prefix' => 'company/orders'], function(){        
            Route::post('', [OrderController::class, 'store']);
            Route::delete('{id}', [OrderController::class, 'delete'])->where('id', '[0-9]+');
            Route::get('', [OrderController::class, 'index']);
            Route::get('{id}', [OrderController::class, 'show'])->where('id', '[0-9]+');
            //смена статуса отклика, 1 = approved, 2 = rejected,
            Route::put('responses/{id}/status_approved', [OrderController::class, 'editStatusApproved'])->where('id', '[0-9]+');
        });
    });

    Route::group(['middleware' => ['role:tech_staff|pilot|flight_attendant']], function(){         
        //заказы
        Route::group(['prefix' => 'orders'], function(){        
            Route::get('', [OC::class, 'index']);
            Route::post('{id}/respond', [OC::class, 'respond'])->where('id', '[0-9]+');
        });
    });



});

// :)
Route::group(['prefix' => 'info'], function ($router) {
    Route::get('/check_email/{email}', function () {
        return JsonSend([
            'exists_email' => \App\Models\User::where('email', request('email'))->exists(),
        ]);
    });
    
    Route::get('/list', function () {
        return JsonSend([
            'list_contracts' => \App\Models\ListContract::all(),
            'list_licenses' => \App\Models\ListLicense::all(),
            'list_planes' => \App\Models\ListPlane::all(),
            'list_positions' => \App\Models\ListPosition::all(),
            'list_salary' => \App\Models\ListSalary::all(),
        ]);
    });
});

Route::prefix('ads')->group(function () {
    Route::get('/banners', [AdvertisementController::class, 'banners']);
    Route::get('/text-ads', [AdvertisementController::class, 'textAds']); 
    Route::get('/feed', [AdvertisementController::class, 'adsFeed']);
});