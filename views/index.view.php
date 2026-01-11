<?php require "views/components/header.php"; ?>
<?php require "views/components/navbar.php"; ?>

<main style="text-align: center; padding: 20px;">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
    
    <div class="game-selection" style="display: flex; justify-content: center; gap: 20px; margin: 30px 0;">
        <div class="card" style="border: 1px solid #ccc; padding: 20px; border-radius: 10px;">
            <h3>Memory Match</h3>
            <a href="/memory" style="background: #2c3e50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Play Now</a>
        </div>
        <div class="card" style="border: 1px solid #ccc; padding: 20px; border-radius: 10px; opacity: 0.6;">
            <h3>Typing Speed</h3>
            <span>Coming Soon</span>
        </div>
    </div>

    <hr>

    <h2>🏆 Memory Match Leaderboard (Top 10)</h2>
    <table style="margin: 20px auto; border-collapse: collapse; width: 80%; max-width: 600px;">
        <thead>
            <tr style="background: #f4f4f4;">
                <th style="padding: 10px; border: 1px solid #ddd;">Rank</th>
                <th style="padding: 10px; border: 1px solid #ddd;">User</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Level</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Time</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($leaderboard as $index => $score): ?>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?= $index + 1 ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($score['username']) ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?= $score['level'] ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?= $score['time_seconds'] ?>s</td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($leaderboard)): ?>
                <tr><td colspan="4" style="padding: 20px;">No scores yet. Be the first!</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<?php require "views/components/footer.php"; ?>