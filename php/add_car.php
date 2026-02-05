<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['usertype'] !== 'admin') {
    header('Location: ../index.html');
    exit();
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $manufacturer = $_POST['manufacturer'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $registration_plate = $_POST['registration_plate'];
    $type = $_POST['type'];
    $fuel_type = $_POST['fuel_type'];
    $transmission = $_POST['transmission'];
    $mileage = intval($_POST['mileage']);
    $info = $_POST['info'];
    $image = '';

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $img_name = basename($_FILES['image']['name']);
        $target_dir = '../images/';
        $target_file = $target_dir . $img_name;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $img_name;
        }
    }

    $stmt = $conn->prepare("INSERT INTO cars (manufacturer, brand, model, registration_plate, type, fuel_type, transmission, mileage, image, info, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'available')");
    $stmt->bind_param('ssssssssss', $manufacturer, $brand, $model, $registration_plate, $type, $fuel_type, $transmission, $mileage, $image, $info);
    $stmt->execute();
    $stmt->close();
    header('Location: ../admin_dashboard.php');
    exit();
}
?> 