<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', 'App\Http\Controllers\userController@logout')->name('logout.api');
    Route::get('/user', 'App\Http\Controllers\userController@userdata')->name('user.api');
});


Route::post('/register', 'App\Http\Controllers\Auth\registerController@register');
Route::post('/login', 'App\Http\Controllers\Auth\loginController@login');
