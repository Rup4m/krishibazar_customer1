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
                              <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr id="order-row-<?php echo $row['id']; ?>">
                                <td><strong>#<?php echo $row['id']; ?></strong></td>
                                <td><?php echo date('M d, Y', strtotime($row['order_date'])); ?></td>
                                <td class="grand-total" style="font-size: 1rem;">৳ <?php echo number_format($row['total_amount'], 2); ?></td>
                                <td>
                                    <span class="status-badge <?php echo strtolower($row['status']); ?>">
                                        <?php echo $row['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if($row['status'] == 'Pending'): ?>
                                        <button class="delete-btn" onclick="cancelOrder(<?php echo $row['id']; ?>)">
                                            <i class="fa-solid fa-xmark"></i> Cancel
                                        </button>
                                    <?php else: ?>
                                        <span style="color: #999; font-size: 0.85rem;">Completed</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 40px;">
                    <i class="fa-solid fa-basket-shopping" style="font-size: 3rem; color: #ddd;"></i>
                    <p style="margin-top: 15px;">No orders found yet.</p>
                    <a href="dashboard.php" class="place-order-btn" style="text-decoration: none; padding: 10px 20px;">Start Shopping</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <script src="../js/order_actions.js"></script>
</body>
</html>
