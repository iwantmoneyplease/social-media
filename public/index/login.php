<?php include("../templates/header.php"); ?>
<main id="login-account">
    <div class="account-square">
        <form method="post" action="post-login.php">
            <h2>Welcome to 𝕍</h2>
            <p>Log in to join the conversation</p>
            <input type="text" name="username" placeholder="Username">
            <input type="text" name="password" placeholder="password">

            <input class="btn btn-primary" type="submit" name="Log in">
        </form>
    </div>
</main>
<?php include("../templates/footer.php"); ?>