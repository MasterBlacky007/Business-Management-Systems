<?php
include 'conf.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch performance data
$searchQuery = "";
if (isset($_POST['search'])) {
    $searchQuery = $_POST['searchQuery'];
    $sql = "SELECT eno, jrole, skill FROM eperformance WHERE eno LIKE '%$searchQuery%'";
} else {
    $sql = "SELECT eno, jrole, skill FROM eperformance";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance Dashboard</title>
    <link rel="stylesheet" href="viewproduct1.css">
    <link rel="stylesheet" href="dasboard.css">
    <script src="cusdash.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* Custom CSS for the Download PDF button */
        button[type="submit"][name="download_pdf"] {
            background-color:rgb(6, 138, 245); /* Green background */
            color: white; /* White text */
            padding: 10px 20px; /* Padding for button */
            font-size: 1em; /* Font size */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            transition: background-color 0.3s ease; /* Smooth transition for background color */
            display: inline-block; /* Aligns the button in line with others */
            margin-top: 20px; /* Space above the button */
        }

        button[type="submit"][name="download_pdf"]:hover {
            background-color: rgb(6, 138, 245); /* Darker green on hover */
        }

        button[type="submit"][name="download_pdf"]:active {
            background-color: rgb(6, 138, 245); /* Even darker green when clicked */
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
            <li><a href="supvdash.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
                <li><a href="supprofile.php"><i class="fas fa-user"></i><span> Profile</span></a></li>
                <li><a href="supertask.php"><i class="fas fa-tasks"></i><span> Tasks</span></a></li>
                <li><a href="viewsupleaves.php"><i class="fas fa-tasks"></i><span> Shift Operations</span></a></li> 
                <li><a href="supgenstock.php"><i class="fas fa-tasks"></i><span> Stock Requests</span></a></li>                 
                <li><a href="spvreport.html"><i class="fas fa-chart-bar"></i><span> Reports</span></a></li>                 
                <li><a href="slogin.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>

            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <header>
            </header>

            <div class="table-container">
                <h2>Performance Report</h2>
                <div class="search-container">
                    <form method="POST" action="">
                        <input type="text" name="searchQuery" placeholder="Enter Employee Number" value="<?php echo htmlspecialchars($searchQuery); ?>">
                        <button type="submit" name="search">Search</button>
                    </form>
                </div>

                <table border="1">
                    <tr>
                        <th>Employee No</th>
                        <th>Job Role</th>
                        <th>Skills</th>
                    </tr>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["eno"] . "</td>";
                            echo "<td>" . $row["jrole"] . "</td>";
                            echo "<td>" . $row["skill"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No performance records found</td></tr>";
                    }
                    ?>
                </table>

                <form action="superpepdf.php" method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
                    <input type="hidden" name="report_id" value="<?php echo htmlspecialchars($_POST['report_id'] ?? ''); ?>">
                    <input type="hidden" name="frequency" value="<?php echo htmlspecialchars($_POST['frequency'] ?? ''); ?>">
                    <input type="hidden" name="start_date" value="<?php echo htmlspecialchars($_POST['start_date'] ?? ''); ?>">
                    <input type="hidden" name="end_date" value="<?php echo htmlspecialchars($_POST['end_date'] ?? ''); ?>">
                    <button type="submit" name="download_pdf">Print Report</button>
                </form>
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
