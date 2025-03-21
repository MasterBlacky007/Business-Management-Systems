<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: cuslogin.html");
    exit();
}

include "conf.php";

// Enable error reporting for debugging (Remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the logged-in user's email
$email = $_SESSION['user_email'];

// Fetch orders with specific statuses
$sql = "SELECT oid, email, odate, rdate, pmatirial, quantity, status FROM genorder 
        WHERE email = ? AND status IN ('Returned', 'Accept Return', 'Cancel Return')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Fetch pmstock details
$sql_pmstock = "SELECT sid, pmid, quantity, location, status, sdate, rsdate FROM pmstock";
$stmt_pmstock = $conn->prepare($sql_pmstock);
$stmt_pmstock->execute();
$result_pmstock = $stmt_pmstock->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Orders</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="ex.css">
    <script src="cusdash.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
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
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>Dashboard</h2>
                <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
            </div>
            <ul class="sidebar-menu">
            <li><a href="skdash.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
                <li><a href="skprofile.php"><i class="fas fa-user"></i><span> Profile</span></a></li>
                <li><a href="inrecord.php"><i class="fas fa-box-open"></i><span>Inventory Records</span></a></li>
                <li><a href="sktask.php"><i class="fas fa-tasks"></i><span> Tasks</span></a></li>
                <li><a href="stocktype.html"><i class="fas fa-calendar-alt"></i><span> Stock Status</span></a></li>
                <li><a href="wst.php"><i class="fas fa-cogs"></i><span> Warehouse Status</span></a></li>
                <li><a href="skreport.html"><i class="fas fa-chart-bar"></i><span> Reports</span></a></li>
                <li><a href="slogin.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1 style="color: red;">Stock Details</h1>
            </header>

            <!-- Order Details Table -->
            
            <!-- PM Stock Table -->
            <section class="profile-container">
           
                <h2>Material List</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Stock ID</th>
                            <th>Material ID</th>
                            <th>Quantity</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Stock Date</th>
                            <th>Resupply Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result_pmstock->num_rows > 0): ?>
                            <?php while ($row = $result_pmstock->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['sid']); ?></td>
                                    <td><?php echo htmlspecialchars($row['pmid']); ?></td>
                                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                    <td><?php echo htmlspecialchars($row['sdate']); ?></td>
                                    <td><?php echo htmlspecialchars($row['rsdate']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">No stock records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>

        </div>
    </div>

</body>
</html>
