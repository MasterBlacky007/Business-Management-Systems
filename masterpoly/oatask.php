<?php
// Database connection
include "conf.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form input values
    $task = trim($_POST['note']);
    $time = $_POST['time'];
    $date = $_POST['date'];
    $description = trim($_POST['description']);

    // Validate input fields (basic validation)
    if (empty($task) || empty($time) || empty($date) || empty($description)) {
        echo "<script>alert('Please fill in all fields!'); window.history.back();</script>";
        exit();
    }

    // Prepare the SQL query to insert the task into the database
    $sql = "INSERT INTO ownertask (task, time, date, description) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Bind the parameters and execute the query
        $stmt->bind_param("ssss", $task, $time, $date, $description);

        if ($stmt->execute()) {
            // Redirect to a success page or show a success message
            echo "<script>alert('Task added successfully!'); window.location.href='ovtask.php';</script>";
        } else {
            echo "<script>alert('Failed to add task. Please try again later.');</script>";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "<script>alert('Database error. Please try again later.');</script>";
    }

    // Close the database connection
    $conn->close();
}
?>
