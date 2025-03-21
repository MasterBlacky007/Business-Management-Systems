<?php
include "conf.php";

// Fetch the next available schedule ID
$result = $conn->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = 'schedule'");
$row = $result->fetch_assoc();
$next_id = $row['AUTO_INCREMENT'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = $conn->real_escape_string($_POST['description']);

    // Insert only the description (ID auto-increments)
    $sql = "INSERT INTO schedule (description) VALUES ('$description')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('New schedule added successfully!');
                window.location.href='fmps.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}



$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FM Schedules</title>
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
            <li><a href="fmdash.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
                <li><a href="fmprofile.php"><i class="fas fa-user"></i><span> Profile</span></a></li>
                <li><a href="fmtasks.php"><i class="fas fa-tasks"></i><span> Tasks</span></a></li>
                <li><a href="fmps.php"><i class="fas fa-calendar-alt"></i><span> Production Schedules</span></a></li> 
                <li><a href="fmstask.html"><i class="fas fa-tasks"></i><span> Assign Tasks</span></a></li> 
                <li><a href="viewfeedback.php"><i class="fas fa-comments"></i><span> Feedback Operations</span></a></li> 
                <li><a href="fmreport.html"><i class="fas fa-chart-bar"></i><span> Reports</span></a></li>                 
                <li><a href="slogin.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Factory Manager- Schedules</h1>
            </header>
            <section class="dash-container">
                <h2>Add Schedules</h2><br><br>
                <form action="fmps.php" method="POST" onsubmit="return validateForm()">


                    <div>
                    <label for="scheduleID">Schedule ID:</label>
                    <input type="text" name="scheduleID" value="<?php echo $next_id; ?>" readonly><br><br>
                    </div>
                    
                    <div>
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" rows="5" style="width: 100%;"></textarea>
                    </div><br><br>
                    
                    <div class="save-button">
                        <button type="submit">Add Schedule</button>
                    </div>
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
