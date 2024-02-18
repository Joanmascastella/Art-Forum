<?php

namespace controller;

use config\dbconfig;
use services\ratingService;
use Exception;


require_once __DIR__ . '/../services/ratingService.php';
require_once __DIR__ . '/../config/dbconfig.php';

class ratingController
{
    private $ratingService;
    private $dbConnection;

    public function __construct()
    {
        $dbConfig = new dbconfig();
        $this->dbConnection = $dbConfig->connect();
        $this->ratingService = new ratingService($this->dbConnection);
    }

    public function toggleLike($postID, $userID)
    {
        try {
            return $this->ratingService->toggleLike($postID, $userID);
        } catch (Exception $e) {
            echo "Error when liking or unliking post";
            throw $e;
        }
    }

    public function countLikes($postID)
    {
        return $this->ratingService->countLikes($postID);
    }

}