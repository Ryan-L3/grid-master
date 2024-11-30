<?php
session_start();

require('database/db_connect.php');

$query = "SELECT * FROM drivers";

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
    <link rel="stylesheet" href="main.css">
    <title>Grid Master</title>
</head>

<?php include('navbar/navbar.php'); ?>

<body>
    <main>
        <h2>Formula 1 Drivers</h2>
        <?php if ($statement->rowCount() == 0): ?>
            <div>
                <h2>No drivers found!</h2>
            </div>
            <?php exit; endif; ?>

        <?php while ($row = $statement->fetch()): ?>
            <div class="card" style="width: 18rem;">
                <h3><?= $row['full_name'] ?></h3>
                <div class="driver-details">
                    <p>Nationality: <?= $row['nationality'] ?></p>
                    <p>Team ID: <?= $row['team_id'] ?></p>
                    <p>Car Number: <?= $row['car_number'] ?></p>
                    <p>Total Points: <?= $row['total_points'] ?></p>
                    <p>Date of Birth: <?= date_format(date_create($row['date_of_birth']), 'F j, Y') ?></p>
                    <p>Status: <?= $row['active'] ? 'Active' : 'Inactive' ?></p>
                </div>
                <div class="actions">
                    <a href="show.php?id=<?= $row['driver_id'] ?>">View Details</a>
                    <a href="edit.php?id=<?= $row['driver_id'] ?>">Edit</a>
                </div>
            </div>
        <?php endwhile; ?>
    </main>
</body>

</html>