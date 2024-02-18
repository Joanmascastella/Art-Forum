<?php

namespace model;

class post
{
    private int $postID;
    private int $userID;
    private string $title;
    private string $description;
    private DateTime $dateTime;
    private string $picture;

    public $username;
    public $Tags;
    public $TotalLikes;
    public $Comments;


    public function __construct()
    {
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDateTime(): DateTime
    {
        return $this->dateTime;
    }

    public function setDateTime(DateTime $dateTime): void
    {
        $this->dateTime = $dateTime;
    }

    public function getPicture(): string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): void
    {
        $this->picture = $picture;
    }
}