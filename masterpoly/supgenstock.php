<?php
include 'conf.php';

$message = ""; // Variable to store success/error messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $stockID = $_POST['stockID'] ?? '';
    $name = $_POST['name'] ?? '';
    $quantity = $_POST['quantity'] ?? '';
    $status = $_POST['status'] ?? '';
    $item = $_POST['item'] ?? '';

    // Validation
    if (empty($stockID) || empty($name) || empty($quantity) || empty($status) || empty($item)) {
        $message = "<p style='color: red;'>All fields must be filled.</p>";
    } elseif (!is_numeric($quantity)) {
        $message = "<p style='color: red;'>Quantity must be a numeric value.</p>";
    } else {
        // Prepare SQL statement to insert into stock table
        $sql = "INSERT INTO stock (stockID, name, quantity, status, item) VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiss", $stockID, $name, $quantity, $status, $item);
        
        // Execute and check success
        if ($stmt->execute()) {
            $message = "<p style='color: green;'>Stock record added successfully!</p>";
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
    <title>Add Stock</title>
    <link rel="stylesheet" href="upp.css">
    <link rel="stylesheet" href="dasboard.css">
    <script src="cusdash.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>Dashboard</h2>
                <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
            </div>
            <ul class="sidebar-menu">
            <li><a href="supvdash.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
                <li><a href="supprofile.php"><i class="fas fa-user"></i><span> Profile</span></a></li>
                <li><a href="supertask.php"><i class="fas fa-tasks"></i><span> Tasks</span></a></li>
                <li><a href="viewsupleaves.php"><i class="fas fa-tasks"></i><span> Shift Operations</span></a></li> 
                <li><a href="supgenstock.php"><i class="fas fa-tasks"></i><span> Stock Requests</span></a></li>                 
                <li><a href="spvreport.html"><i class="fas fa-chart-bar"></i><span> Reports</span></a></li>                 
                <li><a href="slogin.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>

            </ul>
        </nav>

        <div class="main-content">
            <header>
                <h1>Available Stock</h1>
            </header>

            <div class="form-container">
                <div><?php echo $message; ?></div>

                <form action="" method="POST">
                    <div>
                        <label for="stockID">Stock ID</label>
                        <input type="text" id="stockID" name="stockID" placeholder="Enter Stock ID" required>
                    </div>
                    <div>
                        <label for="name">Stock Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter Stock Name" required>
                    </div>
                    <div>
                        <label for="quantity">Quantity</label>
                        <input type="text" id="quantity" name="quantity" placeholder="Enter Quantity" required>
                    </div>
                    <div>
                        <label for="status">Status</label>
                        <input type="text" id="status" name="status" placeholder="Enter Status" required>
                    </div>
                    <div>
                        <label for="item">Item</label>
                        <input type="text" id="item" name="item" placeholder="Enter Item" required>
                    </div>
                    <div class="save-button">
                        <button type="submit">Add Stock</button>
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
