<?php include($_SERVER["DOCUMENT_ROOT"] . "/../functions.php"); ?>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/../conn.php"); ?>

<?php
session_start();

$username = $_SESSION['user_name'] ?? 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/style.css">
</head>

<div id="postModal" class="modalOverlay" onclick="closeModal(event)">
    <div class="modalContent" onclick="event.stopPropagation()">
        <span class="closeModal" onclick="closeModal(event)">&times;</span>
        <div id="modalBody" class="modalBody">
        </div>
    </div>
</div>

<body>
<header class="siteHeader">
    <div class="headerContainer">
        <div class="leftHeaderContainer">
            <?php if (!empty($sidebar)): ?>
                <div class="burgerMenuContainer">
                    <button id="openNav" class="openSidebarBtn" onclick="openSidebar()">&#9776;</button>
                </div>
            <?php endif; ?>
            <div class="logoSymbol">
                <a href="../index/index.php">
                    <h1>𝕍</h1>
                </a>
            </div>
            <div class="userDisplay">
                <a href="../index/profile.php">
                    <p>Hello, <?php echo $username; ?>!</p>
                </a>
            </div>
        </div>

        <div class="headerBtnContainer">
            <div for="dark-mode-toggle" class="darkmodeBtnContainer toggle">
                <input type="checkbox" id="dark-mode-toggle" />
                <label for="dark-mode-toggle">
                    <i class="iconoir-sun-light"></i>
                </label>
            </div>

            <div class="headerButtons links">
                <a href="../index/add-account.php" class="btnCreateAccount btn">Create account</a>
                <a href="../index/add-post.php" class="btn">Create post</a>
            </div>
        </div>
    </div>
</header>

<script>

    document.getElementById("lightDarkSubmit").addEventListener("submit", function(event){
        event.preventDefault();
        const stationDisplay = document.getElementById("stationDisplay");
        stationDisplay.innerHTML = "";
        let results = stations.filter(function(cur){
            return cur.name.toLowerCase().startsWith(inputHome.value.toLowerCase());
        });
        console.log(homeSubmit);
        results.forEach(function(n) 
        {
            let p = document.createElement("p");
            p.innerText = n.name;
            p.addEventListener("click", function(){
            localStorage.setItem("home", JSON.stringify(n));
            let test = JSON.parse(localStorage.getItem("home"));
            console.log(test.gid);
            });

            stationDisplay.append(p);

        });
    })

</script>

