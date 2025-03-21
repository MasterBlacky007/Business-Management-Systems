<?php
session_start(); // Start the session

// Redirect if not logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: slogin.html");
    exit();
}

include "conf.php"; // Include database connection

// Get the logged-in user's email from the session
$email = $_SESSION['user_email'];

// Prepare SQL statement to fetch deliveries assigned to the logged-in driver
$sql = "SELECT delivery_id, destination, delivery_date, products, status FROM deliveries WHERE driver_email = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Delivery</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="dasboard.css">
    <link rel="stylesheet" href="ex.css">
    <script src="cusdash.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
                button.accept {
            background-color: #28a745 !important;
            color: white !important;
            padding: 8px 15px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button.accept:hover {
            background-color: #218838 !important;
        }

        /* Reject Button (Red) */
        button.reject {
            background-color: #dc3545 !important;
            color: white !important;
            padding: 8px 15px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button.reject:hover {
            background-color: #c82333 !important;
        }

        /* Complete Button (Blue) */
        button.complete {
            background-color: #007bff !important;
            color: white !important;
            padding: 8px 15px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button.complete:hover {
            background-color: #0056b3 !important;
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
            <li><a href="disdash.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
                <li><a href="diprofile.php"><i class="fas fa-user"></i><span> Profile</span></a></li>
                <li><a href="dstatus.php"><i class="fas fa-info-circle"></i><span> Status</span></a></li>
                <li><a href="ditask.php"><i class="fas fa-tasks"></i><span> Tasks</span></a></li>
                <li><a href="dvdelevery.php"><i class="fas fa-truck"></i><span> Deliveries</span></a></li>
                <li><a href="didash.html"><i class="fas fa-exclamation-triangle"></i><span> Issues</span></a></li>
                <li><a href="slogin.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Distributor- Deleveries</h1>
            </header>
            <section class="profile-container">
                <h2>My Deliveries</h2>

                <input type="text" id="search" placeholder="Search by any field...">

                
                <?php if ($result->num_rows > 0): ?>
                    <table border="1">
                        <thead>
                            <tr>
                                <th>Delivery ID</th>
                                <th>Destination</th>
                                <th>Delivery Date</th>
                                <th>Products</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['delivery_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['destination']); ?></td>
                                    <td><?php echo htmlspecialchars($row['delivery_date']); ?></td>
                                    <td><?php echo htmlspecialchars($row['products']); ?></td>
                                    <td>
                                        <?php if ($row['status'] === 'Pending'): ?>
                                            <button class="accept" onclick="updateStatus(<?php echo $row['delivery_id']; ?>, 'accept')">Accept</button>
                                            <button class="reject" onclick="updateStatus(<?php echo $row['delivery_id']; ?>, 'reject')">Reject</button>
                                        <?php elseif ($row['status'] === 'Accepted'): ?>
                                            <span style="color: green;">Accepted</span>
                                            <button class="complete" onclick="updateStatus(<?php echo $row['delivery_id']; ?>, 'complete')">Complete</button>
                                        <?php elseif ($row['status'] === 'Rejected'): ?>
                                            <span style="color: red;">Rejected</span>
                                        <?php elseif ($row['status'] === 'Completed'): ?>
                                            <span style="color: blue;">Completed</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No deliveries assigned to you.</p>
                <?php endif; ?>

            </section>
        </div>
    </div>
    <script>
                function updateStatus(deliveryId, action) {
            let formData = new FormData();
            formData.append("delivery_id", deliveryId);
            formData.append("action", action);

            fetch("dudelevery.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "success") {
                    alert("Status updated successfully!");
                    location.reload(); // Refresh the page to reflect changes
                } else {
                    alert("Failed to update status. Try again!");
                }
            })
            .catch(error => console.error("Error:", error));
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
