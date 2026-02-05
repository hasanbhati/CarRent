<?php
// car_actions.php - Handles car actions via AJAX
include 'db.php';
session_start();

$action = $_POST['action'] ?? '';
$response = ['success' => false];

switch ($action) {
    case 'get_details':
        // Fetch car details by ID
        $id = intval($_POST['car_id']);
        $result = $conn->query("SELECT * FROM cars WHERE id = $id");
        if ($car = $result->fetch_assoc()) {
            $response['success'] = true;
            $response['car'] = $car;
        }
        break;
    case 'rent':
        // Rent a car
        if (isset($_SESSION['email']) && $_SESSION['usertype'] === 'client') {
            $id = intval($_POST['car_id']);
            $email = $_SESSION['email'];
            $conn->query("UPDATE cars SET status = 'rented', rented_by = '$email', rent_start = NOW() WHERE id = $id AND status = 'available'");
            // Log to rental_history
            $conn->query("INSERT INTO rental_history (car_id, username, action, action_time) VALUES ($id, '$email', 'rent', NOW())");
            $response['success'] = true;
        }
        break;
    case 'release':
        // Release a car
        if (isset($_SESSION['email']) && $_SESSION['usertype'] === 'client') {
            $id = intval($_POST['car_id']);
            $email = $_SESSION['email'];
            $conn->query("UPDATE cars SET status = 'available', rented_by = NULL, rent_end = NOW() WHERE id = $id AND rented_by = '$email' AND status = 'rented'");
            // Log to rental_history
            $conn->query("INSERT INTO rental_history (car_id, username, action, action_time) VALUES ($id, '$email', 'release', NOW())");
            $response['success'] = true;
        }
        break;
    case 'remove':
        // Remove a car (admin only, if not rented)
        if (isset($_SESSION['email']) && $_SESSION['usertype'] === 'admin') {
            $id = intval($_POST['car_id']);
            $conn->query("UPDATE cars SET status = 'removed' WHERE id = $id AND status = 'available'");
            $response['success'] = true;
        }
        break;
    case 'add':
        // Add a new car (admin only)
        if (isset($_SESSION['email']) && $_SESSION['usertype'] === 'admin') {
            // Handle file upload and insert new car
            // (To be implemented in detail)
        }
        break;
}

header('Content-Type: application/json');
echo json_encode($response);
?> 