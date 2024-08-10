<?php
use App\Controllers\HomeController;
use App\Controllers\ClientController;
use App\Routes\Route;

// Home routes
Route::get('/home', 'HomeController@index');
Route::get('/home-test', 'HomeController@test');

// Booking routes
Route::get('/booking', 'ClientController@index');
Route::get('/booking/create', 'ClientController@create');
Route::post('/booking/create', 'ClientController@store');
Route::get('/booking/show', 'ClientController@show');
Route::get('/booking/edit', 'ClientController@edit');
Route::post('/booking/edit', 'ClientController@update');
Route::post('/booking/delete', 'ClientController@delete');


Route::dispatch();
