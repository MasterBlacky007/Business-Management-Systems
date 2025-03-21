<?php

include 'config.php';

// Function to generate the HTML preview of the inventory report
function generateInventoryReportPreview($result, $creationTime, $createdBy, $summary) {
    $html = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Mico Organic - Inventory Report</title>
                <style>
                    body { font-family: Arial, sans-serif; color: #333; background-color: white; }
                    .header { background-color: #4CAF50; padding: 10px; color: white; text-align: center; }
                    .header h1 { margin: 0; font-size: 2em; }
                    .header h3 { margin: 5px 0; font-style: italic; }
                    .header .meta-info { font-size: 0.9em; margin-top: 5px; }
                    .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: center; }
                    .table th { background-color: #4CAF50; color: white; }
                    .table tr:nth-child(even) { background-color: #f2f2f2; }
                    .footer { text-align: center; margin-top: 30px; font-size: 0.9em; }
                    .footer a { color: #4CAF50; text-decoration: none; }

                    /* Print-specific styles */
                    @media print {
                        body {
                            color: #000 !important;
                            background-color: white !important;
                        }
                        .header {
                            background-color: #4CAF50 !important;
                            color: white !important;
                        }
                        .table th {
                            background-color: #4CAF50 !important;
                            color: white !important;
                        }
                        .table tr:nth-child(even) {
                            background-color: #f2f2f2 !important;
                        }
                        .footer {
                            color: #000 !important;
                        }
                    }
                </style>
                <script>
                    function printReport() {
                        window.print(); // Open print dialog
                    }
                </script>
            </head>
            <body>
                <div class="header">
                    <h3>Inventory Report</h3>
                    <p class="meta-info">Created by: ' . $createdBy . ' | Created on: ' . $creationTime . '</p>
                </div>';

    // Start the table for the inventory report data
    $html .= '<table class="table">
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
                </tr>';

    // Add rows to the table based on query results
    while ($report = $result->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . $report['reportId'] . '</td>';
        $html .= '<td>' . $report['type'] . '</td>';
        $html .= '<td>' . $report['content'] . '</td>';
        $html .= '<td>' . $report['date'] . '</td>';
        $html .= '<td>' . $report['itemName'] . '</td>';
        $html .= '<td>' . $report['quantity'] . '</td>';
        $html .= '<td>' . $report['price'] . '</td>';
        $html .= '<td>' . $report['category'] . '</td>';
        $html .= '<td>' . $report['reorderLevel'] . '</td>';
        $html .= '</tr>';
    }

    // Footer section
    $html .= '</table>
    <div class="footer">
                <p>&copy; ' . date('Y') . ' Mico Organic. All rights reserved.</p>
                <p><a href="#">www.micoorganic.com</a></p>
              </div>
            </body>
            </html>';

    return $html;
}

// Retrieve POST data from the form
$reportId = $_POST['report_id'] ?? '';
$type = $_POST['type'] ?? '';
$startDate = $_POST['start_date'] ?? '';
$endDate = $_POST['end_date'] ?? '';

// Prepare the SQL query with dynamic filters
$query = "SELECT * FROM inventory_report WHERE 1=1"; // Default WHERE clause
$params = [];
$types = ''; // Initialize $types with an empty string

// Add filters based on form input
if ($reportId) {
    $query .= " AND reportId = ?";
    $params[] = $reportId;
    $types .= 's'; // String type for reportId
}

if ($type) {
    $query .= " AND type = ?";
    $params[] = $type;
    $types .= 's'; // String type for type
}

if ($startDate) {
    $query .= " AND date >= ?";
    $params[] = $startDate;
    $types .= 's'; // String type for startDate
}

if ($endDate) {
    $query .= " AND date <= ?";
    $params[] = $endDate;
    $types .= 's'; // String type for endDate
}

// Prepare and execute the SQL query with dynamic filters
$stmt = $conn->prepare($query);
if ($types) {
    $stmt->bind_param($types, ...$params); // Bind dynamic parameters
}

// Execute the query and retrieve results
$stmt->execute();
$result = $stmt->get_result();

// Define creation time and creator
$creationTime = date('Y-m-d H:i:s');
$createdBy = 'Inventory Manager'; // Replace with dynamic data if available

// Summary of the report
$summary = "This inventory report provides details of the items, their quantities, prices, and categories over the specified period. The data helps track stock levels, identify reorder needs, and assess overall inventory performance.";

// Generate the HTML preview for the inventory report
$reportPreview = generateInventoryReportPreview($result, $creationTime, $createdBy, $summary);
echo $reportPreview;

// Button to trigger print dialog
echo '<input type="button" value="Print Report" onclick="printReport()">';
?>
