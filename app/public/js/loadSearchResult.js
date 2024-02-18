document.addEventListener('DOMContentLoaded', function () {
    var searchForm = document.querySelector('form');
    searchForm.addEventListener('submit', handleSearch);
});

function handleSearch(event) {
    event.preventDefault();

    var searchTags = document.getElementById('searchTags').value.trim();
    var postsContainer = document.querySelector('.posts-grid');
    postsContainer.innerHTML = '';

    if (searchTags) {
        fetch(`api/searchPosts.php?tag=${encodeURIComponent(searchTags)}`)
            .then(response => response.json())
            .then(posts => {
                if (posts.length === 0) {
                    postsContainer.innerHTML = '<p class="text-center">No posts found for this tag.</p>';
                    return;
                }

                let rowHtml = '';
                posts.forEach((post, index) => {
                    if (index % 3 === 0) {
                        if (index !== 0) {
                            rowHtml += '</div>';
                            postsContainer.insertAdjacentHTML('beforeend', rowHtml);
                            rowHtml = '';
                        }
                        rowHtml += '<div class="row">';
                    }

                    rowHtml += `<div class="col-md-4">${createPostHtml(post)}</div>`;

                    if (index === posts.length - 1) {
                        rowHtml += '</div>';
                        postsContainer.insertAdjacentHTML('beforeend', rowHtml);
                    }
                });
                addCommentToggleListeners();
                clickLikeButtonListener();
            })
            .catch(error => {
                console.error("Error fetching posts: ", error);
                postsContainer.innerHTML = '<p class="text-center">An error occurred while searching. Please try again later.</p>';
            });
    } else {
        postsContainer.innerHTML = '<p class="text-center">Please enter a tag to search for posts.</p>';
    }
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
        <p class="card-text"><small class="text-muted">${post.Username} posted on ${formatDate(post.PostDate)}</small></p>
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
            <textarea name="commentText" required></textarea>
            <button type="submit">Post Comment</button>
        </form>`;
}

function formatDate(dateString) {
    return new Date(dateString).toISOString().split('T')[0];
}
