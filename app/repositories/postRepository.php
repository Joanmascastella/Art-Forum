<?php

namespace repositories;

use PDO;
use PDOException;
use repositories\ratingrepository;
use model\post;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/ratingrepository.php';
require_once __DIR__ . '/commentrepository.php';
require_once __DIR__ . '/../model/post.php';

class postRepository
{
    private $db;

    private $ratingrepo;
    private $commentrepo;

    public function __construct(PDO $dbConnection)
    {
        $this->db = $dbConnection;
        $this->ratingrepo = new ratingrepository($dbConnection);
        $this->commentrepo = new commentrepository($dbConnection);
    }

    public function createPost($userID, $title, $picture, $description = null, $tags = [])
    {
        try {
            if ($picture === null) {
                throw new PDOException("Picture cannot be null.");
            }
            $sql = "INSERT INTO Posts (UserID, Title, Description, picture) VALUES (:userID, :title, :description, :picture)";
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':userID', $userID);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':picture', $picture);

            $stmt->execute();

            $postId = $this->db->lastInsertId();

            foreach ($tags as $tag) {
                $sql = "INSERT INTO PostTags (PostID, TagName) VALUES (:postID, :tagName)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':postID', $postId);
                $stmt->bindParam(':tagName', $tag);
                $stmt->execute();
            }

        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function deletePostByUser($userID)
    {
        $sql = "DELETE FROM Posts WHERE UserID = :userid";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':userid', $userID);
        $stmt->execute();
    }


    //I had to fetch by association for the 3 functions below due to the way my api's work
    public function getAllPosts()
    {
        $sql = "SELECT Posts.*, Users.username, GROUP_CONCAT(PostTags.TagName) as Tags FROM Posts
            JOIN Users ON Posts.UserID = Users.UserID
            LEFT JOIN PostTags ON Posts.PostID = PostTags.PostID
            GROUP BY Posts.PostID
            ORDER BY Posts.PostDate DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($posts as &$post) {
            $post['picture'] = $post['picture'] ? '/img/post-images/' . basename($post['picture']) : null;
            $post['Tags'] = $post['Tags'] ? explode(',', $post['Tags']) : [];
        }
        return $posts;
    }


    public function getLatestPosts($lastPostId)
    {
        $sql = "SELECT Posts.*, Users.username, GROUP_CONCAT(PostTags.TagName) as Tags FROM Posts
            JOIN Users ON Posts.UserID = Users.UserID
            LEFT JOIN PostTags ON Posts.PostID = PostTags.PostID
            WHERE Posts.PostID > :lastPostId
            GROUP BY Posts.PostID
            ORDER BY Posts.PostDate DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':lastPostId', $lastPostId, PDO::PARAM_INT);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($posts as &$post) {
            $post['Picture'] = $post['picture'] ? 'img/post-images/' . basename($post['picture']) : 'img/account-25.png';
            $post['Comments'] = $this->commentrepo->getCommentsByPostId($post['PostID']);
            $post['TotalLikes'] = $this->ratingrepo->countLikes($post['PostID']);
        }
        return $posts;
    }

    public function searchPostsByTag($tag)
    {
        $sql = "SELECT Posts.*, Users.username, GROUP_CONCAT(PostTags.TagName) as Tags 
            FROM Posts
            JOIN Users ON Posts.UserID = Users.UserID
            LEFT JOIN PostTags ON Posts.PostID = PostTags.PostID
            WHERE PostTags.TagName = :tag
            GROUP BY Posts.PostID
            ORDER BY Posts.PostDate DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':tag', $tag);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($posts as &$post) {
            $post['Picture'] = $post['picture'] ? 'img/post-images/' . basename($post['picture']) : 'img/account-25.png';
            $post['Comments'] = $this->commentrepo->getCommentsByPostId($post['PostID']);
            $post['TotalLikes'] = $this->ratingrepo->countLikes($post['PostID']);
        }

        return $posts;
    }

}