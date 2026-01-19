<?php
session_start();
require_once('../db/database.php');

if (isset($_POST['place_order'])) {
    $u_id = $_SESSION['user_id'];
    $addr = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $pay = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $total = $_POST['total_amount'];

    mysqli_begin_transaction($conn);
    try {
        // 1. Insert Main Order
        $q = "INSERT INTO orders (user_id, total_amount, address, phone, payment_method) 
              VALUES ('$u_id', '$total', '$addr', '$phone', '$pay')";
        mysqli_query($conn, $q);
        $order_id = mysqli_insert_id($conn);

        // 2. Move Items from Cart to Order_Items
        $cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$u_id'");
        while($row = mysqli_fetch_assoc($cart)) {
            $p_id = $row['product_id'];
            $qty = $row['quantity'];
            $price_res = mysqli_query($conn, "SELECT price FROM products WHERE id='$p_id'");
            $p_price = mysqli_fetch_assoc($price_res)['price'];

            mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase) 
                                 VALUES ('$order_id', '$p_id', '$qty', '$p_price')");
        }

        // 3. Clear Cart
        mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$u_id'");
        mysqli_commit($conn);
        echo "success";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "error";
    }
}
?>