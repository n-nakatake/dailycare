<?php


use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\BathController;
use App\Http\Controllers\Admin\EditPasswordController;
use App\Http\Controllers\Admin\MealController;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\SummaryController;
use App\Http\Controllers\Admin\VitalController;
use App\Http\Controllers\Admin\TopController;
use App\Http\Controllers\Admin\ExcretionController;
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
    return redirect('admin/');;
});

Route::controller(TopController::class)->prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('top.index');
});

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
    Route::get('meal/edit/{residentId}/{mealId}', 'edit')->name('meal.edit');
    Route::post('meal/edit/{residentId}/{mealId}', 'update')->name('meal.update');
    Route::get('meal/delete/{residentId}/{mealId}', 'delete')->name('meal.delete');
});

Route::controller(BathController::class)->prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('bath/create/{residentId}', 'add')->name('bath.add');
    Route::post('bath/create', 'create')->name('bath.create');
    Route::get('bath/{residentId}', 'index')->name('bath.index');
    Route::get('bath/edit/{residentId}/{bathId}', 'edit')->name('bath.edit');
    Route::post('bath/edit/{residentId}/{bathId}', 'update')->name('bath.update');
    Route::get('bath/delete/{residentId}/{bathId}', 'delete')->name('bath.delete');
});

Route::controller(AttendanceController::class)->prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('attendance/create', 'add')->name('attendance.add');
    Route::post('attendance/create', 'create')->name('attendance.create');
    Route::get('attendance/edit/{attendanceDate}', 'edit')->name('attendance.edit');
    Route::post('attendance/edit', 'update')->name('attendance.update');
});

Route::controller(SummaryController::class)->prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('summary', 'index')->name('summary.index');
});

Route::controller(EditPasswordController::class)->prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('password/edit', 'edit')->name('password.edit');
    Route::post('password/edit', 'update')->name('password.update');
});

Route::controller(ExcretionController::class)->prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('excretion/create/{residentId}', 'add')->name('excretion.add');
    Route::post('excretion/create', 'create')->name('excretion.create');
    Route::get('excretion/{residentId}', 'index')->name('excretion.index');
    Route::get('excretion/edit/{residentId}/{excretionId}', 'edit')->name('excretion.edit');
    Route::post('excretion/edit/{residentId}/{excretionId}', 'update')->name('excretion.update');
    Route::get('excretion/delete/{residentId}/{excretionId}', 'delete')->name('excretion.delete');
});

Auth::routes();
