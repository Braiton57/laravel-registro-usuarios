<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('registro');
});
Route::get('/admin', function () {
    return view('admin');

});