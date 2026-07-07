<?php include("connection.php");?>
<?php
    // Check cookie
    if(isset($_COOKIE['token'])){
       // echo "Logged";
        $user_id = $_COOKIE['user_id'];
    }
    else{
        //echo ' <meta http-equiv="refresh" content="0;url=login.php">';
        echo "Please login to use panel";
        exit(0);
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="admin-style.css">
  
</head>
<body>
  <div class="dashboard">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
      <div class="brand">
        <i class="fas fa-gem"></i>
        <span>Bellelise</span>
      </div>
        <div class="user-info"> 
            
            <?php
                // Fetch user details
                $sql = "SELECT * FROM users WHERE user_id=$user_id";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $user_name = $row["user_name"];
                    echo '<h1 style="color:#fff;font-size:20px">Hello, '.$user_name.'</h1>';
                }
            }
            ?>
           </div>
     
      <ul class="nav-links">
        <li><a href="admin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="admin-product.php" ><i class="fas fa-box"></i> Product</a></li>
        <li><a href="admin-order.php" ><i class="fas fa-list"></i> Order List</a></li>
        <li><a href="admin-analytics.php"><i class="fas fa-chart-line"></i> Analytics</a></li>
        <li><a href="admin-stock.php"class="active"><i class="fas fa-warehouse"></i> Stock</a></li>    
        <li><a href="admin-team.php"><i class="fas fa-users"></i> Team</a></li>
        <li><a href="admin-message.php"><i class="fas fa-envelope"></i> Messages</a></li>
        <li><a href="#"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <div class="header">
        <div class="menu-icon" id="menu-icon">
          <i class="fas fa-bars"></i>
        </div>
        <div class="search-bar">
          <input type="text" placeholder="Search...">
          <button><i class="fas fa-search"></i></button>
        </div>
        
      </div>
      <div class="content">
        <h1>Stock Management</h1>
      </div>
     
<div>
<?php
// Include database connection
include("connection.php");

// Add Initial Stock
if (isset($_POST['add_stock'])) {
    $product_id = $_POST['product_id'];
    $initial_stock = $_POST['initial_stock'];

    // Check if stock already exists for this product
    $checkStock = $conn->prepare("SELECT * FROM stocks WHERE product_id = ?");
    $checkStock->bind_param("i", $product_id);
    $checkStock->execute();
    $result = $checkStock->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Stock already exists for this product!');</script>";
    } else {
        // Insert initial stock
        $insertStock = $conn->prepare("INSERT INTO stocks (product_id, initial_stock, current_stock) VALUES (?, ?, ?)");
        $insertStock->bind_param("iii", $product_id, $initial_stock, $initial_stock);
        if ($insertStock->execute()) {
            echo "<script>alert('Stock Added Successfully!'); window.location.href='admin-stock.php';</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
}

// Fetch products from product table
$productQuery = "SELECT product_id, product_name, product_image FROM product";
$productResult = $conn->query($productQuery);

// Fetch stocks with product details
$stockQuery = "SELECT s.stock_id, s.product_id, p.product_name, p.product_image, s.initial_stock, s.current_stock 
               FROM stocks s 
               JOIN product p ON s.product_id = p.product_id";
$stockResult = $conn->query($stockQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Management</title>
    <link rel="stylesheet" href="admin-stock.css">
</head>
<body>
    

    <!-- Add Stock Form -->
    <h3>Add Initial Stock</h3>
    <form method="POST">
        <label>Select Product:</label>
        <select name="product_id" required>
            <option value="" disabled selected>Select a product</option>
            <?php while ($row = $productResult->fetch_assoc()) { ?>
                <option value="<?php echo $row['product_id']; ?>"><?php echo $row['product_name']; ?></option>
            <?php } ?>
        </select>
        <label>Initial Stock:</label>
        <input type="number" name="initial_stock" required>
        <button type="submit" name="add_stock">Add Stock</button>
    </form>

    <!-- Display Stocks -->
    <h3>Stock List</h3>
    <table>
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Initial Stock</th>
                <th>Current Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $stockResult->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['product_id']; ?></td>
                    <td><img src="<?php echo $row['product_image']; ?>" alt="Product Image"></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['initial_stock']; ?></td>
                    <td><?php echo $row['current_stock']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>

</div>


  </div>
   
  </div>

  <!-- Embedded JavaScript -->
  <script>
    const menuIcon = document.getElementById("menu-icon");
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.querySelector(".main-content");

    menuIcon.addEventListener("click", () => {
      sidebar.classList.toggle("hidden");
      mainContent.classList.toggle("expanded");
    });
  </script>
</body>
</html>