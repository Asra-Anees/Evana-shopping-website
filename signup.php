<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "evana"; // Update if different

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $contact = trim($_POST["contact"]);
    $user_type = "customer"; // Default
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $message = "❌ Passwords do not match.";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM user1 WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "❌ Email is already registered.";
        } else {
            $stmt->close();

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO user1 (username, email, contact, user_type, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $username, $email, $contact, $user_type, $hashed_password);

            if ($stmt->execute()) {
                header("Location: index.php");
                exit();
            } else {
                $message = "❌ Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign Up</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url("assets/a10.jpg") no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .signup-form {
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      max-width: 500px;
      width: 100%;
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }

    .message {
      text-align: center;
      font-weight: bold;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <div class="signup-form">
    <h3 class="text-center mb-4">Create an Account</h3>

    <?php if (!empty($message)): ?>
      <div class="message alert alert-warning"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="mb-3">
        <input type="text" name="username" class="form-control" placeholder="Username" required />
      </div>
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email" required />
      </div>
      <div class="mb-3">
        <input type="text" name="contact" class="form-control" placeholder="Contact Number" />
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required />
      </div>
      <div class="mb-3">
        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required />
      </div>
      <button type="submit" class="btn btn-success w-100">Sign Up</button>
    </form>
    <p class="mt-3 text-center">Already have an account? <a href="index.php">Login</a></p>
  </div>
</body>
</html>
