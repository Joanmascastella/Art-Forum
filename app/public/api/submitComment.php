<?php

use controller\commentController;

require_once __DIR__ . '/../../controller/commentController.php';
require_once __DIR__ . '/../../model/comment.php';

header('Content-Type: application/json');

$commentController = new commentController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postID = filter_input(INPUT_POST, 'postID', FILTER_VALIDATE_INT);
    $userID = filter_input(INPUT_POST, 'userID', FILTER_VALIDATE_INT);
    $commentText = isset($_POST['commentText']) ? htmlspecialchars($_POST['commentText']) : '';
    $date = date('Y-m-d H:i:s');

    if (strlen($commentText) > 500) {
        echo json_encode(['success' => false, 'message' => 'Comment too long']);
        exit;
    }

    if ($postID !== false && $userID !== false && $commentText) {
        $response = $commentController->createComment($postID, $userID, $commentText, $date);
        echo json_encode($response);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
    }
}
