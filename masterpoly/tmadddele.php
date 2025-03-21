<?php
include "conf.php"; // Database connection

// Fetch distributors
$sql = "SELECT driver_id, name, user_email FROM distributor WHERE status = 'Available'";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TM Dashboard</title>
    <link rel="stylesheet" href="supmakep.css">
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
            <li><a href="tmdash.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
                <li><a href="#"><i class="fas fa-user"></i><span> Profile</span></a></li>
                <li><a href="#"><i class="fas fa-tasks"></i><span> Tasks</span></a></li>
                <li><a href="tmdis.php"><i class="fa-solid fa-people-carry-box"></i><span> Distributors</span></a></li>
                <li><a href="tmdlvrydash.html"><i class="fas fa-truck"></i><span> Deliveries</span></a></li>
                <li><a href="tmvissue.php"><i class="fas fa-exclamation-triangle"></i><span> Issues</span></a></li>
                <li><a href="slogin.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Transport Manager- Add Deliveries</h1>
            </header>
            <section class="dash-container">
                <h2>Add Delivery</h2>
                <form action="adddele.php" method="POST">
                    <label for="distributor">Select Distributor:</label>
                    <select name="driver_id" required>
                        <option value="">-- Select Distributor --</option>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <option value="<?= $row['driver_id'] ?>"><?= $row['name'] ?> (ID: <?= $row['driver_id'] ?>)  Email: <?= $row['user_email'] ?></option>
                        <?php } ?>
                    </select>

                    <label for="destination">Delivery Destination:</label>
                    <input type="text" name="destination" required>

                    <label for="delivery_date">Delivery Date:</label>
                    <input type="date" name="delivery_date" required>

                    <label for="products">Products to Deliver:</label>
                    <textarea name="products" rows="4" required></textarea>


                    <button type="submit">Add Delivery</button>
                </form>

            </section>
        </div>

    </div>
</body>
<footer>
  <div class="footer-container">
      
      <div class="copyright">
          <p><center><b>&copy; 2025 Master Poly (Pvt) Ltd. All rights reserved.</b></center></p>
      </div>
  </div>
</footer>
</html>
