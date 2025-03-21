<?php
// Database connection
include "conf.php";

// Check if the delivery ID is provided
if (!isset($_GET['id'])) {
    die("Invalid request. No task ID provided.");
}

$taskId = $_GET['id'];

// Fetch the current details of the delivery
$sql = "SELECT * FROM ownertask WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $taskId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Task not found.");
}

$row = $result->fetch_assoc();

// Handle form submission to update the delivery details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newtask = $_POST['task'];
    $newTime = $_POST['task_time'];
    $newDate = $_POST['task_date'];
    $newDescription = $_POST['description'];


    // Update query
    $updateSql = "UPDATE ownertask SET task = ?, time = ?, date = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ssssi", $newtask, $newTime, $newDate, $newDescription, $taskId);

    if ($stmt->execute()) {
        echo "<script>alert('Task updated successfully!'); window.location.href='ovtask.php';</script>";
    } else {
        echo "<script>alert('Failed to update Task. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Task</title>
    <link rel="stylesheet" href="supmakep.css">
    <link rel="stylesheet" href="dasboard.css">
    
    <script src="cusdash.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
</head>

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
        <h1>Owner- Update Task</h1>
    </header>
    <section class="profile-container">

    <h2> Update Task </h2>

    <form method="POST">
        <label>Task ID:</label>
        <input type="text" value="<?php echo htmlspecialchars($row['id']); ?>" disabled>

        <label>Task:</label>
        <input type="text" name="task" value="<?php echo htmlspecialchars($row['task']); ?>" required>

        <label> Date:</label>
        <input type="time" name="task_time" value="<?php echo htmlspecialchars($row['time']); ?>" required>

        <label> Date:</label>
        <input type="date" name="task_date" value="<?php echo htmlspecialchars($row['date']); ?>" required>

        <label for="description">Description:</label>
        <textarea name="description" rows="4" required><?php echo htmlspecialchars($row['description']); ?></textarea>


        <button type="submit">Update Task</button>
    </form>
    </section>
</div>


    </div>

</body>
</html>