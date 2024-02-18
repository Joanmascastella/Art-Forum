function submitComment(event, postID) {
    event.preventDefault();
    var form = event.target;
    var formData = new FormData(form);

    fetch('api/submitComment.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCommentsSection(postID);
                form.reset();
            } else {
                console.error('Error submitting comment: ', data.message);
            }
        })
        .catch(error => console.error('Error: ', error));
}

function updateCommentsSection(postID) {
    fetch(`api/getComments.php?postID=${postID}`)
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error('Error fetching comments:', data.message);
                return;
            }
            if (!Array.isArray(data.comments)) {
                console.error('Expected an array of comments, but received:', data.comments);
                return;
            }

            const commentsHtml = data.comments.map(createCommentHtml).join('');
            document.querySelector(`[data-post-id="${postID}"] .comments`).innerHTML = commentsHtml;
            addCommentToggleListeners();
        })
        .catch(error => console.error('Error fetching comments: ', error));
}

