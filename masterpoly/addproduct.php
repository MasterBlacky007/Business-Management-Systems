<?php
include 'conf.php';

$message = ""; // Variable to store success/error messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $productID = $_POST['productID'] ?? ''; // Collect productID from form (if not auto-incremented)
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? '';
    $quantity = $_POST['quantity'] ?? '';

    // Validation
    if (empty($productID) || empty($name) || empty($price) || empty($quantity)) {
        $message = "<p style='color: red;'>All required fields must be filled.</p>";
    } elseif (!is_numeric($price) || !is_numeric($quantity)) {
        $message = "<p style='color: red;'>Price and Quantity must be numeric values.</p>";
    } else {
        // Prepare SQL statement to insert all 5 columns
        $sql = "INSERT INTO product (productID, name, description, price, quantity) 
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdi", $productID, $name, $description, $price, $quantity); // Bind parameters for query

        // Execute and check success
        if ($stmt->execute()) {
            $message = "<p style='color: green;'>Record added successfully!</p>";
        } else {
            $message = "<p style='color: red;'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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
                <h1>Add New Product</h1>
            </header>

            <!-- Form Section -->
            <div class="form-container">

                <!-- Success/Error Message -->
                <div><?php echo $message; ?></div>

                <form action="" method="POST">
                    <div>
                        <label for="productID">Product ID</label>
                        <input type="text" id="productID" name="productID" placeholder="Enter Product ID" required>
                    </div>
                    <div>
                        <label for="name">Product Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter Product Name" required>
                    </div>
                    <div>
                        <label for="description">Product Description</label>
                        <input type="text" id="description" name="description" placeholder="Enter Product Description">
                    </div>
                    <div>
                        <label for="price">Price</label>
                        <input type="text" id="price" name="price" placeholder="Enter Price" required>
                    </div>
                    <div>
                        <label for="quantity">Available Quantity</label>
                        <input type="text" id="quantity" name="quantity" placeholder="Enter Available Quantity" required>
                    </div>
                    <div class="save-button">
                        <button type="submit">Add New Product</button>
                    </div>
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
