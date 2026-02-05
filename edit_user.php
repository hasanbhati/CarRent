<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['usertype'] !== 'admin') {
    header('Location: index.html');
    exit();
}
include 'php/db.php';

// Get user ID from URL
$user_id = intval($_GET['id'] ?? 0);

// Fetch user details
$user_query = "SELECT * FROM users WHERE id = $user_id";
$user_result = $conn->query($user_query);
$user = $user_result->fetch_assoc();

// If user not found, redirect
if (!$user) {
    header('Location: users_list.php?error=4');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User - Car Rental</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>✏️ Edit User</h2>
            <div class="dashboard-header-nav">
                <a href="users_list.php" class="account-btn">Back to Users List</a>
            </div>
        </div>
        
        <?php
        // Show success/error messages
        if (isset($_GET['success']) && $_GET['success'] == '1') {
            echo '<div class="message message-success">User updated successfully!</div>';
        }
        if (isset($_GET['error'])) {
            $errorMsg = 'An error occurred. Please try again.';
            if ($_GET['error'] == '1') {
                $errorMsg = 'Error updating user. Please try again.';
            }
            echo '<div class="message message-error">' . $errorMsg . '</div>';
        }
        ?>

        <h3>Edit User Information</h3>
        <form action="php/update_user.php" method="POST" class="add-car-form">
            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
            
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled style="background: #f5f5f5; cursor: not-allowed; margin-bottom: 5px;">
            <small style="color: #666; display: block; margin-bottom: 16px; font-size: 0.9rem;">Email cannot be changed</small>

            <label for="name">First Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name'] ? $user['name'] : ''); ?>" placeholder="Enter first name">

            <label for="surname">Last Name:</label>
            <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($user['surname'] ? $user['surname'] : ''); ?>" placeholder="Enter last name">

            <label for="contact">Contact Number:</label>
            <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($user['contact'] ? $user['contact'] : ''); ?>" placeholder="Enter phone number">

            <label for="address">Physical Address:</label>
            <textarea id="address" name="address" rows="3" placeholder="Enter address"><?php echo htmlspecialchars($user['address'] ? $user['address'] : ''); ?></textarea>

            <label for="usertype">User Type:</label>
            <select id="usertype" name="usertype" required>
                <option value="client" <?php echo $user['usertype'] === 'client' ? 'selected' : ''; ?>>Client</option>
                <option value="admin" <?php echo $user['usertype'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
            </select>

            <label for="password">New Password (leave blank to keep current password):</label>
            <input type="password" id="password" name="password" placeholder="Enter new password" style="margin-bottom: 5px;">
            <small style="color: #666; display: block; margin-bottom: 16px; font-size: 0.9rem;">Leave empty if you don't want to change password</small>

            <button type="submit">Update User</button>
        </form>
    </div>
</body>
</html>
