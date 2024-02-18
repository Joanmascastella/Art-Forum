<?php

use controller\usercontroller;
use controller\postController;

use routers\router;
use config\dbconfig;

session_start();

require_once __DIR__ . '/../controller/usercontroller.php';
require_once __DIR__ . '/../controller/postController.php';
require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../routers/router.php';

$dbConfig = new dbconfig();
$pdo = $dbConfig->connect();

$userController = new usercontroller();
$postController = new postController();

$router = new router();

$router->addRoute('/', [$userController, 'showLoginPage']);
$router->addRoute('/loginAction', [$userController, 'loginAction']);

$router->addRoute('/register', [$userController, 'showRegisterPage']);
$router->addRoute('/registerAction', [$userController, 'registerAction']);

$router->addRoute('/initialUserView', [$userController, 'showUserView']);
$router->addRoute('/initialAdminView', [$userController, 'showAdminView']);

$router->addRoute('/account-manager', [$userController, 'showUserAccountManagerPage']);
$router->addRoute('/userAccountDeleteAction', [$userController, 'userAccountDeleteAction']);

$router->addRoute('/edit-account-view', [$userController, 'showEditAccountPage']);
$router->addRoute('/editAccountAction', [$userController, 'editAccountAction']);

$router->addRoute('/admin-page', [$userController, 'showAdminAccountManager']);
$router->addRoute('/downloadUserDataAction', [$userController, 'downloadUserDataAction']);
$router->addRoute('/adminDeleteUserAction', [$userController, 'adminDeleteUserAction']);

$router->addRoute('/discover', [$postController, 'showDiscoverPage']);

$router->addRoute('/new-post', [$postController, 'showNewPostPage']);
$router->addRoute('/newPostAction', [$postController, 'newPostAction']);


$router->handleRequest();