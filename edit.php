<?php
session_start();
require('database/db_connect.php');

if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

$driver_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$driver_id) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $query = "UPDATE drivers SET 
            full_name = ?, 
            nationality = ?, 
            date_of_birth = ?, 
            car_number = ?, 
            total_points = ?,
            active = ?
            WHERE driver_id = ?";

        $statement = $db->prepare($query);
        $statement->execute([
            $_POST['full_name'],
            $_POST['nationality'],
            $_POST['date_of_birth'],
            $_POST['car_number'],
            $_POST['total_points'],
            isset($_POST['active']) ? 1 : 0,
            $driver_id
        ]);

        header('Location: driver_details.php?id=' . $driver_id);
        exit();
    } catch (PDOException $e) {
        $error = "Error updating driver details: " . $e->getMessage();
    }
}

$query = "SELECT * FROM drivers WHERE driver_id = ?";
$statement = $db->prepare($query);
$statement->execute([$driver_id]);
$driver = $statement->fetch(PDO::FETCH_ASSOC);

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

    <title>Edit <?= htmlspecialchars($driver['full_name']) ?></title>
</head>

<body>
    <?php include('navbar/navbar.php'); ?>

    <main class="container mt-4" style="margin-left: 300px;">
        <a href="driver_details.php?id=<?= htmlspecialchars($driver_id) ?>" class="btn btn-outline-dark mb-4">
            &larr; Back to Driver Details
        </a>

        <div class="driver-header">
            <h1 class="display-4 text-white">Edit Driver Details</h1>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <div class="card shadow">
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name"
                            value="<?= htmlspecialchars($driver['full_name']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="nationality">Nationality</label>
                        <input type="text" class="form-control" id="nationality" name="nationality"
                            value="<?= htmlspecialchars($driver['nationality']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                            value="<?= htmlspecialchars($driver['date_of_birth']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="car_number">Car Number</label>
                        <input type="number" class="form-control" id="car_number" name="car_number"
                            value="<?= htmlspecialchars($driver['car_number']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="total_points">Total Points</label>
                        <input type="number" step="0.01" class="form-control" id="total_points" name="total_points"
                            value="<?= htmlspecialchars($driver['total_points']) ?>" required>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="active" name="active"
                                <?= $driver['active'] ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="active">Active Driver</label>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="driver_details.php?id=<?= htmlspecialchars($driver_id) ?>"
                            class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>