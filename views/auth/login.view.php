<?php require "views/components/header.php"; ?>

<div class="auth-container">
    <h1>Login</h1>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <?php foreach($errors as $error): ?>
                <p style="color: red;"> <?= htmlspecialchars($error) ?> </p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/login">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
        </div>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="/register">Register here</a></p>
</div>

<?php require "views/components/footer.php"; ?>