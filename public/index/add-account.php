<?php include("../templates/header.php"); ?>
<main id="create-account">
    <div class="accountSquare">
        <form method="post" action="post-add-account.php">
            <h2>Welcome to 𝕍</h2>

            <?php if (isset($_GET['error']) && $_GET['error'] === 'usernametaken'): ?>
                <p style="color: red;">Username taken</p>
            <?php else: ?>
                <p>Fill in to create your account</p>
            <?php endif; ?>

            <input type="text" name="username" placeholder="Username">
            <input type="text" name="password" placeholder="password">

            <input class="btn btn-primary" type="submit" name="Create account">
        </form>
    </div>
</main>
<?php include("../templates/footer.php"); ?>