<?php
// Start the session
session_start();

// Include database connection file
include('conf.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize inputs
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Prepare the SQL query to prevent SQL injection
    $sql = "SELECT * FROM supplier WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        // Error preparing statement
        die("Error preparing the query: " . $conn->error);
    }

    // Bind the email parameter to the prepared statement
    $stmt->bind_param("s", $email);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any record is found
    if ($result->num_rows > 0) {
        // Fetch the user data from the database
        $row = $result->fetch_assoc();

        // Directly compare the password (without hashing)
        if ($password == $row['Password']) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $row['ID'];
            $_SESSION['email'] = $row['Email'];
            $_SESSION['first_name'] = $row['First_Name'];
            $_SESSION['last_name'] = $row['Last_Name'];
            
            // Redirect to dashboard or another page
            header("Location: supdash.html"); // Modify as per your requirement
            exit();
        } else {
            // Invalid password
            echo "<script>alert('Invalid email or password!'); window.location.href = 'suplogin.html';</script>";
        }
    } else {
        // Email doesn't exist in the database
        echo "<script>alert('No account found with that email!'); window.location.href = 'suplogin.html';</script>";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
mysqli_close($conn);
?>
