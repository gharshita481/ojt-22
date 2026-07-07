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
        <li><a href="admin.php" class="active"><i class="fas fa-tachometer-alt "></i> Dashboard</a></li>
        <li><a href="admin-product.php"><i class="fas fa-box"></i> Product</a></li>
        <li><a href="admin-order.php"><i class="fas fa-list"></i> Order List</a></li>
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
          <input type="text" placeholder="Search...">
          <button><i class="fas fa-search"></i></button>
        </div>
        
      </div>
      <div class="content">
        <h1>Dashboard</h1>
      </div>

  
  <div class="container">
    <!-- First Box -->
    <div class="box">
      <div class="right-side">
        <div class="box-topic">Total Order</div>
        <div class="number">5</div>
        <div class="indicator">
          <i class='bx bx-up-arrow-alt'></i>
          <span class="text">Up from yesterday</span>
        </div>
      </div>
      <i class='bx bx-cart-alt cart'></i>
    </div>

    <!-- Second Box -->
    <div class="box">
      <div class="right-side">
        <div class="box-topic">Total Sales</div>
        <div class="number">₹0</div>
        <div class="indicator">
          <i class='bx bx-up-arrow-alt'></i>
          <span class="text">Increased today</span>
        </div>
      </div>
      <i class='bx bx-cart-alt cart'></i>
    </div>

    <!-- Third Box -->
    <div class="box">
      <div class="right-side">
        <div class="box-topic">New Users</div>
        <div class="number">4</div>
        <div class="indicator">
          <i class='bx bx-up-arrow-alt'></i>
          <span class="text">Growing steadily</span>
        </div>
      </div>
      <i class='bx bx-user cart'></i>
    </div>

    <!-- Fourth Box -->
    <div class="box">
      <div class="right-side">
        <div class="box-topic">Revenue</div>
        <div class="number">₹0</div>
        <div class="indicator">
          <i class='bx bx-up-arrow-alt'></i>
          <span class="text">Higher profits</span>
        </div>
      </div>
      <i class='bx bx-dollar cart'></i>
    </div>
  </div>

<!--table-->
<div class="box-container">
    <div class="box-header">
      <span>Registered User </span>
      
    </div>
    <table class="user-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
              <td>{$row['user_id']}</td>
              <td>{$row['user_name']}</td>
              <td>{$row['user_email']}</td>
             
            </tr>";
          }
        } else {
          echo "<tr><td colspan='6'>No users found</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <!--table-->
<div class="box-container" style="margin: 25px 0px 0px 5px;">
    <div class="box-header">
      <span>Customer Reviews</span>
      
    </div>
    <table class="user-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>review</th>
          
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM review";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
              <td>{$row['review_id']}</td>
              <td>{$row['user_name']}</td>
              <td>{$row['review']}</td>
             
            </tr>";
          }
        } else {
          echo "<tr><td colspan='6'>No users found</td></tr>";
        }
        ?>
      </tbody>
    </table>
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