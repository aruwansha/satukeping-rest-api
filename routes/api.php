<?php

use Illuminate\Support\Facades\Route;

Route::post('auth/register', 'AuthController@register');
Route::post('auth/login', 'AuthController@login');
Route::post('image/add', 'ImageController@add')->middleware('auth:api');
Route::delete('image/{image}', 'ImageController@delete')->middleware('auth:api');
Route::get('image/', 'ImageController@showImage');
Route::get('image/{id}', 'ImageController@showImageById');