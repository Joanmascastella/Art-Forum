<?php

namespace services;

use repositories\commentrepository;
use PDO;
use Exception;
use model\comment;

require_once __DIR__ . '/../repositories/commentrepository.php';
require_once __DIR__ . '/../model/comment.php';

class commentService
{

    private $commentRepository;

    public function __construct(PDO $dbConnection)
    {
        $this->commentRepository = new commentrepository($dbConnection);
    }

    public function createComment(comment $comment)
    {
            $this->commentRepository->createComment(
                $comment->getPostID(),
                $comment->getUserID(),
                $comment->getCommentText(),
                $comment->getCommentDate()
            );

    }

    public function deleteComment($userID)
    {
        $this->commentRepository->deleteComment($userID);
    }

    public function getCommentsByPostId($postId)
    {
        return $this->commentRepository->getCommentsByPostId($postId);
    }
}