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
$totalProducts = 0;
$totalOrders = 0;
$productAnalysis = [];
$orderByTime = [];
$remainingStockData = [];

// Fetch total product quantity
$productQuery = "SELECT SUM(quantity) AS totalProducts FROM product";
$productResult = $conn->query($productQuery);
if ($productResult->num_rows > 0) {
    $totalProducts = $productResult->fetch_assoc()['totalProducts'];
}

// Fetch total ordered quantity
$orderQuery = "SELECT SUM(Quantity) AS totalOrders FROM addorder";
$orderResult = $conn->query($orderQuery);
if ($orderResult->num_rows > 0) {
    $totalOrders = $orderResult->fetch_assoc()['totalOrders'];
}

// Fetch product-wise analysis (total available vs. total sold)
$productSalesQuery = "
    SELECT p.productID, p.name, p.quantity AS availableQty, 
           COALESCE(SUM(o.Quantity), 0) AS soldQty
    FROM product p
    LEFT JOIN addorder o ON p.productID = o.ProductID
    GROUP BY p.productID, p.name, p.quantity
";
$productSalesResult = $conn->query($productSalesQuery);
while ($row = $productSalesResult->fetch_assoc()) {
    $soldPercentage = ($row['availableQty'] + $row['soldQty']) > 0 ? ($row['soldQty'] / ($row['availableQty'] + $row['soldQty'])) * 100 : 0;
    $productAnalysis[] = [
        'ProductID' => $row['productID'],
        'Name' => $row['name'],
        'AvailableQty' => $row['availableQty'],
        'SoldQty' => $row['soldQty'],
        'SoldPercentage' => $soldPercentage
    ];
}

// Time-based analysis (Orders per Month)
$timeQuery = "
    SELECT DATE_FORMAT(OrderDate, '%Y-%m') AS orderMonth, COUNT(*) AS totalOrders
    FROM addorder
    GROUP BY orderMonth
    ORDER BY orderMonth DESC
";
$timeResult = $conn->query($timeQuery);
while ($row = $timeResult->fetch_assoc()) {
    $orderByTime[] = [
        'Month' => $row['orderMonth'],
        'TotalOrders' => $row['totalOrders']
    ];
}

// Remaining stock analysis
$remainingStockQuery = "SELECT productID, name, quantity FROM product";
$remainingStockResult = $conn->query($remainingStockQuery);
while ($row = $remainingStockResult->fetch_assoc()) {
    $remainingPercentage = ($row['quantity'] / $totalProducts) * 100;
    $remainingStockData[] = [
        'ProductID' => $row['productID'],
        'Name' => $row['name'],
        'RemainingQty' => $row['quantity'],
        'RemainingPercentage' => $remainingPercentage
    ];
}

// Timezone for Sri Lanka
date_default_timezone_set("Asia/Colombo");
$createdBy = $_SESSION['user_email'];  // Get the logged-in user's name
$createdTime = date("Y-m-d H:i:s");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production Report</title>
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

        <h2>Production Analysis Report</h2>

        <!-- Summary -->
        <h3>Summary</h3>
        <p><strong>Total Products Available:</strong> <?php echo $totalProducts; ?></p>
        <p><strong>Total Orders Placed:</strong> <?php echo $totalOrders; ?></p>

        <!-- Product Analysis Table -->
        <h3>Product Analysis</h3>
        <table>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Available Quantity</th>
                    <th>Sold Quantity</th>
                    <th>Sold Percentage</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productAnalysis as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['ProductID']); ?></td>
                    <td><?php echo htmlspecialchars($product['Name']); ?></td>
                    <td><?php echo htmlspecialchars($product['AvailableQty']); ?></td>
                    <td><?php echo htmlspecialchars($product['SoldQty']); ?></td>
                    <td><?php echo number_format($product['SoldPercentage'], 2) . '%'; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Time-Based Analysis -->
        <h3>Time-Based Analysis (Orders Per Month)</h3>
        <table>
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Total Orders</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderByTime as $timeData): ?>
                <tr>
                    <td><?php echo htmlspecialchars($timeData['Month']); ?></td>
                    <td><?php echo htmlspecialchars($timeData['TotalOrders']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Remaining Stock Analysis -->
        <h3>Remaining Stock Analysis</h3>
        <table>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Remaining Quantity</th>
                    <th>Remaining Percentage</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($remainingStockData as $stock): ?>
                <tr>
                    <td><?php echo htmlspecialchars($stock['ProductID']); ?></td>
                    <td><?php echo htmlspecialchars($stock['Name']); ?></td>
                    <td><?php echo htmlspecialchars($stock['RemainingQty']); ?></td>
                    <td><?php echo number_format($stock['RemainingPercentage'], 2) . '%'; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button onclick="window.print()" class="print-btn">Print Report</button>
    </div>
</body>
</html>
