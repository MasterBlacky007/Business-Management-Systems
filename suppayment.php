<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['email'])) {
    header("Location: cuslogin.html");
    exit();
}

include "conf.php";

// Enable error reporting for debugging (Remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle Accept action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accept']) && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $update_sql = "UPDATE suppayment SET Status = 'Accepted' WHERE OrderID = ?";
    $stmt = $conn->prepare($update_sql);
    if (!$stmt) {
        die("Error preparing SQL: " . $conn->error);
    }
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();

    // Reload the page to reflect status changes
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Get the logged-in user's email
$email = $_SESSION['email'];

// Fetch payments related to the logged-in user with status 'Active'
$sql = "SELECT PaymentID, SupplierID, Email, OrderID, PaymentDate, Currency, Amount, Method, Status 
        FROM suppayment WHERE Email = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparing SQL: " . $conn->error);
}
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Payments</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="ex.css">
    <script src="cusdash.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .btn-accept {
            background-color: green;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .btn-accept:hover {
            background-color: darkgreen;
        }
        .disabled {
            background-color: grey;
            cursor: not-allowed;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .profile-container {
            margin-left: 50px;
        }
        table {
            margin-left: 50px;
            border-collapse: collapse;
            width: 80%;
        }
        th, td {
            padding: 10px;
            border: 1px solid black;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <div class="dashboard">
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
                <li><a href="supreturn.php"><i class="fa-solid fa-repeat"></i><span> Return Orders</span></a></li>
                <li><a href="Home.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
            </ul>
        </nav>

        <div class="main-content">
            <header>
                <h1 style="color: red;">Supplier Payments</h1>
            </header>
            <section class="profile-container">
                <h2>Payment Details</h2>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Payment ID</th>
                            <th>Email</th>
                            <th>Order ID</th>
                            <th>Payment Date</th>
                            <th>Currency</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['PaymentID']); ?></td>
                                <td><?php echo htmlspecialchars($row['Email']); ?></td>
                                <td><?php echo htmlspecialchars($row['OrderID']); ?></td>
                                <td><?php echo htmlspecialchars($row['PaymentDate']); ?></td>
                                <td><?php echo htmlspecialchars($row['Currency']); ?></td>
                                <td><?php echo htmlspecialchars($row['Amount']); ?></td>
                                <td><?php echo htmlspecialchars($row['Method']); ?></td>
                                <td><?php echo htmlspecialchars($row['Status']); ?></td>
                                <td>
                                    <?php if ($row['Status'] === 'Active'): ?>
                                        <form method="post">
                                            <input type="hidden" name="order_id" value="<?php echo $row['OrderID']; ?>">
                                            <button type="submit" name="accept" class="btn-accept">Accept</button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn-accept disabled" disabled></button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8">No orders found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>

</body>
</html>
