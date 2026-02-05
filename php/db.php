<?php
// db.php - Database connection for Car Rental Project

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'car_rental';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?> 