<?php
session_start(); // Start the session
include 'conf.php';

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    echo "<script>alert('User not logged in!'); window.location.href = 'slogin.html';</script>";
    exit();
}

// Get the logged-in user's email
$user_email = $_SESSION['user_email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $type = $_POST['type'] ?? '';
    $note = $_POST['note'] ?? '';
    $description = $_POST['discription'] ?? ''; // Fix typo: 'discription' -> 'description'

    // Validation
    if (empty($type) || empty($note) || empty($description)) {
        echo "<script>alert('All required fields must be filled!'); window.location.href = 'dissue.html';</script>";
    } else {
        // Escaping inputs to prevent SQL injection
        $type = mysqli_real_escape_string($conn, $type);
        $note = mysqli_real_escape_string($conn, $note);
        $description = mysqli_real_escape_string($conn, $description);
        $user_email = mysqli_real_escape_string($conn, $user_email);

        // Insert data into the database including user_email
        $sql = "INSERT INTO issues (Type, Note, Description, UserEmail) 
                VALUES ('$type', '$note', '$description', '$user_email')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Issue added successfully!'); window.location.href = 'dissue.html';</script>";
        } else {
            echo "<script>alert('Error adding issue: " . mysqli_error($conn) . "'); window.location.href = 'dissue.html';</script>";
        }
    }
}

mysqli_close($conn);
?>
