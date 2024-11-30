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
    <header class="header">
        <h1>Grid Master</h1>
        <?php if (!isset($_SESSION['email'])): ?>
            <a href="login.php">
                <button type="button" class="btn btn-outline-light">Login</button>
            </a>
        <?php else: ?>
            <div class="user-info">
                <span class="user-email"><?php echo htmlspecialchars($_SESSION['email']); ?></span>
                <a href="logout.php">
                    <button type="button" class="btn btn-outline-light">Logout</button>
                </a>
            </div>
        <?php endif; ?>
    </header>

    <nav class="sidenav" id="sidenav">
        <a href="index.php" class="f1-logo">
            <img src="public/F1.svg">
        </a>
        <a href="index.php" class="nav-link <?php echo isActive("index.php"); ?>">
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