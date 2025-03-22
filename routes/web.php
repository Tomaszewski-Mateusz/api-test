<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;

Route::resource('pet', PetController::class);

Route::get('/', function () {
    return redirect('/pet');
});
