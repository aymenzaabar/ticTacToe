@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Morpion (Tic-Tac-Toe)</h1>

    {{-- Game Board --}}
    <div id="game" class="flex justify-center mb-8">
        <div class="grid grid-cols-3 gap-2 w-64">
            @for ($i = 0; $i < 9; $i++)
                <button 
                    class="cell w-20 h-20 border-2 border-gray-600 text-3xl font-bold flex items-center justify-center hover:bg-gray-200"
                    data-index="{{ $i }}">
                </button>
            @endfor
        </div>
    </div>

    {{-- Game status --}}
    <div class="text-center mb-6">
        <h2 id="status" class="text-xl font-semibold text-blue-600">Joueur X commence</h2>
    </div>

    {{-- Leaderboard --}}
    <div class="mt-10">
        <h2 class="text-2xl font-bold mb-4">Leaderboard</h2>
        <table class="table-auto w-full border-collapse border border-gray-400">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-400 px-4 py-2">Date</th>
                    <th class="border border-gray-400 px-4 py-2">Résultat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($games as $game)
                    <tr>
                        <td class="border px-4 py-2">{{ $game->created_at->format('d/m/Y H:i') }}</td>
                        <td class="border px-4 py-2">{{ $game->result }}</td>
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

{{-- Simple JS for interactivity --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let currentPlayer = 'X';
        let board = Array(9).fill(null);
        const cells = document.querySelectorAll('.cell');
        const status = document.getElementById('status');

        const winningCombinations = [
            [0,1,2], [3,4,5], [6,7,8],
            [0,3,6], [1,4,7], [2,5,8],
            [0,4,8], [2,4,6]
        ];

        function checkWinner() {
            for (let combo of winningCombinations) {
                const [a, b, c] = combo;
                if (board[a] && board[a] === board[b] && board[a] === board[c]) {
                    return board[a];
                }
            }
            return board.every(cell => cell) ? 'Draw' : null;
        }

        cells.forEach(cell => {
            cell.addEventListener('click', () => {
                const index = cell.dataset.index;
                if (!board[index]) {
                    board[index] = currentPlayer;
                    cell.textContent = currentPlayer;
                    let winner = checkWinner();
                    if (winner) {
                        status.textContent = winner === 'Draw' ? "Match nul !" : `Le joueur ${winner} a gagné !`;

                        // Save result in DB via AJAX
                        fetch("{{ route('games.store') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                result: winner === 'Draw' ? 'Match nul' : `Joueur ${winner}`
                            })
                        });
                    } else {
                        currentPlayer = currentPlayer === 'X' ? 'O' : 'X';
                        status.textContent = `Au tour du joueur ${currentPlayer}`;
                    }
                }
            });
        });
    });
</script>
@endsection
