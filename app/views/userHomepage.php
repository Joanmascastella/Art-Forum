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

<div id="postsContainer" class="container d-flex flex-column align-items-center text-center p-3">
</div>

<script src="js/general.js"></script>
<script src="js/loadLatestRatings.js"></script>
<script src="js/loadLatestPosts.js"></script>
<script src="js/loadLatestComments.js"></script>


<?php
include __DIR__ . '/general_views/footer.php';
?>
