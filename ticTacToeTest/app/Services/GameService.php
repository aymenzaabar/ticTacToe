<?php

namespace App\Services;

use App\Models\Game;
use InvalidArgumentException;

class GameService
{
    private const WIN_LINES = [
        [0, 1, 2],
        [3, 4, 5],
        [6, 7, 8], // lignes
        [0, 3, 6],
        [1, 4, 7],
        [2, 5, 8], // colonnes
        [0, 4, 8],
        [2, 4, 6],          // diagonales
    ];

    /**
     * Crée une nouvelle partie
     */
    public function newGame(): Game
    {
        return Game::create([
            'board' => '---------',
            'current_player' => 'X',
            'status' => 'IN_PROGRESS',
            'winner' => null,
            'started_at' => now(),
            'finished_at' => null,
        ]);
    }

    /**
     * Jouer un coup pour le joueur courant à l'index 0..8
     */
    public function makeMove(Game $game, int $index): Game
    {
        if ($game->isFinished()) {
            throw new InvalidArgumentException('Game already finished');
        }
        if ($index < 0 || $index > 8) {
            throw new InvalidArgumentException('Index out of range');
        }

        $board = $game->boardArray();
        if ($board[$index] !== '-') {
            throw new InvalidArgumentException('Cell already taken');
        }

        $player = $game->current_player;
        $board[$index] = $player;
        $game->board = implode('', $board);

        // Vérifier si le joueur gagne
        if ($this->isWin($board, $player)) {
            $game->status = $player . '_WON';
            $game->winner = $player;
            $game->finished_at = now();
        } elseif (!in_array('-', $board, true)) {
            // Match nul
            $game->status = 'DRAW';
            $game->winner = null;
            $game->finished_at = now();
        } else {
            // Partie continue
            $game->current_player = $player === 'X' ? 'O' : 'X';
        }

        $game->save();

        return $game->refresh();
    }

    /**
     * Vérifie si le joueur a gagné
     */
    private function isWin(array $board, string $player): bool
    {
        foreach (self::WIN_LINES as $line) {
            if (
                $board[$line[0]] === $player &&
                $board[$line[1]] === $player &&
                $board[$line[2]] === $player
            ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Retourne le leaderboard global
     */
    public function getLeaderboard(): array
    {
        $players = ['X', 'O'];
        $leaderboard = [];

        foreach ($players as $player) {
            $wins = Game::where('winner', $player)->count();
            $losses = Game::whereNotNull('winner')
                ->where('winner', '!=', $player)
                ->count();
            $draws = Game::where('status', 'DRAW')->count();

            $leaderboard[$player] = [
                'wins' => $wins,
                'losses' => $losses,
                'draws' => $draws,
            ];
        }

        return $leaderboard;
    }


}
