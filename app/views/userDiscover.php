<?php
include __DIR__ . '/general_views/header.php';
?>
<style>
    .tag {
        background-color: #e0e0e0;
        color: black;
        padding: 2px 8px;
        margin-right: 5px;
        border-radius: 5px;
        font-size: 0.9em;
    }

    .comment {
        margin-top: 10px;
        padding: 5px;
        border-top: 1px solid #ddd;
    }
    .toggle-comments-btn {
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        margin: 10px 0;
        border: none;
        cursor: pointer;
    }

    .toggle-comments-btn:hover {
        background-color: #45a049;
    }
</style>

<div class="container mt-4">
    <div class="p-4 rounded">
        <h1 class="mb-3">Search for posts</h1>
        <h3 class="mb-4">Enter a tag</h3>
        <p>Possible tags to search for: </p>
        <ol><li>Photography</li>
            <li>Classical Art</li>
            <li>Quick Sketch</li>
            <li>From Life</li>
            <li>Study</li></ol>
        <form>
            <div class="mb-3">
                <label for="searchTags" class="form-label">Tags</label>
                <input type="text" class="form-control" id="searchTags" placeholder="Enter tags">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <div class="posts-grid mt-4">

    </div>
</div>

<script src="js/general.js"></script>
<script src="js/loadSearchResult.js"></script>
<script src="js/loadLatestRatings.js"></script>
<script src="js/loadLatestComments.js"></script>


<?php
include __DIR__ . '/general_views/footer.php';
?>
