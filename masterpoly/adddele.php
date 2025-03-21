<?php
include "conf.php"; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $driver_id = $_POST['driver_id'];
    $driver_mail = $_POST['user_email'];
    $destination = $_POST['destination'];
    $delivery_date = $_POST['delivery_date'];
    $products = $_POST['products'];
   

    // Fetch driver email based on selected driver_id
    $query = "SELECT user_email FROM distributor WHERE driver_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $driver_id);
    $stmt->execute();
    $stmt->bind_result($driver_email);
    $stmt->fetch();
    $stmt->close();

     // Check if driver email was found
     if (!$driver_email) {
        echo "<script>alert('Error: Driver email not found!'); window.location.href='tmadddele.php';</script>";
        exit();
    }

   // Insert delivery details into the database
   $query = "INSERT INTO deliveries (driver_id, driver_email, destination, delivery_date, products) 
   VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issss", $driver_id, $driver_email, $destination, $delivery_date, $products);

    if ($stmt->execute()) {
    echo "<script>alert('Delivery added successfully!'); window.location.href='tmadddele.php';</script>";
    } else {
    echo "<script>alert('Error adding delivery!');</script>";
    }

    $stmt->close();
    $conn->close();

}
?>
