<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['email'])) {
    header("Location: cuslogin.html");
    exit();
}

include "conf.php";

// Get the logged-in user's email from session
$email = $_SESSION['email'];

// Prepare the SQL statement to fetch customer details by email
$sql = "SELECT * FROM supplier WHERE Email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email); // Bind the email parameter as a string
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

if (!$customer) {
    echo "Customer not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="dasboard.css">
    <script src="cusdash.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            <li><a href="supdash.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
            <li><a href="suprofile.php"><i class="fas fa-user"></i><span> Profile</span></a></li>
            <li><a href="suporder.php"><i class="fa-solid fa-truck-fast"></i><span> Orders</span></a></li>
                <li><a href="supmakepayment.php"><i class="fa-solid fa-file-invoice-dollar"></i><span> Invoices</span></a></li>
                <li><a href="suppayment.php"><i class="fa-solid fa-credit-card"></i><span> Payments</span></a></li>
                <li><a href="supreturn.php"><i class="fa-solid fa-repeat"></i><span>Return Orders</span></a></li>
                <li><a href="Home.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
    <header>
        <h1>My Profile</h1>
    </header>
    <section class="profile-container">
        <h2>Customer Profile</h2>
        
        <div class="profile-item">
            <label>First Name:</label>
            <span><?php echo htmlspecialchars($customer['First_Name']); ?></span>
        </div>
        
        <div class="profile-item">
            <label>Last Name:</label>
            <span><?php echo htmlspecialchars($customer['Last_Name']); ?></span>
        </div>
        
        <div class="profile-item">
            <label>Email:</label>
            <span><?php echo htmlspecialchars($customer['Email']); ?></span>
        </div>
        
        <div class="profile-item">
            <label>Contact:</label>
            <span><?php echo htmlspecialchars($customer['Contact']); ?></span>
        </div>
        
        <div class="profile-item">
            <label>Address:</label>
            <span><?php echo htmlspecialchars($customer['Address']); ?></span>
        </div>
    </section>
</div>


    </div>
    
   
</body>
</html>
