<?php
// Include database connection
include 'config.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_description = $_POST['task_description'];
    $due_date = $_POST['due_date'];

    // Prepare SQL statement to insert task without Task_ID (auto-generated)
    $stmt = $conn->prepare("INSERT INTO viewtask (Description, Due_Date) VALUES (?, ?)");
    $stmt->bind_param("ss", $task_description, $due_date);

    if ($stmt->execute()) {
        echo "<script>alert('Task Assigned Successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Staff Tasks</title>
    <link rel="stylesheet" href="assign.css">
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
            <li><a href="#">Home</a></li>
            <li><a href="#">View Tasks</a></li>
            <li><a href="#">LogOut</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main>
        <div class="title-container">
            <h1 class="head">Assign Staff Tasks</h1>
        </div>

        <!-- Task Assignment Form -->
        <div class="form-container">
            <form method="post">
                <!-- Task ID will be auto-generated by the database -->
                <label for="task_description">Task Description:</label>
                <input type="text" name="task_description" required>

                <!-- Due Date -->
                <label for="due_date">Due Date:</label>
                <input type="date" name="due_date" required>

                <button type="submit">Assign Task</button>
            </form>
        </div>

        <!-- Table of Assigned Tasks -->
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
                        // Fetch all assigned tasks
                        $assigned_tasks = $conn->query("SELECT * FROM viewtask");
                        while ($row = $assigned_tasks->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['Task_ID']}</td>";
                            echo "<td>{$row['Description']}</td>";
                            echo "<td>{$row['Due_Date']}</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
