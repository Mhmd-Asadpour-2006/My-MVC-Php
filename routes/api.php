<?php

use App\Http\Controllers\UserControllerApi;
use Core\Router\Api\Route;

Route::get('/create_user',[UserControllerApi::class, 'create']);
Route::post('/store_user',[UserControllerApi::class, 'store']);