<?php

use config\dbconfig;
use controller\ratingController;

require_once __DIR__ . '/../../controller/ratingController.php';

header('Content-Type: application/json');
$inputData = json_decode(file_get_contents('php://input'), true);

if (isset($inputData['postId'], $inputData['userId'])) {

    $postId = filter_var($inputData['postId'], FILTER_VALIDATE_INT);
    $userId = filter_var($inputData['userId'], FILTER_VALIDATE_INT);

    if ($postId === false || $userId === false) {
        echo json_encode(['success' => false, 'error' => 'Invalid Post ID or User ID.']);
        exit;
    }

    $ratingController = new ratingController();

    $likeStatus = $ratingController->toggleLike($postId, $userId);
    $totalLikes = $ratingController->countLikes($postId);

    echo json_encode([
        'success' => true,
        'likeStatus' => $likeStatus,
        'totalLikes' => $totalLikes
    ]);
} else {
    echo json_encode(['success' => false, 'error' => 'Post ID or User ID is missing.']);
}
