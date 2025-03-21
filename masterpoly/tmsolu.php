<?php
session_start();
include "conf.php";

// Check if the Issue ID is provided
if (!isset($_GET['id'])) {
    die("Invalid request. No Issue ID provided.");
}

$issueId = $_GET['id'];

// Fetch the current details of the issue
$sql = "SELECT * FROM issues WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $issueId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Issue not found.");
}

$issue = $result->fetch_assoc();

// Handle form submission to update the issue with a solution
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $solution = $_POST['solution'];

    // Validate input
    if (empty($solution)) {
        echo "<script>alert('Solution cannot be empty!'); window.location.href='tmvissue.php';</script>";
        exit();
    }

    // Update query
    $updateSql = "UPDATE issues SET Solution = ? WHERE ID = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("si", $solution, $issueId);

    if ($stmt->execute()) {
        echo "<script>alert('Solution added successfully!'); window.location.href='tmvissue.php';</script>";
    } else {
        echo "<script>alert('Failed to add solution. Please try again.');</script>";
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
            <h1>Transport Manager - Issues</h1>
        </header>
        <section class="profile-container">
            <h2>Add Solution</h2>

            <form method="POST">
                <label>Issue ID:</label>
                <input type="text" name="id" value="<?= htmlspecialchars($issue['ID']); ?>" readonly><br>

                <label>Sent By:</label>
                <input type="text" name="mail" value="<?= htmlspecialchars($issue['UserEmail']); ?>" readonly><br>

                <label>Type:</label>
                <input type="text" name="type" value="<?= htmlspecialchars($issue['Type']); ?>" readonly><br>

                <label>Note:</label>
                <input type="text" name="note" value="<?= htmlspecialchars($issue['Note']); ?>" readonly><br>

                <label>Description:</label>
                <textarea name="description" rows="4" readonly><?= htmlspecialchars($issue['Description']); ?></textarea><br>

                <label for="solution">Solution:</label>
                <textarea name="solution" rows="4" required></textarea><br>

                <button type="submit">Add Solution</button>
            </form>
        </section>
    </div>
</div>

</body>
</html>
