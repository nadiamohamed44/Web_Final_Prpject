<nav class="navbar navbar-expand-lg wilma-navbar" id="navbar">
    <div class="container">
        <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
            <img src="<?php echo e(asset('assets/logo-removebg-preview.png')); ?>" alt="Byte Bites Logo" class="navbar-logo">
        </a>

        <a class="navbar-brand wilma-brand" href="<?php echo e(url('/')); ?>">Byte Bites</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link byte-nav-link" href="<?php echo e(url('/')); ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link byte-nav-link" href="<?php echo e(url('/')); ?>#about">About</a></li>
                <?php if(auth()->guard()->guest()): ?>
                    <li class="nav-item"><a class="nav-link byte-nav-link" href="<?php echo e(url('/login')); ?>">Login</a></li>
                <?php else: ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle byte-nav-link" href="#" role="button"
                            data-bs-toggle="dropdown"><?php echo e(Auth::user()->name); ?></a>
                        <ul class="dropdown-menu">
                            <li>
                                <form action="<?php echo e(route('logout')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link byte-nav-link" href="<?php echo e(url('/products')); ?>">Menu</a></li>
                <li class="nav-item"><a class="nav-link byte-nav-link" href="<?php echo e(url('/cart')); ?>">Cart</a></li>
                <li class="nav-item"><a class="nav-link byte-nav-link" href="<?php echo e(url('/')); ?>#contact">Contact</a></li>
            </ul>
        </div>
    </div>
</nav><?php /**PATH C:\Users\nadaa\OneDrive\Desktop\Web_Final_Prpject\Src\resources\views/partials/navbar.blade.php ENDPATH**/ ?>