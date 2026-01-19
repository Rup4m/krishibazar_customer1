<!DOCTYPE html>
<html>
<head>
    <title>Krishibazar - Signup</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="login-page">
    <div class="form-container">
        <form action="../php/signup_controller.php" method="POST">
            <h2>Create Account</h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="signup_btn">Sign Up</button>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>