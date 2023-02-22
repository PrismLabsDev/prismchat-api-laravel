<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\MessageController;

Route::prefix('/')->middleware([])->group(function () {
  Route::prefix('/auth')->middleware([])->group(function () {
    Route::post('/', [MessageController::class, 'receive']);
    Route::post('/', [MessageController::class, 'send']);
  });

  Route::prefix('/message')->middleware([])->group(function () {
    Route::get('/', [MessageController::class, 'receive']);
    Route::post('/', [MessageController::class, 'send']);
  });
});
