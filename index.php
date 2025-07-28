<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');      // your MySQL username
define('DB_PASSWORD', '');          // your MySQL password
define('DB_NAME', 'e_commerce');

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EVANA SHOPPING</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
    <link
      rel="stylesheet"
      href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    />
    <link rel="stylesheet" href="style.css">
</head>
<style>
    #hero{
        min-width: 100% auto;
    }
</style>
<body>
<section id="header">
    <a href="#"><img src="assets/logo.png" class="logo" alt="EVANA Logo" /></a>

    <div>
        <ul id="navbar">
            <li><a class="active" href="index.php">Home</a></li>
            <li><a href="shop.php">Shop</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="cart.php"><i class="far fa-shopping-bag"></i></a></li>
            <li class="login"><a href="login.php">Login</a></li>
        </ul>
    </div>
</section>


        <div id="mobile">
            <a href="cart.php"><i class="far fa-shopping-bag"></i></a>
            <i id="bar" class="fas fa-outdent"></i>
        </div>
    </section>

    <section id="hero">
        <h4>Trade-in-offer</h4>
        <h2>Super value deals</h2>
        <h1>On all products</h1>
        <p>Save more with coupons &amp; up to 70% off!</p>
        <a href="shop.php"><button>Shop Now</button></a>
    </section>

    <br />

    <section id="feature" class="section-p1">
        <div class="fe-box">
            <img src="assets/features/f1.png" alt="Free Shipping" />
            <h6>Free Shipping</h6>
        </div>
        <div class="fe-box">
            <img src="assets/features/f2.png" alt="Online Order" />
            <h6>Online Order</h6>
        </div>
        <div class="fe-box">
            <img src="assets/features/f3 (1).png" alt="Save Money" />
            <h6>Save Money</h6>
        </div>
        <div class="fe-box">
            <img src="assets/features/f4.png" alt="Promotions" />
            <h6>Promotions</h6>
        </div>
        <div class="fe-box">
            <img src="assets/features/f5.png" alt="Happy Sell" />
            <h6>Happy Sell</h6>
        </div>
        <div class="fe-box">
            <img src="assets/features/f6.png" alt="24/7 Support" />
            <h6>24/7 Support</h6>
        </div>
    </section>

    <section id="product1" class="section-p1">
        <h2>Featured Products</h2>
        <p>Summer Collection new modern Design</p>
        <div class="pro-container">
            <!-- Static product boxes - replace with PHP loop if dynamic -->
            <div class="pro">
                <img src="assets/products/f1.jpg" alt="Cartoon Astronaut T-Shirts" />
                <div class="des">
                    <span>adidas</span>
                    <h5>Cartoon Astronaut T-Shirts</h5>
                    <div class="star">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h4>$78</h4>
                </div>
                <a href="#"><i class="fal fa-shopping-cart cart"></i></a>
            </div>
          
            <div class="pro">
                <img src="assets/products/f2.jpg" alt="Cartoon Astronaut T-Shirts" />
                <div class="des">
                    <span>adidas</span>
                    <h5>Cartoon Astronaut T-Shirts</h5>
                    <div class="star">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h4>$78</h4>
                </div>
                <a href="#"><i class="fal fa-shopping-cart cart"></i></a>
            </div>

            <div class="pro">
                <img src="assets/products/f3.jpg" alt="Cartoon Astronaut T-Shirts" />
                <div class="des">
                    <span>adidas</span>
                    <h5>Cartoon Astronaut T-Shirts</h5>
                    <div class="star">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h4>$78</h4>
                </div>
                <a href="#"><i class="fal fa-shopping-cart cart"></i></a>
            </div>

            <div class="pro">
                <img src="assets/products/f4.jpg" alt="Cartoon Astronaut T-Shirts" />
                <div class="des">
                    <span>adidas</span>
                    <h5>Cartoon Astronaut T-Shirts</h5>
                    <div class="star">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h4>$78</h4>
                </div>
                <a href="#"><i class="fal fa-shopping-cart cart"></i></a>
            </div>

            <div class="pro">
                <img src="assets/products/f5.jpg" alt="Cartoon Astronaut T-Shirts" />
                <div class="des">
                    <span>adidas</span>
                    <h5>Cartoon Astronaut T-Shirts</h5>
                    <div class="star">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h4>$78</h4>
                </div>
                <a href="#"><i class="fal fa-shopping-cart cart"></i></a>
            </div>

            <div class="pro">
                <img src="assets/products/f6.jpg" alt="Cartoon Astronaut T-Shirts" />
                <div class="des">
                    <span>adidas</span>
                    <h5>Cartoon Astronaut T-Shirts</h5>
                    <div class="star">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h4>$78</h4>
                </div>
                <a href="#"><i class="fal fa-shopping-cart cart"></i></a>
            </div>

            <div class="pro">
                <img src="assets/products/f7.jpg" alt="Cartoon Astronaut T-Shirts" />
                <div class="des">
                    <span>adidas</span>
                    <h5>Cartoon Astronaut T-Shirts</h5>
                    <div class="star">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h4>$78</h4>
                </div>
                <a href="#"><i class="fal fa-shopping-cart cart"></i></a>
            </div>

            <div class="pro">
                <img src="assets/products/f8.jpg" alt="Cartoon Astronaut T-Shirts" />
                <div class="des">
                    <span>adidas</span>
                    <h5>Cartoon Astronaut T-Shirts</h5>
                    <div class="star">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h4>$78</h4>
                </div>
                <a href="#"><i class="fal fa-shopping-cart cart"></i></a>
            </div>
        </div>
    </section>

    <!-- Repeat the rest of your sections as-is with the only change for .php extensions -->
    <section id="banner" class="section-m1">
        <h4>Repair Services</h4>
        <h2>Up to <span>70% off</span> All t-shirts &amp; Accessories</h2>
        <button class="normal">Explore More</button>
    </section>

    <section id="product1" class="section-p1">
        <h2>New Arrivals</h2>
        <p>Summer Collection New Modern Design</p>
        <div class="pro-container">
        <div class="pro">
        <img src="assets/products/n1.jpg" alt="">
 <div class="des">
   <span>adidas</span>
   <h5>cartoon Astronaut T-shirts</h5>
   <div class="star">
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
   </div>
   <h4>$78</h4>
 </div>
 <a href="#"><i class="fal fa-shopping-cart cart"></i></a>
       </div>


       <div class="pro">
        <img src="assets/products/n2.jpg" alt="">
 <div class="des">
   <span>adidas</span>
   <h5>cartoon Astronaut T-shirts</h5>
   <div class="star">
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
   </div>
   <h4>$78</h4>
 </div>
 <a href="#"><i class="fal fa-shopping-cart cart"></i></a>
       </div>


       <div class="pro">
        <img src="assets/products/n3.jpg" alt="">
 <div class="des">
   <span>adidas</span>
   <h5>cartoon Astronaut T-shirts</h5>
   <div class="star">
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
   </div>
   <h4>$78</h4>
 </div>
 <a href="#"><i class="fal fa-shopping-cart cart"></i></a>
       </div>

       <div class="pro">
        <img src="assets/products/n4.jpg" alt="">
 <div class="des">
   <span>adidas</span>
   <h5>cartoon Astronaut T-shirts</h5>
   <div class="star">
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
   </div>
   <h4>$78</h4>
 </div>
 <a href="#"><i class="fal fa-shopping-cart cart"></i></a>
       </div>

       <div class="pro">
        <img src="assets/products/n5.jpg" alt="">
 <div class="des">
   <span>adidas</span>
   <h5>cartoon Astronaut T-shirts</h5>
   <div class="star">
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
   </div>
   <h4>$78</h4>
 </div>
 <a href="#"><i class="fal fa-shopping-cart cart"></i></a>
       </div>

       <div class="pro">
        <img src="assets/products/n6.jpg" alt="">
 <div class="des">
   <span>adidas</span>
   <h5>cartoon Astronaut T-shirts</h5>
   <div class="star">
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
   </div>
   <h4>$78</h4>
 </div>
 <a href="#"><i class="fal fa-shopping-cart cart"></i></a>
       </div>

       <div class="pro">
        <img src="assets/products/n7.jpg" alt="">
 <div class="des">
   <span>adidas</span>
   <h5>cartoon Astronaut T-shirts</h5>
   <div class="star">
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
   </div>
   <h4>$78</h4>
 </div>
 <a href="#"><i class="fal fa-shopping-cart cart"></i></a>
       </div>

       <div class="pro">
        <img src="assets/products/n8.jpg" alt="">
 <div class="des">
   <span>adidas</span>
   <h5>cartoon Astronaut T-shirts</h5>
   <div class="star">
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
     <i class="fas fa-star"></i>
   </div>
   <h4>$78</h4>
 </div>
 <a href="#"><i class="fal fa-shopping-cart cart"></i></a>
       </div>

        </div>
    </section>

    <section id="sm-banner" class="section-p1">
        <div class="banner-box">
            <h4>crazy deals</h4>
            <h2>buy 1 get 1 free</h2>
            <span>The best classic dress is on sale at cara</span>
            <button class="white">Learn More</button>
        </div>
        <div class="banner-box banner-box2">
            <h4>Spring/Summer</h4>
            <h2>upcoming season</h2>
            <span>The best classic dress is on sale at cara</span>
            <button class="white">Collection</button>
        </div>
    </section>

    <section id="banner3">
        <div class="banner-box">
            <h2>SEASONAL SALE</h2>
            <h3>Winter Collection -50% OFF</h3>
        </div>
        <div class="banner-box banner-box2">
            <h2>NEW FOOTWEAR COLLECTION</h2>
            <h3>Spring / Summer 2025</h3>
        </div>
        <div class="banner-box banner-box3">
            <h2>T-SHIRTS</h2>
            <h3>New Trendy Prints</h3>
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
