<?php

namespace controller;

use services\userServices;
use services\postService;
use config\dbconfig;
use model\post;
use model\postTagEnum;

require_once __DIR__ . '/../services/postService.php';
require_once __DIR__ . '/../services/userServices.php';
require_once __DIR__ . '/../model/post.php';
require_once __DIR__ . '/../model/postTagEnum.php';

class postController
{
    private $userServices;
    private $postServices;
    private $dbConnection;

    public function __construct()
    {
        $dbConfig = new dbconfig();
        $this->dbConnection = $dbConfig->connect();
        $this->userServices = new userServices($this->dbConnection);
        $this->postServices = new postService($this->dbConnection);
    }

    public function showDiscoverPage()
    {
        if (!isset($_SESSION['username'])) {
            header("Location: /loginPage");
            exit;
        }

        $pageTitle = "Discover";
        $posts = $this->getAllPosts();
        $sessionUSERID = $this->userServices->getUserIDByUsername($_SESSION['username']);
        echo "<script type='text/javascript'>var sessionUSERID = " . json_encode(htmlspecialchars($sessionUSERID)) . ";</script>";


        require '../views/userDiscover.php';
    }

    public function showNewPostPage()
    {
        if (!isset($_SESSION['username'])) {
            header("Location: /");
            exit;
        }
        $pageTitle = "New Post";
        $postTags = postTagEnum::cases();
        $sessionUSERID = $this->userServices->getUserIDByUsername($_SESSION['username']);
        echo "<script type='text/javascript'>var sessionUSERID = " . json_encode(htmlspecialchars($sessionUSERID)) . ";</script>";

        require '../views/newPost.php';
    }

    public function newPostAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (!isset($_SESSION['username'])) {
                header("Location: /loginPage");
                exit;
            }


            $userID = $this->userServices->getUserIDByUsername($_SESSION['username']);

            $title = htmlspecialchars($_POST['title']);
            $description = htmlspecialchars($_POST['description']);
            $tags = isset($_POST['posttags']) ? array_map('htmlspecialchars', $_POST['posttags']) : [];

            $picturePath = $this->handlePictureUpload();

            $post = new \model\post();
            $post->setUserID($userID);
            $post->setTitle($title);
            $post->setDescription($description);
            $post->setPicture($picturePath);

            try {
                $this->postServices->createPost($post, $tags);
                header("Location: /initialUserView");
                exit;
            } catch (\Exception $e) {
                $_SESSION['error_message'] = "Failed to create post: " . $e->getMessage();
                header("Location: /new-post");
                exit;
            }
        }
    }

    private function handlePictureUpload()
    {
        $picturePath = null;
        if (isset($_FILES['picture'])) {

            if ($_FILES['picture']['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['error_message'] = "Error uploading the picture.";
                header("Location: /new-post");
                exit;
            }

            $allowedTypes = ['image/jpeg', 'image/png'];
            $fileType = mime_content_type($_FILES['picture']['tmp_name']);
            if (!in_array($fileType, $allowedTypes)) {
                $_SESSION['error_message'] = "Invalid file type. Only JPG and PNG are allowed.";
                header("Location: /new-post");
                exit;
            }

            $uploadDir = __DIR__ . '/../public/img/post-images/';
            $fileName = time() . '_' . basename($_FILES['picture']['name']);
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['picture']['tmp_name'], $targetPath)) {
                $picturePath = '/img/post-images/' . $fileName;
            } else {
                $_SESSION['error_message'] = "Error uploading the picture.";
                header("Location: /new-post");
                exit;
            }
        }

        return $picturePath;
    }

    public function searchPostsByTag($tag)
    {
        $sanitizedTag = htmlspecialchars($tag);
        $posts = $this->postServices->searchPostsByTag($sanitizedTag);
        return $this->postArrayStructure($posts);
    }

    public function getLatestPosts($lastPostId)
    {
        $posts = $this->postServices->getLatestPosts($lastPostId);
        return $this->postArrayStructure($posts);
    }

    private function getAllPosts()
    {

        $posts = $this->postServices->getAllPosts();
        return $this->postArrayStructure($posts);
    }

    public function postArrayStructure($posts): array
    {
        $postsArray = array_map(function ($post) {
            if (is_string($post['Tags'])) {
                $tags = explode(',', $post['Tags']);
            } else {
                $tags = [];
            }

            return [
                'PostID' => $post['PostID'],
                'UserID' => $post['UserID'],
                'Title' => $post['Title'],
                'Description' => $post['Description'],
                'PostDate' => $post['PostDate'],
                'Picture' => $post['Picture'] ?? null,
                'Username' => $post['username'],
                'Tags' => $tags,
                'Comments' => $post['Comments'] ?? [],
                'TotalLikes' => $post['TotalLikes'] ?? 0
            ];
        }, $posts);

        return $postsArray;
    }


}
