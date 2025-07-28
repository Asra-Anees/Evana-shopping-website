<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "e_commerce");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Delete Order
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $order_id = intval($_GET['delete']);
    $stmt = $mysqli->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_orders.php?deleted=1");
    exit;
}

// Auto-cycle Order Status
if (isset($_GET['change_status']) && is_numeric($_GET['change_status'])) {
    $order_id = intval($_GET['change_status']);

    $stmt = $mysqli->prepare("SELECT order_status FROM orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->bind_result($current_status);
    $stmt->fetch();
    $stmt->close();

    // Determine next status
    $status_cycle = ['Pending', 'Processing', 'Completed', 'Cancelled'];
    $index = array_search($current_status, $status_cycle);
    $new_status = $status_cycle[($index + 1) % count($status_cycle)];

    $stmt = $mysqli->prepare("UPDATE orders SET order_status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $order_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_orders.php?status_changed=1");
    exit;
}

// Fetch Orders
$result = $mysqli->query("SELECT * FROM orders ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Orders - EVANA</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background: url("assets/a15.jpg");
      background-size: cover;
      background-repeat: no-repeat;
    }
    h1 {
      text-align: center;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: center;
    }
    th {
      background: #333;
      color: white;
    }
    .btn {
      padding: 6px 12px;
      border: none;
      cursor: pointer;
      border-radius: 4px;
    }
    .btn-delete {
      background-color: #dc3545;
      color: white;
    }
    .btn-status {
      background-color: #007bff;
      color: white;
    }
  </style>
</head>
<body>

<h1>Manage Orders</h1>

<?php if (isset($_GET['deleted'])): ?>
  <p style="color: green;">Order deleted successfully.</p>
<?php endif; ?>
<?php if (isset($_GET['status_changed'])): ?>
  <p style="color: green;">Order status changed successfully.</p>
<?php endif; ?>

<?php if ($result->num_rows > 0): ?>
<table>
  <tr>
    <th>ID</th>
    <th>Customer</th>
    <th>Email</th>
    <th>Address</th>
    <th>Total</th>
    <th>Payment Method</th>
    <th>Payment Status</th>
    <th>Order Status</th>
    <th>Change Status</th>
    <th>Delete</th>
  </tr>
  <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['customer_name']) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= nl2br(htmlspecialchars($row['address'])) ?></td>
      <td>$<?= number_format($row['total_amount'], 2) ?></td>
      <td><?= htmlspecialchars($row['payment_method']) ?></td>
      <td><?= htmlspecialchars($row['payment_status']) ?></td>
      <td><strong><?= htmlspecialchars($row['order_status']) ?></strong></td>
      <td>
        <a href="manage_orders.php?change_status=<?= $row['id'] ?>">
          <button class="btn btn-status">Change Status</button>
        </a>
      </td>
      <td>
        <a href="manage_orders.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this order?');">
          <button class="btn btn-delete">Delete</button>
        </a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>
<?php else: ?>
  <p>No orders found.</p>
<?php endif; ?>

</body>
</html>
