<?php
include 'conf.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch product details based on ID
$productID = $_GET['id'];
$sql = "SELECT productID, name, description, price, quantity FROM product WHERE productID = '$productID'";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

// Handle product update
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $updateSql = "UPDATE product SET name='$name', description='$description', price='$price', quantity='$quantity' WHERE productID='$productID'";
    if ($conn->query($updateSql) === TRUE) {
        echo "<script>alert('Product updated successfully!'); window.location.href='viewproduct.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="upp.css">
    <link rel="stylesheet" href="dasboard.css">
    <script src="cusdash.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>Dashboard</h2>
                <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
            </div>
            <ul class="sidebar-menu">
                <li><a href="pmdash.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
                <li><a href="pprofile.php"><i class="fas fa-user"></i><span> Profile</span></a></li>
                <li><a href="proddash1.html"><i class="fas fa-box-open"></i><span> Products</span></a></li>
                <li><a href="ptask.php"><i class="fas fa-tasks"></i><span> Tasks</span></a></li>
                <li><a href="viewshedual.php"><i class="fas fa-calendar-alt"></i><span> Schedules</span></a></li>
                <li><a href="resdash.html"><i class="fas fa-cogs"></i><span> Resources</span></a></li>
                <li><a href="pmreport.html"><i class="fas fa-chart-bar"></i><span> Reports</span></a></li>
                <li><a href="slogin.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Update Product</h1>
            </header>

            <!-- Update Product Form -->
            <div class="form-container">
                <form method="POST" action="">
                    <label for="name">Name:</label>
                    <input type="text" name="name" value="<?php echo $product['name']; ?>" required>

                    <label for="description">Description:</label>
                    <input type="text" name="description" value="<?php echo $product['description']; ?>" required>

                    <label for="price">Price:</label>
                    <input type="number" name="price" value="<?php echo $product['price']; ?>" required>

                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" required>

                    <button type="submit" name="update">Update Product</button>
                </form>
            </div>
        </div>
    </div>
</body>
<footer>
    <div class="footer-container">
        <div class="copyright">
            <p><center><b>&copy; 2025 Master Poly (Pvt) Ltd. All rights reserved.</b></center></p>
        </div>
    </div>
</footer>
</html>

<?php
// Close connection
$conn->close();
?>
