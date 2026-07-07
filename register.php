<?php
include("connection.php");
session_start();

if(isset($_POST['submit'])){
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    $hashed_password = md5($user_password); // Using md5 as per your request

    $sql = "INSERT INTO users (user_name, user_email, user_password) VALUES ('$user_name', '$user_email', '$hashed_password')";

    if($conn->query($sql)){
        // Fetch the newly created user's ID
        $user_id = $conn->insert_id;
        $token = $user_id . '-' . md5(rand(1000,9999));

        // Store token in the database
        $update_sql = "UPDATE users SET token = '$token' WHERE user_id = $user_id";
        $conn->query($update_sql);

        // Set session variables
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $user_name;
        $_SESSION['user_email'] = $user_email;

        // Set cookies for authentication
        setcookie("token", "$token", time() + (60*60*24*30), "/");
        setcookie("user_id", "$user_id", time() + (60*60*24*30), "/");

        // Redirect to home page
        header("Location: index.php");
        exit();
    } else {
        echo $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | Bellelise & Co.</title>
  <link rel="icon" href="images/icon2.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="login-style.css">
</head>
<body>
  <div class="wrapper">
    <form action="register.php" method="POST">
      <h2>Register</h2>
      <div class="input-field">
        <input type="text" name="user_name" required>
        <label><b>Enter your Name</b></label>
      </div>
      <div class="input-field">
        <input type="email" name="user_email" required>
        <label><b>Enter your email</b></label>
      </div>
      <div class="input-field">
        <input type="password" name="user_password" required>
        <label><b>Enter your password</b></label>
      </div>
      
      <button type="submit" name="submit">Register</button>
      <div class="register">
        <p>Already have an account? <a href="login.php"><b>Login</b></a></p>
      </div>
    </form>
  </div>
</body>
</html>
