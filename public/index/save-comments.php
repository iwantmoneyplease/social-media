<?php
require("../../conn.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_content'])) {
    $post_id = intval($_POST['post_id']);
    $content = trim($_POST['comment_content']);
    $user_id = $_SESSION['user_id'];

    if (empty($user_id)) {
        header("Location: login.php");
        exit();
    }
    else {
        if (!empty($content)) {
            $stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, comment_content) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $post_id, $user_id, $content);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Redirect back to the main page
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>