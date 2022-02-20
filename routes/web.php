<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('login',function(){
    return view('auth.login');
})->name('user-login');
Route::get('users',function(){
    return view('users.index');
})->name('users');

Route::get('create-user',function(){
    return view('users.create');
})->name('create-user');

Route::get('edit-user/{id}',function(){
    return view('users.edit');
})->name('edit-user');

Route::get('assign-role/{id}',function(){
    return view('users.assign_role');
})->name('assign-role');
