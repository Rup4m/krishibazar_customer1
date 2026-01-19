<?php include('../php/cart_controller.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart | Krishibazar</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header class="header-main">
        <div class="header-container">
            <div class="logo">Krishibazar</div>
            <nav class="header-nav">
                <a href="dashboard.php">Home</a>
                <a href="cart.php" class="active">Cart</a>
                <a href="profile.php">Me</a>
            </nav>
        </div>
    </header>

    <main class="page-content">
        <div class="block-section">
            <h2 class="section-title">Shopping Cart</h2>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grand_total = 0;
                    while($item = mysqli_fetch_assoc($cart_items)): 
                        $subtotal = $item['price'] * $item['quantity'];
                        $grand_total += $subtotal;
                    ?>
                    <tr>
                        <td><?php echo $item['product_name']; ?></td>
                        <td>৳ <?php echo $item['price']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>৳ <?php echo $subtotal; ?></td>
                        <td><a href="../php/cart_controller.php?delete=<?php echo $item['cart_id']; ?>" class="delete-btn">Remove</a></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            
            <div class="cart-summary">
                <h3>Total: ৳ <?php echo $grand_total; ?></h3>
              <a href="checkout.php" class="order-btn" style="text-decoration: none; display: inline-block; text-align: center;">Confirm Order</a>
            </div>
        </div>
    </main>
</body>
</html>