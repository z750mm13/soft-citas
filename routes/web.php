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
 * TODO roles de medicamentos
 * ENFERMERAS
 *-> CRUD conpleto
 */
Route::get('medicines/{type}/report',[
    'as' => 'medicines.report',
    'uses' => 'MedicineController@report']
)->middleware('auth');
Route::resource('medicines', MedicineController::class)->middleware('auth');

/**
 * TODO roles de citas
 * ENFERMERAS
 *-> Reportes
 *-> Altas
 *-> Consultas
 */
// Genera reportes de citas -> Dia Semana Mes
Route::get('appointments/{type}/report',[
    'as' => 'appointments.report',
    'uses' => 'AppointmentController@report']
)->middleware('auth');
Route::resource('appointments', AppointmentController::class)->middleware('auth');

/**
 * TODO roles de consultas
 * ENFERMERAS
 *-> Reportes
 */
// Genera reportes de consultas -> Dia Semana Mes
Route::get('consultations/{type}/report',[
    'as' => 'consultations.report',
    'uses' => 'ConsultationController@report']
)->middleware('auth');
// Genera reportes de consultas -> Dia Semana Mes
Route::get('prescriptions/{consultation_id}/report',[
    'as' => 'consultations.prescriptions',
    'uses' => 'ConsultationController@prescriptionReport']
)->middleware('auth');
Route::get('consultations/{appointment}/create', ['as' => 'consultations.create', 'uses' => 'ConsultationController@create'])->middleware('auth');
Route::post('consultations/{appointment_id}', ['as' => 'consultations.create', 'uses' => 'ConsultationController@create'])->middleware('auth');
Route::post('consultations/{consultation_id}/edit', ['as' => 'consultations.edit', 'uses' => 'ConsultationController@edit'])->middleware('auth');
Route::resource('consultations', ConsultationController::class)
    ->except(['create','edit'])
    ->middleware('auth');

Auth::routes();
