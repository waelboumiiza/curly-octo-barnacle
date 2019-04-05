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


Route::get('/user/login', 'ClassroomsController@showLogin')->name('showLogin');
Route::post('/user/login', 'ClassroomsController@handleLogin')->name('handleLogin');

Route::middleware(['access'])->group(function () { 
Route::get('/', function () {
    return view('welcome');
});

Route::post('/add', 'ClassroomsController@handleAddClassroom')->name('handleAddClassroom');

Route::get('/delete/{id}', 'ClassroomsController@handleDeleteClassroom')->name('handleDeleteClassroom');

Route::get('/list', 'ClassroomsController@showClassrooms')->name('showClassrooms');

Route::get('/show/{id}', 'ClassroomsController@showClassroom')->name('showClassroom');
Route::post('/update/{id}', 'ClassroomsController@handleUpdateClassroom')->name('handleUpdateClassroom');

Route::get('/user/register', 'ClassroomsController@showRegister')->name('showRegister');
Route::post('/user/register', 'ClassroomsController@handleRegister')->name('handleRegister');


Route::get('/user/logout', 'ClassroomsController@Logout')->name('Logout');

Route::get('/showStudents/{id}', 'ClassroomsController@showStudents')->name('showStudents');
Route::get('/deleteStudents/{id}', 'ClassroomsController@handleDeleteStudent')->name('handleDeleteStudent');

});

