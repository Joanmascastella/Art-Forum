<?php

use controller\postController;

require_once __DIR__ . '/../../controller/postController.php';

header('Content-Type: application/json');

$postController = new postController();

$searchQuery = isset($_GET['tag']) ? htmlspecialchars($_GET['tag']) : '';

$result = $postController->searchPostsByTag($searchQuery);

echo json_encode($result);
