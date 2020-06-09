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

Route::get('/', function () {return redirect('auth/login');});

//  Authentication
Route::group(['prefix'=>'auth'],function(){
    Route::get('/login','AuthController@index');
    Route::post('/login','AuthController@login');
    Route::get('/logout','AuthController@logout');
});

// Global
Route::group(['prefix'=>'global'],function(){
    Route::get('zipcode_filter/{zipcode}','GlobalController@zipcode_filter');
});


// Dashboard
Route::group(['prefix'=>'dashboard'],function(){
    Route::get('/','DashboardController@index');
});


// Institutes
Route::group(['prefix'=>'institutes'],function(){
    Route::get('/','InstitutesController@index');
    Route::get('/new','InstitutesController@newInstitute');
    Route::post('/new','InstitutesController@saveInstitute');
    Route::get('/{id}','InstitutesController@editInstitute');
    Route::patch('/{id}','InstitutesController@updateInstitute');
    Route::delete('/{id}','InstitutesController@deleteInstitute');
});


Route::group(['prefix'=>'education_level'],function(){
    Route::get('/','EducationLevelController@index');
});




// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
