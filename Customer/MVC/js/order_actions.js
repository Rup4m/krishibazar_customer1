function cancelOrder(id) {
    if (confirm("Are you sure you want to cancel this order?")) {
        const formData = new FormData();
        formData.append('order_id', id);