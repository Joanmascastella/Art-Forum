document.addEventListener('DOMContentLoaded', function () {
    fetchLatestPosts();
    setInterval(fetchLatestPosts, 5000);
});

var lastPostId = document.querySelector('#postsContainer > div')?.dataset.postId || '0';
var isFetchingPosts = false;

function fetchLatestPosts() {
    if (isFetchingPosts) return;
    isFetchingPosts = true;

    fetch(`api/fetchLatestPosts.php?lastPostId=${lastPostId}`)
        .then(response => response.json())
        .then(posts => {
            if (posts.length) {
                lastPostId = posts[0].PostID;

                posts.forEach(post => {
                    document.getElementById('postsContainer').insertAdjacentHTML('beforeend', createPostHtml(post));
                });

                addCommentToggleListeners();
                clickLikeButtonListener();
            }
            isFetchingPosts = false;
        })
        .catch(error => {
            console.error("An error occurred fetching posts: ", error);
            isFetchingPosts = false;
        });
}

function createPostHtml(post) {
    return `
        <div class="card mb-4" style="width: 100%; max-width: 28rem;" data-post-id="${post.PostID}">
            ${createPostImageHtml(post.Picture)}
            <div class="card-body">
                ${createPostDetailsHtml(post)}
                ${likePost(post)}
                <div class="comments-section">
                    ${createCommentsSectionHtml(post)}
                </div>
                ${createPostCommentFormHtml(post)}
            </div>
        </div>`;
}

function createPostImageHtml(picture) {
    return `<img src="${picture}" class="card-img-top" alt="Post Image">`;
}

function createPostDetailsHtml(post) {
    const tagsHtml = post.Tags.map(tag => `<span class="tag text-black">${tag}</span>`).join(' ');
    return `
        <h5 class="card-title">${post.Title}</h5>
        <p class="card-text">${post.Description}</p>
        <p class="card-text"><small class="text-muted">${post.Username} posted on ${post.PostDate}</small></p>
        <p class="card-tags">Tags: ${tagsHtml}</p>`;
}

function likePost(post) {
    return `
        <form id="likeForm-${post.PostID}" data-post-id="${post.PostID}" data-user-id="${sessionUSERID}" onsubmit="toggleLike(${post.PostID}, ${sessionUSERID}); return false;" class="like-form">
            <button type="submit" class="like-btn">Like</button>
            <span id="likeCount-${post.PostID}">${post.TotalLikes || 0}</span>
        </form>`;
}

function createCommentsSectionHtml(post) {
    const commentsHtml = post.Comments?.map(createCommentHtml).join('') || '';
    return `
        <button class="toggle-comments-btn">Show/Hide Comments</button>
        <div class="comments" style="display: none;">${commentsHtml}</div>`;
}

function createCommentHtml(comment) {
    return `
        <div class="comment">
            <p><strong>${comment.Username || 'Anonymous'}</strong> (${formatDate(comment.CommentDate)}):</p>
            <p>${comment.CommentText || ''}</p>
        </div>`;
}

function createPostCommentFormHtml(post) {
    return `
        <form id="writeCommentForm-${post.PostID}" onsubmit="submitComment(event, ${post.PostID}); return false;" class="card-body">
            <input type="hidden" name="postID" value="${post.PostID}">
            <input type="hidden" name="userID" value="${sessionUSERID}">
            <textarea name="commentText" required maxlength="500"></textarea>
            <button type="submit">Post Comment</button>
        </form>`;
}

function formatDate(dateString) {
    return new Date(dateString).toISOString().split('T')[0];
}
