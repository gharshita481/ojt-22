<?php
session_start();
include("connection.php");

// Fetch all items from the cart
$sql = "SELECT 
cart.product_id,
product.*
FROM 
cart 
LEFT JOIN 
product ON cart.product_id = product.product_id
WHERE
cart.user_id = $_SESSION[user_id];"
;

$all_product=$conn->query($sql);

$total_sum = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Address | Bellelise & Co.</title>
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
        <li><a class="active" href="featured.php">Featured</a></li>
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

<!-- cart ordering links -->
<div class="order-links">
<a href="cart.php" class="active">My Bag</a>
<p class="active"> ----- </p>
<a href="" class="active">Address</a>
<p> ----- </p>
<a href="checkout.php">Payment</a>
</div>

<!-- Featured Section -->
<div class="cart-wrapper">
    <!-- Left: Cart Items -->
    <div class="cart-container">
        <p>Delivery To:</p>
        <div class="address" onclick="openOffcanvas()">
            <i class="fa-solid fa-plus fa-2xl"></i>
            <p>Add your address</p>
        </div>
    </div>

<!-- Offcanvas Form -->
<div id="offcanvas" class="offcanvas">
    <div class="offcanvas-content">
        <span class="close-btn" onclick="closeOffcanvas()">&times;</span>
        <h2>Enter Delivery Address</h2>
        
        <form id="addressForm" action="cart.php" method="POST">
            <input class="col-md-4" type="text" id="Fname" name="Fname" placeholder="First Name*" required>
            <input class="col-md-4" type="text" id="Lname" name="Lname" placeholder="Last Name*" required>

            <input class="col-md-8" type="text" id="houseno" name="houseno" placeholder="House No., Building Name*" required>
            <input class="col-md-8" type="text" id="street" name="street" placeholder="Street Name, Area*" required>
            <input class="col-md-8" type="text" id="landmark" name="landmark" placeholder="Landmark*" required>

            <input class="col-md-4" type="text" id="postal" name="postal" placeholder="Postal Code*" required>
            <input class="col-md-4" type="text" id="city" name="city" placeholder="City/District*" required><br>
            <button type="submit">Save Address</button>
        </form>
    </div>
</div>

<!-- Right: Total Bill Summary -->
    <div class="total-bill">
    <h2>Cart Summary</h2>
        <p>Total Items: <strong><?php echo $all_product->num_rows; ?></strong></p>
        <p>Subtotal: <strong>₹<?php echo $_SESSION['total_sum']; ?></strong></p>
        <p>Shipping: <strong>FREE</strong></p>
        <hr>
        <p><strong>Grand Total: ₹<?php echo $_SESSION['total_sum']; ?></strong></p>
        <form action="place-order.php" method="POST">
    <button type="submit" name="place_order" class="checkout-btn">Place Order</button>
</form>

    </div>
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

<!-- offcanvas form script -->
<script>
    function openOffcanvas() {
    document.getElementById("offcanvas").classList.add("active");
}

function closeOffcanvas() {
    document.getElementById("offcanvas").classList.remove("active");
}
</script>

</body>
</html>
