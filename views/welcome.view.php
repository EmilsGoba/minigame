<?php
    $navbar = "/public/css/navbar.css";
    $style = "/public/css/auth.css";
    require "views/components/header.php";
?>

<div class="auth-wrap welcome-wrap">
    <div class="auth-card welcome-card">
        <h1>Welcome</h1>
        <p class="welcome-subtitle">Choose how you want to continue.</p>

        <div class="auth-actions">
            <a class="auth-btn" href="/login">Login</a>
            <a class="auth-btn" href="/register">Register</a>
        </div>
    </div>
</div>

<?php require "views/components/footer.php"; ?>
