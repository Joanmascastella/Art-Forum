<?php

namespace model;
use DateTime;
class comment
{
    private int $commentID;
    private int $postID;
    private int $userID;
    private string $commentText;
    private DateTime $commentDate;

    public function __construct()
    {
    }

    public function getCommentID(): int
    {
        return $this->commentID;
    }

    public function setCommentID(int $commentID): void
    {
        $this->commentID = $commentID;
    }

    public function getPostID(): int
    {
        return $this->postID;
    }

    public function setPostID(int $postID): void
    {
        $this->postID = $postID;
    }

    public function getUserID(): int
    {
        return $this->userID;
    }

    public function setUserID(int $userID): void
    {
        $this->userID = $userID;
    }

    public function getCommentText(): string
    {
        return $this->commentText;
    }

    public function setCommentText(string $commentText): void
    {
        $this->commentText = $commentText;
    }

    public function getCommentDate(): DateTime
    {
        return $this->commentDate;
    }


    public function setCommentDate(\DateTime $commentDate): void
    {
        $this->commentDate = $commentDate;
    }


}