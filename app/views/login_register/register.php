<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="apple-touch-icon" sizes="180x180" href="../../img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../img/favicon/favicon-16x16.png">
    <link rel="manifest" href="../../img/favicon/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

</head>
<body class="bg-danger p-5 text-white ">
<div class="container ">
    <div class="d-flex flex-column justify-content-center align-items-center " style="min-height: 100vh;">
        <h1>Welcome to the Art Forum.</h1>
        <br>
        <h2>Please Register</h2>
        <br>
        <form method="post" action="/registerAction">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <div class="mb-3" id="adminKeyDiv">
                <label for="adminKey" class="form-label">Admin Key</label>
                <input type="password" class="form-control" name="adminKey" id="adminKey">
            </div>
            <button type="submit" class="btn btn-light">Register</button>
            <button type="button" class="btn btn-dark" onclick="location.href='/'">Login</button>
        </form>
        <br>
        <br>
        <?php if (!empty($registrationStatus)) : ?>
            <div class="alert alert-info">
                <?php echo $registrationStatus; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

