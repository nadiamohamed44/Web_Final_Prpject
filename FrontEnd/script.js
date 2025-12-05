// API URL
const apiURL = 'https://myshop.com/api/products'; // غيّري للرابط الحقيقي

document.addEventListener("DOMContentLoaded", () => {
  // -----------------------
  // تحميل Navbar
  // -----------------------
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
            if (window.scrollY > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
          });

          // smooth scroll for navbar links
          navbar.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', e => {
              e.preventDefault();
              const target = document.querySelector(anchor.getAttribute('href'));
              if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
          });
        }
      }
    })
    .catch(err => console.error("Error loading navbar:", err));

  // -----------------------
  // تحميل Footer
  // -----------------------
  fetch("footer.html")
    .then(res => res.text())
    .then(data => {
      const footerPlaceholder = document.createElement('div');
      footerPlaceholder.innerHTML = data;
      document.body.appendChild(footerPlaceholder);

      const yearSpan = document.getElementById("current-year");
      if (yearSpan) yearSpan.textContent = new Date().getFullYear();
    })
    .catch(err => console.error('Error loading footer:', err));

  // -----------------------
  // دوران الصورة عند التمرير
  // -----------------------
  const dishImage = document.querySelector('.wilma-dish-image');
  if (dishImage) {
    let lastScrollY = window.scrollY;
    let rotation = 0;

    window.addEventListener('scroll', () => {
      const currentScrollY = window.scrollY;
      const scrollDifference = currentScrollY - lastScrollY;

      rotation += scrollDifference * 0.5;
      dishImage.style.transform = `rotate(${rotation}deg)`; // ← تصحيح خطأ الباكتيكس

      lastScrollY = currentScrollY;
    });
  }

  // -----------------------
  // smooth scrolling لكل الروابط
  // -----------------------
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', e => {
      e.preventDefault();
      const target = document.querySelector(anchor.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });

  // -----------------------
  // Products section
  // -----------------------
  initializeProducts();
});

// -----------------------
// Dummy data
// -----------------------
const dummyProducts = [
  {name: "Pepperoni Pizza", price: 250, image: "P4.jpg", category: "pizza"},
  {name: "Cheese Burger", price: 180, image: "B1.jpg", category: "burger"},
  {name: "Chicken Pasta", price: 200, image: "Pasta1.jpg", category: "pasta"},
  {name: "Cold Drink", price: 50, image: "DR1.jpg", category: "drinks"},
  {name: "Chocolate Cake", price: 90, image: "D1.jpg", category: "dessert"},
];

let allProducts = [];

// -----------------------
// عرض المنتجات
// -----------------------
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
      if (productCard) productCard.classList.add('show');
    }, 100 * index);
  });
}

// -----------------------
// تهيئة المنتجات
// -----------------------
function initializeProducts() {
  // جلب البيانات من API أو fallback
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

        // الحصول على العناصر
        const loginTab = document.getElementById('loginTab');
        const registerTab = document.getElementById('registerTab');
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        const successMessage = document.getElementById('successMessage');
        const goToRegister = document.getElementById('goToRegister');
        const goToLogin = document.getElementById('goToLogin');

        // التبديل بين التابات
        loginTab.addEventListener('click', switchToLogin);
        goToLogin.addEventListener('click', switchToLogin);

        registerTab.addEventListener('click', switchToRegister);
        goToRegister.addEventListener('click',switchToRegister)
        ;

        function switchToLogin() {
            loginTab.classList.add('active');
            registerTab.classList.remove('active');
            loginForm.classList.add('active');
            registerForm.classList.remove('active');
        }

        function switchToRegister() {
            registerTab.classList.add('active');
            loginTab.classList.remove('active');
            registerForm.classList.add('active');
            loginForm.classList.remove('active');
        }

        // دالة للتحقق من صحة الإيميل
        function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // دالة للتحقق من كلمة المرور
        function validatePassword(password) {
            return password.length >= 6;
        }

        // عرض رسالة نجاح
        function showSuccess(message) {
            successMessage.textContent = message;
            successMessage.classList.add('show');
            setTimeout(function() {
                successMessage.classList.remove('show');
            }, 3000);
        }

        // === نموذج تسجيل الدخول ===
        const loginEmailInput = document.getElementById('loginEmail');
        const loginPasswordInput = document.getElementById('loginPassword');
        const loginEmailError = document.getElementById('loginEmailError');
        const loginPasswordError = document.getElementById('loginPasswordError');
        const loginBtn = document.getElementById('loginBtn');
        const forgotPassword = document.getElementById('forgotPassword');

        loginEmailInput.addEventListener('input', function() {
            if (this.value && !validateEmail(this.value)) {
                this.classList.add('error');
                loginEmailError.classList.add('show');
            } else {
                this.classList.remove('error');
                loginEmailError.classList.remove('show');
            }
        });

        loginPasswordInput.addEventListener('input', function() {
            if (this.value && !validatePassword(this.value)) {
                this.classList.add('error');
                loginPasswordError.classList.add('show');
            } else {
                this.classList.remove('error');
                loginPasswordError.classList.remove('show');
            }
        });

        document.getElementById('loginFormSubmit').addEventListener('submit', function(e) {
            e.preventDefault();

            const email = loginEmailInput.value.trim();
            const password = loginPasswordInput.value.trim();
            let isValid = true;

            if (!email || !validateEmail(email)) {
                loginEmailInput.classList.add('error');
                loginEmailError.classList.add('show');
                isValid = false;
            }

            if (!password || !validatePassword(password)) {
                loginPasswordInput.classList.add('error');
                loginPasswordError.classList.add('show');
                isValid = false;
            }

            if (isValid) {
                loginBtn.disabled = true;
                loginBtn.textContent = 'Logging in...';

                setTimeout(function() {
                    showSuccess('Login successful! ');
                    loginBtn.disabled = false;
                    loginBtn.textContent = 'Login';
                    loginEmailInput.value = '';
                    loginPasswordInput.value = '';

                    console.log('Login successful:');
                    console.log('Email:', email);
                }, 1500);
            }
        });

        forgotPassword.addEventListener('click', function(e) {
            e.preventDefault();
            alert('Password reset link will be sent to your email');
        });

        // === نموذج التسجيل ===
        const registerFirstNameInput = document.getElementById('registerFirstName');
        const registerLastNameInput = document.getElementById('registerLastName');
        const registerEmailInput = document.getElementById('registerEmail');
        const registerPasswordInput = document.getElementById('registerPassword');
        const registerFirstNameError = document.getElementById('registerFirstNameError');
        const registerLastNameError = document.getElementById('registerLastNameError');
        const registerEmailError = document.getElementById('registerEmailError');
        const registerPasswordError = document.getElementById('registerPasswordError');
        const registerBtn = document.getElementById('registerBtn');

        registerFirstNameInput.addEventListener('input', function() {
            if (this.value && this.value.trim().length < 2) {
                this.classList.add('error');
                registerFirstNameError.classList.add('show');
            } else {
                this.classList.remove('error');
                registerFirstNameError.classList.remove('show');
            }
        });

        registerLastNameInput.addEventListener('input', function() {
            if (this.value && this.value.trim().length < 2) {
                this.classList.add('error');
                registerLastNameError.classList.add('show');
            } else {
                this.classList.remove('error');
                registerLastNameError.classList.remove('show');
            }
        });

        registerEmailInput.addEventListener('input', function() {
            if (this.value && !validateEmail(this.value)) {
                this.classList.add('error');
                registerEmailError.classList.add('show');
            } else {
                this.classList.remove('error');
                registerEmailError.classList.remove('show');
            }
        });

        registerPasswordInput.addEventListener('input', function() {
            if (this.value && !validatePassword(this.value)) {
                this.classList.add('error');
                registerPasswordError.classList.add('show');
            } else {
                this.classList.remove('error');
                registerPasswordError.classList.remove('show');
            }
        });

        document.getElementById('registerFormSubmit').addEventListener('submit', function(e) {
            e.preventDefault();

            const firstName = registerFirstNameInput.value.trim();
            const lastName = registerLastNameInput.value.trim();
            const email = registerEmailInput.value.trim();
            const password = registerPasswordInput.value.trim();
            let isValid = true;

            if (!firstName || firstName.length < 2) {
                registerFirstNameInput.classList.add('error');
                registerFirstNameError.classList.add('show');
                isValid = false;
            }

            if (!lastName || lastName.length < 2) {
                registerLastNameInput.classList.add('error');
                registerLastNameError.classList.add('show');
                isValid = false;
            }

            if (!email || !validateEmail(email)) {
                registerEmailInput.classList.add('error');
                registerEmailError.classList.add('show');
                isValid = false;
            }

            if (!password || !validatePassword(password)) {
                registerPasswordInput.classList.add('error');
                registerPasswordError.classList.add('show');
                isValid = false;
            }

            if (isValid) {
                registerBtn.disabled = true;
                registerBtn.textContent = 'Creating account...';

                setTimeout(function() {
                    showSuccess('Account created successfully! 🎉');
                    registerBtn.disabled = false;
                    registerBtn.textContent = 'Create account';
                    registerFirstNameInput.value = '';
                    registerLastNameInput.value = '';
                    registerEmailInput.value = '';
                    registerPasswordInput.value = '';

                    console.log('Account created:');
                    console.log('Name:', firstName, lastName);
                    console.log('Email:', email);

                    // التبديل تلقائياً لصفحة تسجيل الدخول
                    setTimeout(function() {
                        switchToLogin();
                    }, 2000);
                }, 1500);
            }
        });