<?php
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
$totalDeliveries = 0;
$completedDeliveries = 0;
$pendingDeliveries = 0;
$mostCommonDestination = "N/A";
$deliveriesData = [];

// Fetch total deliveries
$totalDeliveriesQuery = "SELECT COUNT(*) AS total FROM deliveries";
$totalDeliveriesResult = $conn->query($totalDeliveriesQuery);
if ($totalDeliveriesResult->num_rows > 0) {
    $totalDeliveries = $totalDeliveriesResult->fetch_assoc()['total'];
}

// Fetch completed deliveries
$completedDeliveriesQuery = "SELECT COUNT(*) AS completed FROM deliveries WHERE status = 'Completed'";
$completedDeliveriesResult = $conn->query($completedDeliveriesQuery);
if ($completedDeliveriesResult->num_rows > 0) {
    $completedDeliveries = $completedDeliveriesResult->fetch_assoc()['completed'];
}

// Fetch pending deliveries
$pendingDeliveriesQuery = "SELECT COUNT(*) AS pending FROM deliveries WHERE status = 'Pending'";
$pendingDeliveriesResult = $conn->query($pendingDeliveriesQuery);
if ($pendingDeliveriesResult->num_rows > 0) {
    $pendingDeliveries = $pendingDeliveriesResult->fetch_assoc()['pending'];
}

// Fetch most common delivery destination
$mostCommonDestinationQuery = "SELECT destination, COUNT(*) AS count FROM deliveries GROUP BY destination ORDER BY count DESC LIMIT 1";
$mostCommonDestinationResult = $conn->query($mostCommonDestinationQuery);
if ($mostCommonDestinationResult->num_rows > 0) {
    $mostCommonDestination = $mostCommonDestinationResult->fetch_assoc()['destination'];
}

// Fetch breakdown by status
$deliveryStatusQuery = "SELECT status, COUNT(*) AS count FROM deliveries GROUP BY status";
$deliveryStatusResult = $conn->query($deliveryStatusQuery);
if ($deliveryStatusResult->num_rows > 0) {
    while ($row = $deliveryStatusResult->fetch_assoc()) {
        $deliveriesData[] = [
            'status' => $row['status'],
            'total_deliveries' => $row['count'],
            'percentage' => ($row['count'] / $totalDeliveries) * 100
        ];
    }
}

// Fetch normal table data (All Deliveries)
$allDeliveries = [];
$allDeliveriesQuery = "SELECT delivery_id, destination, status, delivery_date FROM deliveries ORDER BY delivery_date DESC";
$allDeliveriesResult = $conn->query($allDeliveriesQuery);
if ($allDeliveriesResult->num_rows > 0) {
    while ($row = $allDeliveriesResult->fetch_assoc()) {
        $allDeliveries[] = $row;
    }
}

// Timezone for Sri Lanka
date_default_timezone_set("Asia/Colombo");
$createdBy = "Transport Manager"; 
$createdTime = date("Y-m-d H:i:s");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Analytics Report</title>
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
                <p><strong>Created By:</strong> <?php echo $createdBy; ?></p>
            </div>
            <div class="right">
                <p><strong>Created Date & Time:</strong> <?php echo $createdTime; ?></p>
            </div>
        </div>

        <h2>Delivery Analytics Report</h2>

        <!-- Status Breakdown Table -->
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Total Deliveries</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (!empty($deliveriesData)) {
                    foreach ($deliveriesData as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['status']); ?></td>
                        <td><?php echo htmlspecialchars($data['total_deliveries']); ?></td>
                        <td><?php echo number_format($data['percentage'], 2) . '%'; ?></td>
                    </tr>
                    <?php endforeach; 
                } else {
                    echo "<tr><td colspan='3'>No delivery data available</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="summary">
            <h2>Summary</h2>
            <p><strong>Total Deliveries:</strong> <?php echo $totalDeliveries; ?></p>
            <p><strong>Completed Deliveries:</strong> <?php echo $completedDeliveries; ?></p>
            <p><strong>Pending Deliveries:</strong> <?php echo $pendingDeliveries; ?></p>
            <p><strong>Most Common Delivery Destination:</strong> <?php echo htmlspecialchars($mostCommonDestination); ?></p>
        </div>

        <h2>All Deliveries</h2>

        <!-- Normal Table Listing All Deliveries -->
        <table>
            <thead>
                <tr>
                    <th>Delivery ID</th>
                    <th>Destination</th>
                    <th>Status</th>
                    <th>Delivery Date</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (!empty($allDeliveries)) {
                    foreach ($allDeliveries as $delivery): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($delivery['delivery_id']); ?></td>
                        <td><?php echo htmlspecialchars($delivery['destination']); ?></td>
                        <td><?php echo htmlspecialchars($delivery['status']); ?></td>
                        <td><?php echo htmlspecialchars($delivery['delivery_date']); ?></td>
                    </tr>
                    <?php endforeach; 
                } else {
                    echo "<tr><td colspan='4'>No delivery records found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <button onclick="window.print()" class="print-btn">Print Report</button>
    </div>
</body>
</html>
