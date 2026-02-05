<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['usertype'] !== 'admin') {
    header('Location: index.html');
    exit();
}
include 'php/db.php';

// Fetch all users from database
$users_query = "SELECT * FROM users ORDER BY created_at DESC";
$users_result = $conn->query($users_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users Management - Car Rental</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>👥 Users Management</h2>
            <div class="dashboard-header-nav">
                <a href="admin_dashboard.php" class="account-btn">Back to Dashboard</a>
            </div>
        </div>
        
        <?php
        // Show success/error messages
        if (isset($_GET['success']) && $_GET['success'] == '1') {
            echo '<div class="message message-success">User updated successfully!</div>';
        }
        if (isset($_GET['success']) && $_GET['success'] == '2') {
            echo '<div class="message message-success">User deleted successfully!</div>';
        }
        if (isset($_GET['error'])) {
            $errorMsg = 'An error occurred. Please try again.';
            if ($_GET['error'] == '1') {
                $errorMsg = 'Error updating user. Please try again.';
            } elseif ($_GET['error'] == '2') {
                $errorMsg = 'Error deleting user. Please try again.';
            } elseif ($_GET['error'] == '3') {
                $errorMsg = 'Cannot delete your own account.';
            }
            echo '<div class="message message-error">' . $errorMsg . '</div>';
        }
        ?>

        <h3>All Users</h3>
        <table class="car-table">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Type</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($user = $users_result->fetch_assoc()): ?>
                <tr class="car-row">
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars(($user['name'] ?? '') . ' ' . ($user['surname'] ?? '')); ?></td>
                    <td><?php echo htmlspecialchars($user['contact'] ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars(ucfirst($user['usertype'])); ?></td>
                    <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $user['id']; ?>" style="background: linear-gradient(90deg, #1976d2 0%, #42a5f5 100%); color: #fff; padding: 6px 12px; border-radius: 5px; text-decoration: none; font-size: 0.9rem; margin-right: 5px;">Edit</a>
                        <?php if ($user['email'] !== $_SESSION['email']): ?>
                        <a href="php/delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone!');" style="background: linear-gradient(90deg, #e53935 0%, #ff7043 100%); color: #fff; padding: 6px 12px; border-radius: 5px; text-decoration: none; font-size: 0.9rem;">Delete</a>
                        <?php else: ?>
                        <span style="color: #999; font-size: 0.9rem;">Current User</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
