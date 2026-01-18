<?php
session_start();
require_once('../db/database.php');

if (isset($_POST['login_btn'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$user' AND password='$pass'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        // Fetch the user data to get the 'id'
        $row = mysqli_fetch_assoc($result);

        // 1. SET SESSIONS
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_id'] = $row['id']; // This fixes the cart error

        // 2. SET COOKIE
        setcookie("last_user", $row['username'], time() + 3600, "/");

        // 3. REDIRECT TO DASHBOARD
        header("Location: ../html/dashboard.php");
        exit(); 
    } else {
        echo "<script>alert('Invalid Username or Password'); window.location='../html/login.php';</script>";
    }
}
?>

