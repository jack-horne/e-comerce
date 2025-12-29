<div class="bg-dark text-white h-100 d-flex flex-column">
    <div class="p-4 w-100">
        <h5 class="mb-4 text-nowrap">
            <i class="fas fa-chart-line me-2"></i>Pixel Part
        </h5>
        <nav>
            <ul class="list-unstyled mb-0">
                <li class="mb-2">
                    <a href="/e_commerce2/admin/dashboard.php" class="text-white text-decoration-none d-block p-2 rounded hover-menu">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="/e_commerce2/admin/products/list.php" class="text-white text-decoration-none d-block p-2 rounded hover-menu">
                        <i class="fas fa-box me-2"></i> Produk
                    </a>
                </li>
                <li class="mb-2">
                    <a href="/e_commerce2/admin/orders/list.php" class="text-white text-decoration-none d-block p-2 rounded hover-menu">
                        <i class="fas fa-shopping-bag me-2"></i> Pesanan
                    </a>
                </li>
                <li class="mb-2">
                    <a href="/e_commerce2/admin/user/list.php" class="text-white text-decoration-none d-block p-2 rounded hover-menu">
                        <i class="fas fa-users me-2"></i> User
                    </a>
                </li>
                <li class="mb-2">
                    <a href="/e_commerce2/admin/reports/sales.php" class="text-white text-decoration-none d-block p-2 rounded hover-menu">
                        <i class="fas fa-chart-bar me-2"></i> Laporan
                    </a>
                </li>
                <li class="mb-2">
                    <a href="/e_commerce2/admin/settings.php" class="text-white text-decoration-none d-block p-2 rounded hover-menu">
                        <i class="fas fa-cog me-2"></i> Pengaturan
                    </a>
                </li>
                <li class="mt-4 pt-3 border-top border-secondary">
                    <a href="../backend/auth.php?action=logout" class="text-danger text-decoration-none d-block p-2 rounded hover-menu">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<style>
    .hover-menu:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff !important;
    }
</style>