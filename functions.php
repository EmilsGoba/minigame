<?php

function redirect(string $path): void
{
	header("Location: {$path}");
	exit;
}

function auth(): void
{
	if (!isset($_SESSION['user_id'])) {
		redirect('/');
	}
}

function guest(): void
{
	if (isset($_SESSION['user_id'])) {
		redirect('/home');
	}
}

function e(?string $value): string
{
	return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
