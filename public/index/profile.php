<?php $sidebar = false; ?>

<?php include("../templates/header.php"); ?>

<main class="profileMain">
    <div class="profile">
        <div class="profileInfo">
            <?php
            include("../../conn.php");

            if (isset($_GET['user'])) {
                $profileUser = $_GET['user'];
                echo "<h1>" . htmlspecialchars($profileUser) . "'s profile</h1>";
            } else {
                $stmt = $conn->prepare("SELECT user_name FROM users WHERE user_id = ?");
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                $profileUser = $row['user_name'] ?? null;
                echo "<h1>Your profile</h1>";
            }
            ?>
        </div>
        <div class="profileActions">
        </div>
        <div class="postDivider"></div>
        <div class="profileView">
            <?php
            if ($profileUser) {

                $query = "SELECT posts.*, users.user_name, post_images.image_url
                        FROM posts
                        JOIN users ON posts.user_id = users.user_id
                        LEFT JOIN post_images ON post_images.post_id = posts.post_id
                        WHERE users.user_name = ?
                        ORDER BY posts.created_at DESC";

                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $profileUser);
                $stmt->execute();

                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        if($row['user_name'] === $profileUser) {

                            $title = htmlspecialchars($row['post_title'], ENT_QUOTES);
                            $content = htmlspecialchars($row['post_content'], ENT_QUOTES);
                            $user = htmlspecialchars($row['user_name']);
                            $postId = $row['post_id'];
                            $image = $row['image_url'];
                            $postType = $row['post_type'];
                            ?>

                            <div class="post" onclick='openPost(<?= json_encode($user) ?>, <?= json_encode($title) ?>, <?= json_encode($content) ?>, <?= json_encode($image) ?>, <?= json_encode($postId) ?>, <?= json_encode($postType) ?>)'>
                                <div class="postHeader">
                                    <a href="../index/profile.php?user=<?php echo urlencode($row['user_name']); ?>">
                                    @<?php echo $user; ?>
                                    </a>
                                </div>
                                <div class="postTitle">
                                    <h5><?php echo $title; ?></h5>
                                </div>
                                <div class="postContent">
                                    <p><?php echo $content; ?></p>
                                </div>

                                <?php
                                $imgQuery = $conn->prepare("SELECT image_url FROM post_images WHERE post_id = ?");
                                $imgQuery->bind_param("i", $postId);
                                $imgQuery->execute();
                                $imgResult = $imgQuery->get_result();

                                if($imgResult->num_rows > 0) {
                                    echo '<div class="postImages">';
                                    $first = true;
                                    while($imgRow = $imgResult->fetch_assoc()) {
                                        $imgUrl = htmlspecialchars($imgRow['image_url']);
                                        if($first) {
                                            echo "<div class='imageWrapper'>
                                                    <img class='bgImage' src='$imgUrl'>
                                                    <img class='mainImage' src='$imgUrl'>
                                                </div>";
                                            $first = false;
                                        }
                                    }
                                echo '</div>';
                                }
                                $imgQuery->close();
                                ?>

                                <div class="postActions">
                                        <div class="actionBtn"><i class="iconoir-thumbs-up"></i>Like</div>
                                        <p><?php echo $row['post_rating']; ?></p>
                                        <div class="actionBtn"><i class="iconoir-thumbs-down"></i>Dislike</div>
                                        <div class="actionBtn"><i class="iconoir-send-diagonal"></i>Share</div>
                                </div>
                            </div>

                            <div class="postDivider"></div>
                            <?php
                        }
                    }

                } else {
                    echo "<p>No posts to display</p>";
                }

            } else {
                echo "Connection error";
            }
            ?>

        </div>
    </div>
</main>

<script> //ska sätta in i gemensam fil
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

                        <input type="hidden" name="return_url" value="${window.location.href}">

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

function loadComments(postId) {
    const container = document.getElementById("commentsList");

    fetch('get-comments.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'post_id=' + postId
    })
    .then(response => response.text())
    .then(data => {
        container.innerHTML = data;
    })
    .catch(err => {
        container.innerHTML = "Error";
    });
}

function closeModal(event) {
    const stateString = location.pathname;
    window.history.pushState("object or string", "Title", stateString);
    document.getElementById("postModal").style.display = "none";
    document.body.style.overflow = "visible";
}

</script>

<?php include("../templates/footer.php"); ?>