<?php
session_start();
if (isset($_SESSION['user_email'])) {
    echo json_encode(["success" => true, "email" => $_SESSION['email']]);
} else {
    echo json_encode(["success" => false]);
}
?>
