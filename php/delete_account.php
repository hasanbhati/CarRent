<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../index.html');
    exit();
}
include 'db.php';

$email = $_SESSION['email'];

// First, release any cars that this user has rented
$conn->query("UPDATE cars SET status = 'available', rented_by = NULL, rent_end = NOW() WHERE rented_by = '$email' AND status = 'rented'");

// Delete the user account
$delete_query = "DELETE FROM users WHERE email = '$email'";

if ($conn->query($delete_query) === TRUE) {
    // Account deleted successfully
    // Destroy session
    session_destroy();
    // Redirect to login page with success message
    header('Location: ../index.html?deleted=1');
    exit();
} else {
    // Delete failed
    header('Location: ../account_details.php?error=2');
    exit();
}

$conn->close();
?>
