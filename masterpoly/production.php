<?php
// Include the database configuration
include 'config.php';

// Initialize the message variable
$message = '';

// Check if the form is submitted to update the schedule
if (isset($_POST['update_schedule'])) {
    $schedule_id = $_POST['schedule_id'];
    $scheduled_date = $_POST['scheduled_date'];
    $status = $_POST['status'];

    // Prepare the query to update the production schedule
    $updateQuery = "UPDATE production_schedule 
                    SET scheduled_date = ?, status = ? 
                    WHERE schedule_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('ssi', $scheduled_date, $status, $schedule_id);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        $message = "Schedule updated successfully!";
    } else {
        $message = "Failed to update the schedule.";
    }
}

// Retrieve the production schedule records
$query = "SELECT * FROM production_schedule";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production Schedule</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f8f8f8;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #4CAF50;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        form {
            display: inline-block;
        }
        input[type="text"], select {
            padding: 5px;
            margin: 5px;
        }
        input[type="submit"] {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message-box {
            margin: 20px 0;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            font-size: 16px;
        }
        .success-message {
            background-color: #4CAF50;
            color: white;
        }
        .error-message {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>
<button class="back-button" onclick="goBack()">⬅ Back</button>
<script>
        function goBack() {
            window.history.back();
        }
    </script>
    <h2>Production Schedule</h2>

    <!-- Message Box that will be shown/hidden dynamically via JavaScript -->
    <div id="message-box" class="message-box" style="display: none;">
        <span id="message-text"></span>
    </div>

    <?php if ($message) : ?>
        <script>
            // Show message dynamically using JavaScript
            window.onload = function() {
                var messageBox = document.getElementById('message-box');
                var messageText = document.getElementById('message-text');

                // Set message content and style based on the PHP message
                <?php if ($message == "Schedule updated successfully!") : ?>
                    messageBox.classList.add('success-message');
                    messageBox.classList.remove('error-message');
                <?php else : ?>
                    messageBox.classList.add('error-message');
                    messageBox.classList.remove('success-message');
                <?php endif; ?>

                messageText.innerHTML = "<?php echo $message; ?>";  // Pass PHP message to JS
                messageBox.style.display = 'block';  // Show the message box

                // Hide message after 5 seconds
                setTimeout(function() {
                    messageBox.style.display = 'none';
                }, 5000);
            };
        </script>
    <?php endif; ?>

    <?php if ($result->num_rows > 0) : ?>
        <table>
            <tr>
                <th>Schedule ID</th>
                <th>Product Name</th>
                <th>Scheduled Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['schedule_id']; ?></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['scheduled_date']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="schedule_id" value="<?php echo $row['schedule_id']; ?>">
                            <input type="text" name="scheduled_date" value="<?php echo $row['scheduled_date']; ?>" required>
                            <select name="status" required>
                                <option value="pending" <?php echo $row['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="approved" <?php echo $row['status'] == 'approved' ? 'selected' : ''; ?>>Approved</option>
                            </select>
                            <input type="submit" name="update_schedule" value="Update">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else : ?>
        <p>No schedules found.</p>
    <?php endif; ?>

</body>
</html>

<?php
// Close the database connection after use
$conn->close();
?>
