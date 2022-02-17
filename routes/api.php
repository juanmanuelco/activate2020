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
Route::post('/change-password/', 'UserController@api_change_password')->name('api_change_password');
Route::post('/change-roles', 'UserController@api_change_roles' )->name('api_change_roles');

Route::get('/notifications', 'NotificationController@api_notifications')->name('api_notifications');

Route::get('/countries', 'AppHelperController@api_countries_index')->name('api_countries_index');

Route::get('/roles', 'AppHelperController@api_roles')->name('api_roles');

Route::post('/read-card' , 'StoreController@read_card')->name('read-card');
Route::get('/applied-benefits' , 'StoreController@api_applied_benefits')->name('api_applied_benefits');

Route::get('/cards', 'CardController@api_index')->name('api_cards');
Route::get('/my-cards', 'CardController@api_my_cards')->name('api_my_cards');
Route::get('/my-applied-benefits', 'UserController@api_my_applied_benefits')->name('api_my_applied_benefits');

Route::post('/add-card', 'CardController@api_add_card')->name('api_add_card');
Route::post('/update-profile', 'UserController@api_profile_update')->name('api_profile_update');

Route::get('/geo', 'StoreController@api_index')->name('api_index');

Route::get('/sales', 'SaleController@api_sales')->name('api_sales');
Route::post('/pay-sale', 'SaleController@api_pay_sale')->name('api_pay_sale');

Route::post('/creat-chat-room', 'ChatRoomController@store')->name('chatroom.store');

Route::get('/card-sale', 'SaleController@api_cards_sale')->name('api_cards_sale');

