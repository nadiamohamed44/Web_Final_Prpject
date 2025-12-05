

<?php $__env->startSection('title', 'Byte Bites - Menu'); ?>

<?php $__env->startSection('content'); ?>
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

    <?php $__env->startPush('scripts'); ?>
        <script>
            // Override API URL to point to our Laravel endpoint
            const apiURL = "<?php echo e(url('/api/products')); ?>";
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nadaa\OneDrive\Desktop\Web_Final_Prpject\Src\resources\views/products/index.blade.php ENDPATH**/ ?>