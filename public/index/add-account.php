<?php include("../templates/header.php"); ?>
<main id="create-account">
    <div class="account-square">
        <form method="post" action="post-add-account.php">
            <h2>Welcome to 𝕍</h2>
            <p>Fill in to create your account</p>
            <input type="text" name="username" placeholder="Username">
            <input type="text" name="password" placeholder="password">

            <input class="btn btn-primary" type="submit" name="Create account">
        </form>
    </div>
</main>
<?php include("../templates/footer.php"); ?>