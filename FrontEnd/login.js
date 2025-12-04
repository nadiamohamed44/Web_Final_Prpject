
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
  