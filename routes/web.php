<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServicioController;

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', function () {
    return redirect()->route('servicios.index');
});

Route::resource('servicios', ServicioController::class);
