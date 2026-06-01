<?php
require("../../conn.php");
session_start();

if (isset($_GET['comment_content']) && isset($_GET['post_id'])) {

    $post_id = intval($_GET['post_id']);
    $content = trim($_GET['comment_content']);
    $user_id = $_SESSION['user_id'];

    if (!empty($user_id) && !empty($content)) {

        $stmt = $conn->prepare(
            "INSERT INTO comments (post_id, user_id, comment_content) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("iis", $post_id, $user_id, $content);
        $stmt->execute();
        $stmt->close();
    }
}

//checks if return_url is received from the form
if (!empty($_GET['return_url'])) {
    header("Location: " . $_GET['return_url'] . "&open=1");
} else {
    header("Location: " . $_SERVER['HTTP_REFERER']);
}
exit();
?>