<?php

namespace services;

use repositories\adminrepository;
use PDO;
use model\admin;

require_once __DIR__ . '/../model/admin.php';
require_once __DIR__ . '/../repositories/adminrepository.php';

class adminServices
{
    private $adminRepository;

    public function __construct(PDO $dbConnection)
    {
        $this->adminRepository = new adminrepository($dbConnection);
    }

    public function authenticateAdmin($username, $password)
    {
        $admin = $this->adminRepository->verifyAdmin($username, $password);
        if ($admin) {
            return $admin;
        }
        return null;
    }

    public function registerAdmin(Admin $admin)
    {
        $this->adminRepository->addAdmin(
            $admin->getAdminUsername(),
            $admin->getAdminPassword(),
            $admin->getAdminRole(),
            $admin->getAdminEmail()
        );
    }
}


