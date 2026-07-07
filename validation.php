<?php
include("connection.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    if (isset($_COOKIE['token'])) {
        $token = $_COOKIE['token'];

        // Fetch all user details based on the token
        $sql = "SELECT * FROM users WHERE token = '$token' LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Store all user details in session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['user_name'];
            $_SESSION['user_email'] = $user['user_email'];

        } else {
            // Invalid token, clear cookies and redirect to login page
            setcookie("token", "", time() - 3600, "/");
            setcookie("user_id", "", time() - 3600, "/");
            header("Location: login.php");
            exit();
        }
    } else {
        // No token, redirect to login page
        header("Location: login.php");
        exit();
    }
}
?>