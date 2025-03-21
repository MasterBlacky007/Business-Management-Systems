<?php
// Database connection
include "conf.php";

// SQL query to get employee emails, excluding managers and owner
$sql = "SELECT email FROM staff WHERE role NOT IN ('imanager', 'pmanager', 'fmanager','tmanager', 'Owner')";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Employee for Performance Report</title>
    <link rel="stylesheet" href="report.css">
    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f9ebec;
    margin: 0;
    padding: 0;
}

/* Container for the form */
.container {
    width: 60%;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Heading Style */
h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

/* Form Style */
form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* Label Style */
label {
    font-size: 16px;
    color: #333;
}

/* Dropdown Style */
select {
    padding: 10px;
    font-size: 16px;
    color: #333;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #f9f9f9;
}

/* Button Style */
button {
    padding: 12px 20px;
    background-color: #007BFF;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        width: 90%;
    }
}

    </style>
</head>
<body>
    <div class="container">
        <h2>Select Employee for Performance Report</h2>
        
        <!-- Employee Selection Form -->
        <form action="empperformance.php" method="GET">
            <label for="employeeEmail">Select Employee Email:</label>
            <select name="employeeEmail" id="employeeEmail" required>
                <option value="" disabled selected>Select an employee</option>
                <?php
                if ($result->num_rows > 0) {
                    // Output employee emails
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['email'] . "'>" . $row['email'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No employees found</option>";
                }
                ?>
            </select>
            <button type="submit">Generate Report</button>
        </form>
    </div>
</body>
</html>
