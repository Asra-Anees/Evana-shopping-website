<?php
// blog.php

$conn = new mysqli("localhost", "root", "", "e_commerce");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$blogs = $conn->query("SELECT * FROM blogs ORDER BY date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVANA SHOPPING</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<section id="header">
        <a href="#"><img src="assets/logo.png" class="logo" alt=""></a>
               
               
              <div>
                <ul id="navbar">
                  <li><a href="index.php">Home</a></li>
                  <li><a href="shop.php">Shop</a></li>
                  <li><a class="active" href="blog.php">Blog</a></li>
                  <li><a href="about.php">About</a></li>
                  <li><a href="contact.php">Contact</a></li>
                  <li><a href="card.php"><i class="far fa-shopping-bag"></i></a></li>
                  <li><a href="login.php">Login</a></li>
              </ul>
        
               <div id="mobile">
                <a href="card.php"><i class="far fa-shopping-bag"></i></a>
                <i id="bar" class="fas fa-outdent"></i>
              </div>
        </section>


<section id="page-header" class="blog-header">
    <h2>#readmore</h2>
    <p>Read all case studies about our products!</p>
</section>

<section id="blog">
    <?php while ($row = $blogs->fetch_assoc()): ?>
    <div class="blog-box">
        <div class="blog-img">
     
        <img src="assets/blogs/<?= htmlspecialchars($row['image']) ?>" alt="">

        </div>
        <div class="blog-details">
            <h4><?= htmlspecialchars($row['title']) ?></h4>
            <p><?= htmlspecialchars($row['content']) ?></p>
            <a href="#">CONTINUE READING</a>
        </div>
        <h1><?= date("d/m", strtotime($row['date'])) ?></h1>
    </div>
    <?php endwhile; ?>
</section>


<section id="pagination" class="section-p1">
    <a href="#">1</a>
    <a href="#">2</a>
    <a href="#"><i class="fal fa-long-arrow-alt-right"></i></a>
</section>


<section id="newsletter" class="section-p1" >
                <div>
            <h4>Sign Up For Newsletter</h4>
            <p>Get E-mail updates about our latest shop and <span>special offers</span></p>
                </div>
                <div class="form">
                    <input type="text" placeholder="Your email address">
                    <button class="normal"> Sign up</button>
                </div>
               </section>
            

              <footer class="section-p1">
  <div class="col">
    <img   class="logo" src="assets/logo.png" alt="">
    <h4>Contact</h4>
    <p><strong>Address:</strong>122 Dehiwala Road, Street 32, colombo</p>
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
        <img src="assets/pay/app.jpg" alt="">
        <img src="assets/pay/play.jpg" alt="">
      </div>
      <p>Secured Payment Gateways</p>
      <img src="assets/pay/pay.png" alt="">
  </div>

  <div class="copyright">
    <p>@ 2021, Tech2 etc -HTML CSS Ecommerce Templates</p>
  </div>
</footer>

<script src="script.js"></script>
</body>
</html>
