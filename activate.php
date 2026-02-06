<?php
require_once 'php/db.php';

$token = $_GET['token'] ?? '';
if (!$token) die("Invalid activation link.");

$hash = hash('sha256', $token);

$stmt = $conn->prepare("
    SELECT is_activated, activation_expires_at
    FROM users
    WHERE activation_token_hash = ?
");
$stmt->bind_param("s", $hash);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows !== 1) {
    die("Invalid or expired activation link.");
}

$user = $res->fetch_assoc();

if ($user['is_activated']) {
    die("Account already activated.");
}

if (strtotime($user['activation_expires_at']) < time()) {
    die("Activation link expired.");
}

$update = $conn->prepare("
    UPDATE users
    SET is_activated = 1,
        activation_token_hash = NULL,
        activation_expires_at = NULL
    WHERE activation_token_hash = ?
");
$update->bind_param("s", $hash);
$update->execute();

echo "✅ Account activated successfully. You may now log in.";

?>