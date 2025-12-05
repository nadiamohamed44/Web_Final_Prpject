function showForm(type) {
      const loginForm = document.getElementById('login-form');
      const registerForm = document.getElementById('register-form');
      const tabBtns = document.querySelectorAll('.tab-btn');
      const toggleText = document.getElementById('toggle-text');

      if (type === 'login') {
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
        tabBtns[0].classList.add('active');
        tabBtns[1].classList.remove('active');
        toggleText.innerHTML = `Don't have an account? <a href="#" onclick="showForm('register')">Register now</a>`;
      } else {
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
        tabBtns[0].classList.remove('active');
        tabBtns[1].classList.add('active');
        toggleText.innerHTML = `Already have an account? <a href="#" onclick="showForm('login')">Login now</a>`;
      }
    }

    // Optional: Submit handlers (يمكنك تربطهم بالـ backend بعدين)
    document.getElementById('login-form').addEventListener('submit', function(e) {
      e.preventDefault();
      alert('Login successful! 🎉');
    });

    document.getElementById('register-form').addEventListener('submit', function(e) {
      e.preventDefault();
      alert('Account created successfully! 🎊');
    });