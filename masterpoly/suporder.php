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

// Handle Confirm and Reject actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['order_id'])) {
        $order_id = $_POST['order_id'];
        $new_status = isset($_POST['accept']) ? 'Confirmed' : (isset($_POST['cancel']) ? 'Rejected' : '');

        if (!empty($new_status)) {
            $update_sql = "UPDATE genorder SET status = ? WHERE oid = ?";
            $stmt = $conn->prepare($update_sql);
            if (!$stmt) {
                die("Error preparing SQL: " . $conn->error);
            }
            $stmt->bind_param("si", $new_status, $order_id);
            $stmt->execute();
            $stmt->close();

            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        }
    }
}

// Get the logged-in user's email
$email = $_SESSION['email'];

// Fetch orders
$sql = "SELECT oid, email, odate, rdate, pmatirial, quantity, status FROM genorder WHERE email = ? AND status IN ('Transferred', 'Confirmed')";
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
    <title>Supplier Orders</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="ex.css">
    <script src="cusdash.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .btn-confirm, .btn-reject {
            color: white;
            border: none;
            padding: 5px 10px;

            cursor: pointer;
        }
        .btn-confirm { background-color: green; }
        .btn-reject { background-color: red; }
        .btn-confirm:hover { background-color: darkgreen; }
        .btn-reject:hover { background-color: darkred; }
        .main-content {
        margin-left: 250px; /* Push content to the right */
        padding: 20px;
    }
    .profile-container {
        margin-left: 50px; /* Further push return orders section */
    }
    table {
        margin-left: 50px; /* Push table to the right */
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
                <li><a href="supdash.html"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="suprofile.php"><i class="fas fa-user"></i> Profile</a></li>
                <li><a href="suporder.php"><i class="fa-solid fa-truck-fast"></i> Orders</a></li>
                <li><a href="supmakepayment.php"><i class="fa-solid fa-file-invoice-dollar"></i> Invoices</a></li>
                <li><a href="suppayment.php"><i class="fa-solid fa-credit-card"></i> Payments</a></li>
                <li><a href="supreturn.php"><i class="fa-solid fa-repeat"></i> Return Orders</a></li>
                <li><a href="Home.html"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>

        <div class="main-content">
            <header>
            <h1 style="color: red;">My Orders</h1>
            </header>
            <section class="profile-container">
                <h2>Order Details</h2>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Email</th>
                            <th>Order Date</th>
                            <th>Receive Date</th>
                            <th>Material</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['oid']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['odate']); ?></td>
                                    <td><?php echo htmlspecialchars($row['rdate']); ?></td>
                                    <td><?php echo htmlspecialchars($row['pmatirial']); ?></td>
                                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                    <td>
                                        <form method="post" style="display:inline;">
                                            <input type="hidden" name="order_id" value="<?php echo $row['oid']; ?>">
                                            <button type="submit" name="accept" class="btn-confirm"
                                                <?php echo ($row['status'] === 'Confirmed' || $row['status'] === 'Rejected') ? 'disabled' : ''; ?>>
                                                Confirm
                                            </button>
                                        </form>
                                        <form method="post" style="display:inline;">
                                            <input type="hidden" name="order_id" value="<?php echo $row['oid']; ?>">
                                            <button type="submit" name="cancel" class="btn-reject"
                                                <?php echo ($row['status'] === 'Confirmed' || $row['status'] === 'Rejected') ? 'disabled' : ''; ?>>
                                                Reject
                                            </button>
                                        </form>
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
