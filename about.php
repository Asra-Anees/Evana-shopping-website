<?php
// Database connection
$host = 'localhost';
$user = 'root';
$pass = ''; // Your DB password
$dbname = 'e_commerce'; // Your DB name

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch About content
$sql = "SELECT * FROM about_content WHERE id = 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $about = $result->fetch_assoc();
} else {
    $about = [
        'title' => 'Default Title',
        'description' => 'Default description goes here.',
        'image' => 'assets/about/default.jpg'
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EVANA SHOPPING - About Us</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <section id="header">
        <a href="#"><img src="assets/logo.png" class="logo" alt="EVANA Logo" /></a>

        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a class="active" href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="card.php"><i class="far fa-shopping-bag"></i></a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
            <div id="mobile">
                <a href="card.php"><i class="far fa-shopping-bag"></i></a>
                <i id="bar" class="fas fa-outdent"></i>
            </div>
        </div>
    </section>

    <section id="page-header" class="about-header">
        <h2>#knowUS</h2>
        <p>Learn more about our journey and mission</p>
    </section>

    <section id="about-head" class="section-p1">
        <img src="<?php echo htmlspecialchars($about['image']); ?>" alt="About Image" />
        <div>
            <h2><?php echo htmlspecialchars($about['title']); ?></h2>
            <p><?php echo nl2br(htmlspecialchars($about['description'])); ?></p>

            <abbr title="Image creation modes">
                Create stunning images with as much or as little control as you like thanks to a choice of Basic and Creative modes.
            </abbr>

            <br /><br />

            <marquee bgcolor="#ccc" loop="-1" scrollamount="5" width="100%">
                Fashion for every mood, moment, and movement — only at EVANA.
            </marquee>
        </div>
    </section>

    <section id="about-app" class="section-p1">
        <h1>Download Our <a href="#">App</a></h1>
        <div class="video">
            <video autoplay muted loop src="assets/about/1.mp4"></video>
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
            <p>@ 2021, Tech2 etc - HTML CSS Ecommerce Templates</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>

<?php $conn->close(); ?>
