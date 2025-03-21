<?php
// Database connection
include "conf.php";

// Fetch lab test data and product names
$sql = "SELECT addorder.OrderID, addorder.ProductID, addorder.Email, addorder.Quantity, addorder.Address, addorder.Amount, product.Name AS ProductName
        FROM addorder
        INNER JOIN product ON addorder.ProductID = product.productID";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Customer Orders</title>
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
        <h1>Owner- Customer Orders</h1>
    </header>
    <section class="profile-container">
    <h2> Customer Orders</h2>

    <input type="text" id="search" placeholder="Search by any field...">

    <table border="1">
        <thead>
            <tr>
                                <th>Order ID</th>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Email</th>
                                <th>Quantity</th>
                                <th>Address</th>
                                <th>Amount</th>
                
                
            </tr>
        </thead>
        <tbody>
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<tr>";
                        echo "<td>" . $row['OrderID'] . "</td>";
                        echo "<td>" . $row['ProductID'] . "</td>";
                        echo "<td>" . $row['ProductName'] . "</td>"; 
                        echo "<td>" . $row['Email'] . "</td>";
                        echo "<td>" . $row['Quantity'] . "</td>";
                        echo "<td>" . $row['Address'] . "</td>";
                        echo "<td>" . $row['Amount'] . "</td>";
                    

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No Order found</td></tr>";
                }
                ?>
        </tbody>
    </table>
    </section>
</div>


    </div>
 <script>
    

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


