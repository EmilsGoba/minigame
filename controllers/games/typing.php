<?php
auth(); // Ensure user is logged in

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $difficultyId = (int)($_POST['difficulty_id'] ?? 0);
    $timeSeconds = (int)($_POST['time_seconds'] ?? 0);
    $wpm = (int)($_POST['words_per_minute'] ?? 0);
    $accuracy = (float)($_POST['accuracy'] ?? 0);

    // Save to the typing_scores table defined in your migrations
    if ($difficultyId > 0 && $wpm >= 0) {
        $db->query(
            "INSERT INTO typing_scores (user_id, difficulty_id, time_seconds, words_per_minute, accuracy) 
             VALUES (:u, :d, :t, :w, :a)",
            [
                'u' => $_SESSION['user_id'],
                'd' => $difficultyId,
                't' => $timeSeconds,
                'w' => $wpm,
                'a' => $accuracy
            ]
        );
        echo json_encode(['ok' => true]);
        exit;
    }
}

require "views/games/typing.view.php"; // Load the visual interface