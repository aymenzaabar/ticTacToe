@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-50 py-10">
        <div class="text-center mb-8">
    <h1 class="text-5xl font-extrabold text-green-400 gaming-font mb-2">
        Tic-Tac-Toe
    </h1>
    <p class="text-xl text-gray-200 tracking-wider gaming-font">
        Three in a row
    </p>

    <style>
    /* Police et style gaming */
    @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

    .gaming-font {
        font-family: 'Press Start 2P', cursive;
        text-shadow: 2px 2px 4px #000;
    }

    /* Couleurs et centrage */
    .text-center {
        text-align: center;
    }

    .mb-8 {
        margin-bottom: 2rem;
    }

    .mb-2 {
        margin-bottom: 0.5rem;
    }

    .text-5xl {
        font-size: 3rem;
    }

    .text-xl {
        font-size: 1.25rem;
    }

    .text-green-400 {
        color: #22c55e;
    }

    .text-gray-200 {
        color: #e61ba9ff;
    }

    .tracking-wider {
        letter-spacing: 0.05em;
    }
    </style>
</div>
        <div class="text-center mb-4">
    <a href="{{ route('games.index') }}" class="gaming-btn">
        Recommencer
    </a>

    <style>
    /* Police gaming */
    @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

    .gaming-btn {
        display: inline-block;
        font-family: 'Press Start 2P', cursive;
        font-size: 1rem;
        padding: 12px 24px;
        color: #ffffff;
        background: linear-gradient(45deg, #ff0055, #ff9900, #00ff99, #00ccff);
        background-size: 300% 300%;
        border: 2px solid #fff;
        border-radius: 8px;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-decoration: none;
        box-shadow: 2px 2px 8px #000;
        transition: all 0.4s ease;
    }

    .gaming-btn:hover {
        background-position: 100% 0;
        transform: scale(1.05);
        box-shadow: 4px 4px 12px #000;
    }

    .text-center {
        text-align: center;
    }

    .mb-4 {
        margin-bottom: 1rem;
    }
    </style>
</div>

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
    <h2 id="status" class="gaming-status">
        Joueur X commence
        
    </h2>
    <button id="leaderboardButton" class="gaming-status">
    Leaderboard
</button>

    <style>
    /* Police gaming */
    @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

    .gaming-status {
        font-family: 'Press Start 2P', cursive;
        font-size: 1.25rem;
        font-weight: bold;
        color: #1e40af; /* Bleu arcade */
        text-shadow: 2px 2px 4px #000;
        letter-spacing: 1px;
    }

    .text-center {
        text-align: center;
    }

    .mt-6 {
        margin-top: 1.5rem;
    }

    .mb-10 {
        margin-bottom: 2.5rem;
    }
    </style>
</div>


        {{-- Leaderboard --}}
     <!-- Le bouton Leaderboard existant -->



<!-- Fenêtre modale pour le Leaderboard -->
<div id="leaderboardModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg max-w-4xl w-full">
        <h2 class="text-2xl font-bold mb-4 text-gray-800 gaming-font text-center">Leaderboard</h2>

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

        <!-- Bouton pour fermer la modale -->
        <button id="closeModalButton" class="mt-4 px-4 py-2 bg-red-600 text-white rounded-md">
            Fermer
        </button>
    </div>
</div>

<!-- Styles pour la modale et la police -->
<style>
    /* Police gaming */
    @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

    .gaming-font {
        font-family: 'Press Start 2P', cursive;
    }

    /* Styles pour la modale */
    #leaderboardModal {
        display: flex;
        justify-content: center;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    /* Cacher la modale par défaut */
    #leaderboardModal.hidden {
        display: none;
    }

    /* Styles du bouton fermer */
    #closeModalButton {
        cursor: pointer;
    }

    /* Le contenu de la modale */
    .bg-white {
        background-color: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>

<!-- Script pour afficher/masquer la modale -->
<script>
    // Ouvrir la modale
    document.getElementById("leaderboardButton").addEventListener("click", function() {
        document.getElementById("leaderboardModal").classList.remove("hidden");
    });

    // Fermer la modale
    document.getElementById("closeModalButton").addEventListener("click", function() {
        document.getElementById("leaderboardModal").classList.add("hidden");
    });
</script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let currentPlayer = 'X';
            let board = Array(9).fill(null);
            let gameOver = false;
            const cells = document.querySelectorAll('.cell');
            const status = document.getElementById('status');

            const winningCombinations = [
                [0, 1, 2],
                [3, 4, 5],
                [6, 7, 8],
                [0, 3, 6],
                [1, 4, 7],
                [2, 5, 8],
                [0, 4, 8],
                [2, 4, 6]
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

            async function saveGame(result) {
                try {
                    let response = await fetch("{{ route('games.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            result
                        })
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
                            status.textContent = winner === 'Draw' ? "Match nul !" :
                                `Le joueur ${winner} a gagné !`;
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
            grid-template-columns: repeat(3, 100px);
            /* 3 columns */
            grid-template-rows: repeat(3, 100px);
            /* 3 rows */
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
