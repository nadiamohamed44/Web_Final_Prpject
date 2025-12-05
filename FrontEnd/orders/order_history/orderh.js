 // Dummy Orders (هتيجي من localStorage أو API بعدين)
    const orders = [
      {
        id: "ORD-2025-001",
        date: "2025-11-28 19:30",
        status: "delivered",
        items: [
          { name: "Pepperoni Pizza", qty: 1, price: 250 },
          { name: "Cold Drink", qty: 2, price: 50 }
        ],
        total: 350
      },
      {
        id: "ORD-2025-002",
        date: "2025-11-30 14:15",
        status: "ontheway",
        items: [
          { name: "Cheese Burger", qty: 2, price: 180 },
          { name: "Chocolate Cake", qty: 1, price: 90 }
        ],
        total: 450
      }
    ];

    function displayOrders() {
      const container = document.getElementById('orders-container');
      const empty = document.getElementById('empty-state');

      if (orders.length === 0) {
        empty.style.display = 'block';
        return;
      }

      container.innerHTML = orders.map(order => `
        <div class="order-card">
          <div class="order-header">
            <div>
              <div class="order-id">#${order.id}</div>
              <div class="order-date">${order.date}</div>
            </div>
            <span class="status ${order.status}">${order.status.toUpperCase()}</span>
          </div>
          <div class="order-body">
            <div class="order-items">
              ${order.items.map(item => `
                <div class="order-item">
                  <span>${item.qty} × ${item.name}</span>
                  <span>LE ${item.price}</span>
                </div>
              `).join('')}
            </div>
            <div class="total-price">Total: LE ${order.total}.00</div>
            ${order.status !== 'delivered' ? `<button class="track-btn" onclick="trackOrder('${order.id}')">Track Order</button>` : ''}
          </div>
        </div>
      `).join('');
    }

    function trackOrder(orderId) {
  localStorage.setItem('trackingOrderId', orderId);
  // المسار الصحيح من مجلد order_history لمجلد order_tracking
  window.location.href = '../order_tracking/ordertracking.html';
}

    // تحميل الـ navbar
    fetch('../../nav.html')
      .then(res => res.text())
      .then(data => document.getElementById('navbar').innerHTML = data);

    displayOrders();