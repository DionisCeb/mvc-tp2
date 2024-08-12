<?php
use App\Controllers;
use App\Routes\Route;

Route::get('/home', 'HomeController@index');
Route::get('', 'HomeController@index');

/*reservations liste*/
Route::get('/bookings', 'BookingController@list');

/*reservation specifique*/
Route::get('/booking/show', 'BookingController@show');




Route::dispatch();
?>