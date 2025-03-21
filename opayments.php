<?php
// Database connection
include "conf.php";

// Set default filter to show all payments
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Prepare the SQL query based on the selected filter
$sql = "SELECT * FROM payments";

// Filter based on weekly, monthly, or yearly
if ($filter == 'weekly') {
    $sql .= " WHERE PaymentDate >= CURDATE() - INTERVAL 7 DAY";
} elseif ($filter == 'monthly') {
    $sql .= " WHERE PaymentDate >= CURDATE() - INTERVAL 1 MONTH";
} elseif ($filter == 'yearly') {
    $sql .= " WHERE PaymentDate >= CURDATE() - INTERVAL 1 YEAR";
}

$result = $conn->query($sql);

// Calculate total payments and amounts for the selected filter
$total_sql = "SELECT COUNT(paymentID) AS totalPayments, SUM(Amount) AS totalAmount FROM payments";
if ($filter == 'weekly') {
    $total_sql .= " WHERE PaymentDate >= CURDATE() - INTERVAL 7 DAY";
} elseif ($filter == 'monthly') {
    $total_sql .= " WHERE PaymentDate >= CURDATE() - INTERVAL 1 MONTH";
} elseif ($filter == 'yearly') {
    $total_sql .= " WHERE PaymentDate >= CURDATE() - INTERVAL 1 YEAR";
}
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Payments</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="dasboard.css">
    <link rel="stylesheet" href="ex.css">
    <script src="cusdash.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Search input */
        #search {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        
        #payment-filter {
            width: 200px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin: 10px 0;
            cursor: pointer;
        }

        #payment-filter option {
            padding: 10px;
            background-color: #f9f9f9;
            color: #333;
        }

        #payment-filter:focus {
            outline: none;
            border-color: #007BFF;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

       
        .totals {
            font-size: 18px;
            margin: 10px 0;
            color: #333;
        }

        .totals p {
            margin: 5px 0;
        }

    </style>
</head>
<body>

    <div class="dashboard">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>Dashboard</h2>
                <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
            </div>
            <ul class="sidebar-menu">
            <li><a href="ownerdash.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
                <li><a href="ownerprofile.php"><i class="fas fa-user"></i><span> Profile</span></a></li>
                <li><a href="omtask.html"><i class="fas fa-tasks"></i><span> Tasks</span></a></li>
                <li><a href="omanagertaskdash.html"><i class="fas fa-user-tie"></i><span> Manager Tasks</span></a></li> 
                <li><a href="oemperform.php"><i class="fas fa-chart-line"></i><span> Employee Performances</span></a></li> 
                <li><a href="ostaff.php"><i class="fas fa-users"></i><span> Staff</span></a></li> 
                <li><a href="opayments.php"><i class="fas fa-file-invoice-dollar"></i><span> Payments</span></a></li>
                <li><a href="oddash.html"><i class="fas fa-truck"></i><span> Delivery Orders</span></a></li> 
                <li><a href="ofeed.php"><i class="fas fa-comment-dots"></i><span> Feedbacks</span></a></li>                                
                <li><a href="oreport.html"><i class="fas fa-chart-bar"></i><span> Reports</span></a></li>                 
                <li><a href="slogin.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Owner- Payments</h1>
            </header>
            <section class="profile-container">
                <h2>Payments</h2>

                <!-- Filter Dropdown -->
                <select id="payment-filter" onchange="filterPayments()">
                    <option value="all" <?php echo $filter == 'all' ? 'selected' : ''; ?>>All</option>
                    <option value="weekly" <?php echo $filter == 'weekly' ? 'selected' : ''; ?>>This Week</option>
                    <option value="monthly" <?php echo $filter == 'monthly' ? 'selected' : ''; ?>>This Month</option>
                    <option value="yearly" <?php echo $filter == 'yearly' ? 'selected' : ''; ?>>This Year</option>
                </select>

                <!-- Total Payments and Amounts -->
                <div class="totals">
                    <p>Total Payments: <?php echo $total_row['totalPayments']; ?></p>
                    <p>Total Amount: $<?php echo number_format($total_row['totalAmount'], 2); ?></p>
                </div>

                <input type="text" id="search" placeholder="Search by any field...">

                <table border="1">
                    <thead>
                        <tr>
                            <th>Payment ID</th>
                            <th>Order ID</th>
                            <th>Payment Date</th>
                            <th>Payment Type</th>
                            <th>Payment Details</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['PaymentID'] . "</td>";
                                    echo "<td>" . $row['OrderID'] . "</td>";
                                    echo "<td>" . $row['PaymentDate'] . "</td>";
                                    echo "<td>" . $row['PaymentType'] . "</td>";
                                    echo "<td>" . $row['PaymentDetails'] . "</td>";
                                    echo "<td>" . $row['Amount'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No Payments found</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>

    <script>
        // Filter payments based on selection
        function filterPayments() {
            const filter = document.getElementById('payment-filter').value;
            window.location.href = "?filter=" + filter;
        }

        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("search");
            const tableRows = document.querySelectorAll("tbody tr");

            searchInput.addEventListener("keyup", function () {
                const searchText = searchInput.value.toLowerCase();

                tableRows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    row.style.display = rowText.includes(searchText) ? "" : "none";
                });
            });
        });
    </script>

</body>
</html>
