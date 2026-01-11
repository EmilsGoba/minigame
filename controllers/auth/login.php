<?php
guest(); 
require "Validator.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = $db->query("SELECT * FROM users WHERE username = :username", [
        'username' => $username
    ])->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        // Set session variables for middleware checks
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header("Location: /");
        exit;
    } else {
        $errors['login'] = "Invalid username or password.";
    }
}

require "views/auth/login.view.php";