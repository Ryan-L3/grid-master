<?php
session_start();
require(__DIR__ . '/../database/db_connect.php');

if (!isset($_SESSION['email']) || !isset($_GET['id'])) {
    header("Location: ../login.php");
    exit();
}

try {
    $query = "DELETE FROM drivers WHERE driver_id = :id";
    $statement = $db->prepare($query);
    $statement->execute([':id' => $_GET['id']]);

    header("Location: ../manage_drivers.php");
} catch (PDOException $e) {
    header("Location: ../manage_drivers.php");
}