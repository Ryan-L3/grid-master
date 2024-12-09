<?php
session_start();
require('database/db_connect.php');

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Fetch all drivers
$query = "SELECT * FROM drivers ORDER BY total_points DESC";
$drivers = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);

// Fetch all users
$query = "SELECT * FROM userdata ORDER BY email";
$users = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="public/F1.svg">
    <link rel="stylesheet" href="main.css">
    <title>Admin Dashboard - Grid Master</title>
</head>

<body>
    <?php include('navbar/navbar.php'); ?>

    <main class="container mt-4" style="margin-left: 300px;">
        <div class="page-header mb-4">
            <h1 class="display-4 text-white">Admin Dashboard</h1>
        </div>
        <a class="btn btn-secondary" href="manage_drivers.php" role="tab">Manage Drivers</a>

        <a class="btn btn-secondary" href="manage_users.php" role="tab">Manage Users</a>
</body>

</html>