<?php

namespace model;

class rating
{
    private int $ratingID;
    private int $postID;
    private int $userID;
    private int $starRating;
    private DateTime $ratingDate;

    /**
     * @param int $ratingID
     * @param int $postID
     * @param int $userID
     * @param int $starRating
     * @param DateTime $ratingDate
     */
    public function __construct(int $ratingID, int $postID, int $userID, int $starRating, DateTime $ratingDate)
    {
        $this->ratingID = $ratingID;
        $this->postID = $postID;
        $this->userID = $userID;
        $this->starRating = $starRating;
        $this->ratingDate = $ratingDate;
    }

    public function getRatingID(): int
    {
        return $this->ratingID;
    }

    public function setRatingID(int $ratingID): void
    {
        $this->ratingID = $ratingID;
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

    public function getStarRating(): int
    {
        return $this->starRating;
    }

    public function setStarRating(int $starRating): void
    {
        $this->starRating = $starRating;
    }

    public function getRatingDate(): DateTime
    {
        return $this->ratingDate;
    }

    public function setRatingDate(DateTime $ratingDate): void
    {
        $this->ratingDate = $ratingDate;
    }


}