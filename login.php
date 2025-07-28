<?php
session_start();

$message = ""; // For error messages

// Database connection settings
$servername = "localhost";
$username = "root";      // Your DB username
$password = "";          // Your DB password
$dbname = "e_commerce";       // Your DB name

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to database
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get and sanitize inputs
    $user = trim($_POST['username']);
    $pass = $_POST['password'];

    // Prepare and execute query to fetch user data
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $role);
        $stmt->fetch();

        // Verify password
        if (password_verify($pass, $hashed_password)) {
            // Set session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $user;
            $_SESSION['role'] = $role;

            // Redirect based on role
            if ($role === 'admin') {
                header("Location: admin_dashboard.php");
                exit();
            } else {
                header("Location: index.php");
                exit();
            }
        } else {
            $message = "Invalid password.";
        }
    } else {
        $message = "User not found.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Login - EVANA</title>
<style>
  /* Simple styling */
  body {
    font-family: Arial, sans-serif;
    background: url("assets/a8.jpg");
    background-size: cover;
    background-repeat: no-repeat;
    display: flex;
    height: 100vh;
    justify-content: center;
    align-items: center;
  }
  .login-container {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 0 10px #ccc;
    width: 320px;
  }
  h2 {
    text-align: center;
    margin-bottom: 1.5rem;
  }
  input[type=text], input[type=password] {
    width: 100%;
    padding: 10px;
    margin-bottom: 1rem;
    border-radius: 5px;
    border: 1px solid #ccc;
  }
  button {
    width: 100%;
    padding: 10px;
    background: #088178;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
  }
  button:hover {
    background: #066b63;
  }
  .message {
    color: red;
    margin-bottom: 1rem;
    text-align: center;
  }
  .signup-link {
    text-align: center;
    margin-top: 1rem;
  }
  .signup-link a {
    color: #088178;
    text-decoration: none;
  }
</style>
</head>
<body>
  <div class="login-container">
    <h2>Login to EVANA</h2>
    <?php if ($message): ?>
      <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form method="POST" action="login.php">
      <input type="text" name="username" placeholder="Username" required autofocus />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit">Log In</button>
    </form>
    <p class="signup-link">
      Don't have an account? <a href="signup.php">Sign Up</a>
    </p>
  </div>
</body>
</html>


