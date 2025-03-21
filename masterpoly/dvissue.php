<?php
session_start(); // Start the session

// Redirect if not logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: slogin.html");
    exit();
}

include "conf.php"; // Include database connection

// Get the logged-in user's email from the session
$email = $_SESSION['user_email'];

// Prepare SQL statement to fetch deliveries assigned to the logged-in driver
$sql = "SELECT ID,UserEmail, Type, Note, Description, Solution,Created_At FROM issues WHERE UserEmail = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Solution</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="dasboard.css">
    <link rel="stylesheet" href="ex.css">
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
                <h1>Distributor- Issues</h1>
            </header>
            <section class="profile-container">
                <h2>Solutions</h2>

                <input type="text" id="search" placeholder="Search by any field...">

                
                <?php if ($result->num_rows > 0): ?>
                    <table border="1">
                        <thead>
                            <tr>

                            <th>Issue ID</th>
                            <th>Send By</th>
                            <th>Issue Type</th>
                            <th>Note</th>
                            <th>Description</th>
                            <th>Send Time</th>
                            <th>Solution</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['ID']); ?></td>
                                    <td><?php echo htmlspecialchars($row['UserEmail']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Type']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Note']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Description']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Created_At']); ?></td>
                                    <td style="color: blue;"><?php echo htmlspecialchars($row['Solution']); ?></td>

                                   
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No Solutions assigned to you.</p>
                <?php endif; ?>

            </section>
        </div>
    </div>
    <script>
            
            document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("search");
        const tableRows = document.querySelectorAll("tbody tr");

        searchInput.addEventListener("keyup", function () {
            const searchText = searchInput.value.toLowerCase();

            tableRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(searchText) ? "" : "none";
            });
        });
    });

    </script>
</body>
</html>
