<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once('../db/database.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $user_id = $_SESSION['user_id'];
