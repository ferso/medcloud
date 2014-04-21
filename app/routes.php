<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/', 'LandingController@get_index');
Route::post('/', 'LandingController@post_index');

//Dashboard
Route::get('/dashboard', 'DashboardController@index')->before('auth');
Route::get('/dashboard/report', 'DashboardController@report')->before('auth');

//Visitors
Route::get('/patients', 'PatientsController@index')->before('auth');
Route::get('/patients/table', 'PatientsController@table')->before('auth');

Route::get('/login', 'LandingController@get_index');

//Areas
Route::get('/areas', 'AreasController@index')->before('auth');
Route::get('/areas/table', 'AreasController@table')->before('auth');
Route::get('/areas/{id}', 'AreasController@get')->before('auth');
Route::post('/areas/delete/{id}', 'AreasController@delete')->before('auth');
Route::post('/areas/save', 'AreasController@save')->before('auth');

//scheduler
Route::get('/scheduler', 'SchedulerController@index')->before('auth');
Route::post('/scheduler/create', 'SchedulerController@create')->before('auth');
Route::get('/scheduler/user/{name}', 'SchedulerController@user')->before('auth');
Route::get('/scheduler/events', 'SchedulerController@events')->before('auth');
Route::post('/scheduler/apt', 'SchedulerController@apt')->before('auth');
Route::get('/scheduler/hosts', 'SchedulerController@hosts')->before('auth');

// Users
Route::get('/users', 'UsersController@index')->before('auth');
Route::get('/users/get/{id}', 'UsersController@get')->before('auth');
Route::post('/users/save', 'UsersController@save')->before('auth');
Route::post('/users/delete/{id}', 'UsersController@delete')->before('auth');
Route::get('/users/table', 'UsersController@table')->before('auth');
Route::post('/users/roles', 'UsersController@roles')->before('auth');


//Dashboard
Route::get('/settings', 'SettingsController@index')->before('auth');

