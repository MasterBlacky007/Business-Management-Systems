<?php
// Include database connection
include('conf.php');

// Get Order ID from query parameter
$oid = $_GET['oid'];

// Fetch order details from the database
$query = "SELECT * FROM sgenpay WHERE OrderID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $oid);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .invoice-container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .invoice-header h1 {
            margin: 0;
            font-size: 2em;
            color: #333;
        }

        .invoice-header p {
            margin: 5px 0;
            font-size: 1em;
            color: #555;
        }

        .invoice-details {
            margin-bottom: 30px;
        }

        .invoice-details th, .invoice-details td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .invoice-details th {
            background-color: #f2f2f2;
        }

        .invoice-footer {
            text-align: right;
            margin-top: 30px;
            font-size: 1.2em;
        }

        .invoice-footer .total {
            font-weight: bold;
        }

        .invoice-footer p {
            margin: 5px 0;
        }

        .print-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 1.1em;
        }

        .print-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <h1>Invoice</h1>
            <p>Order Number: <?php echo htmlspecialchars($order['OrderID']); ?></p>
            <p>Order Date: <?php echo htmlspecialchars($order['OrderDate']); ?></p>
        </div>

        <div class="invoice-details">
            <table style="width: 100%;">
                <tr>
                    <th>Supplier Email</th>
                    <td><?php echo htmlspecialchars($order['Email']); ?></td>
                </tr>
                <tr>
                    <th>Order ID</th>
                    <td><?php echo htmlspecialchars($order['OrderID']); ?></td>
                </tr>
                <tr>
                    <th>Quantity</th>
                    <td><?php echo htmlspecialchars($order['Quantity']); ?></td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td><?php echo htmlspecialchars($order['Price']); ?></td>
                </tr>
                <tr>
                    <th>Order Amount</th>
                    <td><?php echo htmlspecialchars($order['OrderAmount']); ?></td>
                </tr>
            </table>
        </div>

        <div class="invoice-footer">
            <p class="total">Total: <?php echo htmlspecialchars($order['OrderAmount']); ?> USD</p>
            <p>Thank you for your business!</p>
        </div>

        <button class="print-button" onclick="window.print()">Print Invoice</button>
    </div>
</body>
</html>
