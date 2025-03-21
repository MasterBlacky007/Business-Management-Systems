<?php
// Database connection
include "conf.php";

// Fetch lab test data
$sql = "SELECT * FROM cusfeedback";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FM Feedback</title>
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

        .accept {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.3s;
        }

        .accept:hover {
            background-color: #0056b3;
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
            <li><a href="fmdash.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
                <li><a href="#"><i class="fas fa-user"></i><span> Profile</span></a></li>
                <li><a href="tasks.php"><i class="fas fa-tasks"></i><span> Tasks</span></a></li>
                <li><a href="fmps.php"><i class="fas fa-calendar-alt"></i><span> Production Schedules</span></a></li> 
                <li><a href="fmstask.html"><i class="fas fa-tasks"></i><span> Assign Tasks</span></a></li> 
                <li><a href="viewfeedback.php"><i class="fas fa-comments"></i><span> Feedback Operations</span></a></li> 
                <li><a href="fmreport.html"><i class="fas fa-chart-bar"></i><span> Reports</span></a></li>                 
                <li><a href="slogin.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
    <header>
        <h1>Factory Manager- Feedbacks</h1>
    </header>
    <section class="profile-container">
    <h2> View Feedback</h2>

    <input type="text" id="search" placeholder="Search by any field...">

    <table border="1">
        <thead>
            <tr>

                                <th>Feedback ID</th>                
                                <th>Feedback Type</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Description</th>
                                <th>Reply</th>
                                <th>Actions</th>
                                
                
                
            </tr>
        </thead>
        <tbody>
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['FeedbackType'] . "</td>";
                        echo "<td>" . $row['Name'] . "</td>";
                        echo "<td>" . $row['Email'] . "</td>";
                        echo "<td>" . $row['Discription'] . "</td>";
                        echo "<td>" . $row['reply'] . "</td>";
                       
                        
                        echo "<td>";
                        echo "<button class='accept' onclick=\"addreply('" . $row['id'] . "')\">Reply</button>";
                        echo "</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No Feedback found</td></tr>";
                }
                ?>
        </tbody>
    </table>
    </section>
</div>


    </div>
 <script>

    function addreply(replyID) {
        window.location.href = "fmreply.php?id=" + replyID;
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


