<?php
session_start();
include "conf.php";

// Check if the Issue ID is provided
if (!isset($_GET['id'])) {
    die("Invalid request. No Feedback ID provided.");
}

$replyId = $_GET['id'];

// Fetch the current details of the issue
$sql = "SELECT * FROM cusfeedback WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $replyId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Feedback not found.");
}

$reply = $result->fetch_assoc();

// Handle form submission to update the issue with a solution
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reply = $_POST['reply'];

    // Validate input
    if (empty($reply)) {
        echo "<script>alert('Reply cannot be empty!'); window.location.href='viewfeedback.php';</script>";
        exit();
    }

    // Update query
    $updateSql = "UPDATE cusfeedback SET reply = ? WHERE ID = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("si", $reply, $replyId);

    if ($stmt->execute()) {
        echo "<script>alert('Reply added successfully!'); window.location.href='viewfeedback.php';</script>";
    } else {
        echo "<script>alert('Failed to add reply. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TM Issues</title>
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
            <h1>Factory Manager - Feedback</h1>
        </header>
        <section class="profile-container">
            <h2>Add Feedback</h2>

            <form method="POST">
                <label>Feedback ID:</label>
                <input type="text" name="id" value="<?= htmlspecialchars($reply['id']); ?>" readonly><br>

                <label>Feedback Type:</label>
                <input type="text" name="type" value="<?= htmlspecialchars($reply['FeedbackType']); ?>" readonly><br>

                <label>Name:</label>
                <input type="text" name="name" value="<?= htmlspecialchars($reply['Name']); ?>" readonly><br>

                <label>Email:</label>
                <input type="text" name="mail" value="<?= htmlspecialchars($reply['Email']); ?>" readonly><br>

                <label>Description:</label>
                <textarea name="description" rows="4" readonly><?= htmlspecialchars($reply['Discription']); ?></textarea><br>

                <label for="reply">Reply:</label>
                <textarea name="reply" rows="4" required></textarea><br>

                <button type="submit">Add Reply</button>
            </form>
        </section>
    </div>
</div>

</body>
</html>
