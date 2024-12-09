<?php
session_start();
require('database/db_connect.php');

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if (!empty($search)) {
    $query = "SELECT * FROM drivers WHERE full_name LIKE :search ORDER BY total_points DESC";
    $statement = $db->prepare($query);
    $statement->execute(['search' => "%$search%"]);
} else {
    $query = "SELECT * FROM drivers ORDER BY total_points DESC";
    $statement = $db->prepare($query);
    $statement->execute();
}
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
        <div class="page-header">
            <h1 class="display-4 text-white mb-0">Formula 1 Drivers</h1>
            <p class="lead text-white-50 mt-2 mb-4">Current Driver Standings</p>

            <!-- Search Form -->
            <form action="index.php" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search by driver name..."
                        value="<?= htmlspecialchars($search) ?>">
                    <div class="input-group-append">
                        <button class="btn btn-light" type="submit">Search</button>
                        <?php if (!empty($search)): ?>
                            <a href="index.php" class="btn btn-outline-light">Clear</a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>

        <?php if ($statement->rowCount() == 0): ?>
            <div class="alert alert-info">
                <?php if (!empty($search)): ?>
                    <h2>No drivers found matching "<?= htmlspecialchars($search) ?>"</h2>
                <?php else: ?>
                    <h2>No drivers found!</h2>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <?php if (!empty($search)): ?>
                <p class="text-white mb-4">Found <?= $statement->rowCount() ?> driver(s) matching
                    "<?= htmlspecialchars($search) ?>"</p>
            <?php endif; ?>

            <div class="row">
                <?php while ($row = $statement->fetch()): ?>
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm driver-card">
                            <div class="card-header">
                                <h3 class="card-title h5 mb-0"><?= htmlspecialchars($row['full_name']) ?></h3>
                            </div>
                            <div class="card-body">
                                <div class="driver-details">
                                    <p class="card-text"><strong>Nationality:</strong>
                                        <?= htmlspecialchars($row['nationality']) ?></p>
                                    <p class="card-text"><strong>Car Number:</strong>
                                        <?= htmlspecialchars($row['car_number']) ?></p>
                                    <p class="card-text"><strong>Total Points:</strong>
                                        <?= htmlspecialchars($row['total_points']) ?></p>
                                    <p class="card-text"><strong>Date of Birth:</strong>
                                        <?= date_format(date_create($row['date_of_birth']), 'F j, Y') ?></p>
                                    <p class="card-text mb-0">
                                        <strong>Status:</strong>
                                        <span class="badge <?= $row['active'] ? 'badge-success' : 'badge-secondary' ?>">
                                            <?= $row['active'] ? 'Active' : 'Inactive' ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="d-flex justify-content-between">
                                    <a href="driver_details.php?id=<?= htmlspecialchars($row['driver_id']) ?>"
                                        class="btn btn-dark btn-sm">View Details</a>
                                    <?php if (isset($_SESSION['email'])): ?>
                                        <a href="edit.php?id=<?= htmlspecialchars($row['driver_id']) ?>"
                                            class="btn btn-outline-dark btn-sm">Edit</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </main>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
</body>

</html>