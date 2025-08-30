<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;


Route::get('/', function () {  return view('welcome');});
Route::get('/', [GameController::class, 'index'])->name('games.index');
Route::post('/games', [GameController::class, 'store'])->name('games.store');
Route::get('/leaderboard', [GameController::class, 'leaderboard']);


