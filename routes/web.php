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

use App\Http\Controllers\Admin\VitalController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\MealController;
use App\Http\Controllers\Admin\BathController;

/*Route::controller(VitalController::class)->prefix('admin')->group(function() {
    Route::get('vital/create', 'add')->middleware('auth');
});*/

Route::controller(VitalController::class)->prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('vital/create/{residentId}', 'add')->name('vital.add');
    Route::post('vital/create/{residentId}', 'create')->name('vital.create');
    Route::get('vital/{residentId}', 'index')->name('vital.index');
    Route::get('vital/edit/{residentId}', 'edit')->name('vital.edit');
    Route::post('vital/edit/{residentId}', 'update')->name('vital.update');
    Route::get('vital/delete/{residentId}', 'delete')->name('vital.delete');
});

Route::controller(ProfileController::class)->prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('profile/create', 'add')->name('profile.add');
    Route::post('profile/create', 'create')->name('profile.create');
    Route::get('profile', 'index')->name('profile.index');
    Route::get('profile/edit', 'edit')->name('profile.edit');
    Route::post('profile/edit', 'update')->name('profile.update');
    Route::get('profile/delete', 'delete')->name('profile.delete');
});

Route::controller(MealController::class)->prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('meal/create/{residentId}', 'add')->name('meal.add');
    Route::post('meal/create/{residentId}', 'create')->name('meal.create');
    Route::get('meal/{residentId}', 'index')->name('meal.index');
    Route::get('meal/edit/{residentId}', 'edit')->name('meal.edit');
    Route::post('meal/edit/{residentId}', 'update')->name('meal.update');
    Route::get('meal/delete/{residentId}', 'delete')->name('meal.delete');
});

Route::controller(BathController::class)->prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('bath/create/{residentId}', 'add')->name('bath.add');
    Route::post('bath/create/{residentId}', 'create')->name('bath.create');
    Route::get('bath/{residentId}', 'index')->name('bath.index');
    Route::get('bath/edit/{residentId}', 'edit')->name('bath.edit');
    Route::post('bath/edit/{residentId}', 'update')->name('bath.update');
    Route::get('bath/delete/{residentId}', 'delete')->name('bath.delete');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
