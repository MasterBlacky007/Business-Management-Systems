<?php
// Include database configuration
include 'config.php';

// Initialize search query variables
$search_equipment_id = '';
$search_name = '';
$search_status = '';
$search_item = '';

// Check if the search form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $search_equipment_id = $_GET['equipment_id'] ?? '';
    $search_name = $_GET['name'] ?? '';
    $search_status = $_GET['status'] ?? '';
    $search_item = $_GET['item'] ?? '';
}

// Prepare SQL query using prepared statements
$sql = "SELECT * FROM Equipment WHERE 1";
$params = [];
$types = "";

if (!empty($search_equipment_id)) {
    $sql .= " AND Equipment_ID LIKE ?";
    $params[] = "%$search_equipment_id%";
    $types .= "s";
}
if (!empty($search_name)) {
    $sql .= " AND Name LIKE ?";
    $params[] = "%$search_name%";
    $types .= "s";
}
if (!empty($search_status)) {
    $sql .= " AND Status LIKE ?";
    $params[] = "%$search_status%";
    $types .= "s";
}
if (!empty($search_item)) {
    $sql .= " AND item LIKE ?";
    $params[] = "%$search_item%";
    $types .= "s";
}

// Execute the SQL query using prepared statements
$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<link rel="stylesheet" href="viewreport.css">

<!-- Display the search form -->
<h2>Equipment Status</h2>
<form method="GET" action="" style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px;">
    <div style="flex: 1 0 250px;">
        <label for="equipment_id">Equipment ID:</label>
        <input type="text" name="equipment_id" value="<?php echo htmlspecialchars($search_equipment_id); ?>" style="width: 100%;">
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
        <button type="button" onclick="window.location.href='dalire.html';">Back</button>
    </div>
</form>

<!-- Display Stock Data in a Table -->
<h2>Equipment Status Report</h2>

<table border="1" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>Equipment ID</th>
            <th>Item Name</th>
            <th>Status</th>
            <th>Item Type</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['Equipment_ID']) . "</td>
                        <td>" . htmlspecialchars($row['Name']) . "</td>
                        <td>" . htmlspecialchars($row['Status']) . "</td>
                        <td>" . (isset($row['item']) ? htmlspecialchars($row['item']) : 'N/A') . "</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No records found.</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
// Close the database connection
$stmt->close();
$conn->close();
?>
