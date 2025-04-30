<?php

use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingController::class)->name('frontend');
Route::post('/', LandingController::class)->name('frontend');
