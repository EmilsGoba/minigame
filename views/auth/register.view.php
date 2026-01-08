<?php require "../App/views/components/head.php" ?>
<link rel="stylesheet" href="CSS/main.style.css">
<link rel="stylesheet" href="CSS/register.style.css">

<div class="center">

<main class="auth-main-reg">
    <div class="auth-div">
        <h1 class="auth-h1" style="color:#000100;">Register</h1>
        <form method="POST" class="auth-form">
            <label class="auth-label" style="color:white">
                Username
                <input class="auth-input" name="username" value="<?= $_POST["username"] ?? "" ?>"/>
            </label>
            <?php if (isset($errors["username"])) { ?>
                <p class="invalid-data"> <?= $errors["username"] ?> </p>
            <?php } ?>
            <label class="auth-label" style="color:white">
                Email
                <input class="auth-input" type="email" name="email" value="<?= $_POST["email"] ?? "" ?>"/>
            </label>
            <?php if (isset($errors["email"])) { ?>
                <p class="invalid-data"> <?= $errors["email"] ?> </p>
            <?php } ?>
            <label class="auth-label" style="color:white">
                Password
                <br> 
                <input class="auth-input" type="password" name="password" value="<?= $_POST["password"] ?? "" ?>"/>
            </label>
            <?php if (isset($errors["password"])) { ?>
                <p class="invalid-data"> <?= $errors["password"] ?> </p>
            <?php } ?>
            <span style="font-size: 12px; color:white;" >(8 chars: 1 uppercase, 1 number, 1 symbol)</span>
            <button class="auth-button">Submit</button>
        </form>
        <a href="/login">Log-in</a>
    </div>
</main>
</div>
<?php require "../App/views/components/footer.php" ?>
