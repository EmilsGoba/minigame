<?php
// We don't use auth() here because this is an API call, 
// but we check the session directly.
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit;
}

// Get the JSON data from the request body
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (isset($data['time']) && isset($data['difficulty_id'])) {
    $db->query("INSERT INTO memory_scores (user_id, difficulty_id, time_seconds) 
                VALUES (:user_id, :diff_id, :time)", [
        'user_id' => $_SESSION['user_id'],
        'diff_id' => $data['difficulty_id'],
        'time'    => $data['time']
    ]);
    
    echo json_encode(['status' => 'success']);
} else {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
}