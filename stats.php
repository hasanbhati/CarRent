<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['usertype'] !== 'admin') {
    header('Location: index.html');
    exit();
}
include 'php/db.php';

// Get most popular cars (sorted by number of rentals)
$popular_cars_query = "SELECT c.id, c.brand, c.model, c.type, COUNT(*) as rental_count 
                       FROM rental_history h 
                       JOIN cars c ON h.car_id = c.id 
                       WHERE h.action = 'rent' 
                       GROUP BY c.id, c.brand, c.model, c.type 
                       ORDER BY rental_count DESC";
$popular_cars = $conn->query($popular_cars_query);

// Get users with most rentals (sorted by number of rentals)
$top_users_query = "SELECT username, COUNT(*) as rental_count 
                    FROM rental_history 
                    WHERE action = 'rent' 
                    GROUP BY username 
                    ORDER BY rental_count DESC";
$top_users = $conn->query($top_users_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Statistics - Car Rental</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>📊 Statistics Dashboard</h2>
            <div class="dashboard-header-nav">
                <a href="admin_dashboard.php" class="account-btn">Back to Dashboard</a>
            </div>
        </div>
        
        <h3>Most Popular Cars</h3>
        <p style="color: #666; margin-bottom: 20px;">Cars sorted by total number of rentals</p>
        <table class="car-table">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Type</th>
                    <th>Total Rentals</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $rank = 1;
                while($car = $popular_cars->fetch_assoc()): 
                ?>
                <tr class="car-row">
                    <td><strong><?php echo $rank; ?></strong></td>
                    <td><?php echo htmlspecialchars($car['brand']); ?></td>
                    <td><?php echo htmlspecialchars($car['model']); ?></td>
                    <td><?php echo htmlspecialchars($car['type']); ?></td>
                    <td><strong><?php echo $car['rental_count']; ?></strong></td>
                </tr>
                <?php 
                $rank++;
                endwhile; 
                ?>
                <?php if ($popular_cars->num_rows == 0): ?>
                <tr class="car-row">
                    <td colspan="5" style="text-align: center; color: #666;">No rental data available yet.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h3>Top Users by Rentals</h3>
        <p style="color: #666; margin-bottom: 20px;">Users sorted by total number of car rentals</p>
        <table class="car-table">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>User Email</th>
                    <th>Total Rentals</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $rank = 1;
                while($user = $top_users->fetch_assoc()): 
                ?>
                <tr class="car-row">
                    <td><strong><?php echo $rank; ?></strong></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><strong><?php echo $user['rental_count']; ?></strong></td>
                </tr>
                <?php 
                $rank++;
                endwhile; 
                ?>
                <?php if ($top_users->num_rows == 0): ?>
                <tr class="car-row">
                    <td colspan="3" style="text-align: center; color: #666;">No rental data available yet.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
