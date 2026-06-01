<?php include("../templates/header.php"); ?>
<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (user_name, user_password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashedPassword);

try {
    $stmt->execute();

    $_SESSION['user_id'] = $conn->insert_id;
    $_SESSION['user_name'] = $username;

    $stmt->close();

    header("Location: index.php");
    exit();
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() === 1062) {
        header("Location: add-account.php?error=usernametaken");
        exit();
    } else {
        throw $e;
    }
}

header("Location: index.php");
?>
<?php include("../templates/footer.php"); ?>