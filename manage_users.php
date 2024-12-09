<?php
session_start();
require('database/db_connect.php');

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

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
    <title>Manage Users - Grid Master</title>
</head>

<body>
    <?php include('navbar/navbar.php'); ?>

    <main class="container mt-4" style="margin-left: 300px;">
        <div class="page-header mb-4">
            <h1 class="display-4 text-white">Manage Users</h1>
        </div>

        <div class="bg-white p-4 rounded shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0">Users List</h2>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
                    Add New User
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['username']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-danger"
                                        onclick="deleteUser(<?= $user['user_id'] ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="admin/process_user.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script>
        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                window.location.href = 'admin/delete_user.php?id=' + userId;
            }
        }
    </script>
</body>

</html>