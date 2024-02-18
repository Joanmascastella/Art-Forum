<?php

namespace repositories;

use PDO;
use PDOException;
use config\dbconfig;
use model\comment;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/comment.php';

class commentrepository
{
    private $db;

    public function __construct(PDO $dbConnection)
    {
        $this->db = $dbConnection;
    }

    function createComment($postID, $userID, $commentText, $commentDate)
    {
        try {
            $this->db->beginTransaction();

            $formattedDate = $commentDate->format('Y-m-d H:i:s');

            $sql = "INSERT INTO Comments (PostID, UserID, CommentText, CommentDate) values (:postid, :userid, :commenttext, :commentdate)";
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':postid', $postID, PDO::PARAM_INT);
            $stmt->bindParam(':userid', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':commenttext', $commentText, PDO::PARAM_STR);
            // Bind the formatted date string here.
            $stmt->bindParam(':commentdate', $formattedDate, PDO::PARAM_STR);

            $stmt->execute();

            $this->db->commit();
        } catch (PDOException $e) {
            $this->db->rollBack();
            throw $e;
        }
    }


    function deleteComment($userID)
    {
        $sql = "DELETE FROM Comments WHERE UserID = :userid";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':userid', $userID);
        $stmt->execute();
    }

    public function getCommentsByPostId($postId)
    {
        $sql = "SELECT c.*, u.Username FROM Comments c 
                LEFT JOIN Users u ON c.UserID = u.UserID 
                WHERE c.PostID = :postid ORDER BY c.CommentDate DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':postid', $postId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }


}