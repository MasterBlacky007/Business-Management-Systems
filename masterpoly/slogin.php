<?php
include "conf.php";

session_start();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userRole = $_POST['userRole'];

    // Input validation
    if (!empty($email) && !empty($password) && !empty($userRole)) {
        // Prepare the SQL query
        $sql = "SELECT * FROM staff WHERE email = ? AND role = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $userRole);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify password (simple comparison)
            if ($password === $user['password']) {
                // Store user info in the session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $userRole;
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];

                // Redirect to role-based dashboard
                switch ($userRole) {
                    case "owner":
                        header("Location: ownerdash.html");
                        break;
                    case "fmanager":
                        header("Location: fmdash.html");
                        break;
                    case "pmanager":
                        header("Location: pmdash.html");
                        break;
                    case "imanager":
                        header("Location: imdash.html");
                        break;
                    case "tmanager":
                        header("Location: tmdash.html");
                        break;
                    case "supervisor":
                        header("Location: supvdash.html");
                        break;
                    case "employee":
                        header("Location: empdash.html");
                        break;
                    case "skeeper":
                        header("Location: skdash.html");
                        break;
                    case "distributor":
                        header("Location: disdash.html");
                        break;
                   
                    default:
                        header("Location: slogin.html");
                        break;
                }
                exit();
            }  else {
                // Invalid password
                echo "<script>
                        alert('Invalid password. Please try again.');
                        window.location.href = 'slogin.html';
                      </script>";
                exit();
            }
        } else {
            // No user found
            echo "<script>
                    alert('No user found with the provided credentials.');
                    window.location.href = 'slogin.html';
                  </script>";
            exit();
        }
    } else {
        // Missing fields
        echo "<script>
                alert('All fields are required.');
                window.location.href = 'slogin.html';
              </script>";
        exit();
    }
}
?>
