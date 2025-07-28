const bar= document.getElementById('bar');
const close= document.getElementById('close');
const nav= document.getElementById('navbar');

if (bar) {
    bar.addEventListener('click', () => {
        nav.classList.add('active')
    });
}

if (close) {
    close.addEventListener('click', () => {
        nav.classList.remove('active')
    });
}



// Get the current URL
const currentLocation = window.location.pathname;
const navLinks = document.querySelectorAll('#navbar a');

navLinks.forEach(link => {
    // Check if the link's href matches the current URL
    if (link.href === window.location.href) {
        link.classList.add('active'); // Add active class to the current link
    }
});


function submitNewsletter() {
    const emailInput = document.getElementById('newsletter-email');
    const email = emailInput.value.trim();
  
    if (email === "") {
      alert("⚠️ Please enter your email address.");
    } else if (!validateEmail(email)) {
      alert("❌ Please enter a valid email address.");
    } else {
      alert("✅ Thank you for signing up, " + email + "!");
      emailInput.value = ""; // clear input
    }
  }
  
  function validateEmail(email) {
    // Basic email validation pattern
    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return pattern.test(email);
  }

  
  
  function applyCoupon() {
    const code = document.getElementById("coupon-code").value.trim();
    if (code === "") {
      alert("Please enter a coupon code.");
    } else if (code.toLowerCase() === "evana10") {
      alert("🎉 Coupon applied! You get 10% off.");
      // You can apply logic here to update prices
    } else {
      alert("❌ Invalid coupon code.");
    }
}

  function proceedToCheckout() {
    // Redirect to a checkout page or display a message
    window.location.href = "checkout.html"; // Create this page
    // OR
    // alert("Redirecting to secure checkout...");
  }


  

  