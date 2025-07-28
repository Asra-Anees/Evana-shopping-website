<?php
session_start();

// Connect to database
$mysqli = new mysqli("localhost", "root", "", "e_commerce");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$session_id = session_id();

// Handle quantity update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['update_quantity'], $_POST['cart_id'], $_POST['quantity'])) {
        $cart_id = intval($_POST['cart_id']);
        $quantity = max(1, intval($_POST['quantity']));

        $update = $mysqli->prepare("UPDATE cart_items SET quantity = ? WHERE id = ? AND session_id = ?");
        $update->bind_param("iis", $quantity, $cart_id, $session_id);
        $update->execute();
        $update->close();

        header("Location: cart.php");
        exit();
    }
}

// Handle remove item
if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    $stmt = $mysqli->prepare("DELETE FROM cart_items WHERE id = ? AND session_id = ?");
    $stmt->bind_param("is", $remove_id, $session_id);
    $stmt->execute();
    $stmt->close();

    header("Location: cart.php");
    exit();
}

// Fetch cart items
$sql = "SELECT ci.id AS cart_id, p.id AS product_id, p.name, p.price, p.image, ci.quantity
        FROM cart_items ci
        JOIN shop p ON ci.product_id = p.id
        WHERE ci.session_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $session_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total = 0;
while ($row = $result->fetch_assoc()) {
    $row['subtotal'] = $row['price'] * $row['quantity'];
    $total += $row['subtotal'];
    $cart_items[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>EVANA - Cart</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    section { padding: 20px; }
    table { width: 100%; border-collapse: collapse; background: #fff; }
    th, td { padding: 15px; text-align: center; border-bottom: 1px solid #ddd; }
    th { background-color: #333; color: white; }
    .product-img { width: 60px; }
    .remove-link { color: red; font-size: 1.2em; }
    .checkout-btn {
      background-color: #28a745;
      color: white;
      padding: 12px 20px;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      float: right;
      margin-top: 15px;
      cursor: pointer;
    }
    .checkout-btn:hover {
      background-color: #218838;
    }
    .total {
      text-align: right;
      font-size: 1.2em;
      font-weight: bold;
      padding: 10px 0;
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<section id="header">
  <a href="index.php"><img src="assets/logo.png" class="logo" alt="EVANA Logo"></a>
  <div>
    <ul id="navbar">
      <li><a href="index.php">Home</a></li>
      <li><a href="shop.php">Shop</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li><a class="active" href="cart.php"><i class="far fa-shopping-bag"></i></a></li>
      <li><a href="login.php">Login</a></li>
    </ul>
  </div>
</section>

<!-- PAGE HEADER -->
<section id="page-header">
  <h2>#YourCart</h2>
  <p>View and manage products in your cart</p>
</section>

<!-- CART CONTENT -->
<section id="cart" class="section-p1">
<?php if (empty($cart_items)): ?>
  <p style="text-align:center;">Your cart is empty. <a href="shop.php">Go to Shop</a></p>
<?php else: ?>
  <table>
    <thead>
      <tr>
        <th>Remove</th>
        <th>Image</th>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($cart_items as $item): ?>
      <tr>
        <td><a class="remove-link" href="cart.php?remove=<?= $item['cart_id']; ?>">&times;</a></td>
        <td><img class="product-img" src="assets/products/<?= htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['name']); ?>"></td>
        <td><?= htmlspecialchars($item['name']); ?></td>
        <td>$<?= number_format($item['price'], 2); ?></td>
        <td>
          <form method="post" action="cart.php">
            <input type="hidden" name="cart_id" value="<?= $item['cart_id']; ?>">
            <input type="number" name="quantity" value="<?= $item['quantity']; ?>" min="1" required>
            <input type="hidden" name="update_quantity" value="1">
            <button type="submit">Update</button>
          </form>
        </td>
        <td>$<?= number_format($item['subtotal'], 2); ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div class="total">Total: $<?= number_format($total, 2); ?></div>
  <form action="checkout.php" method="post">
    <input type="hidden" name="cart_total" value="<?= $total; ?>">
    <button type="submit" class="checkout-btn">Proceed to Checkout</button>
  </form>
<?php endif; ?>
</section>

<!-- FOOTER -->
<footer class="section-p1">
  <div class="col">
    <img class="logo" src="assets/logo.png" alt="EVANA Logo">
    <h4>Contact</h4>
    <p><strong>Address:</strong> 562 Colombo Road, Sri Lanka</p>
    <p><strong>Phone:</strong> +94 77 123 4567</p>
    <p><strong>Hours:</strong> 10:00 - 18:00, Mon - Sat</p>
  </div>

  <div class="col">
    <h4>About</h4>
    <a href="about.php">About Us</a>
    <a href="#">Delivery Info</a>
    <a href="#">Privacy Policy</a>
    <a href="#">Terms & Conditions</a>
    <a href="contact.php">Contact Us</a>
  </div>

  <div class="col">
    <h4>My Account</h4>
    <a href="#">Sign In</a>
    <a href="cart.php">View Cart</a>
    <a href="#">My Wishlist</a>
    <a href="#">Track Order</a>
  </div>

  <div class="col install">
     <h4>Install App</h4>
      <p>From App Store or Google Play</p>
      <div class="row">
        <img src="assets/pay/app.jpg" alt="">
        <img src="assets/pay/play.jpg" alt="">
      </div>
      <p>Secured Payment Gateways</p>
      <img src="assets/pay/pay.png" alt="">
  </div>
  <div class="copyright">
    <p>&copy; 2025 EVANA. All rights reserved.</p>
  </div>
</footer>

</body>
</html>cart.php page has no table show 