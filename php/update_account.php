<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../index.html');
    exit();
}
include 'db.php';

$email = $_SESSION['email'];

// Get form data
$name = $_POST['name'] ?? '';
$surname = $_POST['surname'] ?? '';
$contact = $_POST['contact'] ?? '';
$address = $_POST['address'] ?? '';
$old_password = $_POST['old_password'] ?? '';
$old_password_confirm = $_POST['old_password_confirm'] ?? '';
$new_password = $_POST['new_password'] ?? '';

// Get current user data to verify old password
$user_query = "SELECT * FROM users WHERE email = '$email'";
$user_result = $conn->query($user_query);
$current_user = $user_result->fetch_assoc();

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

// Handle password change
if ($old_password !== '' || $old_password_confirm !== '' || $new_password !== '') {
    // If any password field is filled, all must be filled
    if ($old_password === '' || $old_password_confirm === '' || $new_password === '') {
        header('Location: ../account_details.php?error=2');
        exit();
    }
    
    // Verify old passwords match
    if ($old_password !== $old_password_confirm) {
        header('Location: ../account_details.php?error=3');
        exit();
    }
    
    // Verify old password matches current password
    if ($old_password !== $current_user['password']) {
        header('Location: ../account_details.php?error=4');
        exit();
    }
    
    // Update password
    $update_fields[] = "password = '" . $conn->real_escape_string($new_password) . "'";
}

// If no fields to update, redirect back
if (empty($update_fields)) {
    header('Location: ../account_details.php?success=1');
    exit();
}

// Build and execute update query
$update_query = "UPDATE users SET " . implode(', ', $update_fields) . " WHERE email = '$email'";

if ($conn->query($update_query) === TRUE) {
    // Update successful
    header('Location: ../account_details.php?success=1');
    exit();
} else {
    // Update failed
    header('Location: ../account_details.php?error=1');
    exit();
}

$conn->close();
?>
