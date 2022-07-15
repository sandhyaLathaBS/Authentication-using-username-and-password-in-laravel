<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
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

Route::group(['prefix' => 'admin',  'middleware' => 'is_admin'], function () {
    Route::get('home', [AdminController::class, 'adminHome'])->name('admin.home');
    Route::post('change-status', [AdminController::class, 'userActiveStatus'])->name('update.status');
});

Route::get('home', [UserController::class, 'index'])->name('home');
Route::get('profile', [UserController::class, 'profile_updateView'])->name('profile.editView');
Route::post('profile-action', [UserController::class, 'profile_updateAction'])->name('profile.editAction');
Route::post('update-file', [UserController::class, 'profile_imageUpdate'])->name('profile.imageupdate');