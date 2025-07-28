<?php
$conn = new mysqli("localhost", "root", "", "evana");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = intval($_POST['cart_id']);
    $quantity = intval($_POST['quantity']);
    if ($quantity < 1) $quantity = 1;

    $stmt = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
    $stmt->bind_param("ii", $quantity, $cart_id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: update_cart.php ");
exit;
?>
