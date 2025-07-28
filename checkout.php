<?php
session_start();

$mysqli = new mysqli("localhost", "root", "", "e_commerce");
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

$session_id = session_id();
$error = '';
$success = '';

/* Fetch cart items */
$sql = "SELECT ci.id AS cart_id, p.id AS product_id, p.name, p.price, p.image, ci.quantity
        FROM cart_items ci
        JOIN shop p ON ci.product_id = p.id
        WHERE ci.session_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $session_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total_amount = 0;
while ($row = $result->fetch_assoc()) {
    $row['subtotal'] = $row['price'] * $row['quantity'];
    $total_amount += $row['subtotal'];
    $cart_items[] = $row;
}
$stmt->close();

/* Handle form submission */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $name = trim($_POST['customer_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $payment_method = $_POST['payment_method'] ?? 'cod';

    if (!$name || !$email || !$address) {
        $error = "Please fill in all required fields.";
    } elseif (empty($cart_items)) {
        $error = "Your cart is empty.";
    } else {
        if ($payment_method === 'creditcard') {
            $cc_number = preg_replace('/\D/', '', $_POST['cc_number'] ?? '');
            $cc_expiry = trim($_POST['cc_expiry'] ?? '');
            $cc_cvv = trim($_POST['cc_cvv'] ?? '');

            if (strlen($cc_number) < 13 || strlen($cc_number) > 19) {
                $error = "Invalid credit card number.";
            } elseif (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $cc_expiry)) {
                $error = "Invalid expiry date format (MM/YY).";
            } elseif (strlen($cc_cvv) < 3 || strlen($cc_cvv) > 4) {
                $error = "Invalid CVV.";
            }
        }
    }

    if (!$error) {
        $created_at = date('Y-m-d H:i:s');
        $status = "Pending";
        $payment_status = ($payment_method === 'cod') ? 'pending' : 'paid';
        $order_status = "Pending";

        $insert_order = $mysqli->prepare("INSERT INTO orders (customer_name, email, address, total_amount, payment_method, payment_status, order_status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_order->bind_param("sssdssss", $name, $email, $address, $total_amount, $payment_method, $payment_status, $order_status, $created_at);
        
        

        if ($insert_order->execute()) {
            $order_id = $insert_order->insert_id;
            $insert_order->close();

            $insert_item = $mysqli->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            foreach ($cart_items as $item) {
                $insert_item->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
                $insert_item->execute();
            }
            $insert_item->close();

            $delete_cart = $mysqli->prepare("DELETE FROM cart_items WHERE session_id = ?");
            $delete_cart->bind_param("s", $session_id);
            $delete_cart->execute();
            $delete_cart->close();

            // Redirect to manage_orders.php after successful order placement
            header("Location: manage_orders.php?");
            exit;
        } else {
            $error = "Failed to place order: " . $mysqli->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Checkout - EVANA</title>
<style>
body { font-family: Arial, sans-serif; max-width: 900px; margin: auto; padding: 20px; background: #f9f9f9;}
h1 { text-align: center; }
table { width: 100%; border-collapse: collapse; margin-bottom: 20px; background: white; }
th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }
input, select, textarea { width: 100%; padding: 8px; margin: 6px 0 12px; box-sizing: border-box; }
button { background-color: #28a745; color: white; padding: 12px 20px; border: none; cursor: pointer; font-size: 16px; }
button:hover { background-color: #218838; }
.error { color: red; margin-bottom: 15px; }
fieldset { border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; }
legend { padding: 0 10px; font-weight: bold; }
</style>
<script>
function toggleCreditCardFields() {
    const pm = document.querySelector('input[name="payment_method"]:checked').value;
    document.getElementById('creditcard_fields').style.display = (pm === 'creditcard') ? 'block' : 'none';
}
window.onload = toggleCreditCardFields;
</script>
</head>
<body>

<h1>Checkout</h1>

<?php if ($error): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if (empty($cart_items)): ?>
    <p>Your cart is empty. <a href="shop.php">Go shopping</a></p>
<?php else: ?>

<table>
    <thead>
        <tr>
            <th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cart_items as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td>$<?= number_format($item['price'], 2) ?></td>
            <td><?= intval($item['quantity']) ?></td>
            <td>$<?= number_format($item['subtotal'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr><td colspan="3" style="text-align:right;"><strong>Total:</strong></td><td><strong>$<?= number_format($total_amount, 2) ?></strong></td></tr>
    </tfoot>
</table>

<form method="POST" action="checkout.php">
    <label for="customer_name">Full Name *</label>
    <input type="text" name="customer_name" id="customer_name" required value="<?= htmlspecialchars($_POST['customer_name'] ?? '') ?>">

    <label for="email">Email *</label>
    <input type="email" name="email" id="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

    <label for="address">Address *</label>
    <textarea name="address" id="address" required><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>

    <fieldset>
        <legend>Payment Method</legend>
        <label><input type="radio" name="payment_method" value="cod" onchange="toggleCreditCardFields()" <?= (($_POST['payment_method'] ?? '') !== 'creditcard') ? 'checked' : '' ?>> Cash on Delivery</label><br>
        <label><input type="radio" name="payment_method" value="creditcard" onchange="toggleCreditCardFields()" <?= (($_POST['payment_method'] ?? '') === 'creditcard') ? 'checked' : '' ?>> Credit Card</label>

        <div id="creditcard_fields" style="margin-top:15px; display:none;">
            <label for="cc_number">Card Number *</label>
            <input type="text" name="cc_number" id="cc_number" maxlength="19" placeholder="1234 5678 9012 3456" value="<?= htmlspecialchars($_POST['cc_number'] ?? '') ?>">

            <label for="cc_expiry">Expiry Date (MM/YY) *</label>
            <input type="text" name="cc_expiry" id="cc_expiry" maxlength="5" placeholder="MM/YY" value="<?= htmlspecialchars($_POST['cc_expiry'] ?? '') ?>">

            <label for="cc_cvv">CVV *</label>
            <input type="text" name="cc_cvv" id="cc_cvv" maxlength="4" placeholder="123" value="<?= htmlspecialchars($_POST['cc_cvv'] ?? '') ?>">
        </div>
    </fieldset>

    <button type="submit" name="place_order">Place Order</button>
</form>

<?php endif; ?>

</body>
</html>
