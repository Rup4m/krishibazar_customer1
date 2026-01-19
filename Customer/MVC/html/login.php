<!DOCTYPE html>
<html>
<head><title>Login</title><link rel="stylesheet" href="../css/style.css"></head>

<body class="login-page">
       <div class="login-box">
        <form action="../php/login_controller.php" method="POST">
            <h2>Login</h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login_btn">Login</button>
        </form>
    </div>
</body>
</html>