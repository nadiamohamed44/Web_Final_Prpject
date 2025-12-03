 fetch('../../nav.html')
      .then(res => res.text())
      .then(data => document.getElementById('navbar').innerHTML = data);

    // جلب رقم الطلب من localStorage
    const orderId = localStorage.getItem('trackingOrderId') || 'ORD-2025-002';
    document.getElementById('order-id').textContent = orderId;