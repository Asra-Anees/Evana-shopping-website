<?php
$conn = new mysqli("localhost", "root", "", "e_commerce");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle AJAX delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    // If you have foreign keys with cascade, this will handle properly; otherwise delete dependents first.
    $conn->query("DELETE FROM order_items WHERE product_id = $id");
    if ($conn->query("DELETE FROM shop WHERE id = $id")) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
    exit();
}

// Handle Add Product form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $brand = $conn->real_escape_string($_POST['brand']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']);
    $rate = intval($_POST['rate']);

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imgTmp = $_FILES['image']['tmp_name'];
        $imgName = basename($_FILES['image']['name']);
        $ext = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($ext, $allowed)) {
            $newFileName = uniqid('prod_', true) . '.' . $ext;
            $destPath = __DIR__ . "/assets/products/" . $newFileName;

            if (move_uploaded_file($imgTmp, $destPath)) {
                // Insert product to DB
                $stmt = $conn->prepare("INSERT INTO shop (name, brand, description, price, rate, image) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssdis", $name, $brand, $description, $price, $rate, $newFileName);
                $stmt->execute();
                $stmt->close();
            } else {
                $error = "Failed to move uploaded image.";
            }
        } else {
            $error = "Invalid image type. Allowed: jpg, jpeg, png, gif.";
        }
    } else {
        $error = "Image upload error or no image selected.";
    }
}

// Fetch all products
$result = $conn->query("SELECT * FROM shop ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Manage Products - EVANA Admin</title>
<style>
  body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: url("assets/a13.jpg");
background-size: cover; background-repeat: no-repeat; }
  h1 { text-align: center; margin-bottom: 20px; color: #fff;}
  .container { max-width: 1200px; margin: auto; }
  form { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 30px; }
  form input, form textarea, form select, form button {
    display: block; width: 100%; padding: 8px; margin-bottom: 15px; border-radius: 4px; border: 1px solid #ccc; font-size: 1rem;
  }
  form input[type="file"] { padding: 3px; }
  form button {
    background-color: #28a745; color: white; border: none; cursor: pointer; font-weight: bold;
  }
  form button:hover { background-color: #218838; }
  .error { color: red; margin-bottom: 15px; }

  .table-wrapper { overflow-x: auto; background: white; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
  table { width: 100%; border-collapse: collapse; min-width: 700px; }
  th, td { padding: 12px 15px; border: 1px solid #ddd; text-align: left; white-space: nowrap; }
  th { background: #f0f0f0; }
  img { max-width: 80px; max-height: 80px; object-fit: cover; border-radius: 4px; }
  button.delete-btn {
    background-color: #d9534f; color: white; border: none; padding: 6px 12px;
    border-radius: 4px; cursor: pointer; font-weight: bold;
  }
  button.delete-btn:hover {
    background-color: #c9302c;
  }

  /* Remove arrows on price input */
  input[type=number]::-webkit-inner-spin-button, 
  input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
  input[type=number] { -moz-appearance:textfield; }

  /* Responsive */
  @media (max-width: 768px) {
    body { padding: 10px; }
    h1 { font-size: 1.5rem; }
    th, td { white-space: normal; }
  }
</style>
</head>
<body>

<div class="container">
  <h1>Manage Products - EVANA</h1>

  <?php if (!empty($error)): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <!-- Add Product Form -->
  <form method="post" enctype="multipart/form-data" id="add-product-form">
    <h2>Add New Product</h2>
    <input type="text" name="name" placeholder="Product Name" required />
    <input type="text" name="brand" placeholder="Brand" required />
    <textarea name="description" placeholder="Description" rows="3" required></textarea>
    <input type="number" name="price" placeholder="Price ($)" step="0.01" min="0" required />
    <select name="rate" required>
      <option value="">Select Rating</option>
      <option value="1">1 star</option>
      <option value="2">2 stars</option>
      <option value="3">3 stars</option>
      <option value="4">4 stars</option>
      <option value="5">5 stars</option>
    </select>
    <input type="file" name="image" accept="image/*" required />
    <button type="submit" name="add_product">Add Product</button>
  </form>

  <!-- Products Table -->
  <div class="table-wrapper">
    <table id="products-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Image</th>
          <th>Name</th>
          <th>Brand</th>
          <th>Description</th>
          <th>Price ($)</th>
          <th>Rate</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr data-id="<?= $row['id'] ?>">
              <td><?= $row['id'] ?></td>
              <td><img src="assets/products/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" /></td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['brand']) ?></td>
              <td><?= htmlspecialchars($row['description']) ?></td>
              <td><?= number_format($row['price'], 2) ?></td>
              <td><?= htmlspecialchars($row['rate']) ?></td>
              <td><button class="delete-btn" onclick="deleteProduct(<?= $row['id'] ?>)">Delete</button></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="8" style="text-align:center;">No products found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  function deleteProduct(id) {
    if (!confirm("Are you sure you want to delete this product?")) return;

    fetch('manage_products.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: 'delete_id=' + id
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // Remove row without reload
        const row = document.querySelector('tr[data-id="' + id + '"]');
        if (row) row.remove();
      } else {
        alert('Error deleting product: ' + (data.error || 'Unknown error'));
      }
    })
    .catch(err => alert('Fetch error: ' + err));
  }
</script>

</body>
</html>
