<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Tasks</title>
<link rel="stylesheet" href="viewtable.css">
</head>
<body>
     <!-- Sidebar -->
     <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
         <!----><li><a href="fmdash.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
                <li><a href="#"><i class="fas fa-user"></i><span> Profile</span></a></li>
                <li><a href="view_assing_task.php"><i class="fas fa-tasks"></i><span> Tasks</span></a></li>
                <li><a href="production.php"><i class="fas fa-calendar-alt"></i><span> Production Schedules</span></a></li> 
                <li><a href="fmstask.html"><i class="fas fa-tasks"></i><span> Assign Tasks</span></a></li> 
                <li><a href="feedback.html"><i class="fas fa-comments"></i><span> Feedback Operations</span></a></li> 
                <li><a href="fmreport.html"><i class="fas fa-chart-line"></i><span> Reports</span></a></li> 
                <li><a href="slogin.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main>
        <!-- Title Layer -->
        <div class="title-container">
            <h1 class="head">View Assigned Tasks</h1>
        </div>

        <!-- Search Layer -->
        <div class="search-container">
            <form method="get">
                <input class="search-input" type="text" name="search" placeholder="Search Task">
                <input class="search-btn" type="submit" value="Search">
            </form>
        </div>

        <!-- Table Layer -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Task ID</th>
                        <th>Description</th>
                        <th>Due Date</th>
                        
                    </tr>
                </thead>
                <tbody>
                <?php
                include 'config.php';

                // Initialize base SQL query to select all tasks
                $sql = "SELECT * FROM employeetask";

                // Check if a search term is provided
                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $searchTerm = $conn->real_escape_string($_GET['search']);
                    $sql .= " WHERE Task_ID LIKE '%$searchTerm%'";
                }

                // Execute the query
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . ($row["Task_ID"]) . "</td>";
                        echo "<td>" . ($row["Description"]) . "</td>";
                        echo "<td>" . ($row["Due_Date"]) . "</td>";
                        
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No tasks found.</td></tr>";
                }

                $conn->close();
                ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
