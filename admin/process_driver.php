<?php
session_start();
require(__DIR__ . '/../database/db_connect.php');

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $query = "INSERT INTO drivers (full_name, nationality, car_number, date_of_birth, total_points, active) 
                  VALUES (:full_name, :nationality, :car_number, :date_of_birth, :total_points, :active)";

        $statement = $db->prepare($query);
        $statement->execute([
            ':full_name' => $_POST['full_name'],
            ':nationality' => $_POST['nationality'],
            ':car_number' => $_POST['car_number'],
            ':date_of_birth' => $_POST['date_of_birth'],
            ':total_points' => $_POST['total_points'],
            ':active' => isset($_POST['active']) ? 1 : 0
        ]);

        header("Location: ../manage_drivers.php");
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>