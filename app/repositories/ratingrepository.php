<?php

namespace repositories;

use PDO;
use PDOException;
use config\dbconfig;

require_once __DIR__ . '/../config/dbconfig.php';

class ratingrepository
{
    private $db;

    public function __construct(PDO $dbConnection)
    {
        $this->db = $dbConnection;
    }

    public function toggleLike($PostID, $UserID)
    {
        $stmt = $this->db->prepare("SELECT * FROM Ratings WHERE PostID = ? AND UserID = ?");
        $stmt->execute([$PostID, $UserID]);
        $like = $stmt->fetch();

        if ($like) {
            $stmt = $this->db->prepare("DELETE FROM Ratings WHERE PostID = ? AND UserID = ?");
            $stmt->execute([$PostID, $UserID]);
            return false;
        } else {
            $stmt = $this->db->prepare("INSERT INTO Ratings (PostID, UserID, LikeStatus) VALUES (?, ?, 1)");
            $stmt->execute([$PostID, $UserID]);
            return true;
        }
    }

    public function countLikes($PostID)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Ratings WHERE PostID = ?");
        $stmt->execute([$PostID]);
        return $stmt->fetchColumn();
    }
}