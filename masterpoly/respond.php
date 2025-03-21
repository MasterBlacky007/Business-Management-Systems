<?php
include 'config.php';

// Get Feedback_ID from URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $feedback_id = $_GET['id'];

    // Fetch feedback details
    $stmt = $conn->prepare("SELECT * FROM Feedback WHERE Feedback_ID = ?");
    $stmt->bind_param("i", $feedback_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $feedback = $result->fetch_assoc();
    $stmt->close();

    // Fetch existing response (if any)
    $stmt = $conn->prepare("SELECT * FROM FeedbackResponse WHERE Feedback_ID = ?");
    $stmt->bind_param("i", $feedback_id);
    $stmt->execute();
    $response_result = $stmt->get_result();
    $existing_response = $response_result->fetch_assoc();
    $stmt->close();
} else {
    die("Invalid Feedback ID.");
}

// Handle response submission only if no existing response
if ($_SERVER["REQUEST_METHOD"] == "POST" && !$existing_response) {
    $response = $_POST['response'];

    // Insert response into the database
    $stmt = $conn->prepare("INSERT INTO FeedbackResponse (Feedback_ID, Response) VALUES (?, ?)");
    $stmt->bind_param("is", $feedback_id, $response);

    if ($stmt->execute()) {
        echo "<script>alert('Response submitted successfully!'); window.location.href='respond_feedback.php';</script>";
    } else {
        echo "<script>alert('Error submitting response: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respond to Feedback</title>
    <link rel="stylesheet" href="respond.css">
</head>
<body>

    <main>
        <h1>Respond to Feedback</h1>

        <p><strong>Feedback ID:</strong> <?php echo htmlspecialchars($feedback["Feedback_ID"]); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($feedback["Description"]); ?></p>

        <?php if ($existing_response): ?>
            <p><strong>Response:</strong> <?php echo htmlspecialchars($existing_response["Response"]); ?></p>
        <?php else: ?>
            <form method="post">
                <label for="response">Your Response:</label>
                <textarea name="response" required></textarea>

                <button type="submit">Submit Response</button>
            </form>
        <?php endif; ?>

        <a href="respond_feedback.php">Back to Feedback List</a>
    </main>

</body>
</html>
