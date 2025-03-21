<?php
include "conf.php";

if (isset($_GET['id'])) {
    $driver_id = $_GET['id'];

    // Delete query
    $query = "DELETE FROM distributor WHERE driver_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $driver_id);

    if ($stmt->execute()) {
        echo "<script>alert('Driver removed successfully!'); window.location.href='tmdis.php';</script>";
    } else {
        echo "<script>alert('Error removing driver!');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
