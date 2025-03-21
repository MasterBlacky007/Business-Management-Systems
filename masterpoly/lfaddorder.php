<?php
include('conf.php');

// Start session to manage login state
session_start();

// Get the form data
$productID = $_POST['productID'];
$email = $_POST['email'];
$orderDate = $_POST['exportOrderDate'];
$quantity = $_POST['quantity'];
$destinationAddress = $_POST['destinationAddress'];
$country = $_POST['country'];
$amount = $_POST['amount'];
$description = $_POST['description'];

// SQL to insert data into the addorder table with 'Payment' set to 'pending'
$sql = "INSERT INTO addorder (ProductID, Email, OrderDate, Quantity, Address, Country, Amount, Description, Payment) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssissds", $productID, $email, $orderDate, $quantity, $destinationAddress, $country, $amount, $description);

$response = [];

if ($stmt->execute()) {
    // Get the auto-generated ID
    $orderID = $conn->insert_id;

    $response['success'] = true;
    $response['orderID'] = $orderID; // Return the generated Order ID
} else {
    $response['success'] = false;
    $response['message'] = "Error inserting order: " . $stmt->error;
}

$stmt->close();
$conn->close();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
