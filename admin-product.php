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
        <li><a href="admin-product.php" class="active"><i class="fas fa-box"></i> Product</a></li>
        <li><a href="admin-order.php" ><i class="fas fa-list"></i> Order List</a></li>
        <li><a href="admin-analytics.php"><i class="fas fa-chart-line"></i> Analytics</a></li>
        <li><a href="admin-stock.php"><i class="fas fa-warehouse"></i> Stock</a></li>    
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
    <form method="GET">
        <input type="text" name="search_query" placeholder="Search..." value="<?php echo isset($_GET['search_query']) ? $_GET['search_query'] : ''; ?>">
        <button type="submit"><i class="fas fa-search"></i></button>
    </form>
</div>

<?php
// Search functionality
$searchResults = [];
if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
    $searchQuery = $_GET['search_query'];
    $sql = "SELECT product_id, product_name FROM product WHERE product_id LIKE ? OR product_name LIKE ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $searchTerm = "%" . $searchQuery . "%";
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $searchResults[] = $row;
            }
        } else {
            echo "Execute Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Prepare Error: " . $conn->error;
    }
}

?>


        
      </div>
      <div class="content">
        <h1>Product </h1>       
      </div>

     
<?php

       include("admin-add-product.php");
       
      ?>

 <!-- Display search results -->
 <?php if (!empty($searchResults)): ?>
    <h2>Search Results</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($searchResults as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                    <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                  
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif (isset($_GET['search_query'])): ?>
    <p>No results found for "<?php echo htmlspecialchars($_GET['search_query']); ?>"</p>
<?php endif; ?>
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