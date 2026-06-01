<?php
    $_ENV = parse_ini_file(__DIR__ . '/.env');
    $server = $_ENV["DB_HOST"];
    $user = $_ENV["DB_USER"];
    $pass = $_ENV["DB_PASSWORD"];
    $dbname = $_ENV["DB_DATABASE"];
    $conn = mysqli_connect($server, $user, $pass, $dbname);
    if(!$conn) {
        die("connection failer:" . mysqli_connect_error());
    }
?>