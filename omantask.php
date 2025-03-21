<?php
// Include database connection
include('conf.php');

// Start session to manage login state
session_start();

// Fetch distinct manager roles
$managerRoles = [];
$roleQuery = "SELECT DISTINCT role FROM staff WHERE role LIKE '%Manager'";
$roleResult = mysqli_query($conn, $roleQuery);
if ($roleResult) {
    while ($row = mysqli_fetch_assoc($roleResult)) {
        $managerRoles[] = $row['role'];
    }
}

// Initialize the success message variable
$successMessage = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $taskname = mysqli_real_escape_string($conn, $_POST['taskname']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $assignby = mysqli_real_escape_string($conn, $_POST['assignby']);
    $assignto = mysqli_real_escape_string($conn, $_POST['assignto']);
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
    

    // Insert into the database
    $sql = "INSERT INTO task (taskname, description, assignby, assignto, startdate, enddate) 
            VALUES ('$taskname', '$description', '$assignby', '$assignto', '$startdate', '$enddate')";

    if (mysqli_query($conn, $sql)) {
        $taskID = mysqli_insert_id($conn);
        $successMessage = "Task added successfully! Task ID: " . $taskID;
        echo "<script>
                alert('Task added successfully! Task ID: " . $taskID . "');
                window.location.href = 'omantask.php'; 
              </script>";
    } else {
        $successMessage = "Error: " . mysqli_error($conn);
        echo "<script>alert('Failed to add task. Please try again.');</script>";
    }
}

// Close database connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Manager Tasks</title>

    <link rel="stylesheet" href="supmakep.css">
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
        <h1>Owner- Assign Manager Task</h1>
    </header>
    <section class="profile-container">
    <h2>Assign Manager Tasks</h2>

            <?php if ($successMessage): ?>
                <div class="success-message"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <form action="omantask.php" method="POST">
                <label for="taskname">Task Name</label>
                <input type="text" id="taskname" name="taskname" required>

                <label for="description">Description</label>
                <textarea id="description" name="description" required></textarea>

                <label for="assignby">Assigned By</label>
                <input type="text" id="assignby" name="assignby" required>

                <label for="managerRole">Manager Role</label>
                <select id="managerRole" name="managerRole" required>
                    <option value="">Select Role</option>
                    <?php foreach ($managerRoles as $role): ?>
                        <option value="<?php echo htmlspecialchars($role); ?>"><?php echo htmlspecialchars($role); ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="assignto">Assigned To (Manager Email)</label>
                <select id="assignto" name="assignto" required>
                    <option value="">Select Email</option>
                </select>

                <label for="startdate">Start Date</label>
                <input type="date" id="startdate" name="startdate" required>

                <label for="enddate">End Date</label>
                <input type="date" id="enddate" name="enddate" required>



                <button type="submit">Submit Task</button>
</form>

    </section>

</div>


    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('#managerRole').change(function () {
        var selectedRole = $(this).val();

        if (selectedRole !== '') {
            $.ajax({
                type: "POST",
                url: "ofetch_manager.php",
                data: { role: selectedRole },
                success: function (response) {
                    console.log("Response received:", response); // Debugging
                    $('#assignto').html(response);
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error); // Debugging
                }
            });
        } else {
            $('#assignto').html('<option value="">Select Email</option>');
        }
    });
});
</script>


</body>
</html>
