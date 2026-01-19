<?php 
// 1. Safe Session Check
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Database & Controller includes
require_once('../db/database.php');
include('../php/cart_controller.php'); 

// 3. Initialize variables to prevent Warnings
$grand_total = 0; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout | Krishibazar</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>
<body class="checkout-page">

    <header class="header-main">
        <div class="header-container">
            <a href="dashboard.php" class="logo">Krishibazar</a>
            <nav class="header-nav">
                <a href="dashboard.php"><i class="fa fa-home"></i> Home</a>
                <a href="cart.php"><i class="fa fa-shopping-cart"></i> Cart</a>
                <a href="orders.php"><i class="fa fa-list-check"></i> Orders</a>
                <a href="profile.php" class="active"><i class="fa fa-user"></i> Me</a>
            </nav>
        </div>
    </header>

    <div class="checkout-main-container" style="margin-top: 100px;">
        <div class="checkout-flex-layout">
            
            <div class="invoice-wrapper" id="invoice-card">
                <div class="invoice-header">
                    <span class="logo" style="font-size: 20px;">Krishibazar</span>
                    <h3 style="color: #666;">Invoice Summary</h3>
                </div>
                
                <div class="invoice-body">
                    <?php 
                    if ($cart_items && mysqli_num_rows($cart_items) > 0):
                        mysqli_data_seek($cart_items, 0); 
                        while($item = mysqli_fetch_assoc($cart_items)): 
                            $item_total = $item['price'] * $item['quantity'];
                            $grand_total += $item_total;
                    ?>
                        <div class="invoice-item" style="display:flex; justify-content:space-between; margin: 10px 0;">
                            <span><?php echo htmlspecialchars($item['product_name']); ?> (x<?php echo $item['quantity']; ?>)</span>
                            <span>৳ <?php echo number_format($item_total, 2); ?></span>
                        </div>
                    <?php endwhile; endif; ?>
                </div>

                <div class="invoice-footer" style="border-top: 2px solid #eee; padding-top: 15px;">
                    <div class="total-row grand-total" style="display:flex; justify-content:space-between; color: #2d8a39; font-size: 1.4rem;">
                        <strong>Grand Total</strong>
                        <strong>৳ <span id="finalTotal"><?php echo $grand_total; ?></span></strong>
                    </div>
                </div>
            </div>

            <div class="delivery-details-card">
                <form id="checkoutForm">
                    <h3><i class="fa-solid fa-truck"></i> Delivery Information</h3>
                    <div class="form-group" style="margin: 15px 0;">
                        <label>Phone Number</label>
                        <input type="text" name="phone" placeholder="01XXXXXXXXX" style="width:100%; padding:10px; border-radius:5px; border:1px solid #ddd;" required>
                    </div>
                    <div class="form-group" style="margin: 15px 0;">
                        <label>Shipping Address</label>
                        <textarea name="address" placeholder="Full Address..." style="width:100%; padding:10px; border-radius:5px; border:1px solid #ddd;" required></textarea>
                    </div>
                    <div class="form-group" style="margin: 15px 0;">
                        <label>Payment Method</label>
                        <select name="payment_method" style="width:100%; padding:10px; border-radius:5px; border:1px solid #ddd;">
                            <option value="Cash on Delivery">Cash on Delivery</option>
                            <option value="bKash">bKash</option>
                        </select>
                    </div>
                    <button type="submit" class="place-order-btn">Confirm Order & Save Receipt</button>
                </form>
            </div>
        </div>
    </div>

    <script src="../js/order.js"></script>
</body>
</html>