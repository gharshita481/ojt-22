<?php
    include("connection.php");
    include("validation.php");

    // Fetch all items from the cart
    $sql = "SELECT 
    cart.product_id,
    product.*
    FROM cart 
    LEFT JOIN product ON cart.product_id = product.product_id
    WHERE cart.user_id = $_SESSION[user_id];";
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
} ?>

<?php
//delete item from cart
if (isset($_GET['delete'])) {
  $user_id = $_SESSION['user_id']; // Get the user ID
  $product_id = mysqli_real_escape_string($conn, $_GET['product_id']); // Sanitize product ID

  // Delete the product from the cart for the specific user
  $sql = "DELETE FROM cart WHERE user_id='$user_id' AND product_id='$product_id'";

  if ($conn->query($sql) === TRUE) {
      echo "<script>alert('Item removed from cart successfully!');</script>";
  } else {
      echo "<script>alert('Error deleting item: " . $conn->error . "');</script>";
  }

  // Refresh the page to update the cart
  echo '<meta http-equiv="refresh" content="0;url=cart.php">';
  exit();
} ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Featured Products | Bellelise & Co.</title>
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
<a href="" class="active">My Bag</a>
<p class="<?php echo $addressSaved ? 'active' : ''; ?>"> ----- </p>
<a href="delivery-address.php" class="<?php echo $addressSaved ? 'active' : ''; ?>">Address</a>
<p> ----- </p>
<a href="checkout.php">Payment</a>
</div>

<!-- Featured Section -->
<div class="cart-wrapper">
    <!-- Left: Cart Items -->
    <div class="cart-container">
    
<!-- print address, if any -->
<div style="display: <?php echo $addressSaved ? '' : 'none'; ?>">
<?php
if (isset($_SESSION['address']) && is_array($_SESSION['address'])) {
    $address = $_SESSION['address'];
    echo "<p>Delivery To:</p>"; // This is outside the address box but still conditionally displayed
    echo "
    <div class='address-box border-box'>
        <p>{$address['Fname']} {$address['Lname']}, {$address['houseno']}, {$address['street']}, {$address['landmark']}, {$address['city']}, {$address['postal']}</p>
        
    </div><br>";
}
?>
</div>

<!-- show all cart items -->
<p>Cart Items:</p>
<div class="cart-box border-box">
  <?php if ($all_product->num_rows > 0): ?>
    <?php while ($row = $all_product->fetch_assoc()): ?>
    <div class="cart-item">
      <div class="cart-img">
        <a href="product.php?id=12">
          <img src="<?php echo htmlspecialchars($row['product_image']); ?>" alt="Product Image">
        </a>
      </div>
    <div class="cart-info">
      <p class="product_name"><?php echo htmlspecialchars($row['product_name']);?></p>
                        
      <p class="product_category"><?php echo htmlspecialchars($row['product_type']); ?></p>
      <p class="price">₹<?php echo htmlspecialchars($row['product_price']); ?></p>
    </div>

<!-- delete item from cart button -->
<div class="right-btn-dlt">
  <form style="display: flex;align-items:start;" action="cart.php" method="GET">
    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
    <button type="submit" name="delete" style="background: none; padding:0;margin-top:-40px;" onclick="return confirm('Are you sure you want to remove this item?');">
        <i class="fa-solid fa-trash fa-lg" style=" cursor: pointer; color: #58595B;"></i>
    </button>
</form>
  </div>

    </div>
      <?php $total_sum += $row['product_price'];
            $product_id=$row['product_id'];
            $product_name=$row['product_name'];
            $product_id=$row['product_id'];
            $product_id=$row['product_id'];
            $product_id=$row['product_id']; ?>
      <?php endwhile; ?>
      <?php else: ?>
        <h1>No products found.</h1>
      <?php endif; ?>
  </div>
  </div>

    <!-- Right: Total Bill Summary -->
    <div class="total-bill">
        <h2>Cart Summary</h2>
        <p>Total Items: <strong><?php echo $all_product->num_rows; ?></strong></p>
        <p>Subtotal: <strong>₹<?php echo $total_sum; ?></strong></p>
        <p>Shipping: <strong>FREE</strong></p>
        <hr>
        <p><strong>Grand Total: ₹<?php echo $total_sum; ?></strong></p>
        

        <form action="place-order.php" method="POST">
        <a href="<?php echo $addressSaved ? 'checkout.php' : 'delivery-address.php'; ?>">
          <button type="submit" name="place_order" class="checkout-btn">Place Order</button>
        </a>
</form>
    </div>
</div>

<?php 
  $_SESSION['total_sum']=$total_sum; 
  $_SESSION['product_id']=$product_id; 
  $_SESSION['product_name']=$product_name; 
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
