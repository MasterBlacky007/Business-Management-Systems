<?php
session_start(); // Start the session

// Redirect if not logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: slogin.html");
    exit();
}

$servername = "localhost";
$username = "Nigeeth";
$password = "2018";
$dbname = "poly";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$totalPayments = 0;
$paypalPayments = 0;
$debitPayments = 0;
$creditPayments = 0;
$totalAmount = 0;

// Fetch total payments
$totalPaymentsQuery = "SELECT COUNT(*) AS total FROM payments";
$totalPaymentsResult = $conn->query($totalPaymentsQuery);
if ($totalPaymentsResult) {
    $data = $totalPaymentsResult->fetch_assoc();
    $totalPayments = $data['total'] ?? 0;
}

// Fetch payment types and their amounts
function fetchPaymentData($conn, $table) {
    $query = "SELECT COUNT(*) AS count, SUM(Amount) AS total FROM $table";
    $result = $conn->query($query);
    $data = $result->fetch_assoc();
    return [
        'count' => $data['count'] ?? 0,
        'total' => $data['total'] ?? 0,
    ];
}

$paypalData = fetchPaymentData($conn, "paypal_table");
$debitData = fetchPaymentData($conn, "debit_table");
$creditData = fetchPaymentData($conn, "credit_table");

$paypalPayments = $paypalData['count'];
$paypalAmount = $paypalData['total'];

$debitPayments = $debitData['count'];
$debitAmount = $debitData['total'];

$creditPayments = $creditData['count'];
$creditAmount = $creditData['total'];

// Calculate total amount
$totalAmount = $paypalAmount + $debitAmount + $creditAmount;

// Prevent division by zero in percentage calculations
function calculatePercentage($count, $total) {
    return ($total > 0) ? number_format(($count / $total) * 100, 2) . '%' : '0.00%';
}

// Fetch all payments
$allPayments = [];
$allPaymentsQuery = "SELECT PaymentID, OrderID, PaymentDate, PaymentType, PaymentDetails, Amount FROM payments ORDER BY PaymentDate DESC";
$allPaymentsResult = $conn->query($allPaymentsQuery);
if ($allPaymentsResult->num_rows > 0) {
    while ($row = $allPaymentsResult->fetch_assoc()) {
        $allPayments[] = $row;
    }
}

// Timezone for Sri Lanka
date_default_timezone_set("Asia/Colombo");
$createdBy = $_SESSION['user_email']; // Get the logged-in user's email from session
$createdTime = date("Y-m-d H:i:s");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Analytics Report</title>
    <link rel="stylesheet" href="report.css"> 
</head>
<body>
    <div class="container report">
        <div class="letterhead">
            <img src="images/logo.jpeg" alt="Logo" class="logo"> 
            <div class="details">
                <h1>MASTER POLY (PVT) LTD</h1>
                <p>134/2, Mampe Maharagama Rd, Piliyandala</p>
                <p>Tel: 0112617575</p>
                <p>Email: info@masterpoly.com | Web: www.masterpoly.com</p>
            </div>
        </div>

        <div class="header-details">
            <div class="left">
                <p><strong>Created By:</strong> <?php echo htmlspecialchars($createdBy); ?></p>
            </div>
            <div class="right">
                <p><strong>Created Date & Time:</strong> <?php echo $createdTime; ?></p>
            </div>
        </div>

        <h2>Payment Analytics Report</h2>

        <!-- Payment Type Breakdown Table -->
        <table>
            <thead>
                <tr>
                    <th>Payment Type</th>
                    <th>Total Payments</th>
                    <th>Total Amount</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Paypal</td>
                    <td><?php echo $paypalPayments; ?></td>
                    <td><?php echo number_format($paypalAmount, 2); ?></td>
                    <td><?php echo calculatePercentage($paypalPayments, $totalPayments); ?></td>
                </tr>
                <tr>
                    <td>Debit</td>
                    <td><?php echo $debitPayments; ?></td>
                    <td><?php echo number_format($debitAmount, 2); ?></td>
                    <td><?php echo calculatePercentage($debitPayments, $totalPayments); ?></td>
                </tr>
                <tr>
                    <td>Credit</td>
                    <td><?php echo $creditPayments; ?></td>
                    <td><?php echo number_format($creditAmount, 2); ?></td>
                    <td><?php echo calculatePercentage($creditPayments, $totalPayments); ?></td>
                </tr>
            </tbody>
        </table>

        <div class="summary">
            <h2>Summary</h2>
            <p><strong>Total Payments:</strong> <?php echo $totalPayments; ?></p>
            <p><strong>Total Amount:</strong> <?php echo number_format($totalAmount, 2); ?></p>
        </div>

        <h2>All Payments</h2>

        <!-- Normal Table Listing All Payments -->
        <table>
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Order ID</th>
                    <th>Payment Date</th>
                    <th>Payment Type</th>
                    <th>Payment Details</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (!empty($allPayments)) {
                    foreach ($allPayments as $payment): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($payment['PaymentID']); ?></td>
                        <td><?php echo htmlspecialchars($payment['OrderID']); ?></td>
                        <td><?php echo htmlspecialchars($payment['PaymentDate']); ?></td>
                        <td><?php echo htmlspecialchars($payment['PaymentType']); ?></td>
                        <td><?php echo htmlspecialchars($payment['PaymentDetails']); ?></td>
                        <td><?php echo number_format($payment['Amount'], 2); ?></td>
                    </tr>
                    <?php endforeach; 
                } else {
                    echo "<tr><td colspan='6'>No payment records found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <button onclick="window.print()" class="print-btn">Print Report</button>
    </div>
</body>
</html>
