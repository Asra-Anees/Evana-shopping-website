<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "evana";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'] ?? 0;
    $current_status = $_POST['current_status'] ?? 'Pending';

    // Determine next status
    $next_status = match ($current_status) {
        'Pending' => 'Confirmed',
        'Confirmed' => 'Shipping',
        'Shipping' => 'Delivered',
        default => 'Delivered'
    };

    // Update in DB
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $next_status, $id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: manage_orders.php");
exit();
