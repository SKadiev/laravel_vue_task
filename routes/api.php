<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskControler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('request.logging')->group(function () {


    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::controller(TaskControler::class)->group(function () {
            Route::get('/tasks', 'index');
            Route::post('/task/add', 'store');
            Route::get('/task/edit/{task}', 'show');
            Route::get('/tasks/statusList', 'taskStatusList');
            Route::post('/task/update', 'update');
            Route::get('/tasks/expiration/{expiration}', 'sortByExpiration');
            Route::get('/tasks/searchByName', 'searchByName');
        });
    });
});
