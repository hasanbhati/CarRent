<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['usertype'] !== 'admin') {
    header('Location: ../index.html');
    exit();
}
include 'db.php';

$user_id = intval($_POST['user_id'] ?? 0);
$name = $_POST['name'] ?? '';
$surname = $_POST['surname'] ?? '';
$contact = $_POST['contact'] ?? '';
$address = $_POST['address'] ?? '';
$usertype = $_POST['usertype'] ?? 'client';
$new_password = $_POST['password'] ?? '';

// Build update query
$update_fields = array();

// Add fields to update if they are provided
if ($name !== '') {
    $update_fields[] = "name = '" . $conn->real_escape_string($name) . "'";
}
if ($surname !== '') {
    $update_fields[] = "surname = '" . $conn->real_escape_string($surname) . "'";
}
if ($contact !== '') {
    $update_fields[] = "contact = '" . $conn->real_escape_string($contact) . "'";
}
if ($address !== '') {
    $update_fields[] = "address = '" . $conn->real_escape_string($address) . "'";
}

// Update user type
$update_fields[] = "usertype = '" . $conn->real_escape_string($usertype) . "'";

// Update password if provided
if ($new_password !== '') {
    $update_fields[] = "password = '" . $conn->real_escape_string($new_password) . "'";
}

// If no fields to update, redirect back
if (empty($update_fields)) {
    header('Location: ../users_list.php?success=1');
    exit();
}

// Build and execute update query
$update_query = "UPDATE users SET " . implode(', ', $update_fields) . " WHERE id = $user_id";

if ($conn->query($update_query) === TRUE) {
    // Update successful
    header('Location: ../users_list.php?success=1');
    exit();
} else {
    // Update failed
    header('Location: ../edit_user.php?id=' . $user_id . '&error=1');
    exit();
}

$conn->close();
?>
