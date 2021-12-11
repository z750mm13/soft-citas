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

/**
 * TODO generar reportes de medicamentos
 */
Route::get('medicines/{type}/report',[
    'as' => 'medicines.report',
    'uses' => 'MedicineController@report']
);
Route::resource('medicines', MedicineController::class)->middleware('auth');

/**
 * TODO generar reportes de citas
 */
Route::resource('appointments', AppointmentController::class)->middleware('auth');

/**
 * TODO generar reportes de consultas
 */
Route::get('consultations/{appointment}/create', ['as' => 'consultations.create', 'uses' => 'ConsultationController@create']);
Route::post('consultations/{appointment_id}', ['as' => 'consultations.create', 'uses' => 'ConsultationController@create']);
Route::post('consultations/{consultation_id}/edit', ['as' => 'consultations.edit', 'uses' => 'ConsultationController@edit']);
Route::resource('consultations', ConsultationController::class)
    ->except(['create','edit'])
    ->middleware('auth');
Route::get('/print',function () {
    $pdf = \PDF::loadView('ejemplo');
    return $pdf->download('ejemplo.pdf');
});
Auth::routes();
