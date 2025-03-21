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
$totalMaterials = 0;
$totalStock = 0;
$restockNeededMaterials = 0;
$restockNeededStock = 0;

// Fetch total materials and stocks
$totalMaterialsQuery = "SELECT COUNT(*) AS total FROM pmstock";
$totalStockQuery = "SELECT COUNT(*) AS total FROM pstock";

$totalMaterialsResult = $conn->query($totalMaterialsQuery);
$totalStockResult = $conn->query($totalStockQuery);

if ($totalMaterialsResult->num_rows > 0) {
    $totalMaterials = $totalMaterialsResult->fetch_assoc()['total'];
}
if ($totalStockResult->num_rows > 0) {
    $totalStock = $totalStockResult->fetch_assoc()['total'];
}

// Fetch restock-needed materials
$restockMaterialsQuery = "SELECT COUNT(*) AS count FROM pmstock WHERE rsdate <= CURDATE()";
$restockMaterialsResult = $conn->query($restockMaterialsQuery);
if ($restockMaterialsResult->num_rows > 0) {
    $restockNeededMaterials = $restockMaterialsResult->fetch_assoc()['count'];
}

// Fetch restock-needed stock
$restockStockQuery = "SELECT COUNT(*) AS count FROM pstock WHERE rsdate <= CURDATE()";
$restockStockResult = $conn->query($restockStockQuery);
if ($restockStockResult->num_rows > 0) {
    $restockNeededStock = $restockStockResult->fetch_assoc()['count'];
}

// Fetch all stock and materials
$allMaterials = [];
$allStock = [];

$allMaterialsQuery = "SELECT * FROM pmstock ORDER BY sdate DESC";
$allStockQuery = "SELECT * FROM pstock ORDER BY sdate DESC";

$allMaterialsResult = $conn->query($allMaterialsQuery);
$allStockResult = $conn->query($allStockQuery);

if ($allMaterialsResult->num_rows > 0) {
    while ($row = $allMaterialsResult->fetch_assoc()) {
        $allMaterials[] = $row;
    }
}
if ($allStockResult->num_rows > 0) {
    while ($row = $allStockResult->fetch_assoc()) {
        $allStock[] = $row;
    }
}

// Timezone for Sri Lanka
date_default_timezone_set("Asia/Colombo");
$createdBy = $_SESSION['user_email'];  // Get the logged-in user's name from session
$createdTime = date("Y-m-d H:i:s");

function getStockData($conn, $table, $interval) {
    $query = "SELECT COUNT(*) AS total FROM $table WHERE sdate >= DATE_SUB(CURDATE(), INTERVAL $interval)";
    $result = $conn->query($query);
    return ($result->num_rows > 0) ? $result->fetch_assoc()['total'] : 0;
}

$weeklyMaterials = getStockData($conn, 'pmstock', '7 DAY');
$monthlyMaterials = getStockData($conn, 'pmstock', '1 MONTH');
$yearlyMaterials = getStockData($conn, 'pmstock', '1 YEAR');

$weeklyStock = getStockData($conn, 'pstock', '7 DAY');
$monthlyStock = getStockData($conn, 'pstock', '1 MONTH');
$yearlyStock = getStockData($conn, 'pstock', '1 YEAR');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock & Material Analysis Report</title>
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

        <h2>Stock & Material Analysis Report</h2>

        <!-- Stock Overview -->
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Total Entries</th>
                    <th>Restock Needed</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Raw Materials</td>
                    <td><?php echo $totalMaterials; ?></td>
                    <td><?php echo $restockNeededMaterials; ?></td>
                </tr>
                <tr>
                    <td>Finished Stock</td>
                    <td><?php echo $totalStock; ?></td>
                    <td><?php echo $restockNeededStock; ?></td>
                </tr>
            </tbody>
        </table>

        <h2>Time-Based Stock Analysis</h2>
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Weekly</th>
                    <th>Monthly</th>
                    <th>Yearly</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Raw Materials</td>
                    <td><?php echo $weeklyMaterials; ?></td>
                    <td><?php echo $monthlyMaterials; ?></td>
                    <td><?php echo $yearlyMaterials; ?></td>
                </tr>
                <tr>
                    <td>Finished Stock</td>
                    <td><?php echo $weeklyStock; ?></td>
                    <td><?php echo $monthlyStock; ?></td>
                    <td><?php echo $yearlyStock; ?></td>
                </tr>
            </tbody>
        </table>

        <h2>Raw Material Details</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Material ID</th>
                    <th>Quantity</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Stock Date</th>
                    <th>Restock Date</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (!empty($allMaterials)) {
                    foreach ($allMaterials as $material): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($material['sid']); ?></td>
                        <td><?php echo htmlspecialchars($material['pmid']); ?></td>
                        <td><?php echo htmlspecialchars($material['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($material['location']); ?></td>
                        <td><?php echo htmlspecialchars($material['status']); ?></td>
                        <td><?php echo htmlspecialchars($material['sdate']); ?></td>
                        <td><?php echo htmlspecialchars($material['rsdate']); ?></td>
                    </tr>
                    <?php endforeach; 
                } else {
                    echo "<tr><td colspan='7'>No raw material records found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h2>Finished Stock Details</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product ID</th>
                    <th>Quantity</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Stock Date</th>
                    <th>Restock Date</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (!empty($allStock)) {
                    foreach ($allStock as $stock): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($stock['sid']); ?></td>
                        <td><?php echo htmlspecialchars($stock['pid']); ?></td>
                        <td><?php echo htmlspecialchars($stock['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($stock['location']); ?></td>
                        <td><?php echo htmlspecialchars($stock['status']); ?></td>
                        <td><?php echo htmlspecialchars($stock['sdate']); ?></td>
                        <td><?php echo htmlspecialchars($stock['rsdate']); ?></td>
                    </tr>
                    <?php endforeach; 
                } else {
                    echo "<tr><td colspan='7'>No finished stock records found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <button onclick="window.print()" class="print-btn">Print Report</button>
    </div>
</body>
</html>
