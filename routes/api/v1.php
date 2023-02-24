<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\MessageController;
use App\Http\Controllers\api\v1\AuthController;
use App\Http\Middleware\AuthenticationMiddleware;

Route::prefix('/')->group(function () {

  Route::post('/test', [AuthController::class, 'test'])->middleware([AuthenticationMiddleware::class]);

  Route::prefix('/auth')->middleware([])->group(function () {
    Route::get('/pubkey', [AuthController::class, 'pubkey']);
    Route::post('/request', [AuthController::class, 'request']);
    Route::post('/verify', [AuthController::class, 'verify']);
  });

  Route::prefix('/message')->middleware([])->group(function () {
    Route::get('/', [MessageController::class, 'receive'])->middleware([AuthenticationMiddleware::class]);
    Route::post('/', [MessageController::class, 'send']);
  });
});
