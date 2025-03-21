<?php
session_start(); // Start session

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
$totalStock = 0;
$totalSupplied = 0;
$stockStatusData = [];
$supplierData = [];
$restockCount = 0;

// Fetch total stock quantity
$stockQuery = "SELECT SUM(quantity) AS totalStock FROM pmstock";
$stockResult = $conn->query($stockQuery);
if ($stockResult->num_rows > 0) {
    $totalStock = $stockResult->fetch_assoc()['totalStock'];
}

// Fetch total quantity supplied by suppliers
$supplyQuery = "SELECT SUM(Quantity) AS totalSupplied FROM sgenpay";
$supplyResult = $conn->query($supplyQuery);
if ($supplyResult->num_rows > 0) {
    $totalSupplied = $supplyResult->fetch_assoc()['totalSupplied'];
}

// Fetch percentage of materials supplied by each supplier
$supplierQuery = "SELECT SupplierID, SUM(Quantity) AS totalQty FROM sgenpay GROUP BY SupplierID";
$supplierResult = $conn->query($supplierQuery);
while ($row = $supplierResult->fetch_assoc()) {
    $supplierData[] = [
        'SupplierID' => $row['SupplierID'],
        'Quantity' => $row['totalQty'],
        'Percentage' => ($totalSupplied > 0) ? ($row['totalQty'] / $totalSupplied) * 100 : 0
    ];
}

// Fetch stock status breakdown
$statusQuery = "SELECT status, COUNT(*) AS count FROM pmstock GROUP BY status";
$statusResult = $conn->query($statusQuery);
while ($row = $statusResult->fetch_assoc()) {
    $stockStatusData[] = [
        'Status' => $row['status'],
        'Count' => $row['count'],
        'Percentage' => ($totalStock > 0) ? ($row['count'] / $totalStock) * 100 : 0
    ];
}

// Count materials that need restocking
$restockQuery = "SELECT COUNT(*) AS count FROM pmstock WHERE rsdate <= CURDATE()";
$restockResult = $conn->query($restockQuery);
if ($restockResult->num_rows > 0) {
    $restockCount = $restockResult->fetch_assoc()['count'];
}
$restockPercentage = ($totalStock > 0) ? ($restockCount / $totalStock) * 100 : 0;

// Timezone for Sri Lanka
date_default_timezone_set("Asia/Colombo");
$createdBy = $_SESSION['email'];  // Get the logged-in user's name
$createdTime = date("Y-m-d H:i:s");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplies & Material Analysis Report</title>
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

        <h2>Supplies & Material Analysis Report</h2>

        <!-- Quantity Summary -->
        <h3>Quantity Summary</h3>
        <p><strong>Total Quantity Supplied:</strong> <?php echo $totalSupplied; ?></p>
        <p><strong>Total Stock Quantity:</strong> <?php echo $totalStock; ?></p>

        <table>
            <thead>
                <tr>
                    <th>Supplier ID</th>
                    <th>Total Quantity Supplied</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($supplierData as $supplier): ?>
                <tr>
                    <td><?php echo htmlspecialchars($supplier['SupplierID']); ?></td>
                    <td><?php echo htmlspecialchars($supplier['Quantity']); ?></td>
                    <td><?php echo number_format($supplier['Percentage'], 2) . '%'; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Stock Status Analysis -->
        <h3>Stock Status Analysis</h3>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Count</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stockStatusData as $status): ?>
                <tr>
                    <td><?php echo htmlspecialchars($status['Status']); ?></td>
                    <td><?php echo htmlspecialchars($status['Count']); ?></td>
                    <td><?php echo number_format($status['Percentage'], 2) . '%'; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Restock Analysis -->
        <h3>Restock Analysis</h3>
        <p><strong>Materials that need restocking:</strong> <?php echo $restockCount; ?></p>
        <p><strong>Restock Percentage:</strong> <?php echo number_format($restockPercentage, 2) . '%'; ?></p>

        <button onclick="window.print()" class="print-btn">Print Report</button>
    </div>
</body>
</html>
