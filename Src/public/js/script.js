// API URL
// const apiURL = '...'; // Defined in blade view or default here
if (typeof apiURL === 'undefined') {
    var apiURL = '/api/products'; // Default fallback
}

document.addEventListener("DOMContentLoaded", () => {
    // -----------------------
    // Removed Navbar/Footer loading since Blade handles it
    // -----------------------

    // -----------------------
    // Navbar Scroll Effect
    // -----------------------
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        });
    }

    // -----------------------
    // Smooth Scroll
    // -----------------------
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', e => {
            // Only if it's a hash link on the same page
            const href = anchor.getAttribute('href');
            if (href.startsWith('#') && href.length > 1) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    });

    // -----------------------
    // Dish Rotation
    // -----------------------
    const dishImage = document.querySelector('.wilma-dish-image');
    if (dishImage) {
        let lastScrollY = window.scrollY;
        let rotation = 0;

        window.addEventListener('scroll', () => {
            const currentScrollY = window.scrollY;
            const scrollDifference = currentScrollY - lastScrollY;
            rotation += scrollDifference * 0.5;
            dishImage.style.transform = `rotate(${rotation}deg)`;
            lastScrollY = currentScrollY;
        });
    }

    // -----------------------
    // Products initialization
    // -----------------------
    initializeProducts();
});

// -----------------------
// Dummy data (Partial Fallback)
// -----------------------
let allProducts = [];

// -----------------------
// Display Products
// -----------------------
function displayProducts(products) {
    const container = document.getElementById('products-container');
    if (!container) return; // Not on products page

    container.innerHTML = '';

    products.forEach((product, index) => {
        const card = document.createElement('div');
        card.className = 'col-12 col-sm-6 col-md-4 col-lg-3';

        // Assuming image path needs adjustment based on where it's stored.
        // If product.image is 'P4.jpg', we need '/assets/P4.jpg' or similar.
        // The API returns 'image' as filename.
        // We use a helper or simple concatenation.
        const imagePath = product.image.startsWith('http') ? product.image : `/assets/${product.image}`;

        card.innerHTML = `
        <div class="product-card">
          <img src="${imagePath}" class="product-img" alt="${product.name}">
          <div class="product-name">${product.name}</div>
          <div class="product-price">LE ${product.price}</div> 
          <button class="select-btn">SELECT OPTIONS</button>
        </div>
      `;
        // Removed .00 from price as it might be string or number

        container.appendChild(card);

        setTimeout(() => {
            const productCard = card.querySelector('.product-card');
            if (productCard) productCard.classList.add('show');
        }, 100 * index);
    });
}

// -----------------------
// Initialize Products
// -----------------------
function initializeProducts() {
    const container = document.getElementById('products-container');
    if (!container) return;

    fetch(apiURL)
        .then(res => res.json())
        .then(data => {
            allProducts = data;
            displayProducts(allProducts);
        })
        .catch(err => {
            console.error('Error fetching products:', err);
            // Fallback could go here
        });

    // Filter Buttons
    const filterButtons = document.getElementById("filter-buttons");
    if (filterButtons) {
        filterButtons.addEventListener("click", e => {
            if (!e.target.classList.contains("filter-btn")) return;

            document.querySelectorAll(".filter-btn").forEach(btn =>
                btn.classList.remove("active")
            );
            e.target.classList.add("active");

            const category = e.target.dataset.category;

            displayProducts(
                category === "all"
                    ? allProducts
                    : allProducts.filter(p => p.category === category)
            );
        });
    }
}


// -----------------------
// Auth Logic (Refactored for Server Submission)
// -----------------------
const loginTab = document.getElementById('loginTab');
const registerTab = document.getElementById('registerTab');
const loginForm = document.getElementById('loginForm');
const registerForm = document.getElementById('registerForm');
const goToRegister = document.getElementById('goToRegister');
const goToLogin = document.getElementById('goToLogin');

if (loginTab && registerTab && loginForm && registerForm) {
    // Toggling
    const switchToLogin = () => {
        loginTab.classList.add('active');
        registerTab.classList.remove('active');
        loginForm.classList.add('active');
        registerForm.classList.remove('active');
    };

    const switchToRegister = () => {
        registerTab.classList.add('active');
        loginTab.classList.remove('active');
        registerForm.classList.add('active');
        loginForm.classList.remove('active');
    };

    loginTab.addEventListener('click', switchToLogin);
    if (goToLogin) goToLogin.addEventListener('click', switchToLogin);

    registerTab.addEventListener('click', switchToRegister);
    if (goToRegister) goToRegister.addEventListener('click', switchToRegister);

    // Client-side validation is good, but we must let the form submit.
    // The previous script had e.preventDefault() in submit handler.
    // We will leave the default form submission (HTML5 validation + server side).
    // Or we can add simple JS validation that prevents default ONLY if invalid.

    // Simplification: We rely on HTML5 'required' attributes and Server validation for this MVP integration
    // to ensure reliability. The error messages from server are displayed in the blade view.
}
