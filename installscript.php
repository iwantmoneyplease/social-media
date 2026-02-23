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
        $conn->query("INSERT INTO disease (name, info) VALUES ('viktorosis', 'deadly disease with readily ease')");
        
        makeEnv();
    }
    $conn->close();

    function makeTabel($conn, $sql, $name) {
        try {
            $conn->query($sql);
            displayMsg("success", "Tabel " . $name . " created successfully");
        } catch(mysqli_sql_exception $e){
            displayMsg("error",  $name . " already exists");
        }
    }

    function makeEnv(){
        $env = [
            'DB_HOST' => $_POST["host"],
            'DB_PORT' => '3306',
            'DB_DATABASE' => $_POST["dbname"],
            'DB_USER' => $_POST["dbuser"],
            'DB_PASSWORD' => $_POST["dbpass"],
        ];
        $content = "";
        foreach ($env as $key => $value) {
            $content .= "{$key}={$value}\n";
        }

        $file = __DIR__ . '/.env';
        if (file_put_contents($file, $content)) {
            displayMsg("success", "All done");
        } else {
            echo "Något knas";
        }

        echo '<a href="/index/index.php"">Gå till index</a>';
    }
?>

