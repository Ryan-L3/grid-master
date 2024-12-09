<?php
session_start();
require('database/db_connect.php');

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch all drivers
$query = "SELECT * FROM drivers ORDER BY total_points DESC";
$drivers = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Manage Drivers - Grid Master</title>
</head>

<body>
    <?php include('navbar/navbar.php'); ?>

    <main class="container mt-4" style="margin-left: 300px;">
        <div class="page-header mb-4">
            <h1 class="display-4 text-white">Manage Drivers</h1>
        </div>

        <div class="bg-white p-4 rounded shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0">Drivers List</h2>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDriverModal">
                    Add New Driver
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                            <th>Nationality</th>
                            <th>Car Number</th>
                            <th>Points</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($drivers as $driver): ?>
                            <tr>
                                <td><?= htmlspecialchars($driver['full_name']) ?></td>
                                <td><?= htmlspecialchars($driver['nationality']) ?></td>
                                <td><?= htmlspecialchars($driver['car_number']) ?></td>
                                <td><?= htmlspecialchars($driver['total_points']) ?></td>
                                <td>
                                    <span class="badge <?= $driver['active'] ? 'badge-success' : 'badge-secondary' ?>">
                                        <?= $driver['active'] ? 'Active' : 'Inactive' ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="edit_driver.php?id=<?= $driver['driver_id'] ?>"
                                        class="btn btn-sm btn-outline-primary">Edit</a>
                                    <button class="btn btn-sm btn-outline-danger"
                                        onclick="deleteDriver(<?= $driver['driver_id'] ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Add Driver Modal -->
    <div class="modal fade" id="addDriverModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Driver</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="admin/process_driver.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" class="form-control" name="full_name" required>
                        </div>
                        <div class="form-group">
                            <label>Nationality</label>
                            <input type="text" class="form-control" name="nationality" required>
                        </div>
                        <div class="form-group">
                            <label>Car Number</label>
                            <input type="number" class="form-control" name="car_number" required>
                        </div>
                        <div class="form-group">
                            <label>Date of Birth</label>
                            <input type="date" class="form-control" name="date_of_birth" required>
                        </div>
                        <div class="form-group">
                            <label>Total Points</label>
                            <input type="number" class="form-control" name="total_points" value="0">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="active" value="1" checked>
                            <label class="form-check-label">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Driver</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script>
        function deleteDriver(driverId) {
            if (confirm('Are you sure you want to delete this driver?')) {
                window.location.href = 'admin/delete_driver.php?id=' + driverId;
            }
        }
    </script>
</body>

</html>