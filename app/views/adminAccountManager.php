<?php
include __DIR__ . '/general_views/header.php';
?>

<div class="container my-4">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-auto">
            <h1 class="text-white">Manage Art Forum Accounts</h1>
        </div>
        <div class="col-auto">
            <form action="/downloadUserDataAction" method="post"
                  onsubmit="return confirm('Are you sure you want to download all this data?');">
                <button type="submit" class="btn btn-light">Download User Data</button>
            </form>
        </div>
    </div>
    <br>
    <?php foreach ($allUsers as $user) { ?>
        <div class="row align-items-center text-center mb-2">
            <div class="col-3"><p>ID: <?php echo htmlspecialchars($user->getUserID()); ?></p></div>
            <div class="col-3"><p>User: <?php echo htmlspecialchars($user->getUsername()); ?></p></div>
            <div class="col-3"><p>Email: <?php echo htmlspecialchars($user->getEmail()); ?></p></div>
            <div class="col-3">
                <form action="/adminDeleteUserAction" method="post"
                      onsubmit="return confirm('Are you sure you want to delete this account? This action cannot be undone.');">
                    <input type="hidden" name="userToDelete" value="<?php echo htmlspecialchars($user->getUsername()); ?>">
                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </form>
            </div>
        </div>
    <?php } ?>
</div>

<br>
<br>

<?php
include __DIR__ . '/general_views/footer.php';
?>
