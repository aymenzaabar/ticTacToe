<?php
use App\Http\Controllers\GameController;
use App\Http\Controllers\LeaderboardController;
use Illuminate\Support\Facades\Route;


Route::prefix('games')->group(function () {
Route::post('/', [GameController::class, 'store']);
Route::get('{game}', [GameController::class, 'show']);
Route::patch('{game}', [GameController::class, 'update']);
});


Route::get('leaderboard', LeaderboardController::class);