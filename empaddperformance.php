<?php
// Include database connection
include('conf.php');

// Start session to manage login state
session_start();

// Initialize the success message variable
$successMessage = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $eno = $_POST['eno'];
    $jrole = $_POST['jrole'];
    $skill = $_POST['skill'];

    // Insert into the database
    $sql = "INSERT INTO eperformance (eno, jrole, skill) 
            VALUES ('$eno', '$jrole', '$skill')";

    if (mysqli_query($conn, $sql)) {
        // Get the last inserted Employee ID
        $empID = mysqli_insert_id($conn);
        $successMessage = "Employee details added successfully!";
    } else {
        // Display error message
        $successMessage = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}



// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>
    <link rel="stylesheet" href="empaddperformance.css">
    <script src="cusdash.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Sidebar -->
   <nav class="sidebar">
            <div class="sidebar-header">
                <h2>Dashboard</h2>
                <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
            </div>
            <ul class="sidebar-menu">
            <li><a href="empdash.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
                <li><a href="empprofile.php"><i class="fas fa-user"></i><span> Profile</span></a></li>
                <li><a href="emptask.php"><i class="fas fa-tasks"></i><span> Tasks</span></a></li>
                <li><a href="empleave.php"><i class="fa-solid fa-clock"></i><span> Shift/Leave</span></a></li>
                <li><a href="empaddperformance.php"><i class="fa-solid fa-chart-bar"></i><span> Performance</span></a></li>
                <li><a href="slogin.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
            </ul>
        </nav>

    <!-- Main Content -->
    <main>
        <div class="container">
            <h2>Add Performance</h2>
            <?php if ($successMessage): ?>
                <div class="success-message"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <form action="empaddperformance.php" method="POST">
                <label for="eno">Employee No</label>
                <input type="text" id="eno" name="eno" required>

                <label for="jrole">Job Role</label>
                <input type="text" id="jrole" name="jrole" required>

                <label for="skill">Skill</label>
                <input type="text" id="skill" name="skill" required>

                <button type="submit">Submit </button>
            </form>

            
        </div>
    </main>
</body>
</html>
