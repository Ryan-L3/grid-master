<?php

try {
    // Connection parameters
    $host = "rle-server.mysql.database.azure.com";
    $username = "bckcctbcay";
    $password = 'yBJedelxw12Vb$dK';
    $database = "rle-database";
    $dsn = "mysql:host=$host;dbname=$database;port=3306;charset=utf8mb4";

    // SSL Certificate Path
    $options = [
        PDO::MYSQL_ATTR_SSL_CA => "DigiCertGlobalRootCA.crt.pem",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    // Create PDO instance
    $db = new PDO($dsn, $username, $password, $options);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?>