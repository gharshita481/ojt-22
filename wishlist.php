<?php
    include("connection.php");
    include("validation.php");

    // Fetch all items from the wishlist
    $sql = "SELECT 
    wishlist.product_id,
    product.*
    FROM wishlist 
    LEFT JOIN product ON wishlist.product_id = product.product_id
    WHERE wishlist.user_id = $_SESSION[user_id];";
    ;

    $all_product = $conn->query($sql);

    if (!$all_product) {
      die("Query failed: " . $conn->error);
  }
    $total_sum = 0;

  // Save the address from the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $_SESSION['address'] = [
      'Fname' => $_POST['Fname'],
      'Lname' => $_POST['Lname'],
      'houseno' => $_POST['houseno'],
      'street' => $_POST['street'],
      'landmark' => $_POST['landmark'],
      'postal' => $_POST['postal'],
      'city' => $_POST['city']
  ];
  header("Location: cart.php");
  exit();
}
?>

<?php
//delete item from cart
if (isset($_GET['delete'])) {
  $user_id = $_SESSION['user_id']; // Get the user ID
  $product_id = mysqli_real_escape_string($conn, $_GET['product_id']); // Sanitize product ID

  // Delete the product from the cart for the specific user
  $sql = "DELETE FROM wishlist WHERE user_id='$user_id' AND product_id='$product_id'";

  if ($conn->query($sql) === TRUE) {
      echo "<script>alert('Item removed from wishlist successfully!');</script>";
  } else {
      echo "<script>alert('Error deleting item: " . $conn->error . "');</script>";
  }

  // Refresh the page to update the cart
  echo '<meta http-equiv="refresh" content="0;url=wishlist.php">';
  exit();
}?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist | Bellelise & Co.</title>
    <link rel="icon" href="images/icon2.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/6105985899.js" crossorigin="anonymous"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="cart.css">
    <script src="style.js"></script>

</head>
<body class="home-page">

<!-- Header/Navbar -->
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
        <li><a href="about.php">About Us</a></li>
        <li><a href="index.php">Home</a></li>
    </ul>

    <div class="icon-container cta">
        <a href="profile.php"><i class="fa-solid fa-user fa-xl"></i></a>
        <a href="wishlist.php"><i class="fa-solid fa-heart fa-xl"></i></a>
        <a href="cart.php"><i class="fa-solid fa-cart-shopping fa-xl"></i></a>
    </div>
</header>

<?php
// check if address is saved
$addressSaved = isset($_SESSION['address']);
?>

<!-- cart ordering links -->
<div class="order-links">
<h2 class="active">YOUR WISHLIST</h2>
</div>

<!-- Featured Section -->
<div class="cart-wrapper">
    <!-- Left: Cart Items -->
    <div class="cart-container">

<!-- show all cart items -->
<div class="cart-box border-box">
        <?php if ($all_product->num_rows > 0): ?>
            <?php while ($row = $all_product->fetch_assoc()): ?>
                <div class="cart-item">
                    <div class="cart-img" style="width: 180px;">
                        <a href="product.php?id=12">
                            <img src="<?php echo htmlspecialchars($row['product_image']); ?>" alt="Product Image">
                        </a>
                    </div>
                    <div class="cart-info">
                        <p style="font-size: 20px; font-weight: bold;" class="product_name"><?php echo htmlspecialchars($row['product_name']); ?></p>
                        
                        <p class="product_category"><?php echo htmlspecialchars($row['product_type']); ?></p>
                        <p style="font-size: 17px; font-weight: bold;" class="price">₹<?php echo htmlspecialchars($row['product_price']); ?></p>
                    </div>

<!-- delete item from cart button -->
<div class="right-btn-dlt">
  <form style="display: flex;align-items:start;" action="wishlist.php" method="GET">
    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
    <button type="submit" name="delete" style="background: none; padding:0;margin-top:-40px;" onclick="return confirm('Are you sure you want to remove this item?');">
        <i class="fa-solid fa-trash fa-lg" style=" cursor: pointer; color: #58595B;"></i>
    </button>
</form>
  </div>
                </div>
                <?php $total_sum += $row['product_price']; ?>
            <?php endwhile; ?>
        <?php else: ?>
            <h1>No products found.</h1>
        <?php endif; ?>
    </div>
    </div>    
</div>

<?php 
  $_SESSION['total_sum']=$total_sum; 
?>

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
