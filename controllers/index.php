<?php
auth();

$games = $db->query("SELECT * FROM games", [])->fetchAll();

// Fetch Top 10 Memory Game Scores
$query = "SELECT u.username, d.name as level, ms.time_seconds, ms.created_at 
          FROM memory_scores ms
          JOIN users u ON ms.user_id = u.user_id
          JOIN difficulties d ON ms.difficulty_id = d.difficulty_id
          ORDER BY ms.time_seconds ASC 
          LIMIT 10";

$leaderboard = $db->query($query, [])->fetchAll();

require "views/index.view.php";