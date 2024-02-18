<?php

namespace controller;

use config\dbconfig;
use model\admin;
use model\User;
use services\userServices;
use services\adminServices;
use services\postService;

require_once __DIR__ . '/../services/userServices.php';
require_once __DIR__ . '/../services/adminServices.php';
require_once __DIR__ . '/../services/postService.php';
require_once __DIR__ . '/../model/user.php';
require_once __DIR__ . '/../model/admin.php';
require_once __DIR__ . '/../config/dbconfig.php';

class usercontroller
{
    private $userServices;
    private $adminServices;
    private $postServices;
    private $dbConnection;

    public function __construct()
    {
        $dbConfig = new dbconfig();
        $this->dbConnection = $dbConfig->connect();
        $this->userServices = new userServices($this->dbConnection);
        $this->adminServices = new adminServices($this->dbConnection);
        $this->postServices = new postService($this->dbConnection);
    }

    public function showLoginPage($loginError = "")
    {
        $pageTitle = "Login";
        require '../views/login_register/login.php';
    }


    public function showRegisterPage()
    {
        $pageTitle = "Register";
        require '../views/login_register/register.php';
    }

    public function showUserView()
    {
        if (!isset($_SESSION['username'])) {
            header("Location: /");
            exit;
        }

        $sessionUSERID = $this->userServices->getUserIDByUsername($_SESSION['username']);
        echo "<script type='text/javascript'>var sessionUSERID = " . json_encode(htmlspecialchars($sessionUSERID)) . ";</script>";

        $pageTitle = "Home";

        $posts = $this->postServices->getAllPosts();

        require '../views/userHomepage.php';
    }

    public function showAdminView()
    {
        $pageTitle = "Admin Home";
        require '../views/adminHomepage.php';
    }

    public function showUserAccountManagerPage()
    {
        $pageTitle = "Account Manager";
        if (!isset($_SESSION['username'])) {
            header("Location: /");
            exit;
        }

        $userData = $this->userServices->getUserDetails($_SESSION['username']);
        require '../views/userAccountManager.php';
    }

    public function showAdminAccountManager()
    {
        $pageTitle = "Admin Account Manager";
        if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
            header("Location: /");
            exit;
        }

        $allUsers = $this->userServices->listAllUsers();
        require '../views/adminAccountManager.php';
    }

    public function showEditAccountPage()
    {
        $pageTitle = "Edit Account";
        if (!isset($_SESSION['username'])) {
            header("Location: /");
            exit;
        }

        $userData = $this->userServices->getUserDetails($_SESSION['username']);
        require '../views/userEditAccountDetails.php';
    }


    public function loginAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = htmlspecialchars($_POST["username"]);
            $password = htmlspecialchars($_POST["password"]);
            $this->login($username, $password);
        }
    }

    private function login($username, $password)
    {
        $admin = $this->adminServices->authenticateAdmin($username, $password);
        if ($admin) {
            $_SESSION['username'] = $admin->getAdminUsername();
            $_SESSION['role'] = $admin->getAdminRole();
            header('Location: /initialAdminView');
            exit;
        }

        $user = $this->userServices->authenticateUser($username, $password);
        if ($user) {
            $_SESSION['username'] = $user->getUsername();
            $_SESSION['role'] = $user->getRole();
            header('Location: /initialUserView');
            exit;
        }

        $this->handleLoginFailure();
    }

    private function handleLoginFailure()
    {
        $loginError = "Login Failed. Please check your credentials.";
        $this->showLoginPage($loginError);
    }


    public function registerAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $email = htmlspecialchars($_POST['email']);
            $adminKey = htmlspecialchars($_POST['adminKey'] ?? '');

            if ($adminKey && $adminKey === 'orangutan') {
                $role = "admin";
                $newAdmin = new admin();
                $newAdmin->setAdminUsername($username);
                $newAdmin->setAdminPassword($password);
                $newAdmin->setAdminRole($role);
                $newAdmin->setAdminEmail($email);

                try {
                    $this->adminServices->registerAdmin($newAdmin);
                    $_SESSION['username'] = $newAdmin->getAdminUsername();

                    header("Location: /");
                    exit;
                } catch (Exception $e) {
                    $_SESSION['error_message'] = "Admin registration failed: " . $e->getMessage();
                    header("Location: /register");
                    exit;
                }
            } else {
                $newUser = new User();
                $newUser->setUsername($username);
                $newUser->setPassword($password);
                $newUser->setEmail($email);

                try {
                    $this->userServices->registerUser($newUser);
                    $_SESSION['username'] = $newUser->getUsername();
                    header("Location: /");
                    exit;
                } catch (Exception $e) {
                    $_SESSION['error_message'] = "User registration failed: " . $e->getMessage();
                    header("Location: /register");
                    exit;
                }
            }
        }
    }

    public function downloadUserDataAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($_SESSION['role'] === 'admin') {
                $allUsers = $this->userServices->listAllUsers();
                $jsonData = json_encode($allUsers, JSON_PRETTY_PRINT);

                header('Content-Type: application/json');
                header('Content-Disposition: attachment; filename="users.json"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');

                echo $jsonData;
                exit;
            } else {
                echo "Unauthorized access.";
                exit;
            }
        }
    }

    public function adminDeleteUserAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userToDelete'])) {
            $usernameToDelete = htmlspecialchars($_POST['userToDelete']);
            if ($_SESSION['role'] === 'admin') {
                $this->userServices->removeUser($usernameToDelete);
                header("Location: /admin-page");
                exit;
            } else {
                echo "Unauthorized access.";
                exit;
            }
        }
    }

    public function userAccountDeleteAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_SESSION['username'] ?? null;
            if ($username) {
                $this->userServices->removeUser($username);
                session_destroy();
                header("Location: /");
                exit;
            }
        }
    }

    public function editAccountAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (!isset($_SESSION['username'])) {
                header("Location: /");
                exit;
            }

            $user = new \model\User();
            $user->setUsername(htmlspecialchars($_POST['username']));
            $user->setEmail(htmlspecialchars($_POST['email']));
            $user->setBio(htmlspecialchars($_POST['bio']));
            $user->setProfilePicture($this->handleProfilePictureUpload());

            try {
                $this->userServices->updateUserProfile($user);
                header("Location: /account-manager");
                exit;
            } catch (Exception $e) {
                $_SESSION['error_message'] = "Profile update failed: " . $e->getMessage();
                header("Location: /edit-account-view");
                exit;
            }
        }
    }

    private function handleProfilePictureUpload()
    {
        $existingProfilePicture = $this->userServices->getCurrentUserProfilePicture($_SESSION['username']);

        if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png'];
            $fileType = mime_content_type($_FILES['profilePicture']['tmp_name']);

            if (!in_array($fileType, $allowedTypes)) {
                $_SESSION['error_message'] = "Invalid file type. Only JPG and PNG are allowed.";
                header("Location: /edit-account-view");
                exit;
            }

            $uploadDir = __DIR__ . '/../public/img/profiles/';
            $fileName = time() . '_' . basename($_FILES['profilePicture']['name']);
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetPath)) {
                return '/img/profiles/' . $fileName;
            } else {
                $_SESSION['error_message'] = "Error uploading the profile picture.";
                header("Location: /edit-account-view");
                exit;
            }
        }

        return $existingProfilePicture;
    }

}


