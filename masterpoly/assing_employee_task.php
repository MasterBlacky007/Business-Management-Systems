<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Employee Tasks</title>
    <link rel="stylesheet" href="assign.css">
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
        <li><a href="fmdash.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
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
        <div class="title-container">
            <h1 class="head">Assign Employee Tasks</h1>
        </div>

        <!-- Task Assignment Form -->
        <div class="form-container">
            <form method="post">
                <label for="employee">Select Employee:</label>
                <select name="employee_id" required>
                    <option value="">-- Select Employee --</option>
                    <?php
                        include 'config.php';
                        $employees = $conn->query("SELECT Employee_ID, Employee_Name FROM Employee");
                        while ($emp = $employees->fetch_assoc()) {
                            echo "<option value='{$emp['Employee_ID']}'>{$emp['Employee_Name']}</option>";
                        }
                    ?>
                </select>

                <label for="task">Select Task:</label>
                <select name="task_id" required>
                    <option value="">-- Select Task --</option>
                    <?php
                        $tasks = $conn->query("SELECT Task_ID, Description FROM viewtask");
                        while ($task = $tasks->fetch_assoc()) {
                            echo "<option value='{$task['Task_ID']}'>{$task['Description']}</option>";
                        }
                    ?>
                </select>

                <label for="due_date">Due Date:</label>
                <input type="date" name="due_date" required>

                <label for="user">User ID:</label>
                <input type="text" name="user" required>

                <button type="submit">Assign Task</button>

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $employee_id = $_POST['employee_id'];
                    $task_id = $_POST['task_id'];
                    $due_date = $_POST['due_date'];
                    $user = $_POST['user'];

                    // Fetch Employee Name
                    $emp_query = $conn->query("SELECT Employee_Name FROM Employee WHERE Employee_ID = $employee_id");
                    $emp_row = $emp_query->fetch_assoc();
                    $employee_name = $emp_row['Employee_Name'];

                    // Fetch Task Description
                    $task_query = $conn->query("SELECT Description FROM viewtask WHERE Task_ID = $task_id");
                    $task_row = $task_query->fetch_assoc();
                    $task_description = $task_row['Description']; // FIXED COLUMN NAME

                    // Insert into EmployeeTask table
                    $stmt = $conn->prepare("INSERT INTO EmployeeTask (Employee_ID, Employee_Name, Task_ID, Description, Due_Date,User_ID) VALUES (?, ?, ?, ?, ?,?)");
                    $stmt->bind_param("issss", $employee_id, $employee_name, $task_id, $task_description, $due_date,$user);

                    if ($stmt->execute()) {
                        echo "<script>alert('Task Assigned Successfully!');</script>";
                    } else {
                        echo "Error: " . $stmt->error;
                    }

                    $stmt->close();
                    $conn->close();
                }
                ?>

            </form>
        </div>

        <!-- Table of Assigned Tasks -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Task ID</th>
                        <th>Description</th>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Due Date</th>
                        <th>User ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        include 'config.php';
                        $assigned_tasks = $conn->query("SELECT * FROM EmployeeTask");
                        while ($row = $assigned_tasks->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['Task_ID']}</td>";
                            echo "<td>{$row['Description']}</td>";
                            echo "<td>{$row['Employee_ID']}</td>";
                            echo "<td>{$row['Employee_Name']}</td>";
                            echo "<td>{$row['Due_Date']}</td>";
                            echo "<td>{$row['User_ID']}</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
