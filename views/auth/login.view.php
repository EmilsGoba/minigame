<?php require "views/components/header.php"; ?>

<div class="auth-wrap">
    <div class="auth-card">
        <h1>Login</h1>

        <?php foreach ($errors as $error) { ?>
            <p><?= e($error) ?></p>
        <?php } ?>

        <form method="POST" action="">
            <label>Username or email:</label>
            <input name="identity" type="text" value="<?= e($identity ?? '') ?>">
            <br>

            <label>Password:</label>
            <input name="password" type="password">
            <br>

            <button type="submit">Login</button>
        </form>

        <p class="typing-note" style="margin-top: 12px;">
            No account? <a href="/register">Register</a>
        </p>
    </div>
</div>

<?php require "views/components/footer.php"; ?>