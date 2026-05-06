<?php
require_once __DIR__ . '/../controllers/authController.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, "Invalid method");
}


$headers = getallheaders();
if (!isset($headers['Authorization'])) {
    sendResponse(false, "Authorization header missing");
}

$authHeader = $headers['Authorization'];
if (strpos($authHeader, 'Bearer ') !== 0) {
    sendResponse(false, "Invalid Authorization format");
}

$token = substr($authHeader, 7);


$input = json_decode(file_get_contents("php://input"), true);

if (
    !isset($input['quiz_id']) ||
    !isset($input['answers']) ||
    !isset($input['started_at'])
) {
    sendResponse(false, "Missing required fields");
}

$quiz_id   = $input['quiz_id'];
$answers   = $input['answers'];
$startedAt = $input['started_at'];

// Validate answers
if (!is_array($answers)) {
    sendResponse(false, "Invalid answers format");
}

$data = new authController();


$data->submitQuiz($token, $quiz_id, $answers, $startedAt);