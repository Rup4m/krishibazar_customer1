<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
require_once('../db/database.php');

$u_id = $_SESSION['user_id'];
$query = "SELECT * FROM orders WHERE user_id = '$u_id' ORDER BY order_date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History | Krishibazar</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="checkout-page"> <header class="header-main">
        <div class="header-container">
            <div class="logo">Krishibazar</div>
            <nav class="header-nav">
                <a href="dashboard.php">Home</a>
                <a href="cart.php">Cart</a>
                <a href="orders.php" class="active">Orders</a>
                <a href="profile.php">Me</a>
            </nav>
        </div>
    </header>

     <main class="checkout-main-container">
        <div class="invoice-wrapper">
            <div class="invoice-header">
                <span class="logo"><i class="fa-solid fa-clock-rotate-left"></i> Your Order History</span>
                <p>Track and manage your recent purchases</p>
            </div>

 <?php if(mysqli_num_rows($result) > 0): ?>
                <div style="overflow-x:auto;">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
