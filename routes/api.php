<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/categories', 'CategoryController@api_index')->name('api_categories_index');
Route::post('/login', 'UserController@api_login')->name('api_login');
Route::post('/register', 'UserController@api_register')->name('api_register');
Route::post('/recovery', 'UserController@api_recovery')->name('api_recovery');
Route::get('/current', 'UserController@current_user')->name('current_user');
Route::get('/notifications', 'NotificationController@api_notifications')->name('api_notifications');

Route::get('/countries', 'AppHelperController@api_countries_index')->name('api_countries_index');

Route::get('/roles', 'AppHelperController@api_roles')->name('api_roles');

Route::get('/geo', 'StoreController@api_index')->name('api_index');
