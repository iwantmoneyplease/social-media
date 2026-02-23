<?php
    $sql = "CREATE TABLE IF NOT EXISTS users (
        user_id INT AUTO_INCREMENT PRIMARY KEY,
        user_name VARCHAR(20) NOT NULL UNIQUE
    )";
    makeTable($conn, $sql, "users");

    $sql = "CREATE TABLE IF NOT EXISTS posts (
        post_id INT AUTO_INCREMENT PRIMARY KEY,
        upload_url VARCHAR(255),
        user_id INT NOT NULL,
        post_rating INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

        FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE CASCADE
    )";
    makeTable($conn, $sql, "posts");

    $sql = "CREATE TABLE IF NOT EXISTS comments (
        comment_id INT AUTO_INCREMENT PRIMARY KEY,
        comment_content VARCHAR(400),
        user_id INT NOT NULL,
        post_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

        FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE CASCADE,

        FOREIGN KEY (post_id) REFERENCES posts(post_id)
        ON DELETE CASCADE
    )";
    makeTable($conn, $sql, "comments");
?>