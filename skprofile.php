<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: slogin.html"); // Redirect to login page
    exit();
}

include "conf.php"; // Include database connection

// Fetch staff details from the database using the logged-in staff's ID
$staff_id = $_SESSION['user_id'];
$sql = "SELECT * FROM staff WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $staff_id); // Bind the staff ID to the query
$stmt->execute();
$result = $stmt->get_result();
$staff = $result->fetch_assoc();

// If staff not found, show an error message
if (!$staff) {
    echo "Staff not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Profile</title>
    <link rel="stylesheet" href="profile.css">
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
                <h1>My Profile</h1>
            </header>
            <section class="profile-container">
                <h2>Staff Profile</h2>
                
                <div class="profile-item">
                    <label>Staff Name:</label>
                    <span><?php echo htmlspecialchars($staff['name']); ?></span>
                </div>
                
                <div class="profile-item">
                    <label>Email:</label>
                    <span><?php echo htmlspecialchars($staff['email']); ?></span>
                </div>
                
                <div class="profile-item">
                    <label>Role:</label>
                    <span><?php echo htmlspecialchars($staff['role']); ?></span>
                </div>
                
                <div class="profile-item">
                    <label>NIC:</label>
                    <span><?php echo htmlspecialchars($staff['nic']); ?></span>
                </div>
                
                <div class="profile-item">
                    <label>Gender:</label>
                    <span><?php echo htmlspecialchars($staff['gender']); ?></span>
                </div>
                
                <div class="profile-item">
                    <label>Phone:</label>
                    <span><?php echo htmlspecialchars($staff['phone']); ?></span>
                </div>
                
                <div class="profile-item">
                    <label>Additional Notes:</label>
                    <span><?php echo htmlspecialchars($staff['additionalNotes']); ?></span>
                </div>
            </section>
        </div>
    </div>

</body>
</html>
