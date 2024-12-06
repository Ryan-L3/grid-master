<?php
session_start();
require('database/db_connect.php');

$query = "SELECT * FROM drivers ORDER BY total_points DESC";
$statement = $db->prepare($query);
$statement->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="public/F1.svg">
    <link rel="stylesheet" href="main.css">
    <title>Grid Master</title>
</head>

<body>
    <?php include('navbar/navbar.php'); ?>

    <main class="container mt-4" style="margin-left: 300px;">
        <h2 class="mb-4">Formula 1 Drivers</h2>

        <?php if ($statement->rowCount() == 0): ?>
            <div class="alert alert-info">
                <h2>No drivers found!</h2>
            </div>
            <?php exit; endif; ?>

        <div class="row">
            <?php while ($row = $statement->fetch()): ?>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title h5 mb-3"><?= htmlspecialchars($row['full_name']) ?></h3>
                            <div class="driver-details">
                                <p class="card-text"><strong>Nationality:</strong>
                                    <?= htmlspecialchars($row['nationality']) ?></p>
                                <p class="card-text"><strong>Team ID:</strong> <?= htmlspecialchars($row['team_id']) ?></p>
                                <p class="card-text"><strong>Car Number:</strong>
                                    <?= htmlspecialchars($row['car_number']) ?></p>
                                <p class="card-text"><strong>Total Points:</strong>
                                    <?= htmlspecialchars($row['total_points']) ?></p>
                                <p class="card-text"><strong>Date of Birth:</strong>
                                    <?= date_format(date_create($row['date_of_birth']), 'F j, Y') ?></p>
                                <p class="card-text">
                                    <strong>Status:</strong>
                                    <span class="badge <?= $row['active'] ? 'badge-success' : 'badge-secondary' ?>">
                                        <?= $row['active'] ? 'Active' : 'Inactive' ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <div class="d-flex justify-content-between">
                                <a href="show.php?id=<?= htmlspecialchars($row['driver_id']) ?>"
                                    class="btn btn-primary btn-sm">View Details</a>
                                <a href="edit.php?id=<?= htmlspecialchars($row['driver_id']) ?>"
                                    class="btn btn-secondary btn-sm">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
</body>

</html>