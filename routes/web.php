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

Route::namespace('Auth')->group(function() {
    Route::resource('/', 'LoginController');
});


Route::namespace('Admin')
    ->group(function() {
        Route::get('api/sinhvien/all', 'StudentController@getAllStudentsAPI');
        Route::get('api/sinhvien/{id}', 'StudentController@getStudentAPI');
    });

Auth::routes();

Route::middleware('auth')
    ->prefix('sinhvien')
    ->name('student.')
    ->namespace('Student')
    ->group(function() {
        Route::get('info', 'StudentController@getInfo')->name('getInfo');
        Route::post('update', 'StudentController@update')->name('update');
        Route::get('dang-ky', 'ScheduleController@index')->name('schedule.index');
        Route::get('dangky/{monthiId}', 'ScheduleController@getCathi')->name('schedule.monthi');
        Route::post('dangky/cathi', 'ScheduleController@postCathi')->name('schedule.submit');
    });
Route::middleware('auth')
    ->prefix('admin') 
    ->name('admin.')  
    ->namespace('Admin')
    ->group(function () {
   	Route::resource('monthis', 'MonthiController');
    Route::resource('cathis', 'CathiController');
    Route::resource('home', 'HomeController');
    Route::resource('sinhvien', 'StudentController');
    Route::get('monthis/{monthiId}/dssv', 'MonthiController@listStudentIndex')->name('monthis.dssv');
    Route::get('monthis/{monthiId}/add-student', 'MonthiController@getAddStudent')->name('monthis.addStudent');
    Route::post('monthis/{monthiId}/save', 'MonthiController@postAddStudent')->name('monthis.saveStudent');
    Route::get('monthis/{monthiId}/edit-student/{studentId}', 'MonthiController@getEditStudent')->name('monthis.getEditStudent');
    Route::post('monthis/{monthiId}/edit-student/{studentId}', 'MonthiController@postEditStudent')->name('monthis.postEditStudent');
    Route::post('monthis/{monthiId}/delete-student/{studentId}', 'MonthiController@deleteStudent')->name('monthis.deleteStudent');
    });
