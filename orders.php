<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "evana";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Delete order if requested
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM orders WHERE id = $id");
    header("Location: orders.php");
    exit();
}

// Fetch all orders
$result = $conn->query("SELECT * FROM orders ORDER BY order_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin - Orders</title>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 30px;
      background: #f0f4f8;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    table {
      border-collapse: collapse;
      width: 100%;
      background: #fff;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: left;
    }
    th {
      background-color: #10b981;
      color: white;
    }
    tr:hover {
      background-color: #f9f9f9;
    }
    .delete-btn {
      color: red;
      text-decoration: none;
    }
    .delete-btn:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
<section id="header">
        <a href="#"><img src="assets/logo.png" class="logo" alt=""></a>
               
               
              <div>
                <ul id="navbar">
                  <li><a href="index.php">Home</a></li>
                  <li><a href="shop.php">Shop</a></li>
                  <li><a href="blog.php">Blog</a></li>
                  <li><a href="about.php">About</a></li>
                  <li><a href="contact.php">Contact</a></li>
                  <li><a href="card.php"><i class="far fa-shopping-bag"></i></a></li>
              </ul>
        
               <div id="mobile">
                <a href="card.php"><i class="far fa-shopping-bag"></i></a>
                <i id="bar" class="fas fa-outdent"></i>
              </div>
        </section>
  <h2>🛒 All Customer Orders</h2>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Product</th>
        <th>Size</th>
        <th>Name</th>
        <th>Email</th>
        <th>Address</th>
        <th>Contact</th>
        <th>Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['product']) ?></td>
            <td><?= $row['size'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['address']) ?></td>
            <td><?= htmlspecialchars($row['contact']) ?></td>
            <td><?= $row['order_date'] ?></td>
            <td>
              <a class="delete-btn" href="orders.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this order?')">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="9" style="text-align:center;">No orders found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

</body>
</html>
