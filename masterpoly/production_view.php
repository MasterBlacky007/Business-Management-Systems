<?php

include 'config.php';

// Function to generate the HTML preview of the report
function generateReportPreview($result, $creationTime, $createdBy, $summary) {
    $html = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Mico Organic - Production Cost Report</title>
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
                    <h3>Production Cost Reports</h3>
                    <p class="meta-info">Created by: ' . $createdBy . ' | Created on: ' . $creationTime . '</p>
                </div>';

   

    // Start the table for the report data
    $html .= '<table class="table">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Quantity (Kg)</th>
                    <th>Price</th>
                </tr>';

    // Add rows to the table based on query results
    while ($report = $result->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . $report['report_id'] . '</td>';
        $html .= '<td>' . $report['title'] . '</td>';
        $html .= '<td>' . $report['report_date'] . '</td>';
        $html .= '<td>' . $report['product_id'] . '</td>';
        $html .= '<td>' . $report['product_name'] . '</td>';
        $html .= '<td>' . $report['quantity_kg'] . '</td>';
        $html .= '<td>' . $report['price'] . '</td>';
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
$frequency = $_POST['frequency'] ?? '';
$startDate = $_POST['start_date'] ?? '';
$endDate = $_POST['end_date'] ?? '';

// Prepare the SQL query with dynamic filters
$query = "SELECT * FROM production_reports WHERE 1=1"; // Default WHERE clause
$params = [];
$types = ''; // Initialize $types with an empty string

// Add filters based on form input
if ($reportId) {
    $query .= " AND id = ?";
    $params[] = $reportId;
    $types .= 'i'; // Integer type
}

if ($frequency) {
    $query .= " AND report_frequency = ?";
    $params[] = $frequency;
    $types .= 's'; // String type
}

if ($startDate) {
    $query .= " AND report_date >= ?";
    $params[] = $startDate;
    $types .= 's'; // String type
}

if ($endDate) {
    $query .= " AND report_date <= ?";
    $params[] = $endDate;
    $types .= 's'; // String type
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
$createdBy = 'Production Manager'; // Replace with dynamic data if available

// Summary of the report
$summary = "This report provides a detailed analysis of the production costs, including the product names, quantities, and prices for the specified period. The data presented here will help the management assess the overall cost of production and make informed decisions about pricing and product quantity.";

$reportPreview = generateReportPreview($result, $creationTime, $createdBy, $summary);
echo $reportPreview;

// Button to trigger print dialog
echo '<input type="button" value="Print Report" onclick="printReport()">';
?>
