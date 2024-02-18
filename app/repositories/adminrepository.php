<?php

namespace repositories;

use PDO;
use PDOException;
use config\dbconfig;
use model\admin;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/admin.php';

class adminrepository
{
    private $db;

    public function __construct(PDO $dbConnection)
    {
        $this->db = $dbConnection;
    }

    public function verifyAdmin($username, $password)
    {
        try {
            $sql = "SELECT * FROM Admin WHERE AdminUsername = :username";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, admin::class);
            $admin = $stmt->fetch();

            if ($admin && password_verify($password, $admin->AdminPassword)) {
                return $admin;
            }
            return null;
        } catch (PDOException $e) {
            echo "Error verifying admin: " . $e->getMessage();
            return null;
        }
    }

    public function addAdmin($username, $password, $adminRole, $adminEmail)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO Admin (AdminUsername, AdminPassword, AdminRole, AdminEmail) VALUES (:AdminUsername, :AdminPassword, :AdminRole, :AdminEmail)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':AdminUsername', $username);
            $stmt->bindParam(':AdminPassword', $hashedPassword);
            $stmt->bindParam(':AdminRole', $adminRole);
            $stmt->bindParam(':AdminEmail', $adminEmail);

            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error adding user: " . $e->getMessage();
        }
    }

}