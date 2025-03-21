<?php
// Include database connection
include('conf.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['role'])) {
    $selectedRole = mysqli_real_escape_string($conn, $_POST['role']);

    // Fetch staff emails based on the selected role, excluding the "Owner"
    $query = "SELECT email FROM staff WHERE role = '$selectedRole' AND role NOT LIKE 'Owner'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<option value="">Select Email</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . htmlspecialchars($row['email']) . '">' . htmlspecialchars($row['email']) . '</option>';
        }
    } else {
        echo '<option value="">No staff found</option>';
    }
}

// Close the database connection
mysqli_close($conn);
?>
