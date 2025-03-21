<?php
// Database connection
include "conf.php";

// Fetch lab test data
$sql = "SELECT * FROM distributor";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TM Distributors</title>
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
        .reject {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.3s;
        }

        .reject:hover {
            background-color: #cc0000;
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
        <h1>Transport Manager- Distributor Details</h1>
    </header>
    <section class="profile-container">
    <h2> Dristributor Details</h2>

    <input type="text" id="search" placeholder="Search by any field...">

    <table border="1">
        <thead>
            <tr>
                <th>Dristributor ID</th>
                <th>Name</th>
                <th>NIC</th>
                <th>Vehicle No</th>
                <th>Status</th>
                <th>Updated time</th>
                <th>Reason</th>
                <th>Action</th>
                
                
            </tr>
        </thead>
        <tbody>
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['driver_id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['nic'] . "</td>";
                        echo "<td>" . $row['vehicle_no'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>" . ($row['updated_at'] ?? 'N/A') . "</td>";
                        echo "<td>" . ($row['reason'] ?? 'N/A') . "</td>";
                        
                        
                        // Conditional buttons for actions
                        echo "<td>";
                        echo "<button class='reject' onclick=\"deleteTestResult('" . $row['driver_id'] . "')\">Remove</button>";
                        echo "</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No Driver found</td></tr>";
                }
                ?>
        </tbody>
    </table>
    </section>
</div>


    </div>
 <script>
    function deleteTestResult(driverId) {
    if (confirm("Are you sure you want to remove this driver?")) {
        window.location.href = "tmrdriver.php?id=" + driverId;
    }
}

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


