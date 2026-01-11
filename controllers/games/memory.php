<?php
auth();

$level = $_GET['level'] ?? null;

// If no level is picked, just show the selection screen
if (!$level) {
    $difficulties = $db->query("SELECT * FROM difficulties WHERE game_id = 1", [])->fetchAll();
    require "views/games/memory-select.view.php";
    exit;
}

// If a level IS picked, fetch settings and start the game
$difficulty = $db->query("SELECT * FROM difficulties WHERE game_id = 1 AND name = :name", [
    'name' => $level
])->fetch();

if (!$difficulty) {
    header("Location: /memory");
    exit;
}

// Generate and Randomize cards
$totalCards = $difficulty['grid_rows'] * $difficulty['grid_cols'];
$cards = [];
for ($i = 1; $i <= ($totalCards / 2); $i++) {
    $cards[] = $i;
    $cards[] = $i;
}
shuffle($cards);

require "views/games/memory.view.php";