<?php
include "conf.php";
session_start();

if (!isset($_SESSION['user_email'])) {
    echo "Unauthorized access!";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delivery_id'], $_POST['action'])) {
    $delivery_id = $_POST['delivery_id'];
    $action = $_POST['action'];

    // Set the new status based on action
    if ($action === "accept") {
        $new_status = "Accepted";
    } elseif ($action === "reject") {
        $new_status = "Rejected";
    } elseif ($action === "complete") {
        $new_status = "Completed";
    } else {
        echo "Invalid action!";
        exit();
    }

    // Update the database
    $sql = "UPDATE deliveries SET status = ? WHERE delivery_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_status, $delivery_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
