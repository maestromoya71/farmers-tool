<?php
include_once "resource/session.php";
include_once "resource/Database.php";

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Product Details</title>
    <!-- Add your CSS and JS links here -->
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($product['Category']); ?></h1>
        <img src="data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>" alt="Product Image">
        <p><?php echo htmlspecialchars($product['Description']); ?></p>
        <p><strong>Price: $<?php echo htmlspecialchars($product['Price']); ?></strong></p>
    </div>
</body>
</html>