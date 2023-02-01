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
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\MealController;
use App\Http\Controllers\Admin\BathController;
use App\Http\Controllers\Admin\SummaryController;

/*Route::controller(VitalController::class)->prefix('admin')->group(function() {
    Route::get('vital/create', 'add')->middleware('auth');
});*/


Route::controller(ResidentController::class)->prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('resident/create', 'add')->name('resident.add');
    Route::post('resident/create', 'create')->name('resident.create');
    Route::get('resident', 'index')->name('resident.index');
    Route::get('resident/edit', 'edit')->name('resident.edit');
    Route::post('resident/edit', 'update')->name('resident.update');
    Route::get('resident/delete', 'delete')->name('resident.delete');
});

Route::controller(VitalController::class)->prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('vital/create/{residentId}', 'add')->name('vital.add');
    Route::post('vital/create', 'create')->name('vital.create');
    Route::get('vital/{residentId}', 'index')->name('vital.index');
    Route::get('vital/edit/{residentId}/{vitalId}', 'edit')->name('vital.edit');
    Route::post('vital/edit/{residentId}/{vitalId}', 'update')->name('vital.update');
    Route::get('vital/delete/{residentId}/{vitalId}', 'delete')->name('vital.delete');
});

Route::controller(MealController::class)->prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('meal/create/{residentId}', 'add')->name('meal.add');
    Route::post('meal/create', 'create')->name('meal.create');
    Route::get('meal/{residentId}', 'index')->name('meal.index');
    Route::get('meal/edit/{residentId}/{mealId', 'edit')->name('meal.edit');
    Route::post('meal/edit/{residentId}/{mealId', 'update')->name('meal.update');
    Route::get('meal/delete/{residentId}/{mealId', 'delete')->name('meal.delete');
});

Route::controller(BathController::class)->prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('bath/create/{residentId}', 'add')->name('bath.add');
    Route::post('bath/create', 'create')->name('bath.create');
    Route::get('bath/{residentId}', 'index')->name('bath.index');
    Route::get('bath/edit/{residentId}/{bathId}', 'edit')->name('bath.edit');
    Route::post('bath/edit/{residentId}/{bathId', 'update')->name('bath.update');
    Route::get('bath/delete/{residentId}/{bathId', 'delete')->name('bath.delete');
});


Route::controller(SummaryController::class)->prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('summary', 'index')->name('summary.index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
