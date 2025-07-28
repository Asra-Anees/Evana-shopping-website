<?php
// sproduct.php
$conn = new mysqli("localhost", "root", "", "evana");

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM sproduct WHERE id = $id");

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Product not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $row['name']; ?> - Product</title>
</head>
<body>
    <h2><?php echo $row['name']; ?></h2>
    <img src="uploads/<?php echo $row['image']; ?>" width="300"><br>
    <strong>Price:</strong> $<?php echo $row['price']; ?><br>
    <strong>Rating:</strong> <?php echo str_repeat("⭐", $row['rating']); ?><br>
    <p><?php echo $row['description']; ?></p>
    <p><strong>Category:</strong> <?php echo $row['category']; ?></p>
</body>
</html>
