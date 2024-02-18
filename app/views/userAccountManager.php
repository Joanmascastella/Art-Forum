<?php
include __DIR__ . '/general_views/header.php';
?>

<div class="container d-flex flex-column justify-content-center align-items-center text-center p-3 text-white">
    <h1 style="color: white">Manage Account</h1>
    <br>
    <div class="row" style="border-radius: 5px; width: 700px; padding: 20px; background-color: #000000;">
        <div class="col-md-7">
            <h3>Profile Image</h3>
            <br>
            <img src="<?php echo $userData->ProfilePicture ? str_replace($_SERVER['DOCUMENT_ROOT'], '', htmlspecialchars($userData->ProfilePicture)) : '../img/default_profile_image.png'; ?>" class="rounded-circle" alt="Profile Image" width="250" height="250" style="border: 3px solid rgb(255,255,255);">
        </div>
        <div class="col-md-4">
            <div class="row mb-3">
                <div class="col">
                    <h3>Username</h3>
                    <p style="font-size:20px;"><?php echo ucfirst(htmlspecialchars($userData->Username)); ?></p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <h3>Email</h3>
                    <p style="font-size:20px;"><?php echo htmlspecialchars($userData->Email); ?></p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <h3>Bio</h3>
                    <p style="font-size:20px;"><?php echo $userData->Bio ? htmlspecialchars($userData->Bio) : 'No bio available'; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row d-flex flex-column justify-content-center align-items-center text-center p-3 text-white" style="border-radius: 5px; width: 700px; padding: 20px; background-color: #000000;">
        <div class="col-auto">
            <form action="/userAccountDeleteAction" method="post" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                <button type="submit" class="btn btn-danger">Delete Account</button>
                <a href="/edit-account-view" class="btn btn-dark">Edit Details</a>
            </form>
        </div>
    </div>
</div>
<br><br>

<?php
include __DIR__ . '/general_views/footer.php';
?>
