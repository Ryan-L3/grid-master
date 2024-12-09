<?php
session_start();
require('database/db_connect.php');

// Get driver ID from URL
$driver_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$driver_id) {
    header('Location: index.php');
    exit();
}

// Fetch driver details
$query = "SELECT * FROM drivers WHERE driver_id = ?";
$statement = $db->prepare($query);
$statement->execute([$driver_id]);
$driver = $statement->fetch(PDO::FETCH_ASSOC);

// Redirect if driver not found
if (!$driver) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="public/F1.svg">
    <link rel="stylesheet" href="driver_details.css">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <title><?= htmlspecialchars($driver['full_name']) ?> - Details</title>
</head>

<body>
    <?php include('navbar/navbar.php'); ?>

    <main class="container mt-4" style="margin-left: 300px;">
        <a href="index.php" class="btn btn-outline-dark mb-4">
            &larr; Back to Drivers
        </a>

        <div class="driver-header">
            <h1 class="display-4 text-white"><?= htmlspecialchars($driver['full_name']) ?></h1>
            <span class="badge <?= $driver['active'] ? 'badge-success' : 'badge-secondary' ?>">
                <?= $driver['active'] ? 'Active' : 'Inactive' ?>
            </span>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow stat-card h-100">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Personal Information</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Nationality:</strong> <?= htmlspecialchars($driver['nationality']) ?></p>
                        <p><strong>Date of Birth:</strong>
                            <?= date_format(date_create($driver['date_of_birth']), 'F j, Y') ?></p>
                        <p><strong>Age:</strong>
                            <?= date_diff(date_create($driver['date_of_birth']), date_create('today'))->y ?> years</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card shadow stat-card h-100">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Racing Information</h3>
                    </div>
                    <div class="card-body">
                        <!-- <p><strong>Team ID:</strong> <?= htmlspecialchars($driver['team_id']) ?></p> -->
                        <p><strong>Car Number:</strong> <?= htmlspecialchars($driver['car_number']) ?></p>
                        <p><strong>Total Points:</strong> <?= htmlspecialchars($driver['total_points']) ?></p>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mb-4">
            <div class="col">
                <?php if (isset($_SESSION['email'])): ?>
                    <a href="edit.php?id=<?= htmlspecialchars($row['driver_id']) ?>"
                        class="btn btn-outline-dark btn-sm">Edit Driver
                        Details</a>
                <?php endif; ?>
            </div>
        </div>
    </main>


</body>

</html>