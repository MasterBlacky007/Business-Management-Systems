<?php
include "conf.php";

if (isset($_GET['id'])) {
    $staff_id = $_GET['id'];

    // Delete query
    $query = "DELETE FROM staff WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $staff_id);

    if ($stmt->execute()) {
        echo "<script>alert('Member removed successfully!'); window.location.href='ostaff.php';</script>";
    } else {
        echo "<script>alert('Error removing member!');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
