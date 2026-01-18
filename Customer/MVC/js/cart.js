function addToCart(id) {
    // Using AJAX (Fetch API) to communicate with the controller
    fetch('../php/cart_controller.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'add_to_cart=1&product_id=' + id
    })
    .then(response => response.text())
    .then(data => {
        if (data === "success") {
            alert("Product added to cart successfully!");
        } else {
            alert("Failed to add product. Please try again.");
        }
    })
    .catch(error => console.error('Error:', error));
}