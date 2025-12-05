@extends('layouts.app')

@section('title', 'Login & Register')

@section('content')

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
                            <img src="{{ asset('assets/login.jpg') }}" alt="restaurant Image">
                        </div>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="right-section">
                    <div class="success-message" id="successMessage">
                        @if (session('success'))
                            {{ session('success') }}
                        @else
                            Success!
                        @endif
                    </div>

                    <!-- Error Messages from Server -->
                    @if ($errors->any())
                        <div class="alert alert-danger" style="width: 100%; margin-bottom: 20px;">
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

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

                        <form id="loginFormSubmit" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="email" name="email" id="loginEmail" placeholder="Email" required
                                    value="{{ old('email') }}">
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

                        <form id="registerFormSubmit" action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group">
                                    <input type="text" name="first_name" id="registerFirstName" placeholder="First name"
                                        required value="{{ old('first_name') }}">
                                    <div class="error-message" id="registerFirstNameError">Please enter your first name
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="last_name" id="registerLastName" placeholder="Last name"
                                        required value="{{ old('last_name') }}">
                                    <div class="error-message" id="registerLastNameError">Please enter your last name</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="email" name="email" id="registerEmail" placeholder="Email" required
                                    value="{{ old('email') }}">
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
@endsection
