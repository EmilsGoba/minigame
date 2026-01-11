<?php
guest(); // Ensure logged-in users cannot access this page
require "Validator.php"; // Load the validation class

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Basic Validation
    if ($username === '' || $email === '' || $password === '') {
        $errors[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if (empty($errors)) {

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // REMOVED 'role' to match your migrations.sql
        $sql = "INSERT INTO users (username, email, password_hash)
                VALUES (:username, :email, :password_hash)";

        try {
            $db->query($sql, [
                'username' => $username,
                'email' => $email,
                'password_hash' => $passwordHash
            ]);

            // Redirect to login upon successful registration
            header("Location: /login");
            exit;

        } catch (PDOException $e) {
            // If the error code is 23000, it means a duplicate entry (username or email)
            if ($e->getCode() == 23000) {
                $errors[] = "Username or email already exists.";
            } else {
                // Shows the actual error if it's not a duplicate issue
                $errors[] = "Database error: " . $e->getMessage();
            }
        }
    }
}

require "views/auth/register.view.php"; // Load the registration view