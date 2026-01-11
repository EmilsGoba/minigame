<?php

// GET: render the typing game page
// POST: accept game results and save to DB (if logged in)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	header('Content-Type: application/json; charset=utf-8');

	if (!isset($_SESSION['user_id'])) {
		http_response_code(401);
		echo json_encode(['ok' => false, 'error' => 'not_logged_in']);
		exit;
	}

	$difficultyId = isset($_POST['difficulty_id']) ? (int)$_POST['difficulty_id'] : 0;
	$timeSeconds = isset($_POST['time_seconds']) ? (int)$_POST['time_seconds'] : 0;
	$wpm = isset($_POST['words_per_minute']) ? (int)$_POST['words_per_minute'] : 0;
	$accuracy = isset($_POST['accuracy']) ? (float)$_POST['accuracy'] : null;

	if ($difficultyId <= 0 || $timeSeconds <= 0 || $wpm < 0) {
		http_response_code(422);
		echo json_encode(['ok' => false, 'error' => 'invalid_payload']);
		exit;
	}

	try {
		$sql = "INSERT INTO typing_scores (user_id, difficulty_id, time_seconds, words_per_minute, accuracy)
				VALUES (:user_id, :difficulty_id, :time_seconds, :words_per_minute, :accuracy)";

		$db->query($sql, [
			'user_id' => (int)$_SESSION['user_id'],
			'difficulty_id' => $difficultyId,
			'time_seconds' => $timeSeconds,
			'words_per_minute' => $wpm,
			'accuracy' => $accuracy,
		]);

		echo json_encode(['ok' => true]);
		exit;
	} catch (Throwable $e) {
		http_response_code(500);
		echo json_encode(['ok' => false, 'error' => 'db_error']);
		exit;
	}
}

$pageTitle = 'Typing Game';

require "views/typing.view.php";
