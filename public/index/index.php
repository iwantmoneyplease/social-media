<?php include("../templates/header.php"); ?>

<!--sidebar (left)-->
<div class="sidebar animate-left displayBlock" id="dirSidebar">
  <button class="closeSidebarBtn barButton"
  onclick="closeSidebar()">Close &times;</button>
  <a href="#" class="barItem barButton">Link 1</a>
  <a href="#" class="barItem barButton">Link 2</a>
  <a href="#" class="barItem barButton">Link 3</a>
</div>

<!--infobar (right)-->
<div class="infobar" id="dirInfobar">
  <div class="infoSquare">
    <div class="mediaGrid">
    </div>
    <div class="infoTxt"></div>
  </div>
  <div class="footerSub links">
    <span>
      <a href="../index.php">Homepage</a>
      <a href="../index/add-post.php">Create post</a>
      <a href="../index/add-account.php">Create account</a>
    </span>
    <span>
      <a href="../dash/admin.php">Admin</a>
      <a href="#">Privacy notice</a>
      <a href="#">Terms of Service</a>
      <a href="#">Sitemap</a>
    </span>
  </div>
</div>

<!--center of page-->
<div id="main">
    <button id="openNav" class="openSidebarBtn" onclick="openSidebar()">&#9776;</button>
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
        ?>

        <div class="post" onclick="openPost('<?php echo $user; ?>','<?php echo $title; ?>', '<?php echo $content; ?>', '<?php echo $image; ?>')">
            <div class="postHeader">
                <p><?php echo $user; ?></p>
            </div>
            <div class="postTitle">
                <h5><?php echo $row['post_title']; ?></h5>
            </div>
            <div class="postContent">
                <p><?php echo $row['post_content']; ?></p>
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
                <span>
                    <button>test</button>
                    <button>test</button>
                    <p>Rating: <?php echo $row['post_rating']; ?></p>
                </span>
            </div>
        </div>
        <?php
    }

} else {
    echo "<p>sorry we outta posts</p>";
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

function openPost(user, title, content, image) {
    const modal = document.getElementById("postModal");
    const modalBody = document.getElementById("modalBody");
    modalBody.innerHTML = `
        <div class="modal-layout">
            <div class="modal-user">
                <p>${user}</p>
            </div>
            <div class="modal-main">
                <h1>${title}</h1>
                <p>${content}</p>
                <div class='imageWrapper'>
                    <img class="modal-image" src='${image}'>
                </div>
            </div>
            <div class="modal-actions">
            <div class="modal-comments">
                <form method="post">
                    <input type="text" name="comment_content" placeholder="Write your thoughts...">

                    <input class="btn btn-primary" type="submit" name="Send">
                </form>
                <h6>Comments</h6>
                <p style="color: gray; font-size: 12px;">Comments coming soon...</p>
            </div>
        </div>
    `;
    modal.style.display = "flex";
    document.body.style.overflow = "hidden";
}

function closeModal(event) {
    document.getElementById("postModal").style.display = "none";
    document.body.style.overflow = "visible";
}
</script>