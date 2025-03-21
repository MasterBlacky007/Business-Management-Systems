<?php
// Include database configuration
include 'config.php';

// Initialize search query variables
$search_stock_id = '';
$search_name = '';
$search_status = '';
$search_item = '';

// Check if the search form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    // Get the search criteria
    $search_stock_id = $_GET['stock_id'];
    $search_name = $_GET['name'];
    $search_status = $_GET['status'];
    $search_item = $_GET['item'];
}

// Prepare SQL query to fetch stock data based on search criteria
$sql = "SELECT * FROM Stock WHERE 1";

// Add filters to the query based on the search criteria
if (!empty($search_stock_id)) {
    $sql .= " AND stockID LIKE '%" . $conn->real_escape_string($search_stock_id) . "%'";
}
if (!empty($search_name)) {
    $sql .= " AND name LIKE '%" . $conn->real_escape_string($search_name) . "%'";
}
if (!empty($search_status)) {
    $sql .= " AND status LIKE '%" . $conn->real_escape_string($search_status) . "%'";
}
if (!empty($search_item)) {
    $sql .= " AND item LIKE '%" . $conn->real_escape_string($search_item) . "%'";
}

// Execute the SQL query
$result = $conn->query($sql);

?>

<link rel="stylesheet" href="viewreport.css">

<!-- Display the search form -->
<h2>Search Stock Status</h2>
<form method="GET" action="" style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px;">
    <div style="flex: 1 0 250px;">
        <label for="stock_id">Stock ID:</label>
        <input type="text" name="stock_id" value="<?php echo htmlspecialchars($search_stock_id); ?>" style="width: 100%;">
    </div>
    
    <div style="flex: 1 0 250px;">
        <label for="name">Item Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($search_name); ?>" style="width: 100%;">
    </div>

    <div style="flex: 1 0 250px;">
        <label for="status">Stock Status:</label>
        <input type="text" name="status" value="<?php echo htmlspecialchars($search_status); ?>" style="width: 100%;">
    </div>

    <div style="flex: 1 0 250px;">
        <label for="item">Item Type:</label>
        <input type="text" name="item" value="<?php echo htmlspecialchars($search_item); ?>" style="width: 100%;">
    </div>

    <div style="flex: 0 1 150px;">
        <button type="submit" name="search" style="width: 100%;">Search</button>
    </div>
    <div>
        <button onclick="window.location.href='dalire.html';">Back</button>
    </div>
</form>

<!-- Display Stock Data in a Table -->
<h2>Stock Status Report</h2>
<table border="1" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>Stock ID</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Item Type</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['stockID']) . "</td>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['quantity']) . "</td>
                        <td>" . htmlspecialchars($row['status']) . "</td>
                        <td>" . htmlspecialchars($row['item']) . "</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No records found.</td></tr>";
        }
        ?>
    </tbody>
</table>

<!-- PDF Download Button -->
<form method="POST" action="download_pdf.php">
    <input type="hidden" name="stock_id" value="<?php echo htmlspecialchars($search_stock_id); ?>">
    <input type="hidden" name="name" value="<?php echo htmlspecialchars($search_name); ?>">
    <input type="hidden" name="status" value="<?php echo htmlspecialchars($search_status); ?>">
    <input type="hidden" name="item" value="<?php echo htmlspecialchars($search_item); ?>">
    <button type="submit" name="download_pdf">Download PDF</button>
</form>

<?php
// Close the database connection after all operations are complete
$conn->close();
?>
