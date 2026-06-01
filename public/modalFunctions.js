function openPost(user, title, content, image, postId, postType) {
    const modal = document.getElementById("postModal");
    const modalBody = document.getElementById("modalBody");
    console.log(location.host + location.pathname);
    const stateString = location.pathname + `?u=${user}&t=${title}&c=${content}&i=${image}&pi=${postId}&pt=${postType}`;
    window.history.pushState("object or string", "Title", stateString);

    const imageHTML = postType === 'image'
    ? `<div class="modalImageWrapper">
            <img class="modalBgImage" src='${image}'>
            <img class="modalMainImage" src='${image}'>
        </div>`
    : '';

    modalBody.innerHTML = `
        <div class="modalLayout">
            <div class="modalHeader">
                <a href="../index/profile.php?user=${encodeURIComponent(user)}">@${user}</a>
            </div>
            <div class="modalMain">
                <h1>${title}</h1>
                <p>${content}</p>
                ${imageHTML}
            </div>
            <div class="modalActions">
            <div class="modalComments">
                <div class="commentInputDiv">
                    <div class="actionBtn commentInputDivBtn"><i class="iconoir-thumbs-up"></i>Like</div>
                    <div class="actionBtn commentInputDivBtn"><i class="iconoir-thumbs-down"></i>Dislike</div>
                    <div class="actionBtn commentInputDivBtn"><i class="iconoir-send-diagonal"></i>Share</div>
                    <div class="actionBtn commentDropdownDivBtn">⋯</div>
                </div>
                
                <div class="modalDivider"></div>

                <div id="commentInputDiv" class="commentInputDiv">
                    <form method="get" action="save-comments.php" class="commentInputForm">
                        <input id="commentInputDivTxt" type="text" class="commentInputDivTxt" name="comment_content" placeholder="Write your thoughts..."></input>

                        <input type="hidden" name="return_url" value=""${encodeURIComponent(window.location.href)}">
                        
                        <input type="hidden" name="post_id" value="${postId}">

                        <input class="sendCommentBtn commentInputDivBtn" type="submit" value="Send">
                    </form>
                </div>

                <div class="commentDisplay">
                <h6>Comments</h6>
            
                <div id="commentsList" class="comment"></div>
                </div>
            </div>
        </div>
    `;
    modal.style.display = "flex";
    document.body.style.overflow = "hidden";

    loadComments(postId);
}

window.openPost = openPost;