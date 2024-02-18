<?php

namespace repositories;

use PDO;
use PDOException;
use model\user;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/user.php';

class userrepository
{
    private $db;

    public function __construct(PDO $dbConnection)
    {
        $this->db = $dbConnection;
    }

    public function verifyUser($username, $password)
    {
        try {
            $sql = "SELECT * FROM Users WHERE Username = :username";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, \model\user::class);
            $user = $stmt->fetch();
            if ($user && password_verify($password, $user->getPassword())) {
                return $user;
            }
            return null;
        } catch (PDOException $e) {
            echo "Error verifying user: " . $e->getMessage();
        }
    }

    public function addUser($username, $email, $password, $profilePicture = null, $bio = null)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO Users (Username, Email, Password, ProfilePicture, Bio) VALUES (:username, :email, :password, :profilePicture, :bio)";
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':profilePicture', $profilePicture);
            $stmt->bindParam(':bio', $bio);

            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error adding user: " . $e->getMessage();
        }
    }

    public function editUser($username, $email, $bio = null, $profilePicture = null)
    {
        try {
            $params = [
                ':email' => $email,
                ':bio' => $bio,
                ':username' => $username
            ];
            $sql = "UPDATE Users SET Email = :email, Bio = :bio";
            if ($profilePicture !== null) {
                $sql .= ", ProfilePicture = :profilePicture";
                $params[':profilePicture'] = $profilePicture;
            }
            $sql .= " WHERE Username = :username";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);

            if ($stmt->rowCount() > 0) {
                return true;
            }

            return false;
        } catch (PDOException $e) {
            echo "Error updating user: " . $e->getMessage();
            return false;
        }
    }


    public function deleteUser($username)
    {
        $sql = "DELETE FROM Users WHERE Username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
    }

    public function getUserByUsername($username)
    {
        try {
            $sql = "SELECT * FROM Users WHERE Username = :username";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, \model\user::class);

            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Error fetching user: " . $e->getMessage();
        }
    }

    public function getUserIDByUsername($username)
    {
        try {
            $sql = "SELECT UserID FROM Users WHERE Username = :username LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, \model\user::class);

            return ($result = $stmt->fetch()) ? $result->UserID : null;
        } catch (PDOException $e) {
            echo "Error fetching user ID: " . $e->getMessage();
            return null;
        }
    }


    public function getAllUsers()
    {
        $sql = "SELECT * FROM Users";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, \model\user::class);
        return $stmt->fetchAll();
    }


}



