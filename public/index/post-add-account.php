<?php include("../templates/header.php"); ?>
<?php
$username = $_POST['username'];
$password = $_POST['password'];

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (user_name, user_password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashedPassword);
$stmt->execute();

echo "Account created successfully!";
?>
<?php include("../templates/footer.php"); ?>