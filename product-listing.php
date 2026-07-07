<?php
session_start();
include("connection.php");

// Initialize filters
$product_type = isset($_GET['product_type']) ? $_GET['product_type'] : "";
$min_price = isset($_GET['min_price']) ? $_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? $_GET['max_price'] : PHP_INT_MAX;
$f_category = isset($_GET['f_category']) ? $_GET['f_category'] : "";

// Build the query dynamically
$sql = "SELECT * FROM product WHERE 1=1";
$params = [];
$types = "";

if (!empty($product_type)) {
    $sql .= " AND product_type = ?";
    $params[] = $product_type;
    $types .= "s";
}

if (!empty($f_category)) {
    $sql .= " AND f_category = ?";
    $params[] = $f_category;
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
    <title>Products Listing | Bellelise & Co.</title>
    <link rel="icon" href="images/icon2.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/6105985899.js" crossorigin="anonymous"></script>

    <!-- swiper.js for carousel -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="product-style.css">
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

<!-- full width banner image -->
<div class="banner-container">
    <img src="images/banner_new.png" alt="" style="width:100%; height:auto;">
</div>

<!-- Sidebar -->
<div class="main-container">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar content here -->
        <!-- Categories Section -->
    <div class="sidebar-section">
        <p>Categories</p>
        <ul>
            <li><a href="?product_type=Necklace">Necklaces</a></li>
            <li><a href="?product_type=Earrings">Earrings</a></li>
            <li><a href="?product_type=Bracelets">Bracelets</a></li>
            <li><a href="?product_type=Ring">Rings</a></li>
            <li><a href="?product_type=Anklet">Anklets</a></li>
        </ul>
    </div> <br>

<!-- Price Range Filter -->
<div class="sidebar-section">
    <p>Price Range</p>
    <form method="GET" action="">
        <label for="price-range">Select range:</label>
        <input 
            type="range" 
            id="price-range" 
            name="max_price" 
            min="0" 
            max="5000" 
            step="20" 
            value="<?php echo isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : '5000'; ?>" 
            oninput="updatePriceValue(this.value)">
        
        <div class="price-values">
            <span id="min-price">0</span>
            <span> - </span>
            <span id="max-price-value">
                <?php echo isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : '5000'; ?>
            </span>
        </div>

        <button type="submit">Apply</button>
    </form>
</div>

<!-- JavaScript to Update Displayed Price -->
<script>
    function updatePriceValue(value) {
        document.getElementById("max-price-value").textContent = value;
    }

    // Ensure the displayed value matches the current slider position on page load
    document.addEventListener("DOMContentLoaded", function() {
        var priceRange = document.getElementById("price-range");
        document.getElementById("max-price-value").textContent = priceRange.value;
    });
</script>
<br>

    <!-- Material Filter -->
    <div class="sidebar-section">
        <p>Featured Sets</p>
        <ul>
            <li><a href="?f_category=Titanic">Titanic</a></li>
            <li><a href="?f_category=Rapunzel">Rapunzel</a></li>
            <li><a href="?f_category=Bridgerton">Bridgerton</a></li>
        </ul>
    </div>
</div>

<!-- Featured Section -->
<div class="content">
    <main>
        <?php
        if ($all_product->num_rows > 0) {
            while ($row = $all_product->fetch_assoc()) {
                ?>
                <div class="card">
                    <div class="image">
                        <a href="product.php?id=<?php echo htmlspecialchars($row['product_id']); ?>">
                            <img src="<?php echo htmlspecialchars($row['product_image']); ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>">
                        </a>
                    </div>
                    <div class="caption">
                        <p class="product_name"><?php echo htmlspecialchars($row['product_name']); ?></p>
                        <hr>
                        <p class="product_category"><?php echo htmlspecialchars($row['product_type']); ?></p>
                        <p class="price">₹<?php echo htmlspecialchars($row['product_price']); ?></p>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<h1>No products found.</h1>";
        }
        ?>
    </main>
</div>
</div>

<?php
// Close the database connection
$conn->close();
?>

</body>
</html>
