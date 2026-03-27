<?php include($_SERVER["DOCUMENT_ROOT"] . "/../functions.php"); ?>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/../conn.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/style.css">
</head>

<div id="postModal" class="modal-overlay" onclick="closeModal(event)">
    <div class="modal-content" onclick="event.stopPropagation()">
        <span class="close-modal" onclick="closeModal(event)">&times;</span>
        <div id="modalBody">
        </div>
    </div>
</div>

<body>
    <header class="site-header">
        <div class="header-container">
        <div class="logo-symbol">
            <h1>𝕍</h1>
        </div>
        <div class="headerButtons links">
            <a href="../index/add-account.php" class="btn-create-account">Create account</a>
            <a href="../index/add-post.php" class="">Create post</a>
        </div>
    </div>
    </header>
