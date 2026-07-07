<?php include("connection.php"); ?>
<?php
session_start();

if(isset($_POST['submit'])){
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $hashed_password = md5($user_password); // Ideally, use password_hash() and password_verify()

    $sql = "SELECT * FROM users WHERE user_email = '$user_email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
        $stored_password = $row['user_password']; // This is the hashed password stored in DB

        if ($stored_password === $hashed_password) {
            $token = $user_id . '-' . md5(rand(1000,9999)); 
            
            // Update token in the database
            $update_sql = "UPDATE users SET token = '$token' WHERE user_id=$user_id";
            $conn->query($update_sql);
            
            // Set cookies
            setcookie("token", "$token", time() + (60*60*24*30), "/");
            setcookie("user_id", "$user_id", time() + (60*60*24*30), "/");

            // Redirect to index.php
            header("Location: index.php");
            exit();
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "No account found";
    }
}
?>

<!DOCTYPE html>
<!-- Coding By CodingNepal - www.codingnepalweb.com -->
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Bellelise & Co.</title>
  <link rel="icon" href="images/icon2.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   
  <link rel="stylesheet" href="login-style.css">
</head>
<body>
  <div class="wrapper">
    <form action="login.php" method="POST">
      <h2>Login</h2>
        <div class="input-field">
        <input type="text" name="user_email" required>
        <label><b>Enter your email</b></label>
      </div>
      <div class="input-field">
        <input type="password" name="user_password" required>
        <label><b>Enter your password</b></label>
      </div>
      <div class="forget">
        <label for="remember">
          <input style="margin: 5px" type="checkbox" id="remember">
          <p style="margin: 3px 0px 0px 3px">Remember me</p>
        </label>
        <a href="#">Forgot password?</a>
      </div>
      <button type="submit" name="submit">Log In</button>
      <div class="register">
        <p>Don't have an account? <a href="register.php"><font color="#964d23"><b>Register</b></a></p>
      </div>
    </form>
  </div>
</body>
</html>