<?php
include 'conf.php';

date_default_timezone_set('Asia/Colombo');

// Function to generate the report preview for eperformance data
function generateReportPreview($result, $creationTime, $createdBy) {
    $html = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Master Poly - Performance Report</title>
                <style>
                    body { font-family: Arial, sans-serif; color: #333; background-color: white; }
                    .header { background-color: rgb(6, 138, 245); padding: 10px; color: white; text-align: center; }
                    .header h1 { margin: 0; font-size: 2em; }
                    .header h3 { margin: 5px 0; font-style: italic; }
                    .header img { width: 100px; height: auto; margin-bottom: 10px; } 
                    .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: center; }
                    .table th { background-color: rgb(6, 138, 245); color: white; }
                    .table tr:nth-child(even) { background-color: #f2f2f2; }
                    .summary { margin-top: 30px; border: 1px solid #ddd; padding: 10px; }
                    .footer { text-align: center; margin-top: 30px; font-size: 0.9em; }
                    .footer a { color: rgb(6, 138, 245); text-decoration: none; }
                    @media print {
                        .print-button, .back-button { display: none !important; }
                    }
                    .print-button, .back-button {
                        background-color: rgb(6, 138, 245); color: white;
                        padding: 10px 20px; font-size: 1em; border: none;
                        cursor: pointer; border-radius: 5px; margin-top: 20px;
                        display: inline-block;
                    }
                    .print-button:hover, .back-button:hover { background-color: rgb(6, 138, 245); }
                </style>
                <script>
                    function printReport() { window.print(); }
                    function goBack() { window.history.back(); }
                </script>
            </head>
            <body>
                <div class="header">
                    <img src="images/logo.png" alt="Master Poly Logo"> 
                    <h1>Master Poly</h1>
                    <h3>Performance Report</h3>
                    <p> Created by: ' . $createdBy . ' | Created on: ' . $creationTime . ' </p>                    
                </div>
                <table class="table">
                    <tr>
                        <th>Employee No</th><th>Job Role</th><th>Skill</th>
                    </tr>';

    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
                    <td>' . $row['eno'] . '</td>
                    <td>' . $row['jrole'] . '</td>
                    <td>' . $row['skill'] . '</td>
                  </tr>';
    }

    $html .= '</table>';
    $html .= '<div class="footer">
                <p>&copy; ' . date('Y') . ' Master Poly (Pvt) Ltd. All rights reserved.</p>
                <p><a href="#">www.masterpoly.com</a></p>
              </div>';
    return $html;
}

// Query to fetch performance data from eperformance table
$query = "SELECT * FROM eperformance";
$result = $conn->query($query);
$creationTime = date('Y-m-d H:i:s');
$createdBy = 'Supervisor';
$reportPreview = generateReportPreview($result, $creationTime, $createdBy);

echo $reportPreview;
echo '<input type="button" class="print-button" value="Print Report" onclick="printReport()">';
echo '<input type="button" class="back-button" value="Back" onclick="goBack()">';

$conn->close();
?>
