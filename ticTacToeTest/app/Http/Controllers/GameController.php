<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Services\GameService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function __construct(private GameService $gameService)
    {
    }

    // SPA/Blade home
    public function index()
    {
        // Get the latest 10 games for leaderboard
        $games = Game::latest()->take(10)->get();

        return view('games.index', compact('games'));
    }


    // POST /api/games
// POST /api/games
    public function store(Request $request): JsonResponse
    {
        // You can check if "result" was passed from JS
        $result = $request->input('result');

        // Create a new game in DB
        $game = $this->gameService->newGame();

        // If result is provided, mark it as finished
        if ($result) {
            if ($result === 'Match nul') {
                $game->status = 'DRAW';
                $game->winner = null;
            } else {
                // Result string looks like "Joueur X"
                $winner = str_contains($result, 'X') ? 'X' : 'O';
                $game->status = $winner . '_WON';
                $game->winner = $winner;
            }
            $game->finished_at = now();
            $game->save();
        }

        return response()->json($game);
    }


    public function newGame(): JsonResponse
    {
        return response()->json($this->gameService->newGame());
    }

    public function makeMove(Request $request, Game $game): JsonResponse
    {
        $validated = $request->validate([
            'index' => 'required|integer|min:0|max:8'
        ]);

        return response()->json(
            $this->gameService->makeMove($game, $validated['index'])
        );
    }

    public function leaderboard(): JsonResponse
    {
        return response()->json($this->gameService->getLeaderboard());
    }
}
