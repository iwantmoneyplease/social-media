<?php include("../templates/header.php"); ?>
<main id="create-post">
    <form method="post" action="post-add-post.php" enctype="multipart/form-data">
        <p>Fill in to create your post</p>
        <input type="text" name="post_title" placeholder="Title">
        <p>Type of post</p>
        <select name="post_type" id="post_type">
            <option value="text">Text</option>
            <option value="image">Image</option>
            <option value="video">Video</option>
        </select>
        <textarea type="text" name="post_content" placeholder="Write your thoughts..."></textarea>
        <input type="file" name="images[]" multiple>

        <input class="btn btn-primary" type="submit" name="Create">
    </form>
</main>
<?php include("../templates/footer.php"); ?>

<?php
require("../../conn.php");

if ($_POST) {
    $title = $_POST['post_title'];
    $content = $_POST['post_content'];
    $type = $_POST['post_type'];
    $user_id = 1;

    $stmt = $conn->prepare("INSERT INTO posts (user_id, post_title, post_content, post_type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $title, $content, $type);
    $stmt->execute();
    $post_id = $conn->insert_id;
    $stmt->close();

    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['name'] as $i => $name) {
            $tmpName = $_FILES['images']['tmp_name'][$i];
            $fileName = time() . "_$name";
            $targetDir = "../uploads/";
            $targetFile = $targetDir . $fileName;

            if (move_uploaded_file($tmpName, $targetFile)) {
                if ($i === 0) {
                    $thumbPath = createThumbnail($targetFile);

                    $stmtThumb = $conn->prepare("UPDATE posts SET upload_url = ? WHERE post_id = ?");
                    $stmtThumb->bind_param("si", $thumbPath, $post_id);
                    $stmtThumb->execute();
                    $stmtThumb->close();
                }

                $stmtImg = $conn->prepare("INSERT INTO post_images (post_id, image_url) VALUES (?, ?)");
                $stmtImg->bind_param("is", $post_id, $targetFile);
                $stmtImg->execute();
                $stmtImg->close();
            }
        }
    }

    $conn->close();
}
?>