<?php include("../templates/header.php"); ?>

<!--sidebar (left)-->
<div class="sidebar animate-left" id="dirSidebar">
  <button class="closeSidebarBtn barButton"
  onclick="closeSidebar()">Close &times;</button>
  <a href="#" class="barItem barButton">Link 1</a>
  <a href="#" class="barItem barButton">Link 2</a>
  <a href="#" class="barItem barButton">Link 3</a>
</div>

<!--infobar (right)-->
<div class="infobar" id="dirInfobar">
  <div>
    <p>hej</p>
  </div>
</div>

<!--center of page-->
<div id="main">
    <button id="openNav" class="openSidebarBtn" onclick="openSidebar()">&#9776;</button>

    <p>you're on the main page</p>

        <h4>dir</h4>
        <a href="../index.php">Main website</a>
        <a href="../index/add-post.php">Create post</a>
        <a href="../index/add-account.php">Create account</a>
</div>

<!--scripts-->
<script>
function openSidebar() {
  document.getElementById("main").style.marginLeft = "25%";
  document.getElementById("dirSidebar").style.width = "20%";
  document.getElementById("dirSidebar").style.display = "block";
  document.getElementById("openNav").style.display = 'none';
}
function closeSidebar() {
  document.getElementById("main").style.marginLeft = "20%";
  document.getElementById("dirSidebar").style.display = "none";
  document.getElementById("openNav").style.display = "inline-block";
}
</script>