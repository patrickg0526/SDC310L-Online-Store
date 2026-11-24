<?php
// Database connection for the online_store database.
// Uses the least-privilege store_user account created by db/create_db.sql (not root).
$dsn      = 'mysql:host=localhost;dbname=online_store;charset=utf8mb4';
$username = 'store_user';
$password = 'SummitTrail#Dev2026';   // local development password from db/create_db.sql
$options  = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // throw exceptions on database errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // return rows as associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                   // use real prepared statements
];

try {
    $db = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    $error_message = 'We are unable to connect to the store database right now. Please try again later.';
    include 'database_error.php';
    exit();
}
