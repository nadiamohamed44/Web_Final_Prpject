@extends('layouts.app')

@section('title', 'Byte Bites - Menu')

@section('content')
    <div class="container">
        <h2 class="page-title" style="padding: 60px;">Menu</h2>

        <!-- filter buttons -->
        <div class="d-flex flex-wrap gap-2 mb-4 justify-content-center" id="filter-buttons">
            <button class="filter-btn active" data-category="all">All</button>
            <button class="filter-btn" data-category="pizza">Pizza</button>
            <button class="filter-btn" data-category="burger">Burger</button>
            <button class="filter-btn" data-category="pasta">Pasta</button>
            <button class="filter-btn" data-category="drinks">Drinks</button>
            <button class="filter-btn" data-category="dessert">Desserts</button>
        </div>

        <!-- products -->
        <!-- We will let JS populate this for now to match the existing behavior, or we can preload it. -->
        <!-- To support SEO and "PHP Project" requirements, ideally we render server side. -->
        <!-- But let's stick to the plan of using the API endpoint for now, or hybrid. -->
        <div class="row g-4" id="products-container">
            <!-- JS will populate this -->
        </div>
    </div>

    @push('scripts')
        <script>
            // Override API URL to point to our Laravel endpoint
            const apiURL = "{{ url('/api/products') }}";
        </script>
    @endpush
@endsection