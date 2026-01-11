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

    <hr style="margin: 40px 0;">

    <h2>🏆 Memory Match Leaderboards</h2>

    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 30px; margin-top: 20px;">
        <?php foreach ($leaderboards as $levelName => $scores): ?>
            <div style="flex: 1; min-width: 280px; max-width: 350px;">
                <h3 style="color: #2c3e50;"><?= htmlspecialchars($levelName) ?> Mode</h3>
                <table style="margin: 10px auto; border-collapse: collapse; width: 100%; font-size: 0.9em;">
                    <thead>
                        <tr style="background: #f4f4f4;">
                            <th style="padding: 10px; border: 1px solid #ddd;">Rank</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">User</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($scores as $index => $score): ?>
                            <tr>
                                <td style="padding: 10px; border: 1px solid #ddd;"><?= $index + 1 ?></td>
                                <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($score['username']) ?></td>
                                <td style="padding: 10px; border: 1px solid #ddd;"><?= $score['time_seconds'] ?>s</td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($scores)): ?>
                            <tr><td colspan="3" style="padding: 15px; color: #777;">No scores yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require "views/components/footer.php"; ?>