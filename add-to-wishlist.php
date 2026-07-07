<?php
include("connection.php");
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Check if product_id is received
if (isset($_POST['product_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];

    // Check if product is already in the wishlist
    $check_sql = "SELECT * FROM wishlist WHERE user_id = '$user_id' AND product_id = '$product_id'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        // Product is already in wishlist
        header("Location: wishlist.php?message=already_added");
    } else {
        // Insert product into wishlist
        $insert_sql = "INSERT INTO wishlist (user_id, product_id) VALUES ('$user_id', '$product_id')";
        if ($conn->query($insert_sql) === TRUE) {
            header("Location: wishlist.php?message=added_successfully");
        } else {
            header("Location: wishlist.php?message=error");
        }
    }
} else {
    header("Location: product-listing.php"); // Redirect back if no product ID
}
?>
