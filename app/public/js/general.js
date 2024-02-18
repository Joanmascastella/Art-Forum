function toggleComments(event) {
    var commentsContainer = event.target.nextElementSibling;
    commentsContainer.style.display = commentsContainer.style.display === 'none' ? 'block' : 'none';
}

function addCommentToggleListeners() {
    document.querySelectorAll('.toggle-comments-btn').forEach(button => {
        button.addEventListener('click', toggleComments);
    });
}

function updateLikeButton(likeButton, isLiked) {
    if (isLiked) {
        likeButton.textContent = 'Unlike';
        likeButton.classList.add('liked');
    } else {
        likeButton.textContent = 'Like';
        likeButton.classList.remove('liked');
    }
}

function updateLikeCount(likeCountElement, likeCount) {
    likeCountElement.textContent = likeCount;
}

function clickLikeButtonListener() {
    document.querySelectorAll('.like-form').forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            const postId = this.dataset.postId;
            const userId = this.dataset.userId;
            toggleLike(postId, userId);
        });
    });
}
