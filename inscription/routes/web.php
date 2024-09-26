<?php

use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('inscription',[FormController::class, 'index']);
Route::post('validation',[FormController::class,'store'])->name('form.store');
