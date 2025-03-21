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
$sql = "SELECT task_id, taskname, description,assignto, assignby, startdate,enddate, sstatus FROM task WHERE assignto = ?";

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
    <title>FM staff tasks</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="dasboard.css">
    <link rel="stylesheet" href="ex.css">
    <script src="cusdash.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
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

        /* Complete Button (Blue) */
        button.complete {
            background-color: #007bff !important;
            color: white !important;
            padding: 8px 15px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button.complete:hover {
            background-color: #0056b3 !important;
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
        <h1>My Tasks</h1>
    </header>
    <section class="profile-container">
                

                
                <?php if ($result->num_rows > 0): ?>
                    <table border="1">
                        <thead>
                            <tr>
                                <th>Task Id</th>
                                <th>Task</th>
                                <th>Description</th>
                                <th>Assign By</th>
                                <th>Assign To</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['task_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['taskname']); ?></td>
                                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                                    <td><?php echo htmlspecialchars($row['assignby']); ?></td>
                                    <td><?php echo htmlspecialchars($row['assignto']); ?></td>
                                    <td><?php echo htmlspecialchars($row['startdate']); ?></td>
                                    <td><?php echo htmlspecialchars($row['enddate']); ?></td>
                                    
                                    <td>
                                        <?php if ($row['sstatus'] === 'Pending'): ?>
                                            <button class="accept" onclick="updateStatus(<?php echo $row['task_id']; ?>, 'accept')">Accept</button>
                                            <button class="reject" onclick="updateStatus(<?php echo $row['task_id']; ?>, 'reject')">Reject</button>
                                        <?php elseif ($row['sstatus'] === 'Accepted'): ?>
                                            <span style="color: green;">Accepted</span>
                                            <button class="complete" onclick="updateStatus(<?php echo $row['task_id']; ?>, 'complete')">Complete</button>
                                        <?php elseif ($row['sstatus'] === 'Rejected'): ?>
                                            <span style="color: red;">Rejected</span>
                                        <?php elseif ($row['sstatus'] === 'Completed'): ?>
                                            <span style="color: blue;">Completed</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No Task assigned to you.</p>
                <?php endif; ?>

            </section>
</div>


    </div>
 <script>
  
  function updateStatus(taskId, action) {
            let formData = new FormData();
            formData.append("task_id", taskId);
            formData.append("action", action);

            fetch("updatetask.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "success") {
                    alert("Status updated successfully!");
                    location.reload(); // Refresh the page to reflect changes
                } else {
                    alert("Failed to update status. Try again!");
                }
            })
            .catch(error => console.error("Error:", error));
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


