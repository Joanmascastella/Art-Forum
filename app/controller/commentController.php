<?php

namespace controller;

use config\dbconfig;
use services\commentService;
use model\comment;
use DateTime;

require_once __DIR__ . '/../services/commentService.php';
require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/comment.php';

class commentController
{
    private $commentService;
    private $dbConnection;

    public function __construct()
    {
        $dbConfig = new dbconfig();
        $this->dbConnection = $dbConfig->connect();
        $this->commentService = new commentService($this->dbConnection);
    }

    public function createComment($postID, $userID, $commentText, $commentDate)
    {
        try {
            $comment = new comment();
            $comment->setPostID($postID);
            $comment->setUserID($userID);
            $comment->setCommentText($commentText);
            $comment->setCommentDate(new DateTime($commentDate));

            $this->commentService->createComment($comment);
            return ['success' => true, 'postID' => $postID];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }


    public function getCommentsByPostId($postId)
    {
        try {
            $comments = $this->commentService->getCommentsByPostId($postId);
            return ['success' => true, 'comments' => $comments];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

}