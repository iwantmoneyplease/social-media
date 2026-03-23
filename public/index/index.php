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
    <p>hej</p>
  </div>
  <div class="footerSub">
    <span class="links">
      <a href="../index.php">Homepage</a>
      <a href="../index/add-post.php">Create post</a>
      <a href="../index/add-account.php">Create account</a>
    </span>
    <span>
      <a href="#">Privacy notice</a>
      <a href="#">Don't sell my data</a>
      <a href="#">Terms of Service</a>
    </span>
  </div>
</div>

<!--center of page-->
<div id="main">
    <button id="openNav" class="openSidebarBtn" onclick="openSidebar()">&#9776;</button>

    <?php
    // 1. The SQL Query: We join 'posts' and 'users' to get the username 
    // instead of just the user_id number.
    $query = "SELECT posts.*, users.user_name 
              FROM posts
              JOIN users ON posts.user_id = users.user_id 
              ORDER BY created_at DESC";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // 2. The Loop: This runs for every single row found in the database
        while($row = $result->fetch_assoc()) {

            // We escape the strings to prevent JavaScript errors in the onclick
            $title = htmlspecialchars($row['post_title'], ENT_QUOTES);
            $content = htmlspecialchars($row['post_content'], ENT_QUOTES);
            $user = htmlspecialchars($row['user_name']);
            ?>

            <div class="post" onclick="openPost('<?php echo $user; ?>','<?php echo $title; ?>', '<?php echo $content; ?>')">
                <div class="postHeader">
                    <p>@<?php echo $user; ?></p>
                </div>
                <div class="postTitle">
                    <h5><?php echo $row['post_title']; ?></h5>
                </div>
                <div class="postContent">
                    <p><?php echo $row['post_content']; ?></p>
                </div>
                <div class="postActions">
                    <span>Rating: <?php echo $row['post_rating']; ?></span>
                </div>
            </div>

            <?php
        }
    } else {
        echo "<p>No posts yet. Be the first to share!</p>";
    }
    ?>
</div>

<!--
<div id="main">
    <button id="openNav" class="openSidebarBtn" onclick="openSidebar()">&#9776;</button>

    <div class="post" onclick="openPost('Title of post', 'Lorem ipsum content here...')">
      <div class="postHeader">
        <p>user</p>
      </div>
      <div class="postTitle">
        <h5>Title of post</h5>
      </div>
      <div class="postContent">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      </div>
      <div class="postActions">
        <a href="../index.php">Main website</a>
        <a href="../index/add-post.php">Create post</a>
        <a href="../index/add-account.php">Create account</a>
      </div>
    </div>
    <div class="post">
      <div class="postHeader">
        <p>user</p>
      </div>
      <div class="postTitle">
        <h5>Title of post</h5>
      </div>
      <div class="postContent">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      </div>
      <div class="postActions">
        <a href="../index.php">Main website</a>
        <a href="../index/add-post.php">Create post</a>
        <a href="../index/add-account.php">Create account</a>
      </div>
    </div>
    <div class="post">
      <div class="postHeader">
        <p>user</p>
      </div>
      <div class="postTitle">
        <h5>Title of post</h5>
      </div>
      <div class="postContent">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      </div>
      <div class="postActions">
        <a href="../index.php">Main website</a>
        <a href="../index/add-post.php">Create post</a>
        <a href="../index/add-account.php">Create account</a>
      </div>
    </div>
    <p>hej</p>
</div>
-->

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

function openPost(user, title, content) {
    const modal = document.getElementById("postModal");
    const modalBody = document.getElementById("modalBody");
    // We use innerHTML to build the 'Instagram' style view
    modalBody.innerHTML = `
        <div class="modal-layout">
            <div class="modal-user">
                <p>${user}</p>
            </div>
            <div class="modal-main">
                <h1>${title}</h1>
                <p>${content}</p>
            </div>
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
    document.body.style.overflow = "hidden"; // Disable background scroll
}

function closeModal(event) {
    document.getElementById("postModal").style.display = "none";
}
</script>