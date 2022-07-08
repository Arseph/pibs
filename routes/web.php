<?php

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
Route::Auth();
Route::get('/', 'Auth\LoginController@index');
Route::post('login', 'Auth\LoginController@login');
Route::get('/logout', function(){
    \Illuminate\Support\Facades\Session::flush();
    return redirect('/');
});
Route::post('register', 'Auth\LoginController@registerIndex');
Route::post('register-account', 'Auth\LoginController@register');

Route::get('admin', 'AdminController@index');
Route::get('patient-profile', 'AdminController@patientProfile');
Route::get('doctor', 'DoctorController@index');
Route::get('patient', 'PatientController@index');
