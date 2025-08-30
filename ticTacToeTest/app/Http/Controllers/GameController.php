<?php


namespace App\Http\Controllers;


use App\Models\Game;
use App\Services\GameService;
use Illuminate\Http\Request;


class GameController extends Controller
{
public function __construct(private GameService $service) {}


// SPA/Blade home
public function index()
{
return view('games.index');
}


// POST /api/games
public function store()
{
$game = $this->service->newGame();
return response()->json($game);
}


// GET /api/games/{game}
public function show(Game $game)
{
return response()->json($game);
}


// PATCH /api/games/{game}
public function update(Request $request, Game $game)
{
$data = $request->validate([
'index' => ['required','integer','between:0,8'],
]);


try {
$updated = $this->service->makeMove($game, $data['index']);
return response()->json($updated);
} catch (\InvalidArgumentException $e) {
return response()->json(['message' => $e->getMessage()], 422);
}
}
}