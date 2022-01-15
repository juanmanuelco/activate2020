<?php

use App\Http\Controllers\BuilderController;
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
    $custom = \App\Models\Builder::where('option', 'index')->where('active', true)->first();
    return view('welcome')->with('custom', $custom);
})->name('home.index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');


Route::middleware(['auth', 'permissions'])->group(function () {
    Route::get('group/assign', [GroupController::class, 'assign'] )->name('group.assign');
    Route::post('group/assign', [GroupController::class, 'assign_post'] )->name('group.assign_post');
    Route::resource('group', 'GroupController');

    Route::get('builder/edit/{id}', [BuilderController::class, 'edition'])->name('builder.edition');
    Route::get('builder/insert', [BuilderController::class, 'insert'])->name('builder.insert');
    Route::post('builder/insert/post', [BuilderController::class, 'insert_post'])->name('builder.insert_post');
    Route::put('builder/insert/update', [BuilderController::class, 'insert_update'])->name('builder.insert_update');
    Route::resource('builder', 'BuilderController');
    Route::resource('imageFIle', 'ImageFileController');

    Route::get('role/assign', [RoleController::class, 'assign'])->name('role.assign');
    Route::post('role/assign', [RoleController::class, 'assign_post'])->name('role.assign_post');

    Route::get('role/apply/{role}', [RoleController::class, 'apply'])->name('role.apply');
    Route::resource('role', 'RoleController');

    Route::get('notification/my-notifications',  [NotificationController::class, 'my_notifications'])->name('notification.my_notifications');
    Route::post('notification/remove',  [NotificationController::class, 'remove'])->name('notification.remove');
    Route::get('notification/mailing', [NotificationController::class, 'mail'])->name('notification.mail');
    Route::post('notification/mailing', [NotificationController::class, 'mailing'])->name('notification.mailing');
    Route::resource('notification', 'NotificationController')->except(['destroy', 'edit', 'update']);

    Route::get('permission/assign', [PermissionController::class, 'assign'])->name('permission.assign');
    Route::post('permission/assign', [PermissionController::class, 'assign_post'])->name('permission.assign_post');
    Route::resource('permission', 'PermissionController');

    Route::post('configuration/delete', 'ConfigurationController@delete')->name('configuration.delete');
    Route::resource('configuration', 'ConfigurationController')->except('create', 'edit', 'show');

    Route::resource('audit', 'AuditController');

    Route::post('/profile/password', 'UserController@profile_password')->name('profile.password');
    Route::post('/profile/direction', 'UserController@profile_direction')->name('profile.direction');
    Route::post('/profile/configuration', 'UserController@profile_configuration')->name('profile.configuration');
    Route::post('/profile/image', 'UserController@profile_image')->name('profile.image');
    Route::post('/profile', 'UserController@profile_post')->name('profile.post');
    Route::get('/profile', 'UserController@profile')->name('profile.index');

    Route::get('/chat', 'ChatController@index')->name('chat.index');


    Route::resource('category', 'CategoryController');

    Route::resource('store', 'StoreController');

    Route::resource('branch', 'BranchController');
    Route::resource('benefit', 'BenefitController');
    Route::resource('card', 'CardController');
    Route::resource('market', 'MarketController');
    Route::resource('seller', 'SellerController');

    Route::resource('assignments', 'AssignmentController');


});

Route::get('/page/{page}', 'BuilderController@page')->name('page_name');
