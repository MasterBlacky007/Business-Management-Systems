<?php
include 'config.php';

// Start session and generate CSRF token if not set
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['csrf_token'];

$message = '';
$searchResults = [];

// Helper function to execute prepared statements
function executeQuery($conn, $query, $params = [], $types = '') {
    $stmt = $conn->prepare($query);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt->get_result();
}

// Pagination Setup
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Handle Search Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    if (!hash_equals($csrfToken, $_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    }

    $reportId = trim($_POST['report_id'] ?? '');
    $startDate = $_POST['start_date'] ?? '';
    $endDate = $_POST['end_date'] ?? '';

    $query = "SELECT * FROM inventory_report WHERE 1=1";
    $params = [];
    $types = '';

    if (!empty($reportId)) {
        $query .= " AND reportId = ?";
        $params[] = $reportId;
        $types .= 's';  // String type for reportId
    }

    if (!empty($startDate) && !empty($endDate)) {
        $query .= " AND date BETWEEN ? AND ?";
        $params[] = $startDate;
        $params[] = $endDate;
        $types .= 'ss';  // String types for startDate and endDate
    }

    $query .= " LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;
    $types .= 'ii';  // Integer types for limit and offset

    $searchResults = executeQuery($conn, $query, $params, $types);
} else {
    // Default: Fetch all reports with pagination
    $query = "SELECT * FROM inventory_report LIMIT ? OFFSET ?";
    $searchResults = executeQuery($conn, $query, [$limit, $offset], 'ii');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reports</title>
    <link rel="stylesheet" href="report.css">
</head>
<body>
    <div class="container">
        <h2>Inventory Report</h2>
        <p><?php echo htmlspecialchars($message); ?></p>

        <!-- Back Button -->
        <div>
            <button onclick="window.location.href='fmreport.html';">Back</button>
        </div>

        <!-- Search Form -->
        <form action="" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
            <div>
                <label for="report_id">Report ID:</label>
                <input type="text" id="report_id" name="report_id" placeholder="Enter Report ID">
            </div>
            
            <div>
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date">
            </div>
            <div>
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date">
            </div>
            <button class='ss1' type="submit" name="search">Search</button>
        </form>

        <!-- Table to view reports -->
        <table border="1">
            <thead>
                <tr>
                    <th>Report ID</th>
                    <th>Type</th>
                    <th>Content</th>
                    <th>Date</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Reorder Level</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($report = $searchResults->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($report['reportId']); ?></td>
                        <td><?php echo htmlspecialchars($report['type']); ?></td>
                        <td><?php echo htmlspecialchars($report['content']); ?></td>
                        <td><?php echo htmlspecialchars($report['date']); ?></td>
                        <td><?php echo htmlspecialchars($report['itemName']); ?></td>
                        <td><?php echo htmlspecialchars($report['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($report['price']); ?></td>
                        <td><?php echo htmlspecialchars($report['category']); ?></td>
                        <td><?php echo htmlspecialchars($report['reorderLevel']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Download Report Form -->
        <form action="inventory_view.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
            <input type="hidden" name="report_id" value="<?php echo htmlspecialchars($_POST['report_id'] ?? ''); ?>">
            <input type="hidden" name="start_date" value="<?php echo htmlspecialchars($_POST['start_date'] ?? ''); ?>">
            <input type="hidden" name="end_date" value="<?php echo htmlspecialchars($_POST['end_date'] ?? ''); ?>">
            <button type="submit" name="download_pdf">View Preview</button>
        </form>

        <!-- Pagination -->
        <div>
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>">Previous</a>
            <?php endif; ?>
            <a href="?page=<?php echo $page + 1; ?>">Next</a>
        </div>
    </div>
</body>
</html>
