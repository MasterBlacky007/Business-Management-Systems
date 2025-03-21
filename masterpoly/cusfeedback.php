<?php 
include('conf.php');  // Include your database configuration

// Start session to manage login state
session_start();
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
//$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedbackType = $_POST['feedbackType'];
    $description = $_POST['description'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];

    $name = $firstName . " " . $lastName;

    $sql = "INSERT INTO cusfeedback (FeedbackType, Name, Email, Discription)
            VALUES ('$feedbackType', '$name', '$email', '$description')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Thank you for your feedback!'); window.location.href = 'cusfeedback.php';</script>";
        
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="lffeedback.css">
    <script src="cusdash.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Inline CSS for displaying the message */
        .message {
            color: green;
            font-weight: bold;
            display: block;
            margin-bottom: 15px; /* Adds space below the message */
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
            <div class="sidebar-header">
                <h2>Dashboard</h2>
                <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
            </div>
            <ul class="sidebar-menu">
            <li><a href="dasboard.html"><i class="fas fa-home"></i><span> Dashboard</span></a></li>
                <li><a href="cusprofile.php"><i class="fas fa-user"></i><span> Profile</span></a></li>
                <li><a href="cuspv.php"><i class="fas fa-shopping-cart"></i><span> Products</span></a></li>
                <li><a href="cusorder.html"><i class="fas fa-shopping-cart"></i><span> Orders</span></a></li>
                <li><a href="cusfeedback.php"><i class="fa-solid fa-comment-dots"></i><span> Feedback</span></a></li>
                <li><a href="cuslogin.html"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
            </ul>
        </nav>

    <!-- Main Content -->
    <main class="main-content">
        <h1>Feedback Form</h1>

        <?php if (!empty($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        
        <!-- Feedback Form -->
        <form action="cusfeedback.php" method="POST">
            <!-- Feedback Type -->
            <label for="feedbackType">Feedback Type:</label>
            <div class="feedback-type">
                <label><input type="radio" id="comments" name="feedbackType" value="Complains" required> Complains</label>
                <label><input type="radio" id="suggestions" name="feedbackType" value="Normal Feedback"> Normal Feedback</label>
                
            </div>

            <!-- Description -->
            <label for="description">Describe Your Feedback:</label>
            <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>

            <!-- Name -->
            <label for="name">Name:</label>
            <input type="text" id="firstName" name="firstName" placeholder="First Name" required>
            <input type="text" id="lastName" name="lastName" placeholder="Last Name"><br><br>

            <!-- Email -->
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="example@example.com" required><br><br>

            <!-- Submit Button -->
            <button type="submit">Submit</button>
        </form>
    </main>
</body>
</html>
