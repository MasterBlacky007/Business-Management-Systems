<?php
include 'conf.php'; // Include your database connection
session_start();

if (!isset($_SESSION['user_email'])) {
    echo "<script>alert('You must be logged in!'); window.location.href='slogin.html';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $driver_id = $_POST['driver_id'];
    $name = $_POST['name'];
    $nic = $_POST['nic'];
    $role = $_POST['role'];
    $vehicle_no = $_POST['vehicle_no'];
    $status = $_POST['status'];
    $reason = ($status === "Not Available") ? $_POST['reason'] : NULL;
    $user_email = $_SESSION['user_email']; // Logged-in user's email

    // Insert/Update into Distributor table
    $query = "INSERT INTO distributor (driver_id, name, nic, role, vehicle_no, status, reason, user_email)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)
              ON DUPLICATE KEY UPDATE 
              name = VALUES(name), nic = VALUES(nic), role = VALUES(role), 
              vehicle_no = VALUES(vehicle_no), status = VALUES(status), 
              reason = VALUES(reason), user_email = VALUES(user_email)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssssss", $driver_id, $name, $nic, $role, $vehicle_no, $status, $reason, $user_email);

    if ($stmt->execute()) {
        echo "<script>alert('Driver status updated successfully!'); window.location.href='dstatus.php';</script>";
    } else {
        echo "<script>alert('Error updating status!');</script>";
    }
    
    $stmt->close();
    $conn->close();
}
?>
