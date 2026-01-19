function cancelOrder(id) {
    if (confirm("Are you sure you want to cancel this order?")) {
        const formData = new FormData();
        formData.append('order_id', id);

            fetch('../php/order_history_controller.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === "success") {
                alert("Order Cancelled.");
                location.reload(); // Refresh to see status change
            } else {
                alert("Error: Could not cancel order.");
            }
        });
    }
}