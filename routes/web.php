<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\EventoController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('doctor',DoctorController::class.'@index')->name('doctor.index');
Route::get('buscardoctor',DoctorController::class.'@show')->name('doctor.show');
Route::get('doctor/lista',DoctorController::class.'@lista')->name('doctor.lista');
Route::post('doctor',DoctorController::class.'@store')->name('doctor.store');
Route::post('guardarotros',DoctorController::class.'@guardarotros')->name('doctor.guardarotros');
Route::post('doctor/import',DoctorController::class.'@cargamasiva')->name('doctor.cargamasiva');
Route::get('/doctor/export', [DoctorController::class, 'export'])->name('doctor.export');
Route::get('',DashboardController::class.'@index')->name('dashboard.index');
Route::get('evento',EventoController::class.'@index')->name('evento.index');
Route::post('evento',EventoController::class.'@store')->name('evento.store');
Route::put('evento/update/{id}',EventoController::class.'@update')->name('evento.update');