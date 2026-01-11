<?php

$pageTitle = 'Leaderboard';

// Typing Speed game_id from migrations seed
$gameId = 2;

$difficulties = [];
$selectedDifficultyId = null;
$scores = [];

try {
	$difficulties = $db
		->query('SELECT id, name FROM difficulties WHERE game_id = :game_id ORDER BY id', [
			'game_id' => $gameId,
		])
		->fetchAll();

	if (!empty($difficulties)) {
		$selectedDifficultyId = (int)$difficulties[0]['id'];
	}

	if (isset($_GET['difficulty'])) {
		$requested = (int)$_GET['difficulty'];
		foreach ($difficulties as $diff) {
			if ((int)$diff['id'] === $requested) {
				$selectedDifficultyId = $requested;
				break;
			}
		}
	}

	if ($selectedDifficultyId !== null) {
		$scores = $db
			->query(
				"SELECT u.username,
						ts.words_per_minute,
						ts.accuracy,
						ts.time_seconds,
						ts.created_at
				 FROM typing_scores ts
				 JOIN users u ON u.user_id = ts.user_id
				 WHERE ts.difficulty_id = :difficulty_id
				 ORDER BY ts.words_per_minute DESC,
				 		(ts.accuracy IS NULL) ASC,
				 		ts.accuracy DESC,
				 		ts.time_seconds ASC,
				 		ts.created_at ASC
				 LIMIT 10",
				[
					'difficulty_id' => $selectedDifficultyId,
				]
			)
			->fetchAll();
	}
} catch (Throwable $e) {
	// Fail closed: show empty state.
	$difficulties = [];
	$selectedDifficultyId = null;
	$scores = [];
}

require 'views/leaderboard.view.php';

