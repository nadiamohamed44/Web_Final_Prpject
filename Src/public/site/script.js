// script.js
// API URL
const apiURL = 'https://myshop.com/api/products'; // غيّري للرابط الحقيقي
// Dummy data
const dummyProducts = [
  {name: "Pepperoni Pizza", price: 250, image: "P4.jpg", category: "pizza"},
  {name: "Cheese Burger", price: 180, image: "B1.jpg", category: "burger"},
  {name: "Chicken Pasta", price: 200, image: "Pasta1.jpg", category: "pasta"},
  {name: "Cold Drink", price: 50, image: "DR1.jpg", category: "drinks"},
  {name: "Chocolate Cake", price: 90, image: "D1.jpg", category: "dessert"},
];

let allProducts = [];

// عرض المنتجات
function displayProducts(products) {
  const container = document.getElementById('products-container');
  container.innerHTML = '';
  products.forEach((product, index) => {
    const card = document.createElement('div');
    card.className = 'col-12 col-sm-6 col-md-4 col-lg-3';
    card.innerHTML = `
      <div class="product-card">
        <img src="../assets/${product.image}" class="product-img" alt="${product.name}">
        <div class="product-name">${product.name}</div>
        <div class="product-price">LE ${product.price}.00</div>
        <button class="select-btn">SELECT OPTIONS</button>
      </div>
    `;
    container.appendChild(card);
    setTimeout(() => card.querySelector('.product-card').classList.add('show'), 100 * index);
  });
}

// جلب البيانات من API أو fallback للـ dummy
if (apiURL) {
  fetch(apiURL)
    .then(res => res.json())
    .then(data => {
      allProducts = data;
      displayProducts(allProducts);
    })
    .catch(err => {
      console.error('Error fetching products:', err);
      allProducts = dummyProducts;
      displayProducts(allProducts);
    });
} else {
  allProducts = dummyProducts;
  displayProducts(allProducts);
}

// فلترة المنتجات
document.getElementById("filter-buttons").addEventListener("click", (e) => {
  if (!e.target.classList.contains("filter-btn")) return;

  document.querySelectorAll(".filter-btn").forEach(btn => btn.classList.remove("active"));
  e.target.classList.add("active");

  const category = e.target.dataset.category;
  displayProducts(category === "all" ? allProducts : allProducts.filter(p => p.category === category));
});

// navbar loader
document.addEventListener("DOMContentLoaded", () => {
  fetch("nav.html")
    .then(res => res.text())
    .then(data => document.getElementById("navbar").innerHTML = data)
    .catch(err => console.error(err));
});
