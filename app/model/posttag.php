<?php

namespace model;

class posttag
{
    private int $tagID;
    private int $postID;
    private string $tagName;

    /**
     * @param int $tagID
     * @param int $postID
     * @param string $tagName
     */
    public function __construct(int $tagID, int $postID, string $tagName)
    {
        $this->tagID = $tagID;
        $this->postID = $postID;
        $this->tagName = $tagName;
    }

    public function getTagID(): int
    {
        return $this->tagID;
    }

    public function setTagID(int $tagID): void
    {
        $this->tagID = $tagID;
    }

    public function getPostID(): int
    {
        return $this->postID;
    }

    public function setPostID(int $postID): void
    {
        $this->postID = $postID;
    }

    public function getTagName(): string
    {
        return $this->tagName;
    }

    public function setTagName(string $tagName): void
    {
        $this->tagName = $tagName;
    }


}
