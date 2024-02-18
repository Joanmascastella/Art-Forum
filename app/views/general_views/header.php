<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : "Art Forum"; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/headerstyling.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <link rel="apple-touch-icon" sizes="180x180" href="../../img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../img/favicon/favicon-16x16.png">
    <link rel="manifest" href="../../img/favicon/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

</head>
<body>
<nav class="navbar navbar-expand-lg bg-light-subtle">
    <div class="container">
        <a class="navbar-brand ">
            <img src="../../img/logo.gif" alt="logo" class="logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item text-white">
                <?php
                if (isset($_SESSION['role'])) {
                    $role = $_SESSION['role'];

                    if ($role == 'admin') {
                        echo '<a href="/initialAdminView" class="nav-link text-white ">Home</a></li>';
                    } elseif ($role == 'user') {
                        echo '   <a href="/initialUserView" class="nav-link text-white ">Home</a></li>';
                    }
                }
                ?>
                <li class="nav-item">
                    <?php
                    if (isset($_SESSION['role'])) {
                        $role = $_SESSION['role'];

                        if ($role == 'admin') {
                            echo '';
                        } elseif ($role == 'user') {
                            echo '<a href="/discover" class="nav-link text-white">Discover</a>';
                        }
                    }
                    ?>
                    </li>
                <li class="nav-item ">
                    <?php
                    if (isset($_SESSION['role'])) {
                        $role = $_SESSION['role'];

                        if ($role == 'admin') {
                            echo '<a href="/admin-page" class="nav-link nav-link-accountImage text-white">Admin Dashboard</a>';
                        } elseif ($role == 'user') {
                            echo '<a href="/account-manager" class="nav-link nav-link-accountImage"><img src="../../img/account-25.png"
                                                                                    alt="Plus"></a>';
                        }
                    }
                    ?>
                </li>
                <li class="nav-item"><?php
                    if (isset($_SESSION['role'])) {
                        $role = $_SESSION['role'];

                        if ($role == 'admin') {
                            echo '';
                        } elseif ($role == 'user') {
                            echo '<a href="/new-post" class="nav-link nav-link-plus"><img src="../../img/thumbnail_Image.png"
                                                                                    alt="Plus"></a>';
                        }
                    }
                    ?></li>
                <li class="nav-item"><a href="/logout.php" class="nav-link text-white">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<br>

