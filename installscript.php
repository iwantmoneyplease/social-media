<?php
    $conn = mysqli_connect($_POST["host"], $_POST["dbuser"], $_POST["dbpass"]);
    if(!$conn) {
        displayMsg("error", "Wrong passowrd for database");
        exit();
    } else {

        $sql = "CREATE DATABASE IF NOT EXISTS " . $_POST["dbname"];
        try {
            $conn->query($sql);
            displayMsg("success", "Database created successfully");
        } catch(mysqli_sql_exception $e){
            displayMsg("error", "Database already exists");
        }

    }
    $conn->close();
    $conn = mysqli_connect($_POST["host"], $_POST["dbuser"], $_POST["dbpass"], $_POST["dbname"]);
    if(!$conn) {
        displayMsg("error", "Wrong passowrd for database");
        exit();
    } else {
        displayMsg("success", "MAKE TABLES!!!");

        include_once("../../prefabs/maketable.php");

        //dummy data
        $conn->query("INSERT IGNORE INTO users (user_id, user_name) VALUES
        (1, 'leo'),
        (2, 'viktor'),
        (3, 'jason')");
        $conn->query("INSERT INTO posts (upload_url, user_id, post_rating, post_title, post_content) VALUES
        ('', 2, 5, 'Cool picture', 'Lorem ipsum...'),
        ('', 1, 2, 'My rant about ARKit', 'Lorem ipsum...'),
        ('', 3, 7, 'Check this video out', 'Lorem ipsum...')");
        $conn->query("INSERT INTO comments (comment_content, user_id, post_id) VALUES
        ('Nice post!', 2, 1),
        ('AWFUL. DISLIKE.', 3, 1),
        ('Cool video!', 1, 2)");

        makeEnv();
    }
    $conn->close();
?>