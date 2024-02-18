<?php
include __DIR__ . '/general_views/header.php';
?>

<div class="container d-flex flex-column justify-content-center align-items-center text-center p-3">
    <h1>New Post</h1>
    <br>
    <form action="/newPostAction" method="post" enctype="multipart/form-data">
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="title" style="color: white">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="description" style="color: white">Description</label>
            <textarea class="form-control" id="description" name="description" style="height: 200px;" required></textarea>
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="picture" style="color: white">Picture</label>
            <input type="file" class="form-control-file" id="picture" name="picture" required>
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label style="color: white">Choose a tag:</label>
            <?php foreach ($postTags as $tag): ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="posttags[]" id="tag_<?php echo htmlspecialchars($tag->value); ?>" value="<?php echo htmlspecialchars($tag->value); ?>">
                    <label class="form-check-label" for="tag_<?php echo htmlspecialchars($tag->value); ?>"><?php echo htmlspecialchars($tag->value); ?></label>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="submit" class="btn btn-danger" style="margin-right: 10px;">Create Post</button>
        <a href="/initialUserView" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<br>
<br>
<br>
<br>

<?php
include __DIR__ . '/general_views/footer.php';
?>
