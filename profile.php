<?php
    include("connection.php");
    include("validation.php");
?>
<?php

if(isset($_POST['save'])) {
    $email = $_SESSION['user_email']; // Email remains unchanged
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    // Update user details in the database
    $sql = "UPDATE users SET user_name='$name', user_dob='$dob', user_phone='$phone' WHERE user_email='$email'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Profile updated successfully!');</script>";
        $_SESSION['user_name'] = $name;
        $_SESSION['user_dob'] = $dob;
        $_SESSION['user_phone'] = $phone;
    } else {
        echo "<script>alert('Error updating profile: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | Bellelise & Co.</title>
    <link rel="icon" href="images/icon2.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/6105985899.js" crossorigin="anonymous"></script>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="cart.css">
    <script src="style.js"></script>

</head>
<body class="home-page">

<!-- header / navbar -->
<header>
<a href="index.php"><p class="logo">Bellelise</p></a>
    <input type="checkbox" id="click">
    <label for="click" class="menu-btn">
        <i class="fas fa-bars"></i>
    </label>

    <ul class="nav__links">
        <li><a href="collections.php">Collections</a></li>
        <li><a href="featured.php">Featured</a></li>
        <li><a href="product-listing.php">Products</a></li>
        <li><a href="aout.php">About Us</a></li>
        <li><a href="index.php">Home</a></li>
    </ul>

    <div class="icon-container cta">
        <a href="profile.php"><i class="fa-solid fa-user fa-xl"></i></a>
        <a href="wishlist.php"><i class="fa-solid fa-heart fa-xl"></i></a>
        <a href="cart.php"><i class="fa-solid fa-cart-shopping fa-xl"></i></a>
    </div>
</header>

<!-- profile box -->
 <div class="profile-box">
    <p class="heading">PROFILE INFORMATION</p>
    
    <form method="POST" action="profile.php">
        <div class="profile">
            <label class="text" for="email">Email ID</label><br>
            <input type="text" name="email" value="<?php echo $_SESSION['user_email']; ?>" readonly>
            <br><br>
            <hr>
            <p class="heading">General Information</p>
            <br>
            <div class="half-input">
                <div class="col-md-12">
                    <label class="text" for="name">Full Name</label>
                    <input type="text" name="name" value="<?php echo $_SESSION['user_name']; ?>">
                </div>
            </div>
            <br>
            <div class="half-input">
                <div class="col-md-4">
                    <label class="text" for="DOB">Date Of Birth</label>
                    <input type="date" name="dob" value="<?php echo isset($_SESSION['user_dob']) ? $_SESSION['user_dob'] : ''; ?>">
                </div>
                <div class="col-md-4">
                    <label class="text" for="phone_no">Phone Number</label>
                    <input type="tel" name="phone" placeholder="Enter your phone number" value="<?php echo isset($_SESSION['user_phone']) ? $_SESSION['user_phone'] : ''; ?>" required>
                </div>
            </div>
            <br><br>
        </div>
        <br>

        <div class="profile-btn">
            <div class="profile-save">
                <button type="submit" name="save">SAVE</button>
            </div>
            <div class="profile-logout">
                <a href="logout.php"><button type="button">LOGOUT</button></a>
            </div>
        </div>
    </form>
</div>

<!--footer-->
<section class="footer">
      <div class="footer-row">
        <div class="footer-col">
          <h4>Info</h4>
          <ul class="links">
            <li><a href="#">About Us</a></li>
            <li><a href="#">Compressions</a></li>
            <li><a href="#">Customers</a></li>
            <li><a href="#">Service</a></li>
            <li><a href="#">Collection</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Explore</h4>
          <ul class="links">
            <li><a href="#">Free Designs</a></li>
            <li><a href="#">Latest Designs</a></li>
            <li><a href="#">Themes</a></li>
            <li><a href="#">Popular Designs</a></li>
            <li><a href="#">Art Skills</a></li>
            <li><a href="#">New Uploads</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Legal</h4>
          <ul class="links">
            <li><a href="#">Customer Agreement</a></li>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">GDPR</a></li>
            <li><a href="#">Security</a></li>
            <li><a href="#">Testimonials</a></li>
            <li><a href="#">Media Kit</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Newsletter</h4>
          <p>
            Subscribe to our newsletter for a weekly dose
            of news, updates, helpful tips, and
            exclusive offers.
          </p>
          <form action="#">
            <input type="text" placeholder="Your email" required>
            <button type="submit">SUBSCRIBE</button>
          </form>
          <div class="icons">
            <i class="fa-brands fa-facebook-f"></i>
            <i class="fa-brands fa-twitter"></i>
            <i class="fa-brands fa-linkedin"></i>
            <i class="fa-brands fa-github"></i>
          </div>
        </div>
      </div>
    </section>

<?php
// Close the database connection
$conn->close();
?>

</body>
</html>