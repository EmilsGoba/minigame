<?php
auth();

// 1. Memory Match Leaderboards (Game ID 1)
$memDiffs = $db->query("SELECT * FROM difficulties WHERE game_id = 1", [])->fetchAll();
$memoryLeaderboards = [];
foreach ($memDiffs as $diff) {
    $memoryLeaderboards[$diff['name']] = $db->query(
        "SELECT u.username, ms.time_seconds FROM memory_scores ms 
         JOIN users u ON ms.user_id = u.user_id 
         WHERE ms.difficulty_id = :id ORDER BY ms.time_seconds ASC LIMIT 5",
        ['id' => $diff['difficulty_id']]
    )->fetchAll();
}

// 2. Typing Speed Leaderboards (Game ID 2)
$typeDiffs = $db->query("SELECT * FROM difficulties WHERE game_id = 2", [])->fetchAll();
$typingLeaderboards = [];
foreach ($typeDiffs as $diff) {
    $typingLeaderboards[$diff['name']] = $db->query(
        "SELECT u.username, ts.words_per_minute, ts.accuracy FROM typing_scores ts 
         JOIN users u ON ts.user_id = u.user_id 
         WHERE ts.difficulty_id = :id ORDER BY ts.words_per_minute DESC LIMIT 5",
        ['id' => $diff['difficulty_id']]
    )->fetchAll();
}

require "views/index.view.php";