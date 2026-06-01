<?php $sidebar = true; ?>

<?php include("../templates/header.php"); ?>

<?php
$postToOpen = $_GET['post'] ?? null;
?>

<!--sidebar (left)-->
<div class="sidebar animateLeft displayBlock" id="dirSidebar">
  <button class="closeSidebarBtn barButton"
  onclick="closeSidebar()">Close &times;</button>
  <a href="../index/profile.php" class="barItem barButton">Profile</a>
  <a href="#" class="barItem barButton">Link 2</a>
  <a href="#" class="barItem barButton">Link 3</a>
</div>

<!--infobar (right)-->
<div class="infobar" id="dirInfobar">
  <div class="infoSquare">
    <div class="infoTxt">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
  </div>
  <div class="footerSub links">
    <span>
      <a href="../index.php">Homepage</a>
      <a href="../index/add-post.php">Create post</a>
      <a href="../index/add-account.php">Create account</a>
    </span>
    <span>
      <a href="../index/profile.php">Profile</a>
      <a href="../dash/admin.php">Admin</a>
      <a href="../index/login.php">Log in</a>
      <a href="../../install/index.php">Install database</a>
    </span>
  </div>
</div>

<!--center of page-->
<div id="main">

<?php
$query = "SELECT posts.*, users.user_name, post_images.image_url
        FROM posts
        JOIN users ON posts.user_id = users.user_id
        LEFT JOIN post_images ON post_images.post_id = posts.post_id
        ORDER BY posts.created_at DESC";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

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

            if (!empty($image)) {
            $imgUrl = htmlspecialchars($image);

            echo "<div class='postImages'>
                <div class='imageWrapper'>
                    <img class='bgImage' src='$imgUrl'>
                    <img class='mainImage' src='$imgUrl'>
                </div>
                </div>";
            }
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

} else {
    echo "<p>No posts to display</p>";
}
?>
</div>

<!--scripts-->
<script>
const desktopMedia = window.matchMedia("(max-width: 1200px)");

function handleTabletChange(e) {
  if (e.matches) {
    closeSidebar();
  } else {
    openSidebar();
  }
}

desktopMedia.addEventListener("change", handleTabletChange);

handleTabletChange(desktopMedia);

function openSidebar() {
  const sidebar = document.getElementById("dirSidebar");
  const main = document.getElementById("main");

  sidebar.classList.remove("displayNone");
  sidebar.classList.add("displayBlock");

  main.classList.remove("mainNoSidebar");
  main.classList.add("mainSidebar");

  document.getElementById("openNav").style.display = 'none';
}

function closeSidebar() {
  const sidebar = document.getElementById("dirSidebar");
  const main = document.getElementById("main");

  sidebar.classList.remove("displayBlock");
  sidebar.classList.add("displayNone");

  main.classList.remove("mainSidebar");
  main.classList.add("mainNoSidebar");

  document.getElementById("openNav").style.display = "inline-block";
}

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

//eventlistener checks if you've loaded in
window.addEventListener('load', () => {
    const params = new URLSearchParams(window.location.search);
    //reads the existing paramaters in the url

    //if it has the post index it reads the other params
    if (params.has('pi')) {
        openPost(
            params.get('u'),
            params.get('t'),
            params.get('c'),
            params.get('i'),
            params.get('pi'),
            params.get('pt')
        );
    }
});

</script>

