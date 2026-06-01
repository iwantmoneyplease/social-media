<?php $sidebar = false; ?>

<?php include("../templates/header.php"); ?>

<div id="main">

<div class="dashboard">

</div>

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
</div>

<?php include("../templates/footer.php"); ?>