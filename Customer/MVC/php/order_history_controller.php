<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once('../db/database.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $user_id = $_SESSION['user_id'];

      // Only cancel if it belongs to the user and is still 'Pending'
    $sql = "UPDATE orders SET status = 'Cancelled' WHERE id = '$order_id' AND user_id = '$user_id' AND status = 'Pending'";
    
    if (mysqli_query($conn, $sql) && mysqli_affected_rows($conn) > 0) {
        echo "success";
    } else {
        echo "error";
    }
    exit();
}
?>
