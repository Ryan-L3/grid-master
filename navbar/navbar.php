<?php
function isActive($page)
{
    return (basename($_SERVER["PHP_SELF"]) == $page) ? "active" : "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="navbar/navbar_style.css">
</head>

<body>
    <nav class="sidenav" id="sidenav">
        <a href="drivers.php" class="f1-logo">
            <img src="public/F1.svg">
        </a>
        <a href="drivers.php" class="nav-link <?php echo isActive("drivers.php"); ?>">
            <span class="nav-text">Drivers</span>
        </a>
        <a href="teams.php" class="nav-link <?php echo isActive("teams.php"); ?>">
            <span class="nav-text">Teams</span>
        </a>
        <a href="news.php" class="nav-link <?php echo isActive("news.php"); ?>">
            <span class="nav-text">News</span>
        </a>
    </nav>
</body>

</html>