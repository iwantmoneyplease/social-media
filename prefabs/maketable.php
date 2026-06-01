<?php
    $sql = "CREATE TABLE IF NOT EXISTS users (
        user_id INT AUTO_INCREMENT PRIMARY KEY,
        user_name VARCHAR(20) NOT NULL UNIQUE,
        user_password VARCHAR(255) NOT NULL
    )";
    makeTable($conn, $sql, "users");

    $sql = "CREATE TABLE IF NOT EXISTS posts (
        post_id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        post_title VARCHAR (30),
        post_content TEXT,
        post_rating INT,
        upload_url VARCHAR(255),
        post_type ENUM('text','image','video') NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

        FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE CASCADE
    )";
    makeTable($conn, $sql, "posts");

    $sql = "CREATE TABLE IF NOT EXISTS post_images (
    image_id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    FOREIGN KEY (post_id) REFERENCES posts(post_id)
    ON DELETE CASCADE
    )";
    makeTable($conn, $sql, "post_images");

    $sql = "CREATE TABLE IF NOT EXISTS comments (
        comment_id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        post_id INT NOT NULL,
        comment_content TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

        FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE CASCADE,

        FOREIGN KEY (post_id) REFERENCES posts(post_id)
        ON DELETE CASCADE
    )";
    makeTable($conn, $sql, "comments");
?>