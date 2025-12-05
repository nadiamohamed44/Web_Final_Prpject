<div class="sidebar">
    <div class="text-center mb-4">
        <h4 class="text-white">لوحة التحكم</h4>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> الرئيسية
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}">
                <i class="fas fa-box"></i> المنتجات
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i> التصنيفات
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i> الطلبات
            </a>
        </li>


    </ul>
</div>
