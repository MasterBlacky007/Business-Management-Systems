<?php
include('conf.php');

if (isset($_POST['role'])) {
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $query = "SELECT email FROM staff WHERE role = '$role'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo '<option value="">Select Email</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . htmlspecialchars($row['email']) . '">' . htmlspecialchars($row['email']) . '</option>';
        }
    } else {
        echo '<option value="">No emails found</option>';
    }
}

// Close database connection
mysqli_close($conn);
?>
