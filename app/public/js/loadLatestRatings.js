function toggleLike(postId, userId) {
    if (window.toggleLikeInProgress) return;
    window.toggleLikeInProgress = true;

    fetch(`/api/fetchLatestRatings.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({postId: postId, userId: userId})
    })
        .then(response => response.json())
        .then(data => {
            window.toggleLikeInProgress = false;
            if (data.success) {
                const likeButton = document.querySelector(`#likeForm-${postId} .like-btn`);
                const likeCountElement = document.getElementById(`likeCount-${postId}`);
                updateLikeButton(likeButton, data.likeStatus);
                updateLikeCount(likeCountElement, data.totalLikes);
            } else {
                console.error('Error toggling like: ', data.error);
            }
        })
        .catch(error => {
            window.toggleLikeInProgress = false;
            console.error('Error: ', error);
        });
}
