<?php require "views/components/header.php"; ?>

<div class="auth-container">
    <h1>Register</h1>

    <form method="POST" action="/register">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?= $_POST['username'] ?? '' ?>" required>
            <?php if (isset($errors['username'])): ?>
                <p class="error" style="color: red;"><?= $errors['username'] ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?= $_POST['email'] ?? '' ?>" required>
            <?php if (isset($errors['email'])): ?>
                <p class="error" style="color: red;"><?= $errors['email'] ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <small>(Minimum 6 characters)</small>
            <?php if (isset($errors['password'])): ?>
                <p class="error" style="color: red;"><?= $errors['password'] ?></p>
            <?php endif; ?>
        </div>

        <button type="submit">Create Account</button>
    </form>

    <p>Already have an account? <a href="/login">Login here</a></p>
</div>

<?php require "views/components/footer.php"; ?>