/***********************
  CART PAGE + CHECKOUT
************************/

// Dummy cart data
let cartItems = JSON.parse(localStorage.getItem("cart")) || [
  { id: 1, name: "Product A", price: 120, qty: 1, img: "https://via.placeholder.com/60" },
  { id: 2, name: "Product B", price: 200, qty: 2, img: "https://via.placeholder.com/60" }
];

// Save cart to localStorage
function saveCart() {
  localStorage.setItem("cart", JSON.stringify(cartItems));
}

/*************** CART PAGE ***************/
function renderCartPage() {
  const container = document.getElementById("cartItems");
  if (!container) return;

  container.innerHTML = "";
  let subtotal = 0;

  cartItems.forEach(item => {
    subtotal += item.price * item.qty;

    container.innerHTML += `
      <div class="d-flex align-items-center justify-content-between border p-2 mb-2 rounded">
        <div class="d-flex align-items-center gap-3">
          <img src="${item.img}" class="product-img">
          <div>
            <h6>${item.name}</h6>
            <p class="mb-0">${item.price} EGP</p>
          </div>
        </div>

        <div class="d-flex align-items-center gap-2">
          <button class="btn btn-sm btn-secondary" onclick="updateQty(${item.id}, -1)">-</button>
          <span>${item.qty}</span>
          <button class="btn btn-sm btn-secondary" onclick="updateQty(${item.id}, 1)">+</button>
          <button class="btn btn-danger btn-sm ms-3" onclick="removeItem(${item.id})">Delete</button>
        </div>
      </div>
    `;
  });

  document.getElementById("subtotal").innerText = subtotal;
  saveCart();
}

function updateQty(id, change) {
  let item = cartItems.find(x => x.id === id);
  if (!item) return;

  item.qty += change;
  if (item.qty < 1) item.qty = 1;

  renderCartPage();
}

function removeItem(id) {
  cartItems = cartItems.filter(x => x.id !== id);
  renderCartPage();
}

/*************** CHECKOUT PAGE ***************/
let paymentMethods = [
  { id: 1, method: "Cash on Delivery" },
  { id: 2, method: "Credit Card" },
  { id: 3, method: "Vodafone Cash" }
];

function loadCheckoutPage() {
  const paymentSelect = document.getElementById("paymentMethod");
  const orderBox = document.getElementById("orderSummary");

  if (!paymentSelect || !orderBox) return;

  // Load payment methods
  paymentSelect.innerHTML = paymentMethods.map(p => `
    <option value="${p.method}">${p.method}</option>
  `).join("");

  // Order summary
  let summaryHTML = "";
  let subtotal = 0;

  cartItems.forEach(item => {
    subtotal += item.price * item.qty;
    summaryHTML += `<p>${item.name} (x${item.qty}) — ${item.price * item.qty} EGP</p>`;
  });

  orderBox.innerHTML = summaryHTML;

  updatePaymentSummary();
}

function updatePaymentSummary() {
  const summaryBox = document.getElementById("paymentSummary");
  if (!summaryBox) return;

  let subtotal = cartItems.reduce((acc, item) => acc + item.price * item.qty, 0);
  let shipping = 50;
  let tax = subtotal * 0.10;
  let total = subtotal + shipping + tax;

  summaryBox.innerHTML = `
    <p>Subtotal: ${subtotal} EGP</p>
    <p>Shipping: ${shipping} EGP</p>
    <p>Tax (10%): ${tax.toFixed(2)} EGP</p>
    <h5>Total: ${total.toFixed(2)} EGP</h5>
  `;
}

/*************** VALIDATION ***************/
function placeOrder() {
  let name = document.getElementById("fullName").value.trim();
  let phone = document.getElementById("phone").value.trim();
  let address = document.getElementById("address").value.trim();
  let payment = document.getElementById("paymentMethod").value;

  if (cartItems.length === 0) return alert("Your cart is empty!");

  if (!name || !phone || !address || !payment)
    return alert("Please fill all fields.");

  if (!/^01[0-2,5][0-9]{8}$/.test(phone))
    return alert("Enter a valid Egyptian phone number.");

  alert("Order placed successfully!");
  localStorage.removeItem("cart");
}

/*************** INIT ***************/
window.onload = function () {
  renderCartPage();
  loadCheckoutPage();
};
