<?php
session_start();

$conn = new mysqli("localhost", "root", "", "evana"); // Add DB name here

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $cart_id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM cart_items WHERE id = ?");
    $stmt->bind_param("i", $cart_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: cart.php");
exit();
?>
