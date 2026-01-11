<?php
guest(); // Prevents logged-in users from accessing this page

$pageTitle = 'Login';
$navbar = "/public/css/navbar.css";
$style = "/public/css/auth.css";

$errors = [];
$identity = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$identity = trim((string)($_POST['identity'] ?? ''));
	$password = (string)($_POST['password'] ?? '');

	if ($identity === '' || $password === '') {
		$errors[] = 'Username/email and password are required.';
	} else {
		$sql = "SELECT user_id, username, email, password_hash FROM users WHERE username = :identity OR email = :identity LIMIT 1";
		$user = $db->query($sql, ['identity' => $identity])->fetch();

		if (!$user) {
			$errors[] = 'User not found.';
		} elseif (!password_verify($password, $user['password_hash'])) {
			$errors[] = 'Incorrect password.';
		} else {
			$_SESSION['user_id'] = (int)$user['user_id'];
			$_SESSION['username'] = $user['username'];
			redirect('/home');
		}
	}
}

require "views/auth/login.view.php";
