<?php

require('connect.php');

$query = "SELECT * FROM blog";

$statement = $db->prepare($query);

$statement->execute();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Grid Master</title>
</head>



<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <header class="header">
        <div class="text-center">
            <h1>Grid Master</h1>
        </div>
    </header>

    <?php include('navbar/navbar.php'); ?>

</body>

</html>