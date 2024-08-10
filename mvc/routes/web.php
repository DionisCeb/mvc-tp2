<?php
use App\Controllers\HomeController;
use App\Routes\Route;

Route::get('/', 'HomeController@index');
Route::dispatch();
?>
