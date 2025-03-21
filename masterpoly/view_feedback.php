<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback</title>
    <link rel="stylesheet" href="view.css">
</head>
<body>
    
   

    <!-- Main Content -->
    <main>
        <!-- Title Layer -->
        <div class="title-container">
            <h1 class="head">View Feedback</h1>
        </div>
        <div>
            <button onclick="window.location.href='feedback.html';">Back</button>
        </div>

        <!-- Search Layer -->
        <div class="search-container">
            <form method="get">
                <input class="search-input" type="text" name="search_id" placeholder="Search by Feedback ID">
                <input class="search-btn" type="submit" value="Search">

                <input class="search-input" type="date" name="search_date" placeholder="Search by Date">
                <input class="search-btn" type="submit" value="Search">
            </form>
        </div>

        <!-- Table Layer -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Feedback ID</th>
                        <th>Description</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'config.php';

                    // Base SQL query
                    $sql = "SELECT * FROM Feedback WHERE 1=1";  

                    // Search by Feedback ID
                    if (isset($_GET['search_id']) && !empty($_GET['search_id'])) {
                        $searchID = $conn->real_escape_string($_GET['search_id']);
                        $sql .= " AND Feedback_ID LIKE '%$searchID%'";
                    }

                    // Search by Date
                    if (isset($_GET['search_date']) && !empty($_GET['search_date'])) {
                        $searchDate = $conn->real_escape_string($_GET['search_date']);
                        $sql .= " AND Date = '$searchDate'";
                    }

                    // Execute query
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["Feedback_ID"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["Description"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["Date"]) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No feedback found.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
