<?php
// Database connection
include "conf.php";

// Check if the delivery ID is provided
if (!isset($_GET['id'])) {
    die("Invalid request. No delivery ID provided.");
}

$deliveryId = $_GET['id'];

// Fetch the current details of the delivery
$sql = "SELECT * FROM deliveries WHERE delivery_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $deliveryId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Delivery not found.");
}

$delivery = $result->fetch_assoc();

// Handle form submission to update the delivery details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newDestination = $_POST['destination'];
    $newDeliveryDate = $_POST['delivery_date'];
    $newProducts = $_POST['products'];
    $updatedTime = date('Y-m-d H:i:s'); // Get current timestamp

    // Update query
    $updateSql = "UPDATE deliveries SET destination = ?, delivery_date = ?, products = ?, updated_at = ? WHERE delivery_id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ssssi", $newDestination, $newDeliveryDate, $newProducts, $updatedTime, $deliveryId);

    if ($stmt->execute()) {
        echo "<script>alert('Delivery details updated successfully!'); window.location.href='tmvdele.php';</script>";
    } else {
        echo "<script>alert('Failed to update delivery details. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Delivery</title>
    <link rel="stylesheet" href="supmakep.css">
    <link rel="stylesheet" href="dasboard.css">
    
    <script src="cusdash.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
</head>

<div class="dashboard">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>Dashboard</h2>
                <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
            </div>
            <ul class="sidebar-menu">
            <li><a href="tmdash.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
                <li><a href="tmprofile.php"><i class="fas fa-user"></i><span> Profile</span></a></li>
                <li><a href="tmtask.php"><i class="fas fa-tasks"></i><span> Tasks</span></a></li>
                <li><a href="tmdis.php"><i class="fa-solid fa-people-carry-box"></i><span> Distributors</span></a></li>
                <li><a href="tmdlvrydash.html"><i class="fas fa-truck"></i><span> Deliveries</span></a></li>
                <li><a href="tmvissue.php"><i class="fas fa-exclamation-triangle"></i><span> Issues</span></a></li>
                <li><a href="slogin.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
    <header>
        <h1>Transport Manager- View Delivery</h1>
    </header>
    <section class="profile-container">

    <h2>Update Delivery Details</h2>

    <form method="POST">
        <label>Delivery ID:</label>
        <input type="text" value="<?php echo htmlspecialchars($delivery['delivery_id']); ?>" disabled>

        <label>Destination:</label>
        <input type="text" name="destination" value="<?php echo htmlspecialchars($delivery['destination']); ?>" required>

        <label>Delivery Date:</label>
        <input type="date" name="delivery_date" value="<?php echo htmlspecialchars($delivery['delivery_date']); ?>" required>

        <label for="products">Products to Deliver:</label>
<textarea name="products" rows="4" required><?php echo htmlspecialchars($delivery['products']); ?></textarea>


        <button type="submit">Update Delivery</button>
    </form>
    </section>
</div>


    </div>

</body>
</html>