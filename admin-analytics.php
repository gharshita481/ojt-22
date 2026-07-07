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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <li><a href="#"class="active"><i class="fas fa-chart-line"></i> Analytics</a></li>
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
       <p> <h1>Analytics</h1><br>
        <?php
  // Fetch age distribution data
$sql = "
SELECT 
    CASE 
        WHEN TIMESTAMPDIFF(YEAR, user_dob, CURDATE()) BETWEEN 10 AND 19 THEN '10-19'
        WHEN TIMESTAMPDIFF(YEAR, user_dob, CURDATE()) BETWEEN 20 AND 29 THEN '20-29'
        WHEN TIMESTAMPDIFF(YEAR, user_dob, CURDATE()) BETWEEN 30 AND 39 THEN '30-39'
        WHEN TIMESTAMPDIFF(YEAR, user_dob, CURDATE()) BETWEEN 40 AND 49 THEN '40-49'
        ELSE '50+' 
    END AS age_group,
    COUNT(*) AS count
FROM users
GROUP BY age_group
ORDER BY age_group;
";

$result = $conn->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
$data[$row['age_group']] = $row['count'];
}

//$conn->close();
?>
  <div class="chart-container">
        <h2><u><b>Users Age Distribution</h2>
        <canvas id="ageChart"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('ageChart').getContext('2d');
        const ageData = {
            labels: <?php echo json_encode(array_keys($data)); ?>,
            datasets: [{
                label: 'Number of Users',
                data: <?php echo json_encode(array_values($data)); ?>,
                backgroundColor: 'rgba(121, 98, 185, 0.5)',
                borderColor: 'rgb(99, 57, 112)',
                borderWidth: 1
            }]
        };

        new Chart(ctx, {
            type: 'bar',
            data: ageData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
 
<br>

<?php
// Fetch product category data
$sql = "SELECT product_type, COUNT(*) as count FROM product GROUP BY product_type";
$result = $conn->query($sql);

$categories = [];
$counts = [];

while ($row = $result->fetch_assoc()) {
    $categories[] = $row['product_type'];
    $counts[] = $row['count'];
}

// Convert PHP arrays to JSON for JavaScript
$categories_json = json_encode($categories);
$counts_json = json_encode($counts);
?>

<div class="chart-container">
        <h2><u><b>Types of Product Distribution</h2>
        <canvas id="productChart"></canvas>
    </div>
    <div class="chart-container ">
   <script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById('productChart').getContext('2d');
        var productChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo $categories_json; ?>,
                datasets: [{
                    label: 'Number of Products',
                    data: <?php echo $counts_json; ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });
</script>
<br>

<?php
// Fetch product category data
$sql = "SELECT f_category, COUNT(*) as count FROM product GROUP BY f_category";
$result = $conn->query($sql);

$categories = [];
$counts = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['f_category'];
        $counts[] = $row['count'];
    }
} else {
    echo "No data found!";
}

// Convert PHP arrays to JSON for JavaScript
$categories_json = json_encode($categories);
$counts_json = json_encode($counts);
?>

<h2 style="text-align: center;">Product Distribution by Featured Category</h2>

<div style="width: 50%; margin: auto;" class="chart-container">
    <canvas id="fCategoryChart"></canvas>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var categories = <?php echo $categories_json; ?>;
        var counts = <?php echo $counts_json; ?>;

        console.log("Categories:", categories);
        console.log("Counts:", counts);

        if (categories.length === 0 || counts.length === 0) {
            document.getElementById("debug").innerHTML = "No data available to display.";
            return;
        }

        var ctx = document.getElementById('fCategoryChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie', // Change to 'doughnut', 'bar', 'line', etc.
            data: {
                labels: categories,
                datasets: [{
                    label: 'Number of Products',
                    data: counts,
                    backgroundColor: [
                        'rgba(255, 65, 106, 0.6)',   // Rapunzel
                        'rgba(39, 114, 165, 0.6)',   // Bridgerton
                        'rgba(221, 34, 34, 0.6)' ,   // Titanic
                        'rgba(88, 199, 153, 0.6)'    // Titanic
                    ],
                    borderColor: 'rgba(0, 0, 0, 0.1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>



</p>



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