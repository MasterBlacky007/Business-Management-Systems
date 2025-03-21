<?php
// Include database connection
include('conf.php');

// Start session to manage login state
session_start();

// Initialize the success message variable
$successMessage = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $suid = $_POST['suid'];
    $email = $_POST['email'];
    $oid = $_POST['oid'];
    $odate = $_POST['odate'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    

    // Calculate Order Amount
    $oa = ($quantity * $price) + ($quantity * 10);

    // Check if the record with the same SupplierID and OrderID already exists
    $checkQuery = "SELECT * FROM sgenpay WHERE SupplierID = ? AND OrderID = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $suid, $oid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Record already exists, display error message
        echo "<script>
                alert('Duplicate entry: This order with the same SupplierID and OrderID already exists.');
              </script>";
    } else {
        // Insert into the database if no duplicate
        $sql = "INSERT INTO sgenpay (SupplierID,Email, OrderID, OrderDate, Quantity, Price, OrderAmount, Status) 
                VALUES ('$suid','$email', '$oid', '$odate', '$quantity', '$price', '$oa', 'pending')";

if (mysqli_query($conn, $sql)) {
    $orderId = mysqli_insert_id($conn);
    $successMessage = "Order added successfully!";
    header("Location: print_invoice.php?oid=$oid");
    exit();
    
        } else {
            // Display error message
            $successMessage = "Error: " . $sql . "<br>" . mysqli_error($conn);

            // Display failure message using JavaScript
            echo "<script>
                    alert('Failed to add record. Please try again.');
                  </script>";
        }
    }

    // Close the statement
    $stmt->close();
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <link rel="stylesheet" href="supmakep.css">
    <script src="cusdash.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        function calculateOrderAmount() {
            const quantity = parseFloat(document.getElementById('quantity').value) || 0;
            const price = parseFloat(document.getElementById('price').value) || 0;
            const orderAmount = (quantity * price) + (quantity * 10);
            document.getElementById('oa').value = orderAmount.toFixed(2); // Display calculated value
        }
    </script>
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
                <li><a href="supdash.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
                <li><a href="suprofile.php"><i class="fas fa-user"></i><span> Profile</span></a></li>
                <li><a href="suporder.php"><i class="fa-solid fa-truck-fast"></i><span> Orders</span></a></li>
                <li><a href="supmakepayment.php"><i class="fa-solid fa-file-invoice-dollar"></i><span> Invoices</span></a></li>
                <li><a href="suppayment.php"><i class="fa-solid fa-credit-card"></i><span> Payments</span></a></li>
                <li><a href="supreturn.php"><i class="fa-solid fa-repeat"></i><span>Return Orders</span></a></li>
                <li><a href="Home.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
            </ul>
        </nav>
    <!-- Main Content -->
    <main>
        <div class="container">
            <h2>Create Order</h2>
            <?php if ($successMessage): ?>
                <div class="success-message"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <form action="supmakepayment.php" method="POST">
                <label for="suid">Supplier ID</label>
                <input type="text" id="suid" name="suid" required>

                <label for="email">Supplier Email</label>
                <input type="text" id="email" name="email" required>

                <label for="oid">Order ID</label>
                <input type="text" id="oid" name="oid" required>

                <label for="odate">Order Date</label>
                <input type="date" id="odate" name="odate" required>

                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" oninput="calculateOrderAmount()" required>

                <label for="price">Price</label>
                <input type="number" id="price" name="price" step="0.01" oninput="calculateOrderAmount()" required>

                <label for="oa">Order Amount</label>
                <input type="number" id="oa" name="oa" step="0.01" readonly required>

                <button type="submit">Submit</button>
            </form>
        </div>
            </div>
    </main>
</body>
</html>
