<?php
include __DIR__ . '/general_views/header.php';
?>

<div class="container d-flex flex-column justify-content-center align-items-center text-center p-3"
     style="max-width: 500px; margin: auto;">
    <h1>Edit Account</h1>
    <br>
    <form action="/editAccountAction" method="post" enctype="multipart/form-data"
          style="border: 1px solid #595959; padding: 20px; border-radius: 5px; background-color: #000000;">
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="username" style="color: white">Username</label>
            <input type="text" class="form-control" id="username" name="username"
                   value="<?php echo htmlspecialchars($userData->Username); ?>"
                   style="border: 1px solid #595959; padding: .375rem .75rem;">
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="email" style="color: white">Email</label>
            <input type="email" class="form-control" id="email" name="email"
                   value="<?php echo htmlspecialchars($userData->Email); ?>"
                   style="border: 1px solid #595959; padding: .375rem .75rem;">
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="bio" style="color: white">Bio</label>
            <textarea class="form-control" id="bio" name="bio" maxlength="250"
                      style="height: 200px; border: 1px solid #595959; padding: .375rem .75rem;"><?php echo $userData->Bio ? htmlspecialchars($userData->Bio) : 'No bio available'; ?></textarea>
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="profilePicture" style="color: white">Profile Picture</label>
            <input type="file" class="form-control-file" id="profilePicture" name="profilePicture"
                   style="border: 1px solid #595959; padding: .375rem .75rem;">
        </div>
        <button type="submit" class="btn btn-danger" style="margin-right: 10px;">Confirm Changes</button>
        <a href="/account-manager" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<br>
<br>
<br>

<?php
include __DIR__ . '/general_views/footer.php';
?>
