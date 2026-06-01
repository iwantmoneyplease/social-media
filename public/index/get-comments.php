<?php
require("../../conn.php");

if (isset($_POST['post_id'])) {
    $post_id = intval($_POST['post_id']);

    $query = "SELECT comments.*, users.user_name 
              FROM comments 
              JOIN users ON comments.user_id = users.user_id 
              WHERE comments.post_id = ? 
              ORDER BY comments.created_at DESC";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="comment-item">';
            echo '<strong>' . htmlspecialchars($row['user_name']) . ':</strong>';
            echo '<p>' . htmlspecialchars($row['comment_content']) . '</p>';
            echo '</div>';
        }
    } else {
        echo "<p>No comments yet. Start the conversation!</p>";
    }
    $stmt->close();
    $conn->close();
}
?>