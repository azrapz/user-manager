<?php

use App\Http\Controllers\Api\UserController;
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

Route::post('login', [UserController::class, 'login'])->name('login');

Route::group(
    ['middleware' => 'auth:sanctum'],
    function () {
        Route::get('users', [UserController::class, 'index']);
        Route::post('user', [UserController::class, 'store']);
        Route::put('user', [UserController::class, 'update']);
        Route::delete('user', [UserController::class, 'delete']);
        Route::get('get-user-data', [UserController::class, 'getData']);
        Route::post('assign-role', [UserController::class,'assignRole']);
        Route::get('role-check', [UserController::class, 'checkRole']);
    }
);
