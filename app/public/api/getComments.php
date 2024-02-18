<?php

use controller\commentController;

require_once __DIR__ . '/../../controller/commentController.php';

header('Content-Type: application/json');

$commentController = new commentController();
$postID = isset($_GET['postID']) ? htmlspecialchars($_GET['postID']) : null;


if ($postID) {
    $comments = $commentController->getCommentsByPostId($postID);
    echo json_encode($comments);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid post ID']);
}
