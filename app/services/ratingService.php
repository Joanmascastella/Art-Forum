<?php

namespace services;

use repositories\ratingrepository;
use PDO;
use Exception;

require_once __DIR__ . '/../repositories/ratingrepository.php';


class ratingService
{
    private $ratingRepository;

    public function __construct(PDO $dbConnection)
    {
        $this->ratingRepository = new ratingrepository($dbConnection);
    }


    public function toggleLike($postID, $userID)
    {
        try {
            $result = $this->ratingRepository->toggleLike($postID, $userID);
            return $result;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function countLikes($postID)
    {
        return $this->ratingRepository->countLikes($postID);
    }

}