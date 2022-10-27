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

/*Route::controller(VitalController::class)->prefix('admin')->group(function() {
    Route::get('vital/create', 'add')->middleware('auth');
});*/

Route::controller(VitalController::class)->prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('vital/create', 'add')->name('vital.add');
    Route::post('vital/create', 'create')->name('vital.create');
    Route::get('vital', 'index')->name('vital.index');
    Route::get('vital/edit', 'edit')->name('vital.edit');
    Route::post('vital/edit', 'update')->name('vital.update');
    Route::get('vital/delete', 'delete')->name('vital.delete');
});

Route::controller(ProfileController::class)->prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('profile/create', 'add')->name('profile.add');
    Route::post('profile/create', 'create')->name('profile.create');
    Route::get('profile', 'index')->name('profile.index');
    Route::get('profile/edit', 'edit')->name('profile.edit');
    Route::post('profile/edit', 'update')->name('profile.update');
    Route::get('profile/delete', 'delete')->name('profile.delete');
});


/*Route::group(['prefix' => 'admin'], function() {
    Route::get('vital/create', 'Admin\VitalController@add')->middleware('auth');
    Route::post('vital/create', 'Admin\VitalController@create')->middleware('auth');
    Route::get('vital', 'Admin\VitalController@index')->middleware('auth');
    Route::get('vital/edit', 'Admin\VitalController@edit')->middleware('auth');
    Route::post('vital/edit', 'Admin\VitalController@update')->middleware('auth');
    Route::get('vital/delete', 'Admin\VitalController@delete')->middleware('auth');
    Route::get('vital/search', 'Admin\VitalController@search')->middleware('auth');

    Route::get('profile/create', 'Admin\ProfileController@add')->middleware('auth');
    Route::post('profile/create', 'Admin\ProfileController@create')->middleware('auth');
    Route::get('profile/edit', 'Admin\ProfileController@edit')->middleware('auth');
    Route::post('profile/edit', 'Admin\ProfileController@update')->middleware('auth');
    Route::get('profile/delete', 'Admin\ProfileController@delete')->middleware('auth');
    Route::get('profile', 'Admin\ProfileController@index')->middleware('auth');    
   
});
*/


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
