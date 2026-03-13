<?php include("../templates/header.php"); ?>

<!--sidebar (left)-->
<div class="sidebar animate-left displayBlock" id="dirSidebar">
  <button class="closeSidebarBtn barButton"
  onclick="closeSidebar()">Close &times;</button>
  <a href="#" class="barItem barButton">Link 1</a>
  <a href="#" class="barItem barButton">Link 2</a>
  <a href="#" class="barItem barButton">Link 3</a>
</div>

<!--infobar (right)-->
<div class="infobar" id="dirInfobar">
  <div class="infoSquare">
    <p>hej</p>
  </div>
  <div class="footerSub">
    <span>
      <a href="#">test</a>
      <a href="#">test</a>
      <a href="#">test</a>
    </span>
    <span>
      <a href="#">test</a>
      <a href="#">test</a>
      <a href="#">test</a>
      <a href="#">test</a>
    </span>
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
  const sidebar = document.getElementById("dirSidebar");
  const main = document.getElementById("main");

  sidebar.classList.remove("sidebarClosed");
  sidebar.classList.add("sidebarOpen");

  main.style.marginLeft = "22vw";

  document.getElementById("openNav").style.display = 'none';
}

function closeSidebar() {
  const sidebar = document.getElementById("dirSidebar");
  const main = document.getElementById("main");

  // Swap the classes
  sidebar.classList.remove("sidebarOpen");
  sidebar.classList.add("sidebarClosed");

  // Reset the main content margin so it centers or fills the space
  main.style.marginLeft = "auto";

  // Show the button that allows users to re-open the sidebar
  document.getElementById("openNav").style.display = "inline-block";
}
</script>