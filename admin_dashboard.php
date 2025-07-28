<?php
session_start();

// Redirect if not logged in as admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard - EVANA SHOPPING</title>
  <style>
    /* Reset */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      display: flex;
      min-height: 100vh;
      background: #f5f7fa;
      color: #333;
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
      background: #088178;
      color: white;
      display: flex;
      flex-direction: column;
      padding: 1.5rem;
    }

    .sidebar h2 {
      margin-bottom: 2rem;
      font-weight: 700;
      letter-spacing: 2px;
      font-size: 1.5rem;
      text-align: center;
      text-transform: uppercase;
    }

    .sidebar a {
      padding: 1rem 1.2rem;
      margin-bottom: 1rem;
      color: white;
      text-decoration: none;
      font-weight: 600;
      border-radius: 6px;
      transition: background 0.3s ease;
    }

    .sidebar a:hover {
      background: #066b63;
    }

    /* Main content */
    .main-content {
      flex-grow: 1;
      padding: 2.5rem;
      background: white;
      border-radius: 0 12px 12px 0;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }

    .main-content h1 {
      margin-bottom: 1rem;
      color: #088178;
      font-weight: 700;
    }     
    .stats {
      display: flex;
      gap: 2rem;
      margin-top: 2rem;
    }

    .card {
      flex: 1;
      background: #e0f2f1;
      border-radius: 10px;
      padding: 1.5rem;
      text-align: center;
      box-shadow: 0 3px 6px rgba(0,0,0,0.1);
      transition: transform 0.2s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 15px rgba(0,0,0,0.15);
    }

    .card h3 {
      font-size: 2.2rem;
      margin-bottom: 0.5rem;
      color: #00796b;
    }

    .card p {
      font-weight: 600;
      color: #004d40;
    }

    /* Logout button */
    .logout-btn {
      margin-top: auto;
      padding: 1rem 1.2rem;
      background: #b71c1c;
      text-align: center;
      border-radius: 6px;
      color: white;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      transition: background 0.3s ease;
    }

    .logout-btn:hover {
      background: #7f0000;
    }

    /* Responsive */
    @media(max-width: 768px) {
      body {
        flex-direction: column;
      }
      .sidebar {
        width: 100%;
        flex-direction: row;
        overflow-x: auto;
      }
      .sidebar a, .logout-btn {
        flex: 1;
        margin: 0 0.5rem;
        padding: 0.8rem;
        font-size: 0.9rem;
        text-align: center;
      }
      .main-content {
        border-radius: 0;
        padding: 1.5rem;
      }
      .stats {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>

  <nav class="sidebar">
    <h2>EVANA Admin</h2>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="manage_products.php">Manage Products</a>
    <a href="manage_orders.php">Manage Orders</a>
    <a href="logout.php" class="logout-btn">Logout</a>
  </nav>

  <main class="main-content">
    <h1>Welcome, Admin!</h1>
    <p>Here is a quick overview of your site status.</p>

    <section class="stats">
      <div class="card">
        <h3>16</h3>
        <p>Products</p>
      </div>
      <div class="card">
        <h3>0</h3>
        <p>Orders</p>
      </div>
      <div class="card">
        <h3>0</h3>
        <p>Users</p>
      </div>
    </section>
  </main>

</body>
</html>
