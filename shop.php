<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "e_commerce");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Add product to cart when form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $session_id = session_id();

    // Check if product already in cart
    $stmt = $mysqli->prepare("SELECT id, quantity FROM cart_items WHERE session_id = ? AND product_id = ?");
    $stmt->bind_param("si", $session_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update quantity
        $row = $result->fetch_assoc();
        $new_quantity = $row['quantity'] + 1;
        $update = $mysqli->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
        $update->bind_param("ii", $new_quantity, $row['id']);
        $update->execute();
        $update->close();
    } else {
        // Insert new cart item
        $insert = $mysqli->prepare("INSERT INTO cart_items (session_id, product_id, quantity) VALUES (?, ?, 1)");
        $insert->bind_param("si", $session_id, $product_id);
        $insert->execute();
        $insert->close();
    }

    $stmt->close();

    // Redirect to cart page after adding product
    header("Location: cart.php");
    exit();
}

// Fetch all products from shop table
$result = $mysqli->query("SELECT * FROM shop");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Shop - EVANA</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<section id="header">
    <a href="#"><img src="assets/logo.png" class="logo" alt="EVANA"></a>
    <div>
        <ul id="navbar">
            <li><a href="index.php">Home</a></li>
            <li><a class="active" href="shop.php">Shop</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li id="lg-bag"><a href="cart.php"><i class="far fa-shopping-bag"></i></a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </div>
</section>


<section id="page-header" class="about-header">
  <h2>#let's_talk</h2>
  <p>LEAVE A MESSAGE, We love to hear from you!</p>
</section>


<section id="product1" class="section-p1">
    <div class="pro-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="pro">
                <img src="assets/products/<?= htmlspecialchars($row['image']); ?>" alt="<?= htmlspecialchars($row['name']); ?>" />
                <div class="des">
                    <span><?= htmlspecialchars($row['brand']); ?></span>
                    <h5><?= htmlspecialchars($row['name']); ?></h5>
                    <div class="star">
                        <?php 
                        $rate = (int)$row['rate']; 
                        for ($i = 1; $i <= 5; $i++) {
                            echo $i <= $rate ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                        }
                        ?>
                    </div>
                    <h4>$<?= htmlspecialchars($row['price']); ?></h4>
                </div>
                <form method="post" action="shop.php" class="add-to-cart-form">
                    <input type="hidden" name="product_id" value="<?= $row['id']; ?>">
                    <button type="submit" style="background: none; border: none; cursor: pointer;">
                        <i class="fal fa-shopping-cart cart"></i>
                    </button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<section id="newsletter" class="section-p1">
        <div>
            <h4>Sign Up For Newsletter</h4>
            <p>Get E-mail updates about our latest shop and <span>special offers</span></p>
        </div>
        <div class="form">
            <input type="text" placeholder="Your email address" />
            <button class="normal">Sign up</button>
        </div>
    </section>

<footer class="section-p1">
        <div class="col">
            <img class="logo" src="assets/logo.png" alt="EVANA Logo" />
            <h4>Contact</h4>
            <p><strong>Address:</strong> 122 Dehiwala Road, Street 32, Colombo</p>
            <p><strong>Hours:</strong> 08.30 - 18.00, Mon-Sat</p>
            <div class="Follow">
                <h4>Follow Us</h4>
                <div class="icon">
                    <i class="fab fa-facebook-f"></i>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-pinterest-p"></i>
                    <i class="fab fa-youtube"></i>
                </div>
            </div>
        </div>

        <div class="col">
            <h4>About</h4>
            <a href="#">About Us</a>
            <a href="#">Delivery Information</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms & Conditions</a>
            <a href="#">Contact Us</a>
        </div>

        <div class="col">
            <h4>My Account</h4>
            <a href="#">Sign In</a>
            <a href="#">View Cart</a>
            <a href="#">Track My Order</a>
            <a href="#">Helps</a>
        </div>

        <div class="col install">
            <h4>Install App</h4>
            <p>From App Store or Google Play</p>
            <div class="row">
                <img src="assets/pay/app.jpg" alt="App Store" />
                <img src="assets/pay/play.jpg" alt="Google Play" />
            </div>
            <p>Secured Payment Gateways</p>
            <img src="assets/pay/pay.png" alt="Payment Gateways" />
        </div>

        <div class="copyright">
            <p>@ 2021, Tech2 etc - HTML CSS E-commerce Website Design</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
