<?php
include 'conf.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch supplier data
$searchQuery = "";
if (isset($_POST['search'])) {
    $searchQuery = $_POST['searchQuery'];
    $sql = "SELECT ID, First_Name, Last_Name, Contact, Email, Address FROM supplier WHERE ID LIKE '%$searchQuery%'";
} else {
    $sql = "SELECT ID, First_Name, Last_Name, Contact, Email, Address FROM supplier";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Dashboard</title>
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
                <li><a href="imdash.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
                <li><a href="inprofile.php"><i class="fas fa-user"></i><span> Profile</span></a></li>
                <li><a href="intask.php"><i class="fas fa-tasks"></i><span> Tasks</span></a></li>
                <li><a href="viewsuplier.php"><i class="fas fa-truck-loading"></i><span> Suppliers</span></a></li> 
                <li><a href="imsorder.html"><i class="fas fa-clipboard-list"></i><span> Supplier Orders</span></a></li> 
                <li><a href="viewstock.php"><i class="fas fa-boxes"></i><span> Stock Status</span></a></li> 
                <li><a href="imreport.html"><i class="fas fa-chart-line"></i><span> Reports</span></a></li> 
                <li><a href="slogin.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <header>
            </header>

            <!-- Supplier Table -->
            <div class="table-container">
                <h2>Supplier List</h2>

                <div class="search-container">
                    <form method="POST" action="">
                        <input type="text" name="searchQuery" placeholder="Enter Supplier ID" value="<?php echo htmlspecialchars($searchQuery); ?>">
                        <button type="submit" name="search">Search</button>
                    </form>
                </div>

                <table border="1">
                    <tr>
                        <th>Supplier ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Contact No</th>
                        <th>Email</th>
                        <th>Address</th>
                    </tr>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["ID"] . "</td>";
                            echo "<td>" . $row["First_Name"] . "</td>";
                            echo "<td>" . $row["Last_Name"] . "</td>";
                            echo "<td>" . $row["Contact"] . "</td>";
                            echo "<td>" . $row["Email"] . "</td>";
                            echo "<td>" . $row["Address"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No suppliers found</td></tr>";
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
