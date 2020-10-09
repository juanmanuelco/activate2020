<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');


Route::middleware(['auth', 'permissions'])->group(function () {
    Route::get('group/assign', [GroupController::class, 'assign'] )->name('group.assign');
    Route::post('group/assign', [GroupController::class, 'assign_post'] )->name('group.assign_post');
    Route::resource('group', 'GroupController');
    Route::resource('builder', 'BuilderController');
    Route::resource('imageFIle', 'ImageFileController');

    Route::get('role/assign', [RoleController::class, 'assign'])->name('role.assign');
    Route::post('role/assign', [RoleController::class, 'assign_post'])->name('role.assign_post');

    Route::get('role/apply/{role}', [RoleController::class, 'apply'])->name('role.apply');
    Route::resource('role', 'RoleController');

    Route::post('notification/remove',  [NotificationController::class, 'remove'])->name('notification.remove');
    Route::resource('notification', 'NotificationController');

    Route::get('permission/assign', [PermissionController::class, 'assign'])->name('permission.assign');
    Route::post('permission/assign', [PermissionController::class, 'assign_post'])->name('permission.assign_post');
    Route::resource('permission', 'PermissionController');
});

Route::get('/page/{page}', 'BuilderController@page')->name('page_name');
