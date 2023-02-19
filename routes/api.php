<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

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

Route::post('/test', function (Request $request) {
  return response([
    'message' => 'This is a test route!'
  ], 200);
});

Route::prefix('/message')->middleware([])->group(function () {
  Route::get('/', [MessageController::class, 'receive']);
  Route::post('/', [MessageController::class, 'send']);
});
