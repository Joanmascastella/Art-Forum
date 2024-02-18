<?php

namespace services;

use repositories\userrepository;
use PDO;
use model\User;

require_once __DIR__ . '/../repositories/userrepository.php';
require_once __DIR__ . '/../model/user.php';


class userServices
{
    private $userRepository;

    public function __construct(PDO $dbConnection)
    {
        $this->userRepository = new userrepository($dbConnection);
    }

    public function authenticateUser($username, $password)
    {
        $user = $this->userRepository->verifyUser($username, $password);
        if ($user) {

            return $user;
        }
        return null;
    }

    public function registerUser(User $user)
    {

        $this->userRepository->addUser(
            $user->getUsername(),
            $user->getEmail(),
            $user->getPassword()
        );
    }


    public function updateUserProfile(User $user)
    {

        $this->userRepository->editUser(
            $user->getUsername(),
            $user->getEmail(),
            $user->getBio(),
            $user->getProfilePicture()
        );
    }

    public function removeUser($username)
    {
        $this->userRepository->deleteUser($username);
    }

    public function getUserDetails($username)
    {
        return $this->userRepository->getUserByUsername($username);
    }

    public function listAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }

    public function getCurrentUserProfilePicture($username)
    {
        $userDetails = $this->userRepository->getUserByUsername($username);
        if (is_array($userDetails) && isset($userDetails['ProfilePicture'])) {
            return $userDetails['ProfilePicture'];
        } else {
            return null;
        }
    }

    public function getUserIDByUsername($username)
    {
        try {
            return $this->userRepository->getUserIDByUsername($username);
        } catch (PDOException $e) {
            echo "Error fetching user ID: " . $e->getMessage();
            return null;
        }
    }
}
