<?php

use controller\postController;

header('Content-Type: application/json');
require_once __DIR__ . '/../../controller/postController.php';

$postController = new postController();

$lastPostId = filter_input(INPUT_GET, 'lastPostId', FILTER_SANITIZE_NUMBER_INT);
if ($lastPostId === null || $lastPostId === false) {
    $lastPostId = 0;
}

$latestPosts = $postController->getLatestPosts($lastPostId);

echo json_encode($latestPosts);
