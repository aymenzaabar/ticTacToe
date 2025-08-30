<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Morpion</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Morpion</h1>
    <div id="board">
        <div class="row">
            <button class="cell" data-index="0"></button>
            <button class="cell" data-index="1"></button>
            <button class="cell" data-index="2"></button>
        </div>
        <div class="row">
            <button class="cell" data-index="3"></button>
            <button class="cell" data-index="4"></button>
            <button class="cell" data-index="5"></button>
        </div>
        <div class="row">
            <button class="cell" data-index="6"></button>
            <button class="cell" data-index="7"></button>
            <button class="cell" data-index="8"></button>
        </div>
    </div>

    <div id="message"></div>

    <script>
        let currentPlayer = 'X';
        let board = ['', '', '', '', '', '', '', '', ''];

        $(document).ready(function() {
            $(".cell").click(function() {
                let index = $(this).data("index");
                if (board[index] === '') {
                    board[index] = currentPlayer;
                    $(this).text(currentPlayer);
                    if (checkWinner()) {
                        $('#message').text(currentPlayer + ' a gagné !');
                        saveGame(currentPlayer);
                    } else if (board.every(cell => cell !== '')) {
                        $('#message').text('Match nul');
                        saveGame(null);
                    } else {
                        currentPlayer = (currentPlayer === 'X') ? 'O' : 'X';
                    }
                }
            });
        });

        function checkWinner() {
            const winningCombinations = [
                [0, 1, 2], [3, 4, 5], [6, 7, 8],  // Lignes
                [0, 3, 6], [1, 4, 7], [2, 5, 8],  // Colonnes
                [0, 4, 8], [2, 4, 6]               // Diagonales
            ];

            return winningCombinations.some(combination => {
                const [a, b, c] = combination;
                return board[a] && board[a] === board[b] && board[a] === board[c];
            });
        }

        function saveGame(winner) {
            $.ajax({
                url: '/games',
                method: 'POST',
                data: {
                    winner: winner,
                    _token: "{{ csrf_token() }}"
                },
                success: function() {
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
            });
        }
    </script>

</body>
</html>
