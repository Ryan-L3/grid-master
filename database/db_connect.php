<?php

try {
    // Connection parameters
    $host = getenv('AZURE_MYSQL_HOST');
    $username = getenv('AZURE_MYSQL_USERNAME');
    $password = getenv('AZURE_MYSQL_PASSWORD');
    $database = getenv('AZURE_MYSQL_DBNAME');
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

?>`