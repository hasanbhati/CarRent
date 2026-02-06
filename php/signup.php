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
    // Generate activation token and store hashed token with expiry
    $token = bin2hex(random_bytes(32));
    $tokenHash = hash('sha256', $token);
    $expiresAt = date('Y-m-d H:i:s', time() + 86400); // 24 hours

    // Insert new user as NOT activated
    require_once __DIR__ . '/mailer.php';

    $stmt = $conn->prepare("\n        INSERT INTO users (email, password, usertype, is_activated, activation_token_hash, activation_expires_at)\n        VALUES (?, ?, 'client', 0, ?, ?)\n    ");
    $stmt->bind_param("ssss", $email, $password, $tokenHash, $expiresAt);
    if ($stmt->execute()) {
        // Send activation email
        $baseUrl = "http://localhost/CarRent"; // adjust if your folder differs
        $activationLink = $baseUrl . "/activate.php?token=" . urlencode($token);

        // Try sending activation email
        $emailSent = sendActivationEmail($email, $activationLink);
        
        // Redirect back to login page with success code
        // Email may or may not have sent, but account was created
        if ($emailSent) {
            header('Location: ../index.html?success=2');
        } else {
            // Email failed but account created - inform user
            header('Location: ../index.html?success=3');
        }
        exit();
    } else {
        header('Location: ../index.html?error=4');
        exit();
    }
}

$conn->close();
?>
