<?php
// Database connection
include "conf.php";

// Fetch lab test data
$sql = "SELECT * FROM deliveries";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TM Deliveries</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="dasboard.css">
    <link rel="stylesheet" href="ex.css">
    <script src="cusdash.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Search input */
        #search {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
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
            <li><a href="tmdash.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
                <li><a href="tmprofile.php"><i class="fas fa-user"></i><span> Profile</span></a></li>
                <li><a href="tmtask.php"><i class="fas fa-tasks"></i><span> Tasks</span></a></li>
                <li><a href="tmdis.php"><i class="fa-solid fa-people-carry-box"></i><span> Distributors</span></a></li>
                <li><a href="tmdlvrydash.html"><i class="fas fa-truck"></i><span> Deliveries</span></a></li>
                <li><a href="tmvissue.php"><i class="fas fa-exclamation-triangle"></i><span> Issues</span></a></li>
                <li><a href="slogin.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
    <header>
        <h1>Transport Manager- Delivery Status</h1>
    </header>
    <section class="profile-container">
    <h2> Delivery Status</h2>

    <input type="text" id="search" placeholder="Search by any field...">

    <table border="1">
        <thead>
            <tr>
                                <th>Delivery ID</th>
                                <th>Destination</th>
                                <th>Delivery Date</th>
                                <th>Products</th>
                                <th>Status</th>
                
                
            </tr>
        </thead>
        <tbody>
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['delivery_id'] . "</td>";
                        echo "<td>" . $row['destination'] . "</td>";
                        echo "<td>" . $row['delivery_date'] . "</td>";
                        echo "<td>" . $row['products'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        
                    

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No Delivery found</td></tr>";
                }
                ?>
        </tbody>
    </table>
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


