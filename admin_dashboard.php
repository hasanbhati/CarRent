<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['usertype'] !== 'admin') {
    header('Location: index.html');
    exit();
}
include 'php/db.php';
$email = $_SESSION['email'];

// Fetch cars from DB
$available = $conn->query("SELECT * FROM cars WHERE status = 'available'");
$rented = $conn->query("SELECT * FROM cars WHERE status = 'rented'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Car Rental</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/main.js" defer></script>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>🚗 Car Rental Admin Dashboard</h2>
            <div class="dashboard-header-nav">
                <a href="account_details.php" class="account-btn">My Account</a>
                <a href="users_list.php" class="account-btn">Users</a>
                <a href="stats.php" class="account-btn">Stats</a>
                <a href="php/logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
        <button id="add-car-btn">➕ Add a car</button>
        <h3>Available Cars for Rental</h3>
        <table class="car-table" id="available-cars">
            <thead>
                <tr>
                    <th>Brand</th><th>Model</th><th>Type</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($car = $available->fetch_assoc()): ?>
                <tr class="car-row" data-car-id="<?php echo $car['id']; ?>">
                    <td><?php echo htmlspecialchars($car['brand']); ?></td>
                    <td><?php echo htmlspecialchars($car['model']); ?></td>
                    <td><?php echo htmlspecialchars($car['type']); ?></td>
                    <td><button class="remove-btn" data-car-id="<?php echo $car['id']; ?>">Remove</button></td>
                </tr>
                <tr class="car-details-row" style="display:none;"><td colspan="4"></td></tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <h3>Rented Cars</h3>
        <table class="car-table" id="rented-cars">
            <thead>
                <tr>
                    <th>Brand</th><th>Model</th><th>Type</th><th>Rented By</th>
                </tr>
            </thead>
            <tbody>
                <?php while($car = $rented->fetch_assoc()): ?>
                <tr class="car-row" data-car-id="<?php echo $car['id']; ?>">
                    <td><?php echo htmlspecialchars($car['brand']); ?></td>
                    <td><?php echo htmlspecialchars($car['model']); ?></td>
                    <td><?php echo htmlspecialchars($car['type']); ?></td>
                    <td><?php echo htmlspecialchars($car['rented_by']); ?></td>
                </tr>
                <tr class="car-details-row" style="display:none;"><td colspan="4"></td></tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div id="add-car-form-container" style="display:none;"></div>
    </div>
</body>
</html> 