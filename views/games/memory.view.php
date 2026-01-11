<?php require "views/components/header.php"; ?>
<?php require "views/components/navbar.php"; ?>

<style>
    .game-container { text-align: center; padding: 20px; }
    
    /* Grid setup based on database columns */
    .game-board {
        display: grid;
        grid-template-columns: repeat(<?= $difficulty['grid_cols'] ?>, 100px);
        gap: 10px;
        justify-content: center;
        margin-top: 20px;
    }

    .card {
        width: 100px;
        height: 100px;
        background-color: #2c3e50;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        cursor: pointer;
        border-radius: 8px;
        user-select: none;
        transition: background-color 0.3s, transform 0.2s;
    }

    /* This makes the "flipped" card look different */
    .card.flipped {
        background-color: #ecf0f1;
        color: #2c3e50;
        cursor: default;
    }

    /* This hides matched cards */
    .card.matched {
        visibility: hidden;
        pointer-events: none;
    }

    .card:hover:not(.flipped) {
        transform: scale(1.05);
        background-color: #34495e;
    }
</style>

<div class="game-container">
    <div style="margin-bottom: 20px;">
        <a href="/memory">← Change Difficulty</a>
        <h1>Memory Match: <?= htmlspecialchars($difficulty['name']) ?></h1>
        <p style="font-size: 1.2rem;">Time: <b id="timer">0</b> seconds</p>
    </div>

    <div class="game-board">
        <?php foreach ($cards as $index => $value): ?>
            <div class="card" 
                 data-value="<?= $value ?>" 
                 id="card-<?= $index ?>" 
                 onclick="handleCardClick(this)">
                ?
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    let flippedCards = [];
    let matchedPairs = 0;
    let seconds = 0;
    let isProcessing = false; // Prevents clicking 3rd card while checking match
    const totalPairs = <?= ($difficulty['grid_rows'] * $difficulty['grid_cols']) / 2 ?>;

    // Start Timer
    const timerInterval = setInterval(() => {
        seconds++;
        document.getElementById('timer').innerText = seconds;
    }, 1000);

    function handleCardClick(card) {
        // Prevent clicking if: already flipped, already matched, or 2 cards are being checked
        if (isProcessing || card.classList.contains('flipped') || card.classList.contains('matched')) {
            return;
        }

        // Flip the card
        card.classList.add('flipped');
        card.innerText = card.dataset.value;
        flippedCards.push(card);

        if (flippedCards.length === 2) {
            isProcessing = true; // Lock clicking
            setTimeout(checkMatch, 700);
        }
    }

    function checkMatch() {
        const [card1, card2] = flippedCards;

        if (card1.dataset.value === card2.dataset.value) {
            // It's a match!
            card1.classList.add('matched');
            card2.classList.add('matched');
            matchedPairs++;

            if (matchedPairs === totalPairs) {
                clearInterval(timerInterval);
                saveScore(seconds);
            }
        } else {
            // Not a match, flip back
            card1.classList.remove('flipped');
            card1.innerText = "?";
            card2.classList.remove('flipped');
            card2.innerText = "?";
        }

        flippedCards = [];
        isProcessing = false; // Unlock clicking
    }

    function saveScore(finalTime) {
        // URL updated to match your routes.php configuration
        fetch('/save-score', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                time: finalTime,
                difficulty_id: <?= (int)$difficulty['difficulty_id'] ?>
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert("Congratulations! You finished in " + finalTime + " seconds. Your score has been saved!");
                window.location.href = "/"; // Redirect to see the new leaderboard entry
            } else {
                alert("Game finished, but there was an error saving your score.");
                window.location.href = "/";
            }
        })
        .catch(error => {
            console.error("Error saving score:", error);
            window.location.href = "/";
        });
    }
</script>

<?php require "views/components/footer.php"; ?>