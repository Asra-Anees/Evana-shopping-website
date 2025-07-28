<?php
session_start();

// Destroy all session data to log out user
$_SESSION = [];
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Logged Out</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f0f2f5;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .logout-container {
      background: #fff;
      padding: 40px 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      max-width: 600px;
      width: 90%;
      text-align: center;
    }
    .logout-container h1 {
      color: #28a745;
      margin-bottom: 20px;
    }
    .logout-container p {
      font-size: 18px;
      margin-bottom: 30px;
      color: #555;
    }
    .logout-container a {
      text-decoration: none;
      font-weight: 600;
      color: #fff;
      background-color: #28a745;
      padding: 12px 25px;
      border-radius: 6px;
      display: inline-block;
      transition: background-color 0.3s ease;
    }
    .logout-container a:hover {
      background-color: #218838;
    }
    @media (max-width: 480px) {
      .logout-container {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>

  <div class="logout-container">
    <h1>Logged Out</h1>
    <p>You have successfully logged out.</p>
    <a href="login.php">Login Again</a>
  </div>

</body>
</html>
