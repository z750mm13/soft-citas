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

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('patients', PatientController::class)->middleware('auth');
Route::resource('medicines', MedicineController::class)->middleware('auth');
Route::resource('appointments', AppointmentController::class)->middleware('auth');

Route::get('consultations/{appointment}/create', [
    'as' => 'consultations.create',
    'uses' => 'ConsultationController@create'
]);
Route::post('consultations/{consultation}/edit', [
    'as' => 'consultations.edit',
    'uses' => 'ConsultationController@edit'
]);
Route::resource('consultations', ConsultationController::class)
    ->except(['create','edit'])
    ->middleware('auth')
;

Auth::routes();
