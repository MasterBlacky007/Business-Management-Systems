<?php
include "conf.php";

if (isset($_GET['id'])) {
    $driver_id = $_GET['id'];

    // Delete query
    $query = "DELETE FROM deliveries WHERE delivery_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $driver_id);

    if ($stmt->execute()) {
        echo "<script>alert('Deliver removed successfully!'); window.location.href='tmvdele.php';</script>";
    } else {
        echo "<script>alert('Error removing deliver!');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
