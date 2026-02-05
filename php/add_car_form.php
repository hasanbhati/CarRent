<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['usertype'] !== 'admin') {
    header('Location: ../index.html');
    exit();
}
?>
<form action="php/add_car.php" method="POST" enctype="multipart/form-data" class="add-car-form">
    <label>Manufacturer: <input type="text" name="manufacturer" required></label><br>
    <label>Brand: <input type="text" name="brand" required></label><br>
    <label>Model: <input type="text" name="model" required></label><br>
    <label>Registration Plate: <input type="text" name="registration_plate" required></label><br>
    <label>Type: <input type="text" name="type" required></label><br>
    <label>Fuel Type: <input type="text" name="fuel_type" required></label><br>
    <label>Transmission: <input type="text" name="transmission" required></label><br>
    <label>Mileage: <input type="number" name="mileage" required></label><br>
    <label>Photo: <input type="file" name="image" accept="image/*" required></label><br>
    <label>Info: <textarea name="info" rows="3" required></textarea></label><br>
    <button type="submit">Add Car</button>
</form> 