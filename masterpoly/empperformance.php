<?php
session_start(); // Start the session

// Redirect if not logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: slogin.html");
    exit();
}

include "conf.php";

// Fetch supervisor-selected employee email
$employeeEmail = isset($_GET['employeeEmail']) ? $conn->real_escape_string($_GET['employeeEmail']) : '';

// Initialize variables for employee task performance
$totalTasks = 0;
$completedTasks = 0;
$pendingTasks = 0;
$taskDetails = [];
$timeBasedData = [];
$taskCompletionPercentage = 0;

// Fetch employee task data
$taskQuery = "
    SELECT task_id, taskname, description, assignby, assignto, startdate, enddate, sstatus, created_at
    FROM task
    WHERE assignto = '$employeeEmail'
";
$taskResult = $conn->query($taskQuery);

if (!$taskResult) {
    die("Query failed: " . $conn->error);
}

// Analyze task completion
while ($row = $taskResult->fetch_assoc()) {
    $totalTasks++;
    if ($row['sstatus'] == 'Completed') {
        $completedTasks++;
    } else {
        $pendingTasks++;
    }

    $taskDetails[] = $row;
}

// Calculate task completion percentage
if ($totalTasks > 0) {
    $taskCompletionPercentage = ($completedTasks / $totalTasks) * 100;
}

// Time-based task analysis (tasks per month)
$timeQuery = "
    SELECT DATE_FORMAT(created_at, '%Y-%m') AS taskMonth, COUNT(*) AS totalTasks
    FROM task
    WHERE assignto = '$employeeEmail'
    GROUP BY taskMonth
    ORDER BY taskMonth DESC
";
$timeResult = $conn->query($timeQuery);

if (!$timeResult) {
    die("Time query failed: " . $conn->error);
}

while ($row = $timeResult->fetch_assoc()) {
    $timeBasedData[] = [
        'Month' => $row['taskMonth'],
        'TotalTasks' => $row['totalTasks']
    ];
}

// Timezone for Sri Lanka
date_default_timezone_set("Asia/Colombo");
$createdBy = $_SESSION['user_email'];  // Get the logged-in user's name
$createdTime = date("Y-m-d H:i:s");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Performance Report</title>
    <link rel="stylesheet" href="report.css"> 
</head>
<body>
    <div class="container report">
        <div class="letterhead">
            <img src="images/logo.jpeg" alt="Logo" class="logo"> 
            <div class="details">
                <h1>MASTER POLY (PVT) LTD</h1>
                <p>134/2, Mampe Maharagama Rd, Piliyandala</p>
                <p>Tel: 0112617575</p>
                <p>Email: info@masterpoly.com | Web: www.masterpoly.com</p>
            </div>
        </div>

        <div class="header-details">
            <div class="left">
                <p><strong>Created By:</strong> <?php echo htmlspecialchars($createdBy); ?></p>
            </div>
            <div class="right">
                <p><strong>Created Date & Time:</strong> <?php echo $createdTime; ?></p>
            </div>
        </div>

        <h2>Employee Performance Report for <?php echo htmlspecialchars($employeeEmail); ?></h2>

        <!-- Summary -->
        <h3>Summary</h3>
        <p><strong>Total Tasks Assigned:</strong> <?php echo $totalTasks; ?></p>
        <p><strong>Completed Tasks:</strong> <?php echo $completedTasks; ?></p>
        <p><strong>Pending Tasks:</strong> <?php echo $pendingTasks; ?></p>
        <p><strong>Task Completion Percentage:</strong> <?php echo number_format($taskCompletionPercentage, 2) . '%'; ?></p>

        <!-- Time-Based Task Analysis -->
        <h3>Time-Based Task Analysis (Tasks Per Month)</h3>
        <table>
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Total Tasks</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($timeBasedData as $timeData): ?>
                <tr>
                    <td><?php echo htmlspecialchars($timeData['Month']); ?></td>
                    <td><?php echo htmlspecialchars($timeData['TotalTasks']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Task Details -->
        <h3>Task Details</h3>
        <table>
            <thead>
                <tr>
                    <th>Task ID</th>
                    <th>Task Name</th>
                    <th>Description</th>
                    <th>Assigned By</th>
                    <th>Assigned To</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($taskDetails as $task): ?>
                <tr>
                    <td><?php echo htmlspecialchars($task['task_id']); ?></td>
                    <td><?php echo htmlspecialchars($task['taskname']); ?></td>
                    <td><?php echo htmlspecialchars($task['description']); ?></td>
                    <td><?php echo htmlspecialchars($task['assignby']); ?></td>
                    <td><?php echo htmlspecialchars($task['assignto']); ?></td>
                    <td><?php echo htmlspecialchars($task['startdate']); ?></td>
                    <td><?php echo htmlspecialchars($task['enddate']); ?></td>
                    <td><?php echo htmlspecialchars($task['sstatus']); ?></td>
                    <td><?php echo htmlspecialchars($task['created_at']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button onclick="window.print()" class="print-btn">Print Report</button>
    </div>
</body>
</html>
