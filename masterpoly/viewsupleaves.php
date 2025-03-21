<?php
include 'conf.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch leave data
$searchQuery = "";
if (isset($_POST['search'])) {
    $searchQuery = $_POST['searchQuery'];
    $sql = "SELECT leaveID, userID, leaveDate, reason, status FROM leaves WHERE userID LIKE '%$searchQuery%'";
} else {
    $sql = "SELECT leaveID, userID, leaveDate, reason, status FROM leaves";
}
$result = $conn->query($sql);

// Handle Approve and Deny actions
if (isset($_GET['action']) && isset($_GET['leaveID'])) {
    $leaveID = $_GET['leaveID'];
    $newStatus = ($_GET['action'] == 'approve') ? 'Approved' : 'Denied';
    
    $updateSql = "UPDATE leaves SET status = '$newStatus' WHERE leaveID = '$leaveID'";
    if ($conn->query($updateSql) === TRUE) {
        echo "<script>alert('Leave status update successfully!'); window.location.href='viewsupleaves.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PM Dashboard - Leaves</title>
    <link rel="stylesheet" href="viewproduct1.css">
    <link rel="stylesheet" href="dasboard.css">
    <script src="cusdash.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>Dashboard</h2>
                <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
            </div>
            <ul class="sidebar-menu">
            <li><a href="supvdash.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
                <li><a href="supprofile.php"><i class="fas fa-user"></i><span> Profile</span></a></li>
                <li><a href="supertask.php"><i class="fas fa-tasks"></i><span> Tasks</span></a></li>
                <li><a href="viewsupleaves.php"><i class="fas fa-tasks"></i><span> Shift Operations</span></a></li> 
                <li><a href="supgenstock.php"><i class="fas fa-tasks"></i><span> Stock Requests</span></a></li>                 
                <li><a href="spvreport.html"><i class="fas fa-chart-bar"></i><span> Reports</span></a></li>                 
                <li><a href="slogin.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>

            </ul>
        </nav>

        <div class="main-content">
            <header></header>

            <div class="table-container">
                <h2>Leave Requests</h2>
                <div class="search-container">
                    <form method="POST" action="">
                        <input type="text" name="searchQuery" placeholder="Enter User ID" value="<?php echo htmlspecialchars($searchQuery); ?>">
                        <button type="submit" name="search">Search</button>
                    </form>
                </div>

                <table border="1">
                    <tr>
                        <th>Leave ID</th>
                        <th>User ID</th>
                        <th>Leave Date</th>
                        <th>Reason</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["leaveID"] . "</td>";
                            echo "<td>" . $row["userID"] . "</td>";
                            echo "<td>" . $row["leaveDate"] . "</td>";
                            echo "<td>" . $row["reason"] . "</td>";
                            echo "<td>
                                    <a href='viewsupleaves.php?action=approve&leaveID=" . $row['leaveID'] . "' onclick='return confirm(\"Approve this leave request?\")'>Approve</a> | <a href='viewsupleaves.php?action=deny&leaveID=" . $row['leaveID'] . "' onclick='return confirm(\"Deny this leave request?\")'>Deny</a> </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No leave requests found</td></tr>";
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
$conn->close();
?>