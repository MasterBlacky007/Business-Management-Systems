<?php
include 'conf.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch stock details based on ID
$stockID = $_GET['id'];
$sql = "SELECT stockID, name, quantity, status, item FROM stock WHERE stockID = '$stockID'";
$result = $conn->query($sql);
$stock = $result->fetch_assoc();

// Handle stock update
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];
    $item = $_POST['item'];

    $updateSql = "UPDATE stock SET name='$name', quantity='$quantity', status='$status', item='$item' WHERE stockID='$stockID'";
    if ($conn->query($updateSql) === TRUE) {
        echo "<script>alert('Stock updated successfully!'); window.location.href='viewstock.php';</script>";
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
    <title>Update Stock</title>
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
            <li><a href="imdash.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
                <li><a href="inprofile.php"><i class="fas fa-user"></i><span> Profile</span></a></li>
                <li><a href="intask.php"><i class="fas fa-tasks"></i><span> Tasks</span></a></li>
                <li><a href="viewsuplier.php"><i class="fas fa-truck-loading"></i><span> Suppliers</span></a></li> 
                <li><a href="imsorder.html"><i class="fas fa-clipboard-list"></i><span> Supplier Orders</span></a></li> 
                <li><a href="viewstock.php"><i class="fas fa-boxes"></i><span> Stock Status</span></a></li> 
                <li><a href="imreport.html"><i class="fas fa-chart-line"></i><span> Reports</span></a></li> 
                <li><a href="slogin.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Update Stock</h1>
            </header>

            <!-- Update Stock Form -->
            <div class="form-container">
                <form method="POST" action="">
                    <label for="name">Name:</label>
                    <input type="text" name="name" value="<?php echo $stock['name']; ?>" required>

                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" value="<?php echo $stock['quantity']; ?>" required>

                    <label for="status">Status:</label>
                    <input type="text" name="status" value="<?php echo $stock['status']; ?>" required>

                    <label for="item">Item:</label>
                    <input type="text" name="item" value="<?php echo $stock['item']; ?>" required>

                    <button type="submit" name="update">Update Stock</button>
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
