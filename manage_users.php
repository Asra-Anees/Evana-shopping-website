<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "evana");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete user
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM user1 WHERE id = $id");
    header("Location: manage_users.php");
    exit();
}

// Fetch users
$result = $conn->query("SELECT * FROM user1 ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Manage Users - EVANA Admin</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background: #f9f9f9;
    padding: 20px;
    margin: 0;
  }
  h1 {
    text-align: center;
    margin-bottom: 20px;
  }
  .table-wrapper {
    overflow-x: auto;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    background: white;
    border-radius: 8px;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    min-width: 700px; /* To enable horizontal scroll on smaller screens */
  }
  th, td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: left;
    white-space: nowrap;
  }
  th {
    background: #f0f0f0;
  }
  a.delete-btn {
    color: #d9534f;
    text-decoration: none;
    font-weight: bold;
    padding: 6px 12px;
    border: 1px solid #d9534f;
    border-radius: 4px;
    display: inline-block;
  }
  a.delete-btn:hover {
    background-color: #d9534f;
    color: white;
  }
  /* Responsive tweaks */
  @media (max-width: 768px) {
    body {
      padding: 10px;
    }
    h1 {
      font-size: 1.5rem;
    }
  }
</style>
</head>
<body>

<h1>Customer Management - EVANA</h1>

<div class="table-wrapper">
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Registered</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= htmlspecialchars($row['address']) ?></td>
            <td><?= $row['created_at'] ?></td>
            <td>
              <a href="?delete=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="7" style="text-align:center;">No customers found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

</body>
</html>
