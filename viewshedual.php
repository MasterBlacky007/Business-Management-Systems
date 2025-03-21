<?php
include 'conf.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch schedule data
$searchQuery = "";
if (isset($_POST['search'])) {
    $searchQuery = $_POST['searchQuery'];
    $sql = "SELECT scheduleID, description FROM schedule WHERE scheduleID LIKE '%$searchQuery%'";
} else {
    $sql = "SELECT scheduleID, description FROM schedule";
}
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PM Dashboard</title>
    <link rel="stylesheet" href="viewproduct1.css">
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
            <li><a href="pmdash.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
                <li><a href="pprofile.php"><i class="fas fa-user"></i><span> Profile</span></a></li>
                <li><a href="proddash1.html"><i class="fas fa-box-open"></i><span> Products</span></a></li>
                <li><a href="ptask.php"><i class="fas fa-tasks"></i><span> Tasks</span></a></li>
                <li><a href="viewshedual.php"><i class="fas fa-calendar-alt"></i><span> Schedules</span></a></li>
                <li><a href="resdash.html"><i class="fas fa-cogs"></i><span> Resources</span></a></li>
                <li><a href="pmreport.html"><i class="fas fa-chart-bar"></i><span> Reports</span></a></li>
                <li><a href="slogin.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <header>
            </header>

            <!-- Schedule Table -->
            <div class="table-container">
                <h2>Schedule List</h2>

                <div class="search-container">
                    <form method="POST" action="">
                        <input type="text" name="searchQuery" placeholder="Enter Schedule ID" value="<?php echo htmlspecialchars($searchQuery); ?>">
                        <button type="submit" name="search">Search</button>
                    </form>
                </div>

                <table border="1">
                    <tr>
                        <th>Schedule ID</th>
                        <th>Description</th>
                    </tr>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["scheduleID"] . "</td>";
                            echo "<td>" . $row["description"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No schedules found</td></tr>";
                    }
                    ?>
                </table>
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

<?php
// Close connection
$conn->close();
?>
