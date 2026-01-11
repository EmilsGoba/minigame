<?php require "views/components/header.php"; ?>
<?php require "views/components/navbar.php"; ?>

<main style="text-align: center; padding: 20px;">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
    
    <div style="display: flex; justify-content: center; gap: 20px; margin: 30px 0;">
        <div class="card" style="border: 1px solid #ccc; padding: 20px; border-radius: 10px;">
            <h3>Memory Match</h3>
            <a href="/memory" style="background: #2c3e50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Play</a>
        </div>
        <div class="card" style="border: 1px solid #ccc; padding: 20px; border-radius: 10px;">
            <h3>Typing Speed</h3>
            <a href="/typing" style="background: #27ae60; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Play</a>
        </div>
    </div>

    <hr>

    <div style="display: flex; justify-content: space-around; flex-wrap: wrap; margin-top: 20px;">
        <section>
            <h2>🧠 Memory Top Scores</h2>
            <?php foreach ($memoryLeaderboards as $lvl => $scores): ?>
                <div style="margin-bottom: 20px;">
                    <h4><?= $lvl ?></h4>
                    <table border="1" style="width: 250px; border-collapse: collapse;">
                        <?php foreach ($scores as $s): ?>
                            <tr><td><?= htmlspecialchars($s['username']) ?></td><td><?= $s['time_seconds'] ?>s</td></tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endforeach; ?>
        </section>

        <section>
            <h2>⌨️ Typing Top Scores</h2>
            <?php foreach ($typingLeaderboards as $lvl => $scores): ?>
                <div style="margin-bottom: 20px;">
                    <h4><?= $lvl ?></h4>
                    <table border="1" style="width: 250px; border-collapse: collapse;">
                        <?php foreach ($scores as $s): ?>
                            <tr><td><?= htmlspecialchars($s['username']) ?></td><td><?= $s['words_per_minute'] ?> WPM</td></tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endforeach; ?>
        </section>
    </div>
</main>

<?php require "views/components/footer.php"; ?>