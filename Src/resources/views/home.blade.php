@extends('layouts.app')

@section('title', 'Byte Bites - Home')

@section('content')
    <!-- Hero Section -->
    <section class="wilma-hero-section" id="home">
        <div class="wilma-hero-content">
            <p class="wilma-hero-subtitle">MORE FLAVOR FOR LESS</p>
            <h1 class="wilma-hero-title">Taste The<br>Difference</h1>
            <p class="wilma-hero-description"><strong>Discover a culinary journey like no other, where every dish is
                    thoughtfully prepared to create unforgettable moments of indulgence."</strong></p>
            <a class="btn wilma-btn-custom" href="{{ url('/products') }}">Menu</a>

        </div>
    </section>

    <!-- About Section -->
    <section class="wilma-about-section" id="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="{{ asset('assets/resturant.jpg') }}" alt="Restaurant Interior" class="wilma-about-image">
                </div>
                <div class="col-lg-6">
                    <p class="wilma-section-subtitle">Your Special Occasion Destination</p>
                    <h2 class="wilma-section-title">A haven of exquisite flavors, where every bite transforms an ordinary
                        moment into a <em>cherished</em> memory.</h2>
                    <div class="wilma-decorative-line"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Chef Recommendation Section -->
    <section class="wilma-chef-section" id="menus">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="wilma-chef-card">
                        <p class="wilma-section-subtitle">Delight in Every Bite</p>
                        <h3>Our Chef Recommend</h3>
                        <p class="mariam">Golden-crisp chicken bites, free-range and artfully spiced, paired with
                            hand-crafted dipping sauces. Farm-to-table flavor, elevated with a touch of gourmet flair.</p>
                        <a href="{{ url('/products') }}">
                            <button class="btn wilma-btn-custom">View Menus</button>
                        </a>

                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('assets/dish-removebg-preview.png') }}" alt="Chef Special Dish"
                        class="wilma-dish-image">
                </div>
            </div>
        </div>
    </section>
@endsection