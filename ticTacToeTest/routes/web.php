<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;


Route::get('/', function () {  return view('welcome');});
Route::get('/', [GameController::class, 'index'])->name('games.index');
