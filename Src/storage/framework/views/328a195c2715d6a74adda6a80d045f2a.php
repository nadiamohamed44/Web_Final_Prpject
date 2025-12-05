

<?php $__env->startSection('title', 'Login & Register'); ?>

<?php $__env->startSection('content'); ?>

    <style>
        .login-container {
            margin-top: 120px;
            /* Adjust according to navbar height */
        }
    </style>

    <div class="login-container">

        <div class="page-wrapper">
            <div class="main-container">
                <!-- Left Section -->
                <div class="left-section">
                    <div class="logo">Byte Bites</div>

                    <div>
                        <div class="hero-image">
                            <img src="<?php echo e(asset('assets/login.jpg')); ?>" alt="restaurant Image">
                        </div>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="right-section">
                    <div class="success-message" id="successMessage">
                        <?php if(session('success')): ?>
                            <?php echo e(session('success')); ?>

                        <?php else: ?>
                            Success!
                        <?php endif; ?>
                    </div>

                    <!-- Error Messages from Server -->
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger" style="width: 100%; margin-bottom: 20px;">
                            <ul style="margin: 0; padding-left: 20px;">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Tabs -->
                    <div class="tabs">
                        <div class="tab active" id="loginTab">Login</div>
                        <div class="tab" id="registerTab">Register</div>
                    </div>

                    <!-- Login Form -->
                    <div class="form-container active" id="loginForm">
                        <div class="form-header">
                            <h1>Welcome back</h1>
                            <p>Don't have an account? <a href="#" id="goToRegister">Sign up</a></p>
                        </div>

                        <form id="loginFormSubmit" action="<?php echo e(route('login')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <input type="email" name="email" id="loginEmail" placeholder="Email" required
                                    value="<?php echo e(old('email')); ?>">
                                <div class="error-message" id="loginEmailError">Please enter a valid email</div>
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" id="loginPassword" placeholder="Enter your password"
                                    required>
                                <div class="error-message" id="loginPasswordError">Password must be at least 6 characters
                                </div>
                            </div>

                            <div class="forgot-password">
                                <a href="#" id="forgotPassword">Forgot password?</a>
                            </div>

                            <button type="submit" id="loginBtn">Login</button>
                        </form>
                    </div>

                    <!-- Register Form -->
                    <div class="form-container" id="registerForm">
                        <div class="form-header">
                            <h1>Create an account</h1>
                            <p>Already have an account? <a href="#" id="goToLogin">Log in</a></p>
                        </div>

                        <form id="registerFormSubmit" action="<?php echo e(route('register')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="form-row">
                                <div class="form-group">
                                    <input type="text" name="first_name" id="registerFirstName" placeholder="First name"
                                        required value="<?php echo e(old('first_name')); ?>">
                                    <div class="error-message" id="registerFirstNameError">Please enter your first name
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="last_name" id="registerLastName" placeholder="Last name"
                                        required value="<?php echo e(old('last_name')); ?>">
                                    <div class="error-message" id="registerLastNameError">Please enter your last name</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="email" name="email" id="registerEmail" placeholder="Email" required
                                    value="<?php echo e(old('email')); ?>">
                                <div class="error-message" id="registerEmailError">Please enter a valid email</div>
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" id="registerPassword"
                                    placeholder="Enter your password" required>
                                <div class="error-message" id="registerPasswordError">Password must be at least 6 characters
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="password" name="password_confirmation" id="registerConfirmPassword"
                                    placeholder="Confirm your password" required>
                            </div>

                            <button type="submit" id="registerBtn">Create account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nadaa\OneDrive\Desktop\Web_Final_Prpject\Src\resources\views/auth/login.blade.php ENDPATH**/ ?>