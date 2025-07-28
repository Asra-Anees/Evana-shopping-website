<?php
// Connect to MySQL
$conn = new mysqli("localhost", "root", "", "e_commerce");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
$success = $error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO contact_messages (name, email, subject, message) 
            VALUES ('$name', '$email', '$subject', '$message')";

    if ($conn->query($sql)) {
        $success = "Message sent successfully!";
    } else {
        $error = "Failed to send message.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EVANA SHOPPING - Contact</title>
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
      <li><a href="about.php">About</a></li>
      <li><a class="active" href="contact.php">Contact</a></li>
      <li><a href="cart.php"><i class="far fa-shopping-bag"></i></a></li>
      <li><a href="login.php">Login</a></li>
    </ul>
  </div>
  <div id="mobile">
    <a href="cart.php"><i class="far fa-shopping-bag"></i></a>
    <i id="bar" class="fas fa-outdent"></i>
  </div>
</section>

<section id="page-header" class="about-header">
  <h2>#let's_talk</h2>
  <p>LEAVE A MESSAGE, We love to hear from you!</p>
</section>

<section id="contact-details" class="section-p1">
  <div class="details">
    <span>GET IN TOUCH</span>
    <h2>Visit one of our agency locations or contact us today</h2>
    <h3>Head Office</h3>
    <div>
      <li><i class="fal fa-map"></i> <p>56 Dehiwala Street, Pettah, Colombo</p></li>
      <li><i class="fal fa-envelope"></i> <p>contact@example.com</p></li>
      <li><i class="fal fa-phone-alt"></i> <p>+94 77 123 4567</p></li>
      <li><i class="fal fa-clock"></i> <p>Monday to Saturday: 9.00am to 4.00pm</p></li>
    </div>
  </div>

  <div class="map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126740.4413234949!2d79.96797042193647!3d6.933703218098522!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2596309dfdd3f%3A0x45a4b0e7834ac0d4!2sUniversity%20of%20Colombo!5e0!3m2!1sen!2slk!4v1745126069232!5m2!1sen!2slk" 
            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
  </div>
</section>

<section id="form-details">
  <form action="" method="POST">
    <span>LEAVE A MESSAGE</span>
    <h2>We love to hear from you</h2> 

    <?php if ($success): ?>
      <p style="color:green;"><?php echo $success; ?></p>
    <?php elseif ($error): ?>
      <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <input type="text" name="name" placeholder="Your Name" required>     
    <input type="email" name="email" placeholder="E-mail" required>  
    <input type="text" name="subject" placeholder="Subject" required> 
    <textarea name="message" cols="30" rows="10" placeholder="Your Message" required></textarea>
    <button class="normal" type="submit">Submit</button>  
  </form>

  <div class="people">
    <div>
      <img src="assets/people/1.png" alt="">
      <p><span>John Deo</span> Senior Marketing Manager<br>Phone: +000 123 000 77 88<br>Email: contact@example.com</p>
    </div>
    <div>
      <img src="assets/people/2.png" alt="">
      <p><span>William Smith</span> Senior Marketing Manager<br>Phone: +000 123 000 77 88<br>Email: contact@example.com</p>
    </div>
    <div>
      <img src="assets/people/3.png" alt="">
      <p><span>Emma Stone</span> Senior Marketing Manager<br>Phone: +000 123 000 77 88<br>Email: contact@example.com</p>
    </div>
  </div>
</section>

<section id="newsletter" class="section-p1">
  <div>
    <h4>Sign Up For Newsletter</h4>
    <p>Get E-mail updates about our latest shop and <span>special offers</span></p>
  </div>
  <div class="form">
    <input type="text" placeholder="Your email address">
    <button class="normal">Sign up</button>
  </div>
</section>

<footer class="section-p1">
  <div class="col">
    <img class="logo" src="assets/logo.png" alt="">
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
      <img src="assets/pay/app.jpg" alt="">
      <img src="assets/pay/play.jpg" alt="">
    </div>
    <p>Secured Payment Gateways</p>
    <img src="assets/pay/pay.png" alt="">
  </div>

  <div class="copyright">
    <p>@ 2021, Tech2 etc - HTML CSS Ecommerce Templates</p>
  </div>
</footer>

<script src="script.js"></script>
</body>
</html>
