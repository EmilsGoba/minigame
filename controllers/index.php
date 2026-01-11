<?php
auth();

// Fetch all available games for the selection cards
$games = $db->query("SELECT * FROM games", [])->fetchAll();

// 1. Fetch all difficulties for Memory Match (game_id = 1)
$difficulties = $db->query("SELECT * FROM difficulties WHERE game_id = 1", [])->fetchAll();

$leaderboards = [];

// 2. Loop through each difficulty to get its specific top 5 scores
foreach ($difficulties as $diff) {
    $query = "SELECT u.username, ms.time_seconds, ms.created_at 
              FROM memory_scores ms
              JOIN users u ON ms.user_id = u.user_id
              WHERE ms.difficulty_id = :diff_id
              ORDER BY ms.time_seconds ASC 
              LIMIT 5";

    $leaderboards[$diff['name']] = $db->query($query, ['diff_id' => $diff['difficulty_id']])->fetchAll();
}

require "views/index.view.php";