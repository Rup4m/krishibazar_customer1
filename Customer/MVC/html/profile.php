
<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
require_once('../db/database.php');

$u_id = $_SESSION['user_id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$u_id'"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | Krishibazar</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="checkout-page">
    <header class="header-main">
        <div class="header-container">
            <div class="logo">Krishibazar</div>
            <nav class="header-nav">
                <a href="dashboard.php">Home</a>
                <a href="cart.php">Cart</a>
                <a href="orders.php">Orders</a>
                <a href="profile.php" class="active">Me</a>
                <a href="../php/logout.php" style="color: #d9534f;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            </nav>
        </div>
    </header>


     <main class="checkout-main-container">
        <div class="invoice-wrapper" style="max-width: 650px; margin: 0 auto;">
            <div class="invoice-header">
                <span class="logo"><i class="fa-solid fa-user-gear"></i> Account Settings</span>
            </div>

            <form id="profileForm" enctype="multipart/form-data">
                <div style="text-align: center; margin-bottom: 25px;">
                    <div style="position: relative; display: inline-block;">
                        <img src="../images/<?php echo $user['profile_image'] ?: 'default_user.png'; ?>" 
                             id="preview" style="width: 130px; height: 130px; border-radius: 50%; object-fit: cover; border: 4px solid #2d8a39; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    </div>

                     <br>
                    <label for="profile_pic" class="delete-btn" style="display: inline-block; cursor: pointer; margin-top: 10px; font-size: 0.8rem;">Change Photo</label>
                    <input type="file" name="profile_pic" id="profile_pic" style="display:none;" onchange="previewImage(this)">
                </div>

                <div class="checkout-flex-layout" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Delivery Address</label>
                    <textarea name="address" rows="2"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label>New Password (Leave blank to keep current)</label>
                    <input type="password" name="new_password" placeholder="••••••••">
                </div>

                <button type="submit" class="place-order-btn">Save All Changes</button>
            </form>
            <div id="response" style="margin-top: 15px; text-align: center; font-weight: 500;"></div>
        </div>
    </main>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) { document.getElementById('preview').src = e.target.result; }
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.getElementById('profileForm').onsubmit = function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const responseDiv = document.getElementById('response');
            responseDiv.innerHTML = "Updating...";
            
            fetch('../php/profile_controller.php', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if(data.status === "success") {
                    responseDiv.style.color = "green";
                    responseDiv.innerHTML = data.message;
                    if(data.new_image) {
                        // Cache-busting logic for real-time update
                        document.getElementById('preview').src = "../images/" + data.new_image + "?t=" + Date.now();
                    }
                } else {
                    responseDiv.style.color = "red";
                    responseDiv.innerHTML = "Error: " + data.message;
                }
            })
            .catch(err => {
                responseDiv.style.color = "red";
                responseDiv.innerHTML = "Server connection error.";
            });
        };
    </script>
</body>
</html>

