<?php

namespace services;

use model\post;
use repositories\postRepository;
use PDO;
use Exception;

require_once __DIR__ . '/../repositories/postRepository.php';


class postService
{
    private $postRepository;

    public function __construct(PDO $dbConnection)
    {
        $this->postRepository = new postRepository($dbConnection);
    }

    public function createPost(post $post, array $tags)
    {
        try {
            $this->postRepository->createPost(
                $post->getUserID(),
                $post->getTitle(),
                $post->getPicture(),
                $post->getDescription(),
                $tags
            );
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function deletePostByUser($userID)
    {
        $this->postRepository->deletePostByUser($userID);
    }

    public function getAllPosts()
    {
        return $this->postRepository->getAllPosts();
    }

    public function getCommentsByPostId($postId)
    {
        return $this->postRepository->getCommentsByPostId($postId);
    }

    public function getLatestPosts($lastPostId)
    {
        return $this->postRepository->getLatestPosts($lastPostId);
    }

    public function searchPostsByTag($tag)
    {
        return $this->postRepository->searchPostsByTag($tag);
    }

}