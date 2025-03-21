<?php
include "conf.php";

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    // Delete query
    $query = "DELETE FROM ownertask WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $task_id);

    if ($stmt->execute()) {
        echo "<script>alert('Task removed successfully!'); window.location.href='ovtask.php';</script>";
    } else {
        echo "<script>alert('Error removing Task!');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
