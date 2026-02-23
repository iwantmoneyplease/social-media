<?php include("../templates/header.php"); ?>
<main id="install">
    <?php 
    if(isset($_POST["install"])){
        require_once("../../installscript.php");
    }
    ?>
</main>

<?php include("../templates/footer.php"); ?>

