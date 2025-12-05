<nav class="navbar navbar-expand-lg wilma-navbar" id="navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('assets/logo-removebg-preview.png') }}" alt="Byte Bites Logo" class="navbar-logo">
        </a>

        <a class="navbar-brand wilma-brand" href="{{ url('/') }}">Byte Bites</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link byte-nav-link" href="{{ url('/') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link byte-nav-link" href="{{ url('/') }}#about">About</a></li>
                @guest
                    <li class="nav-item"><a class="nav-link byte-nav-link" href="{{ url('/login') }}">Login</a></li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle byte-nav-link" href="#" role="button"
                            data-bs-toggle="dropdown">{{ Auth::user()->name }}</a>
                        <ul class="dropdown-menu">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
                <li class="nav-item"><a class="nav-link byte-nav-link" href="{{ url('/products') }}">Menu</a></li>
                <li class="nav-item"><a class="nav-link byte-nav-link" href="{{ url('/cart') }}">Cart</a></li>
                <li class="nav-item"><a class="nav-link byte-nav-link" href="{{ url('/') }}#contact">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>