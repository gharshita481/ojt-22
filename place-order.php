<?php
session_start();
include("connection.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to place an order.'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if cart has items
$sql = "SELECT product_id FROM cart WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<script>alert('Your cart is empty!'); window.location.href='cart.php';</script>";
    exit();
}

// Check if address is saved
if (!isset($_SESSION['address'])) {
    echo "<script>alert('Please enter your address before placing the order.'); window.location.href='delivery-address.php';</script>";
    exit();
}

// Retrieve address details
$address = $_SESSION['address'];
$user_address = "{$address['Fname']} {$address['Lname']}, {$address['houseno']}, {$address['street']}, {$address['landmark']}, {$address['city']}, {$address['postal']}";

// Insert each cart item as an order
while ($row = $result->fetch_assoc()) {
    $product_id = $row['product_id'];

    // Insert into orders table
    $insert_sql = "INSERT INTO orders (user_id, product_id, user_address, order_status)
                   VALUES ('$user_id', '$product_id', '$user_address', 'Pending')";

    if (!$conn->query($insert_sql)) {
        echo "<script>alert('Error placing order: " . $conn->error . "');</script>";
        exit();
    }

    // *Update stock in the stocks table*
    $updateStock = $conn->prepare("UPDATE stocks SET current_stock = GREATEST(current_stock - 1, 0) WHERE product_id = ?");
    $updateStock->bind_param("i", $product_id);
    $updateStock->execute();
}

// *Cart is NOT cleared*

echo "<script>alert('Order placed successfully!'); window.location.href='checkout.php';</script>";
exit();
?>