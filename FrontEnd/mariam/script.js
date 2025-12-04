// script.js
// API URL
const apiURL = 'https://myshop.com/api/products'; // غيّري للرابط الحقيقي

document.addEventListener("DOMContentLoaded", () => {
  // تحميل Navbar
  fetch("navbar.html")
    .then(res => res.text())
    .then(data => {
      const placeholder = document.getElementById("navbar-placeholder");
      if (placeholder) {
        placeholder.innerHTML = data;
        const navbar = placeholder.querySelector('nav');

        if (navbar) {
          // scroll effect
          window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
              navbar.classList.add('scrolled');
            } else {
              navbar.classList.remove('scrolled');
            }
          });

          // smooth scroll
          navbar.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', e => {
              e.preventDefault();
              const target = document.querySelector(anchor.getAttribute('href'));
              if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
              }
            });
          });
        }
      }
    })
    .catch(err => console.error("Error loading navbar:", err));

  // تحميل Footer
  fetch("footer.html")
    .then(res => res.text())
    .then(data => {
      const footerPlaceholder = document.createElement('div');
      footerPlaceholder.innerHTML = data;
      document.body.appendChild(footerPlaceholder);

      // تحديث السنة الحالية تلقائياً
      const yearSpan = document.getElementById("current-year");
      if (yearSpan) {
        yearSpan.textContent = new Date().getFullYear();
      }
    })
    .catch(err => console.error('Error loading footer:', err));

  // Dish rotation on scroll
  const dishImage = document.querySelector('.wilma-dish-image');
  if (dishImage) {
    let lastScrollY = window.scrollY;
    let rotation = 0;

    window.addEventListener('scroll', function() {
      const currentScrollY = window.scrollY;
      const scrollDifference = currentScrollY - lastScrollY;
      
      // Rotate based on scroll direction and amount
      rotation += scrollDifference * 0.5;
      dishImage.style.transform = `rotate(${rotation}deg)`;
      
      lastScrollY = currentScrollY;
    });
  }

  // Smooth scrolling for all anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });

  // Products section
  initializeProducts();
});

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
  if (!container) return;
  
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
    setTimeout(() => {
      const productCard = card.querySelector('.product-card');
      if (productCard) {
        productCard.classList.add('show');
      }
    }, 100 * index);
  });
}

// تهيئة المنتجات
function initializeProducts() {
  // جلب البيانات من API أو fallback للـ dummy
  if (apiURL && apiURL !== 'https://myshop.com/api/products') {
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
  const filterButtons = document.getElementById("filter-buttons");
  if (filterButtons) {
    filterButtons.addEventListener("click", (e) => {
      if (!e.target.classList.contains("filter-btn")) return;

      document.querySelectorAll(".filter-btn").forEach(btn => btn.classList.remove("active"));
      e.target.classList.add("active");

      const category = e.target.dataset.category;
      displayProducts(category === "all" ? allProducts : allProducts.filter(p => p.category === category));
    });
  }
}