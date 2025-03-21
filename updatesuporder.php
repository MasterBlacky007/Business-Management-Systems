<?php
include 'conf.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch order details based on ID
$orderID = $_GET['id'];
$sql = "SELECT oid, suid, email, pmatirial, quantity, status, odate, rdate FROM genorder WHERE oid = '$orderID'";
$result = $conn->query($sql);
$order = $result->fetch_assoc();

// Handle order update
if (isset($_POST['update'])) {
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];
    $pmatirial = $_POST['pmatirial'];
    $odate = $_POST['odate'];
    $rdate = $_POST['rdate'];

    $updateSql = "UPDATE genorder SET quantity='$quantity', status='$status', pmatirial='$pmatirial', odate='$odate', rdate='$rdate' WHERE oid='$orderID'";
    if ($conn->query($updateSql) === TRUE) {
        echo "<script>alert('Order updated successfully!'); window.location.href='viewsuporder.php';</script>";
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
    <title>Update Order</title>
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
                <h1>Update Order</h1>
            </header>

            <!-- Update Order Form -->
            <div class="form-container">
                <form method="POST" action="">
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" value="<?php echo $order['quantity']; ?>" required>

                    <label for="status">Status:</label>
                    <input type="text" name="status" value="<?php echo $order['status']; ?>" required>

                    <label for="pmatirial">Material:</label>
                    <input type="text" name="pmatirial" value="<?php echo $order['pmatirial']; ?>" required>

                    <label for="odate">Order Date:</label>
                    <input type="date" name="odate" value="<?php echo $order['odate']; ?>" required>

                    <label for="rdate">Receive Date:</label>
                    <input type="date" name="rdate" value="<?php echo $order['rdate']; ?>" required>

                    <button type="submit" name="update">Update Order</button>
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
