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

// Fetch stock details
$sql = "SELECT stockID, name, quantity, status, item FROM stock";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Details</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="ex.css">
    <script src="cusdash.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
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
            <section class="profile-container">
                <h2>Stock List</h2>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Stock ID</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            
                            <th>Item</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['stockID']); ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                
                                <td><?php echo htmlspecialchars($row['item']); ?></td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                            <tr>
                                <td colspan="5">No stock found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</body>
</html>
