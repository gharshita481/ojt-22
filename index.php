<?php 
  session_start();
  include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bellelise & Co.</title>
    <link rel="icon" href="images/icon2.png">

    <!--google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">

    <!--jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

   <!--font-awesome-->
   <script src="https://kit.fontawesome.com/6105985899.js" crossorigin="anonymous"></script>
   <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <!--links-->
    <link rel="stylesheet" href="style.css">
    <script src="style.js"></script>

</head>
<body>
    
<!--  NAVBAR  -->
    <!-- Hero -->
    <section class="et-hero-tabs">

<!--icons-->
    <div class="fa-container">
        <a href="<?php echo isset($_COOKIE['token']) ? 'profile.php' : 'login.php'; ?>"><i class="fa-solid fa-user" style="color: #ffffff;"></i></a>
        <a href="<?php echo isset($_COOKIE['token']) ? 'wishlist.php' : 'login.php'; ?>"><i class="fa-solid fa-heart" style="color: #ffffff;"></i></a>
        <a href="<?php echo isset($_COOKIE['token']) ? 'cart.php' : 'login.php'; ?>"><i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i></a>
    </div>

    <h1>BELLELISE & CO.</h1>
    <h3>Where Elegance Meets Eternity</h3>
    <div class="et-hero-tabs-container">
      <a class="et-hero-tab" href="#tab-es6">Collections</a>
      <a class="et-hero-tab" href="#tab-flexbox">Featured</a>
      <a class="et-hero-tab" href="#tab-react">Shop All</a>
      <a class="et-hero-tab" href="#tab-angular">About Us</a>
      <a class="et-hero-tab" href="#tab-other">Customer Reviews</a>
      <span class="et-hero-tab-slider"></span>
    </div>
  </section>

  <!-- Main -->
  <main class="et-main">
    <section class="et-slide col1" id="tab-es6">
      <img class="left-img" src="images/collection1.png" alt="">
      <h1>Collections</h1>
      <p>Timeless elegance, curated for you.</p>
      <a href="collections.php"><button><h3>View Collections</h3></button></a>
</div>
    </section>

    <section class="et-slide col2" id="tab-flexbox">
      <img class="right-img" src="images/ring.png" alt="">
      <h1>Featured</h1>
      <p>Handpicked favorites, just for you.</p>
      <a href="featured.php"><button><h3>View Featured Sets</h3></button></a>
    </section>

    <section class="et-slide col3" id="tab-react">
    <img class="left-img" src="images/shop15.png" alt="">
    <img class="right-img" src="images/shop14.png" alt="">
      <h1>Shop All</h1>
      <p>Explore our full range of timeless pieces.</p>
      <a href="product-listing.php"><button><h3>View all products</h3></button></a>
    </section>

    <section class="et-slide col4" id="tab-angular">
    <img class="left-img" src="images/shop17.png" alt="">
    <h1>About Us</h1>  <br>  
    <a href="about.php"><button><h3>Learn More</h3></button></a>
    </section>

    <section class="et-slide col5" id="tab-other">
    <img class="right-img" src="images/shop4.png" alt="">
    <h1>Customer Reviews</h1><br>
    <a href="review.php"><button><h3>Click to write review</h3></button></a>
    </section>
  </main>

<!-- Message Icon -->

<div id="messageIcon" onclick="openMessageForm()" style="position: fixed; bottom: 20px; right: 20px; cursor: pointer;">
    <i class='fas fa-comment-dots' ></i> <!-- Using Boxicons -->
</div>

  <!-- Pop-up Form -->
  <div class="popup-form" id="messageForm">
        <button class="close-btn" onclick="closeMessageForm()">&times;</button>
        <h3>Send a Message</h3>
        <form action="send-message.php" method="post">
            <input type="text" name="user_name" placeholder="Your Name" required>
            <textarea name="message" placeholder="Your Message" required></textarea>
            <button type="submit">Send</button>
        </form>
    </div>
    <?php
if (isset($_GET['message'])) {
    if ($_GET['message'] == 'success') {
        echo "<p style='color: green; text-align: center;'>Message sent successfully!</p>";
    } elseif ($_GET['message'] == 'error') {
        echo "<p style='color: red; text-align: center;'>Message sending failed!</p>";
    }
}
?>


<script>
  function openMessageForm() {
	document.getElementById("messageForm").classList.add("active");
}

function closeMessageForm() {
	document.getElementById("messageForm").classList.remove("active");
}
// Check if the message was sent successfully
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.get('message') === 'success') {
	alert("Message sent successfully!"); // Optional alert
} else if (urlParams.get('message') === 'error') {
	alert("Message sending failed!"); // Optional alert
}
</script>

</body>
</html>