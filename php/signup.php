<?php
session_start();
include 'db.php';

// Get form data
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$usertype = $_POST['usertype'] ?? 'client';

// Check if email and password are provided
if (empty($email) || empty($password)) {
    header('Location: ../index.html?error=3');
    exit();
}

// Check if email already exists
$check_query = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($check_query);

if ($result->num_rows > 0) {
    // Email already exists
    header('Location: ../index.html?error=2');
    exit();
} else {
    // Insert new user into database
    $insert_query = "INSERT INTO users (email, password, usertype) VALUES ('$email', '$password', '$usertype')";
    
    if ($conn->query($insert_query) === TRUE) {
        // Account created successfully
        header('Location: ../index.html?success=1');
        exit();
    } else {
        // Error creating account
        header('Location: ../index.html?error=4');
        exit();
    }
}

$conn->close();
?>
