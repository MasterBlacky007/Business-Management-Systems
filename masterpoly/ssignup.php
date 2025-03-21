<?php
// Include database connection file
include('conf.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    // Validate password
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
    } else {
        // Check if the email already exists
        $email_check_sql = "SELECT * FROM supplier WHERE Email = '$email'";
        $result = mysqli_query($conn, $email_check_sql);
        
        if (mysqli_num_rows($result) > 0) {
            // Email already exists
            echo "<script>alert('An account with this email already exists!'); window.location.href = 'csignup.html';</script>";
            
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare the SQL query to insert user data
            $sql = "INSERT INTO supplier (Email, First_Name, Last_Name,Address,Contact, Password) VALUES ('$email', '$firstname', '$lastname','$address','$contact', '$password')";

            // Execute the query
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Register Successfully!'); window.location.href = 'suplogin.html';</script>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>
