<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: slogin.html");
    exit();
}

include 'conf.php';

$driver_email = $_SESSION['user_email']; // Correct session key

// Fetch driver details from 'staff' table
$query = "SELECT id, name, nic, role FROM staff WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $driver_email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    echo "<script>alert('Driver Not Found!!'); window.location.href='slogin.html';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distributor Dashboard</title>
    <link rel="stylesheet" href="supmakep.css">
    <link rel="stylesheet" href="dasboard.css">
    
    <script src="cusdash.js" defer></script>
    <script>
        function toggleReasonField() {
            var status = document.getElementById("status").value;
            var reasonField = document.getElementById("reasonField");
            if (status === "Not Available") {
                reasonField.style.display = "block";
            } else {
                reasonField.style.display = "none";
            }
        }
    </script>
    
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
            <li><a href="disdash.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
                <li><a href="diprofile.php"><i class="fas fa-user"></i><span> Profile</span></a></li>
                <li><a href="dstatus.php"><i class="fas fa-info-circle"></i><span> Status</span></a></li>
                <li><a href="ditask.php"><i class="fas fa-tasks"></i><span> Tasks</span></a></li>
                <li><a href="dvdelevery.php"><i class="fas fa-truck"></i><span> Deliveries</span></a></li>
                <li><a href="didash.html"><i class="fas fa-exclamation-triangle"></i><span> Issues</span></a></li>
                <li><a href="slogin.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Distributor - Status</h1>
            </header>
            <section class="dash-container">
                <h2>Add Driver Status</h2><br><br>
                <form action="dustatus.php" method="POST">
                    <label>Driver ID:</label>
                    <input type="text" name="driver_id" value="<?= htmlspecialchars($row['id']); ?>" readonly><br>

                    <label>Name:</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($row['name']); ?>" readonly><br>

                    <label>NIC:</label>
                    <input type="text" name="nic" value="<?= htmlspecialchars($row['nic']); ?>" readonly><br>

                    <label>Role:</label>
                    <input type="text" name="role" value="<?= htmlspecialchars($row['role']); ?>" readonly><br>

                    <label>Vehicle No:</label>
                    <input type="text" name="vehicle_no" required><br>

                    <label>Status:</label>
                    <select name="status" id="status" onchange="toggleReasonField()" required>
                        <option value="Available">Available</option>
                        <option value="Not Available">Not Available</option>
                    </select><br>

                    <div id="reasonField" style="display: none;">
                        <label>Reason:</label>
                        <input type="text" name="reason"><br>
                    </div>

                    <div class="save-button">
                        <button type="submit">Update Status</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</body>

</html>
