let cart = [
  { name: "Burger Meal", price: 150, qty: 1 },
  { name: "Chicken Wrap", price: 120, qty: 2 }
];

// CART PAGE
if (document.getElementById("cartItems")) {
  renderCart();
}

function renderCart() {
  let box = document.getElementById("cartItems");
  box.innerHTML = "";
  let subtotal = 0;

  cart.forEach((item, i) => {
    subtotal += item.price * item.qty;

    box.innerHTML += `
      <div class="cart-item">
        <div class="cart-item-name">${item.name}</div>
        <div>
          <button class="qty-btn" onclick="changeQty(${i}, -1)">-</button>
          ${item.qty}
          <button class="qty-btn" onclick="changeQty(${i}, 1)">+</button>
        </div>
        <div class="price">${item.price * item.qty} EGP</div>
      </div>
    `;
  });

  document.getElementById("subtotal").innerText = subtotal;
}

function changeQty(i, val) {
  cart[i].qty += val;
  if (cart[i].qty < 1) cart[i].qty = 1;
  renderCart();
}

// CHECKOUT PAGE
if (document.getElementById("sumSubtotal")) {
  updateSummary();
}

function updateSummary() {
  let subtotal = cart.reduce((sum, item) => sum + item.price * item.qty, 0);
  let tax = Math.round(subtotal * 0.14);
  let total = subtotal + tax;

  document.getElementById("sumSubtotal").innerText = subtotal;
  document.getElementById("tax").innerText = tax;
  document.getElementById("sumTotal").innerText = total;
}

function placeOrder() {
  let name = document.getElementById("fullName").value;
  let phone = document.getElementById("phone").value;
  let address = document.getElementById("address").value;

  if (!name || !phone || !address) {
    alert("Please fill all fields.");
    return;
  }

  alert("Order placed successfully!");
}
