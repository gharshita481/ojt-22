<?php
include("connection.php");
include("validation.php");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the product ID from the URL
$product_id = $_GET['id'];

// Initialize filters
$type = isset($_GET['product_type']) ? $_GET['product_type'] : "";
$min_price = isset($_GET['min_price']) ? $_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? $_GET['max_price'] : PHP_INT_MAX;
$material = isset($_GET['material']) ? $_GET['material'] : "";

// Build the query dynamically
$sql = "SELECT * FROM product WHERE product_id=$product_id";
$params = [];
$types = "";

if (!empty($type)) {
    $sql .= " AND type = ?";
    $params[] = $type;
    $types .= "s";
}

if (!empty($material)) {
    $sql .= " AND material = ?";
    $params[] = $material;
    $types .= "s";
}

if (!empty($min_price) || !empty($max_price)) {
    $sql .= " AND product_price BETWEEN ? AND ?";
    $params[] = $min_price;
    $params[] = $max_price;
    $types .= "ii";
}

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$all_product = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | Bellelise & Co.</title>
    <link rel="icon" href="images/icon2.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/6105985899.js" crossorigin="anonymous"></script>

    <!-- AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    

    <!-- CSS -->
    <link rel="stylesheet" href="product.css">
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
        <li><a class="active" href="product-listing.php">Products</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="index.php">Home</a></li>
    </ul>

    <div class="icon-container cta">
        <a href="profile.php"><i class="fa-solid fa-user fa-xl"></i></a>
        <a href="wishlist.php"><i class="fa-solid fa-heart fa-xl"></i></a>
        <a href="cart.php"><i class="fa-solid fa-cart-shopping fa-xl"></i></a>
    </div>
</header>

<!-- Featured Section -->
<div class="container">
<?php
        if ($all_product->num_rows > 0) {
            while ($row = $all_product->fetch_assoc()) {
                ?>

    <div class="product-image-gallery">
    <!-- Main Product Image -->
    <div class="main-image">
        <img id="main-product-image" src="<?php echo htmlspecialchars($row['product_image']); ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>">
    </div>
    
    <!-- Thumbnail Row -->
    <div class="thumbnail-row">
        <img class="thumbnail" src="<?php echo htmlspecialchars($row['product_image']); ?>" onclick="changeMainImage(this.src)">
        <img class="thumbnail" src="<?php echo htmlspecialchars($row['image2']); ?>" onclick="changeMainImage(this.src)">
    </div>
</div>

    <div class="description">
        <h1 class="product_name"><?php echo htmlspecialchars($row['product_name']); ?></h1>
        <p class="product_category"><?php echo htmlspecialchars($row['product_type']); ?></p>
        
        <br>
        <hr style="border: 1px solid#b9b9b9; width: 100%;">
        <br>        
       
        <h1 class="price">₹<?php echo htmlspecialchars($row['product_price']); ?></h1>
        <p>MRP Rs. <?php echo htmlspecialchars($row['product_price']); ?> incl. of all taxes</p>
        <br>
        
        <!-- add to cart and wishlist -->
        <div class="btn-group">
            <form class="cart-btn-form" action="add-to-cart.php" method="POST">
              <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($row['product_id']); ?>">
              <button class="add-btn" type="submit"><i class="fa-solid fa-cart-shopping"></i>  ADD TO CART</button>
            </form>
            <form class="cart-btn-form" action="add-to-wishlist.php" method="POST">
              <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($row['product_id']); ?>">
              <button class="add-btn wishlist" type="submit"><i class="fa-regular fa-heart"></i>  ADD TO WISHLIST</button>
            </form>
        </div><br>

        <!-- share product option -->
         <p>Share
         <i class="fa-brands fa-instagram fa-lg"></i>
         <i class="fa-brands fa-x-twitter fa-lg"></i>
         <i class="fa-brands fa-facebook-f fa-lg"></i>
         <i class="fa-brands fa-whatsapp fa-lg"></i>
         </p><br>

         <!-- return and exchange -->
         <div class="return-info">
            <div class="return-info-icon">
            <i class="fa-solid fa-arrow-right-arrow-left"></i>
            </div>

            <div class="return-info-text">
            This product is eligible for return or exchange under our 30-day return or exchange policy. No questions asked.
            </div>
        </div><br>
  <p>Product Details</p>
  <div class="prod-desc-box">
    <h4>Material & Care<br></h4>
    <p>High-quality 925 Sterling Silver with Ruby Red Crystal. Rhodium-plated for extra shine & durability.
    Hypoallergenic & Tarnish-resistant.
    Store in a dry place & avoid direct perfume/sweat contact.</p><br>
    <h4>Country of Origin:<br></h4>
    <p>India (Crafted with Love & Precision)</p><br>
    <h4>Authenticity Note:<br></h4>
    <p>Every piece is handcrafted with care and authenticity guaranteed when purchased from our official website or verified sellers.</p><br>
    <h4>Manufactured & Sold By:<br></h4>
    <p>Bellelise & Co.<br>
Bailiey Road, Patna <br>
India <br>
📩 Support: support@Bellelise@gmail.com</p>
  </div>

    <?php
            }
        } else {
            echo "<h1>No products found.</h1>";
        }
        ?>
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

<script>
  function changeMainImage(newSrc) {
    document.getElementById("main-product-image").src = newSrc;
}
</script>

</body>
</html>
