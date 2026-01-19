<?php 
session_start();
if(!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
include('../php/dashboard_controller.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Krishibazar | Professional Home</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header-main">
        <div class="header-container">
            <div class="logo">Krishibazar</div>
            <div class="search-area">
                <form action="" method="GET">
                    <input type="text" name="search" placeholder="Search for fresh farm products...">
                    <button type="submit">Search</button>
                </form>
            </div>
            <nav class="header-nav">
                <a href="dashboard.php" class="active">Home</a>
                <a href="cart.php">Cart</a>
                <a href="orders.php">Orders</a>
                <a href="profile.php">Me</a>
            </nav>
        </div>
    </header>

    <main class="page-content">
        <section class="block-section banner-block">
            <div class="banner-text">
                <h1>Fresh From Farm to Doorstep</h1>
                <p>Buy organic Bangladeshi products directly from farmers.</p>
            </div>
        </section>

        <section class="block-section">
            <div class="section-title">
                <h3>Top Categories</h3>
                <a href="#" class="view-all">View All</a>
            </div>
            <div class="category-flex">
                <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                    <a href="category.php?id=<?php echo $cat['id']; ?>" class="category-item">
                        <div class="circle-box">
                            <img src="../images/<?php echo strtolower($cat['category_name']); ?>.jpg" 
                                 alt="<?php echo $cat['category_name']; ?>" 
                                 style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; display: block;">
                        </div>
                        <span><?php echo $cat['category_name']; ?></span>
                    </a>
                <?php endwhile; ?>
            </div>
        </section>

        <section class="block-section">
            <div class="section-title">
                <h3>Recommended for You</h3>
            </div>
            <div class="product-grid">
                <?php while($row = mysqli_fetch_assoc($products)): ?>
                    <div class="product-block">
                        <div class="product-img-box">
                            <img src="../images/<?php echo $row['product_name']; ?>.jpg" 
                                 alt="<?php echo $row['product_name']; ?>" 
                                 style="width: 100%; height: 100%; object-fit: cover; display: block;">
                        </div>
                        <div class="product-details">
                            <h4 class="product-name"><?php echo $row['product_name']; ?></h4>
                            <p class="product-price">৳ <?php echo $row['price']; ?></p>
                            <button class="cart-btn" onclick="addToCart(<?php echo $row['id']; ?>)">Add to Cart</button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </main>

    <script src="../js/cart.js"></script>
</body>
</html>