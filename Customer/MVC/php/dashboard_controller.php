<?php
require_once('../db/database.php');

// Fetch Categories (7 blocks)
$cat_query = "SELECT * FROM categories LIMIT 7";
$categories = mysqli_query($conn, $cat_query);

// Handle Search Functional Logic
$search_query = "";
if (isset($_GET['search'])) {
    $search_term = mysqli_real_escape_string($conn, $_GET['search']);
    $search_query = " WHERE product_name LIKE '%$search_term%'";
}

$prod_query = "SELECT * FROM products" . $search_query;
$products = mysqli_query($conn, $prod_query);
?>