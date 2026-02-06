<?php
session_start();
include 'db.php';

// Get form data
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Check if email and password are provided
if (empty($email) || empty($password)) {
    header('Location: ../index.html?error=1');
    exit();
}

// Check if user exists in database
$query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // User found, get user data
    $user = $result->fetch_assoc();
    // Block login if account not activated
    if ((int)$user['is_activated'] !== 1) {
        header('Location: ../index.html?error=5');
        exit();
    }
    
    // Set session variables
    $_SESSION['username'] = $user['email']; // Using email as username for compatibility
    $_SESSION['email'] = $user['email'];
    $_SESSION['usertype'] = $user['usertype'];
    
    // Redirect based on user type
    if ($user['usertype'] === 'admin') {
        header('Location: ../admin_dashboard.php');
    } else {
        header('Location: ../client_dashboard.php');
    }
    exit();
} else {
    // Invalid credentials
    header('Location: ../index.html?error=1');
    exit();
}

$conn->close();
?> 