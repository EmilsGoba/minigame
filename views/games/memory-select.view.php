<?php require "views/components/header.php"; ?>
<?php require "views/components/navbar.php"; ?>

<div style="text-align: center; padding: 50px;">
    <h1>Select Difficulty</h1>
    <p>Choose a level to start the Memory Match game:</p>
    
    <div style="display: flex; justify-content: center; gap: 20px; margin-top: 30px;">
        <?php foreach ($difficulties as $diff): ?>
            <a href="/memory?level=<?= $diff['name'] ?>" 
               style="padding: 20px; border: 2px solid #333; border-radius: 10px; text-decoration: none; color: black; width: 150px;">
                <strong style="font-size: 1.2rem;"><?= $diff['name'] ?></strong><br>
                <span style="font-size: 0.9rem; color: #666;">
                    <?= $diff['grid_rows'] ?> x <?= $diff['grid_cols'] ?> Grid
                </span>
            </a>
        <?php endforeach; ?>
    </div>
    
    <br><br>
    <a href="/">← Back to Home</a>
</div>

<?php require "views/components/footer.php"; ?>