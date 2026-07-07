<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $conn->real_escape_string($_POST['user_name']);
    $message = $conn->real_escape_string($_POST['message']);
    
    $sql = "INSERT INTO message (user_name, message, created_at) VALUES ('$user_name', '$message', NOW())";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to index.php with success message
        header("Location: index.php?message=success");
        exit();
    } else {
        header("Location: index.php?message=error");
        exit();
    }

    $conn->close();
}
?>