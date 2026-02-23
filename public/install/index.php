<?php include("../templates/header.php"); ?>
<main id="install">
    <form method="post" action="post-install.php">
        <h2>Fill in form to install the blogg</h2>
        <p>Server info</p>
        <input type="text" name="host" placeholder="host">
        <input type="text" name="dbuser" placeholder="username">
        <input type="text" name="dbpass" placeholder="password">
        <input type="text" name="dbname" placeholder="database">
        <p>Admin creation</p>
        <input type="text" name="admin" placeholder="username">
        <input type="text" name="password" placeholder="password">
        <input class="btn btn-primary" type="submit" name="install">
    </form>
</main>

<?php include("../templates/footer.php"); ?>

