<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
require_once('../db/database.php');

$u_id = $_SESSION['user_id'];
$query = "SELECT * FROM orders WHERE user_id = '$u_id' ORDER BY order_date DESC";
$result = mysqli_query($conn, $query);
?>