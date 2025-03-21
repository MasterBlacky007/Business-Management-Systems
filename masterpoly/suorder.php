<?php
include 'conf.php';

$message = ""; // Variable to store success/error messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $suid = $_POST['suid'] ?? ''; // Supplier ID
    $email = $_POST['email'] ?? ''; // Supplier Email
    $odate = $_POST['odate'] ?? ''; // Order Date
    $rdate = $_POST['rdate'] ?? ''; // Required Date
    $pmatirial = $_POST['pmatirial'] ?? ''; // Material
    $quantity = $_POST['quantity'] ?? ''; // Quantity
    $status = $_POST['status'] ?? ''; // Order Status

    // Validation
    if (empty($suid) || empty($email) || empty($odate) || empty($rdate) || empty($pmatirial) || empty($quantity) || empty($status)) {
        $message = "<p style='color: red;'>All fields must be filled.</p>";
    } elseif (!is_numeric($quantity)) {
        $message = "<p style='color: red;'>Quantity must be a numeric value.</p>";
    } else {
        // Prepare SQL statement to insert all columns
        $sql = "INSERT INTO genorder (suid, email, odate, rdate, pmatirial, quantity, status) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssis", $suid, $email, $odate, $rdate, $pmatirial, $quantity, $status); // Bind parameters

        // Execute and check success
        if ($stmt->execute()) {
            $message = "<p style='color: green;'>Order added successfully!</p>";
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
    <title>Add Order</title>
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
                <h1>Add New Order</h1>
            </header>

            <!-- Form Section -->
            <div class="form-container">

                <!-- Success/Error Message -->
                <div><?php echo $message; ?></div>

                <form action="" method="POST">
                    <div>
                        <label for="suid">Supplier ID</label>
                        <input type="text" id="suid" name="suid" placeholder="Enter Supplier ID" required>
                    </div>
                    <div>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter Email" required>
                    </div>
                    <div>
                        <label for="odate">Order Date</label>
                        <input type="date" id="odate" name="odate" required>
                    </div>
                    <div>
                        <label for="rdate">Required Date</label>
                        <input type="date" id="rdate" name="rdate" required>
                    </div>
                    <div>
                        <label for="pmatirial">Material</label>
                        <input type="text" id="pmatirial" name="pmatirial" placeholder="Enter Material" required>
                    </div>
                    <div>
                        <label for="quantity">Quantity</label>
                        <input type="text" id="quantity" name="quantity" placeholder="Enter Quantity" required>
                    </div>
                    <div>
                        <label for="status">Status</label>
                        <input type="text" id="status" name="status" placeholder="Enter Status" required>
                    </div>

                    <div class="save-button">
                        <button type="submit">Add New Order</button>
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
