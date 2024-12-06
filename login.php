<?php
// References: https://www.geeksforgeeks.org/creating-a-registration-and-login-system-with-php-and-mysql/
include 'database/db_connect.php';

$message = "";
$toastClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM userdata WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $message = "Login successful";
            $toastClass = "bg-success";

            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
            exit();
        } else {
            $message = "Incorrect password";
            $toastClass = "bg-danger";
        }
    } else {
        $message = "Email not found";
        $toastClass = "bg-warning";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/svg+xml" href="public/F1.svg">
    <title>Login Page</title>
</head>

<body class="bg-light">
    <div class="container p-5 d-flex flex-column align-items-center">
        <?php if ($message): ?>
            <div class="toast align-items-center text-white 
            <?php echo $toastClass; ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $message; ?>
                    </div>
                    <button type="button" class="btn-close
                    btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
        <form action="" method="post" class="form-control mt-5 p-4" style="height:auto; width:380px; box-shadow: rgba(60, 64, 67, 0.3) 
            0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;">
            <div class="row">

                <i class="fa fa-user-circle-o fa-3x mt-1 mb-2" style="text-align: center; color: black;"></i>
                <h5 class="text-center p-4" style="font-weight: 700;">Login Into Your Account</h5>
            </div>
            <div class="col-mb-3">
                <label for="email"><i class="fa fa-envelope"></i> Email</label>
                <input type="text" name="email" id="email" class="form-control" required>
            </div>
            <div class="col mb-3 mt-3">
                <label for="password"><i class="fa fa-lock"></i> Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="col mb-3 mt-3 d-flex justify-content-between">
                <a href="index.php" class="btn btn-outline-dark" style="width: 70px">
                    Back
                </a>
                <button type="submit" class="btn btn-primary" style="font-weight: 600;">Login</button>
            </div>
            <div class="col mb-2 mt-4">
                <p class="text-center" style="font-weight: 600; color: navy;">Don't have an account? <a
                        href="./register.php" style="text-decoration: none;">Create Account</a></p>
            </div>
        </form>
    </div>
    <script>
        var toastElList = [].slice.call(document.querySelectorAll('.toast'))
        var toastList = toastElList.map(function (toastEl) {
            return new bootstrap.Toast(toastEl, { delay: 3000 });
        });
        toastList.forEach(toast => toast.show());
    </script>
</body>

</html>