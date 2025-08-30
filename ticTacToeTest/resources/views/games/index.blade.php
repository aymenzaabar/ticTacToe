@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen bg-gray-50 py-10">
    <h1 class="text-4xl font-bold mb-8 text-gray-800">Morpion (Tic-Tac-Toe)</h1>
<a href="{{ route('games.index') }}"
                        class="btn btn-success btn-block m-1 mb-3">
                        Recommencer
                    </a>
    {{-- Game Board --}}
    <div id="game" class="flex justify-center mb-8">
        <div class="board">
            @for ($i = 0; $i < 9; $i++)
                <button class="cell" data-index="{{ $i }}"></button>
            @endfor
        </div>
    </div>

    {{-- Game status --}}
    <div class="text-center mt-6 mb-10">
        <h2 id="status" class="text-xl font-semibold text-blue-600">Joueur X commence</h2>
    </div>

    {{-- Leaderboard --}}
    <div class="w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Leaderboard</h2>
        <table class="table-auto w-full border border-gray-300 shadow-sm rounded-md overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">Date</th>
                    <th class="border px-4 py-2">Résultat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($games as $game)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $game->created_at->format('d/m/Y H:i') }}</td>
                        <td class="border px-4 py-2">{{ $game->clean_status }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="border px-4 py-2 text-center text-gray-500">Aucune partie enregistrée</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let currentPlayer = 'X';
    let board = Array(9).fill(null);
    let gameOver = false;
    const cells = document.querySelectorAll('.cell');
    const status = document.getElementById('status');

    const winningCombinations = [
        [0,1,2],[3,4,5],[6,7,8],
        [0,3,6],[1,4,7],[2,5,8],
        [0,4,8],[2,4,6]
    ];

    function checkWinner() {
        for (let combo of winningCombinations) {
            const [a,b,c] = combo;
            if (board[a] && board[a] === board[b] && board[a] === board[c]) {
                return board[a];
            }
        }
        return board.every(cell => cell) ? 'Draw' : null;
    }

    async function saveGame(result) {
        try {
            let response = await fetch("{{ route('games.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ result })
            });

            if (!response.ok) throw new Error("Erreur serveur");
            let data = await response.json();
            console.log("Game saved:", data);
        } catch (err) {
            console.error("Save failed:", err);
        }
    }

    cells.forEach(cell => {
        cell.addEventListener('click', () => {
            if (gameOver) return;
            const index = cell.dataset.index;

            if (!board[index]) {
                board[index] = currentPlayer;
                cell.textContent = currentPlayer;

                let winner = checkWinner();
                if (winner) {
                    status.textContent = winner === 'Draw' ? "Match nul !" : `Le joueur ${winner} a gagné !`;
                    gameOver = true;

                    // Save result in DB
                    saveGame(winner === 'Draw' ? 'Match nul' : `Joueur ${winner}`);
                } else {
                    currentPlayer = currentPlayer === 'X' ? 'O' : 'X';
                    status.textContent = `Au tour du joueur ${currentPlayer}`;
                }
            }
        });
    });
});
</script>

<style>
    .board {
            display: grid;
            grid-template-columns: repeat(3, 100px); /* 3 columns */
            grid-template-rows: repeat(3, 100px);    /* 3 rows */
            gap: 0;
            border: 4px solid #333;
            width: max-content;
            margin: auto;
        }
 .cell {
            width: 100px;
            height: 100px;
            font-size: 2.5rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #333;
            cursor: pointer;
        }

.cell:disabled {
    cursor: not-allowed;
    color: #888;
}
</style>
@endsection
