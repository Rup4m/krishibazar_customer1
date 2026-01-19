document.getElementById('checkoutForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    formData.append('place_order', '1');
    formData.append('total_amount', document.getElementById('finalTotal').innerText);

    fetch('../php/order_controller.php', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(data => {
        if(data.trim() === "success") {
            const invoiceElement = document.getElementById('invoice-card');
            html2canvas(invoiceElement).then(canvas => {
                const link = document.createElement('a');
                link.download = 'Krishibazar_Invoice.png';
                link.href = canvas.toDataURL();
                link.click();
                
                alert("Order Placed Successfully! Your invoice is downloading.");
                window.location.href = "dashboard.php";
            });
        } else {
            alert("Order failed. Please check your connection.");
        }
    });
});