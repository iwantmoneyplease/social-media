<?php include("../templates/header.php"); ?>
<main id="createpost">
    <form method="post" action="post-add-account.php">
        <p>Fill in to create your post</p>
        <input type="text" name="post_title" placeholder="Title">
        <p>Type of post</p>
        <select name="post_type" id="post_type">
            <option value="text">Text</option>
            <option value="image">Image</option>
            <option value="video">Video</option>
        </select>
        <textarea type="text" name="post_content" placeholder="Write your thoughts..."></textarea>

        <input class="btn btn-primary" type="submit" name="Create account">
    </form>
</main>
<?php include("../templates/footer.php"); ?>