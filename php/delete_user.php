<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['usertype'] !== 'admin') {
    header('Location: ../index.html');
    exit();
}
include 'db.php';

$user_id = intval($_GET['id'] ?? 0);
$current_email = $_SESSION['email'];

// Get user to delete
$user_query = "SELECT * FROM users WHERE id = $user_id";
$user_result = $conn->query($user_query);
$user = $user_result->fetch_assoc();

// If user not found
if (!$user) {
    header('Location: ../users_list.php?error=4');
    exit();
}

// Prevent admin from deleting themselves
if ($user['email'] === $current_email) {
    header('Location: ../users_list.php?error=3');
    exit();
}

// Release any cars that this user has rented
$user_email = $user['email'];
$conn->query("UPDATE cars SET status = 'available', rented_by = NULL, rent_end = NOW() WHERE rented_by = '$user_email' AND status = 'rented'");

// Delete the user account
$delete_query = "DELETE FROM users WHERE id = $user_id";

if ($conn->query($delete_query) === TRUE) {
    // Delete successful
    header('Location: ../users_list.php?success=2');
    exit();
} else {
    // Delete failed
    header('Location: ../users_list.php?error=2');
    exit();
}

$conn->close();
?>
