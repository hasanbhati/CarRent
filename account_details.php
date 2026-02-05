<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.html');
    exit();
}
include 'php/db.php';
$email = $_SESSION['email'];

// Fetch user details from database
$query = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($query);
$user = $result->fetch_assoc();

// If user not found, redirect to login
if (!$user) {
    header('Location: index.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Details - Car Rental</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>⚙️ My Account Details</h2>
            <div class="dashboard-header-nav">
                <a href="<?php echo ($user['usertype'] === 'admin') ? 'admin_dashboard.php' : 'client_dashboard.php'; ?>" class="account-btn">Back to Dashboard</a>
            </div>
        </div>
        
        <?php
        // Show success/error messages
        if (isset($_GET['success']) && $_GET['success'] == '1') {
            echo '<div class="message message-success">Account updated successfully!</div>';
        }
        if (isset($_GET['error'])) {
            $errorMsg = 'An error occurred. Please try again.';
            if ($_GET['error'] == '1') {
                $errorMsg = 'Error updating account. Please try again.';
            } elseif ($_GET['error'] == '2') {
                $errorMsg = 'To change password, please fill all password fields.';
            } elseif ($_GET['error'] == '3') {
                $errorMsg = 'Old passwords do not match. Please try again.';
            } elseif ($_GET['error'] == '4') {
                $errorMsg = 'Old password is incorrect. Please try again.';
            }
            echo '<div class="message message-error">' . $errorMsg . '</div>';
        }
        ?>

        <h3>Edit Your Account Information</h3>
        <form action="php/update_account.php" method="POST" class="add-car-form">
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled style="background: #f5f5f5; cursor: not-allowed; margin-bottom: 5px;">
            <small style="color: #666; display: block; margin-bottom: 16px; font-size: 0.9rem;">Email cannot be changed</small>

            <label for="name">First Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name'] ? $user['name'] : ''); ?>" placeholder="Enter your first name">

            <label for="surname">Last Name:</label>
            <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($user['surname'] ? $user['surname'] : ''); ?>" placeholder="Enter your last name">

            <label for="contact">Contact Number:</label>
            <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($user['contact'] ? $user['contact'] : ''); ?>" placeholder="Enter your phone number">

            <label for="address">Physical Address:</label>
            <textarea id="address" name="address" rows="3" placeholder="Enter your address"><?php echo htmlspecialchars($user['address'] ? $user['address'] : ''); ?></textarea>

            <label for="old_password">Old Password (required to change password):</label>
            <input type="password" id="old_password" name="old_password" placeholder="Enter your current password" style="margin-bottom: 5px;">
            <small style="color: #666; display: block; margin-bottom: 16px; font-size: 0.9rem;">Enter your current password to verify</small>

            <label for="old_password_confirm">Confirm Old Password:</label>
            <input type="password" id="old_password_confirm" name="old_password_confirm" placeholder="Enter your current password again" style="margin-bottom: 5px;">
            <small style="color: #666; display: block; margin-bottom: 16px; font-size: 0.9rem;">Re-enter your current password</small>

            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" placeholder="Enter new password" style="margin-bottom: 5px;">
            <small style="color: #666; display: block; margin-bottom: 16px; font-size: 0.9rem;">Leave all password fields empty if you don't want to change password</small>

            <button type="submit">Save Changes</button>
        </form>

        <h3>Delete Account</h3>
        <div class="add-car-form" style="background: #fff3e0; border: 1px solid #ffcc80;">
            <p style="color: #666; margin-bottom: 15px;">Warning: This action cannot be undone. All your data will be permanently deleted.</p>
            <form action="php/delete_account.php" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone!');">
                <button type="submit" class="delete-account-btn" style="background: linear-gradient(90deg, #e53935 0%, #ff7043 100%); width: 100%;">Delete My Account</button>
            </form>
        </div>
    </div>
</body>
</html>
