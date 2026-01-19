<?php
require_once('../db/database.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id']; // Ensure this was set during login

// Handle Adding to Cart (AJAX)
if (isset($_POST['add_to_cart'])) {
    $p_id = $_POST['product_id'];
    $check = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$p_id'");
    
    if (mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "UPDATE cart SET quantity = quantity + 1 WHERE user_id='$user_id' AND product_id='$p_id'");
    } else {
        mysqli_query($conn, "INSERT INTO cart (user_id, product_id) VALUES ('$user_id', '$p_id')");
    }
    echo "success"; exit;
}

// Handle Deleting from Cart
if (isset($_GET['delete'])) {
    $cart_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM cart WHERE id='$cart_id' AND user_id='$user_id'");
    header("Location: ../html/cart.php");
}

// Fetch Cart Items for Display
$cart_items = mysqli_query($conn, "SELECT cart.id as cart_id, products.*, cart.quantity 
                                   FROM cart JOIN products ON cart.product_id = products.id 
                                   WHERE cart.user_id = '$user_id'");
?>

