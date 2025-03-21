<?php
// Database connection
include "conf.php";

// Fetch lab test data
$sql = "SELECT * FROM ownertask";
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

        button.accept {
            background-color: #28a745 !important;
            color: white !important;
            padding: 8px 15px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button.accept:hover {
            background-color: #218838 !important;
        }

        /* Reject Button (Red) */
        button.reject {
            background-color: #dc3545 !important;
            color: white !important;
            padding: 8px 15px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button.reject:hover {
            background-color: #c82333 !important;
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
            <li><a href="ownerdash.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
                <li><a href="ownerprofile.php"><i class="fas fa-user"></i><span> Profile</span></a></li>
                <li><a href="omtask.html"><i class="fas fa-tasks"></i><span> Tasks</span></a></li>
                <li><a href="omanagertaskdash.html"><i class="fas fa-user-tie"></i><span> Manager Tasks</span></a></li> 
                <li><a href="oemperform.php"><i class="fas fa-chart-line"></i><span> Employee Performances</span></a></li> 
                <li><a href="ostaff.php"><i class="fas fa-users"></i><span> Staff</span></a></li> 
                <li><a href="opayments.php"><i class="fas fa-file-invoice-dollar"></i><span> Payments</span></a></li>
                <li><a href="oddash.html"><i class="fas fa-truck"></i><span> Delivery Orders</span></a></li> 
                <li><a href="ofeed.php"><i class="fas fa-comment-dots"></i><span> Feedbacks</span></a></li>                                
                <li><a href="oreport.html"><i class="fas fa-chart-bar"></i><span> Reports</span></a></li>                 
                <li><a href="slogin.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
    <header>
        <h1>Owner- View Tasks</h1>
    </header>
    <section class="profile-container">
    <h2> My Tasks </h2>

    <input type="text" id="search" placeholder="Search by any field...">

    <table border="1">
        <thead>
            <tr>
                                <th>Task No</th>
                                <th>Task</th>
                                <th>Time</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Created Time</th>
                                <th>Actions</th>
                
                
            </tr>
        </thead>
        <tbody>
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['task'] . "</td>";
                        echo "<td>" . $row['time'] . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        
                        echo "<td>";
                    
                        echo "<button class='accept' onclick=\"updateTask('" . $row['id'] . "')\">Update</button> ";
                        echo "<button class='reject' onclick=\"deleteTask('" . $row['id'] . "')\">Delete</button>";
                        echo "</td>";

                    

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No Tasks found</td></tr>";
                }
                ?>
        </tbody>
    </table>
    </section>
</div>


    </div>
 <script>

function deleteTask(taskId) {
    if (confirm("Are you sure you want to delete this task?")) {
        window.location.href = "odtask.php?id=" + taskId;
    }
}

function updateTask(taskId) {
    window.location.href = "outask.php?id=" + taskId;
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


