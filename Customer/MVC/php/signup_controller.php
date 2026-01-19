<?php
session_start();
require_once('../db/database.php');

if (isset($_POST['signup_btn'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password']; // In production, use password_hash()

    // Check if user exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$user'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Username taken!'); window.location='../html/signup.php';</script>";
    } else {
        // Save to DB
        $query = "INSERT INTO users (username, password) VALUES ('$user', '$pass')";
        if (mysqli_query($conn, $query)) {
            // Use Session and Cookie
            $_SESSION['new_user'] = $user;
            setcookie("registration_date", date("Y-m-d"), time() + (86400 * 30), "/");

            echo "<script>alert('Signup Successful!'); window.location='../html/login.php';</script>";
        }
    }
}
?>