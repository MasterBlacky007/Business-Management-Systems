<?php
include 'config.php';

// Create a function to generate the HTML preview of the stock report
function generateStockReportPreview($result, $creationTime, $createdBy) {
    // Initialize summary variables
    $totalRecords = 0;
    $totalQuantity = 0;
    
    $html = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Mico Organic - Stock Report</title>
                <style>
                    body { font-family: Arial, sans-serif; color: #333; background-color: white; }
                    .header { background-color: #4CAF50; padding: 10px; color: white; text-align: center; }
                    .header h1 { margin: 0; font-size: 2em; }
                    .header h3 { margin: 5px 0; font-style: italic; }
                    .header img { width: 100px; height: auto; margin-bottom: 10px; } 
                    .header .meta-info { font-size: 0.9em; margin-top: 5px; }
                    .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: center; }
                    .table th { background-color: #4CAF50; color: white; }
                    .table tr:nth-child(even) { background-color: #f2f2f2; }
                    .footer { text-align: center; margin-top: 30px; font-size: 0.9em; }
                    .footer a { color: #4CAF50; text-decoration: none; }
                    @media print {
                        .print-button {
                            display: none !important;
                        }
                    }
                    .print-button {
                        background-color: #4CAF50; /* Green */
                        color: white;
                        padding: 10px 20px;
                        font-size: 1em;
                        border: none;
                        cursor: pointer;
                        border-radius: 5px;
                        margin-top: 20px;
                        display: inline-block;
                    }

                    .print-button:hover {
                        background-color: #45a049; /* Darker green */
                    }

                    .print-button:active {
                        background-color: #39843c; /* Even darker green */
                    }
                </style>
                <script>
                    function printReport() {
                        window.print();
                    }
                </script>
            </head>
            <body>
                <div class="header">
                    <!-- Uncomment this line to show logo in the report -->
                    <!-- <img src="https://micoceylonorganics.lk/assets/img/mico.png" alt="Mico Organic Logo"> 
                    <h1>Mico Organic</h1> -->
                    <h3>Stock Report</h3>
                    <p class="meta-info">Created by: ' . $createdBy . ' | Created on: ' . $creationTime . '</p>
                </div>
                
                <table class="table">
                    <tr>
                        <th>Stock ID</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Item Type</th>
                    </tr>';

    // Add rows for each stock item
    while ($stock = $result->fetch_assoc()) {
        $stockID = isset($stock['stockID']) ? $stock['stockID'] : 'N/A';
        $itemName = isset($stock['name']) ? $stock['name'] : 'N/A';
        $quantity = isset($stock['quantity']) ? $stock['quantity'] : 0;
        $status = isset($stock['status']) ? $stock['status'] : 'N/A';
        $itemType = isset($stock['item']) ? $stock['item'] : 'N/A';

        $totalRecords++;
        $totalQuantity += $quantity;

        $html .= '<tr>';
        $html .= '<td>' . $stockID . '</td>';
        $html .= '<td>' . $itemName . '</td>';
        $html .= '<td>' . $quantity . '</td>';
        $html .= '<td>' . $status . '</td>';
        $html .= '<td>' . $itemType . '</td>';
        $html .= '</tr>';
    }

    $html .= '</table>';

    $html .= '<div class="footer">
                <p>&copy; ' . date('Y') . '  All rights reserved.</p>
                <p><a href="#">www..com</a></p>
              </div>

            <input type="button" class="print-button" value="Print Report" onclick="printReport()">';

    $html .= '</body></html>';

    return $html;
}

// Retrieve POST data from the form
$itemId = isset($_POST['item_id']) ? $_POST['item_id'] : '';
$startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$endDate = isset($_POST['end_date']) ? $_POST['end_date'] : '';

// Prepare the SQL query with filters
$query = "SELECT * FROM stock WHERE 1=1";
$params = [];
$types = '';

if ($itemId) {
    $query .= " AND item_id = ?";
    $params[] = $itemId;
    $types .= 'i';
}

if ($startDate) {
    $query .= " AND stock_date >= ?";
    $params[] = $startDate;
    $types .= 's';
}

if ($endDate) {
    $query .= " AND stock_date <= ?";
    $params[] = $endDate;
    $types .= 's';
}

// Prepare and execute the SQL query with dynamic filters
$stmt = $conn->prepare($query);
if ($types) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$creationTime = date('Y-m-d H:i:s');
$createdBy = 'Stock Manager';

$reportPreview = generateStockReportPreview($result, $creationTime, $createdBy);

echo $reportPreview;
?>
