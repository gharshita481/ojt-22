<?php
session_start();
include('connection.php');

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

$total_sum=$_SESSION['total_sum']; 
$order_id = 0;
$product_id = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Bellelise & Co.</title>
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

<!-- cart ordering links -->
<div class="order-links">
<a href="cart.php" class="active">My Bag</a>
<p class="active"> ----- </p>
<a href="delivery-address.php" class="active">Address</a>
<p class="active"> ----- </p>
<a href="checkout.php" class="active">Payment</a>
</div>

<!-- Featured Section -->
<div class="cart-wrapper">
    <!-- Left: Cart Items -->
    <div class="cart-container">
        <?php if ($all_product->num_rows > 0): ?>
            <?php while ($row = $all_product->fetch_assoc()): ?>
                <div class="cart-item">
                    <div class="cart-img">
                        <a href="product.php?id=12">
                            <img src="<?php echo htmlspecialchars($row['product_image']); ?>" alt="Product Image">
                        </a>
                    </div>
                    <div class="cart-info">
                        <p class="product_name"><?php echo htmlspecialchars($row['product_name']); ?></p>
                        
                        <p class="product_category"><?php echo htmlspecialchars($row['product_type']); ?></p>
                        <p class="price">₹<?php echo htmlspecialchars($row['product_price']); ?></p>
                    </div>
                </div>
                                
            <?php endwhile; ?>
        <?php else: ?>
            <h1>No products found.</h1>
        <?php endif; ?>
    </div>

    <!-- Right: Total Bill Summary -->
    <div class="total-bill">
        <h2>Order Summary</h2>
        
        <p>Total Items: <strong><?php echo $all_product->num_rows; ?></strong></p>
        <p>Subtotal: <strong>₹<?php echo $_SESSION['total_sum']; ?></strong></p>
        <p>Shipping: <strong>FREE</strong></p>
        <hr>
        <p><strong>Grand Total: ₹<?php echo $_SESSION['total_sum']; ?></strong></p>
        <form id="payment-form" action="generate_invoice.php" method="POST" style="display: inline;">
          <input type="hidden" name="order_id" value="<?php echo $order_id; ?>"> <!-- Dynamic Order ID -->

          <input type="hidden" name="product_id" value="<?php echo $_SESSION['product_id']; ?>">
          <input type="hidden" name="product_name" value="<?php echo $_SESSION['product_name']; ?>">

          <input type="hidden" name="user_name" value="<?php echo $_SESSION['user_name']; ?>">
          <input type="hidden" name="total_sum" value="<?php echo $total_sum; ?>">
          <button type="submit" style="text-decoration: underline;border: none;background: none; color: grey; padding: 0; font-size: 16px; cursor: pointer; border-radius: 5px;">
             Download Invoice
          </button>
        </form>
        <br><br>
        <a href="https://rzp.io/rzp/358VclAz"><button class="checkout-btn">Pay Now</button></a>
    </div>
</div>

<!-- Offcanvas Form -->
<div id="offcanvas" class="offcanvas">
    <div class="offcanvas-content">
        <span class="close-btn" onclick="closeOffcanvas()">&times;</span>
        <h2>Order Summary</h2>
        
        <div class="total-ill">
        <p>Total Items: <strong>3</strong></p>
        <p>Subtotal: <strong>₹4,999</strong></p>
        <p>Shipping: <strong>FREE</strong></p>
        <hr>
        <p><strong>Grand Total: ₹4,999</strong></p><br>
        
        <form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_PctAqc1LTJSbC9" async> </script> </form>
    </div>
        
    </div>
</div>

<style>
.offcanvas{
    color: grey;
    line-height: 35px;
}
.offcanvas-content{
    width: 30%;
}
</style>

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

<script>
document.getElementById("pay-now").addEventListener("click", function () {
    // Generate Invoice First
    let form = document.createElement("form");
    form.method = "POST";
    form.action = "generate_invoice.php";
    
    let input = document.createElement("input");
    input.type = "hidden";
    input.name = "order_id";
    input.value = "12345"; // Replace with dynamic order ID
    
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();

    // After 3 seconds, open Razorpay Payment
    setTimeout(() => {
        window.location.href = "razorpay_payment_page.php"; // Redirect to Razorpay
    }, 3000);
});
</script>
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
