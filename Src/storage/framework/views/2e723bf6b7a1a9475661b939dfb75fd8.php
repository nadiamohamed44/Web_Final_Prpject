<footer class="wilma-footer">
    <div class="container">
        <div class="row">
            <!-- About Column -->
            <div class="col-md-4 mb-4">
                <h4 class="footer-title">Byte Bites</h4>
                <p class="footer-text">Premium restaurant serving the finest dishes with exceptional taste and quality.
                </p>
                <div class="footer-social">
                    <a href="https://www.fa-facebook.com/"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>

                </div>
            </div>

            <!-- Quick Links Column -->
            <div class="col-md-4 mb-4">
                <h4 class="footer-title">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
                    <li><a href="<?php echo e(url('/')); ?>#about">About Us</a></li>
                    <li><a href="<?php echo e(url('/products')); ?>">Our Menus</a></li>
                    <li><a href="<?php echo e(url('/cart')); ?>">Cart</a></li>
                    <?php if(auth()->guard()->guest()): ?>
                        <li><a href="<?php echo e(url('/login')); ?>">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Contact Column -->
            <div class="col-md-4 mb-4">
                <h4 class="footer-title">Contact Us</h4>
                <ul class="footer-contact">
                    <li><i class="fas fa-map-marker-alt"></i> 123 Restaurant St, Cairo, Egypt</li>
                    <li><i class="fas fa-phone"></i> +20 123 456 7890</li>
                    <li><i class="fas fa-envelope"></i> info@bytebites.com</li>
                    <li><i class="fas fa-clock"></i> Daily: 10:00 AM - 11:00 PM</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2024 Byte Bites. All Rights Reserved.</p>
        </div>
    </div>
</footer><?php /**PATH C:\Users\nadaa\OneDrive\Desktop\Web_Final_Prpject\Src\resources\views/partials/footer.blade.php ENDPATH**/ ?>