<?php
use App\Controllers;
use App\Routes\Route;

Route::get('/home', 'HomeController@index');
Route::get('/home-test', 'HomeController@test');

Route::get('/booking', 'ClientController@index');
Route::get('/booking/create', 'ClientController@create');
Route::post('/booking/create', 'ClientController@store');
Route::get('/booking/show', 'ClientController@show');
Route::get('/booking/edit', 'ClientController@edit');
Route::post('/booking/edit', 'ClientController@update');
Route::post('/booking/delete', 'ClientController@delete');



Route::dispatch();

