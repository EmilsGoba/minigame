<?php

guest();

$pageTitle = 'Register';
$navbar = "/public/css/navbar.css";
$style = "/public/css/auth.css";

$errors = [];
$values = [
	'username' => '',
	'email' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$username = trim((string)($_POST['username'] ?? ''));
	$email = trim((string)($_POST['email'] ?? ''));
	$password = (string)($_POST['password'] ?? '');
	$confirm = (string)($_POST['confirm_password'] ?? '');

	$values['username'] = $username;
	$values['email'] = $email;

	if ($username === '' || $email === '' || $password === '') {
		$errors[] = 'Username, email, and password are required.';
	}
	if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors[] = 'Email is not valid.';
	}
	if ($password !== '' && strlen($password) < 6) {
		$errors[] = 'Password must be at least 6 characters.';
	}
	if ($confirm !== '' && $password !== $confirm) {
		$errors[] = 'Passwords do not match.';
	}

	if (!$errors) {
		$exists = $db->query(
			"SELECT user_id FROM users WHERE username = :username OR email = :email LIMIT 1",
			['username' => $username, 'email' => $email]
		)->fetch();

		if ($exists) {
			$errors[] = 'Username or email already exists.';
		} else {
			$hash = password_hash($password, PASSWORD_DEFAULT);
			$db->query(
				"INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)",
				['username' => $username, 'email' => $email, 'password_hash' => $hash]
			);

			redirect('/login');
		}
	}
}

require "views/auth/register.view.php";
