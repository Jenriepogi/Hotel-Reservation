<?php
$host = 'localhost';  // Update if different
$dbname = 'hotel_db'; // Change to your DB name
$username = 'root';   // Use your DB username
$password = '';       // Use your DB password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
?>
