<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['email'])) {
    header("Location: cuslogin.html");
    exit();
}

include "conf.php";

// Get the logged-in user's email
$email = $_SESSION['email'];

// Fetch orders for the logged-in user
$sql = "SELECT OrderID, ProductID, OrderDate, Quantity, Address, Country, Amount, Payment FROM addorder WHERE Email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if any orders exist
if ($result->num_rows === 0) {
    echo "<p>No orders found for this account.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Orders</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="dasboard.css">
    <link rel="stylesheet" href="ex.css">
    <script src="cusdash.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        #orderTable {
            display: none; /* Hide the table initially */
        }
        .viewButton, .payButton {
            display: inline-block;
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 5px;
        }

        .payButton {
            background-color: #2196F3;
        }

        .viewButton:hover, .payButton:hover {
            opacity: 0.8;
        }
    </style>
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
            <li><a href="dasboard.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
                <li><a href="cusprofile.php"><i class="fas fa-user"></i><span> Profile</span></a></li>
                <li><a href="cuspv.php"><i class="fas fa-shopping-cart"></i><span> Products</span></a></li>
                <li><a href="cusorder.html"><i class="fas fa-shopping-cart"></i><span> Orders</span></a></li>
                <li><a href="cusfeedback.php"><i class="fa-solid fa-comment-dots"></i><span> Feedback</span></a></li>
                <li><a href="cuslogin.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>My Orders</h1>
            </header>
            <section class="profile-container">
                <h2>Order Details</h2>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Product ID</th>
                            <th>Order Date</th>
                            <th>Quantity</th>
                            <th>Address</th>
                            <th>Country</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['OrderID']); ?></td>
                                <td><?php echo htmlspecialchars($row['ProductID']); ?></td>
                                <td><?php echo htmlspecialchars($row['OrderDate']); ?></td>
                                <td><?php echo htmlspecialchars($row['Quantity']); ?></td>
                                <td><?php echo htmlspecialchars($row['Address']); ?></td>
                                <td><?php echo htmlspecialchars($row['Country']); ?></td>
                                <td><?php echo htmlspecialchars($row['Amount']); ?></td>
                                <td><?php echo htmlspecialchars($row['Payment']); ?></td>
                                <td>
                                    <a href='invoice2.php?orderId=<?php echo $row['OrderID']; ?>' class='viewButton'>View</a>
                                    <a href='pay2.php?orderId=<?php echo $row['OrderID']; ?>' class='payButton'>Pay</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
    
</body>
</html>
