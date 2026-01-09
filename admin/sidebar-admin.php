<div class="bg-dark text-white vh-100 p-3 shadow">
    <h5 class="mb-4 border-bottom pb-3">
        <i class="fas fa-microchip me-2 text-info"></i>Pixel Part
    </h5>
    <nav>
        <ul class="list-unstyled">
            <li class="mb-2">
                <a href="<?= BASE_URL; ?>admin/dashboard.php" class="text-white text-decoration-none d-block p-2 rounded hover-menu">
                    <i class="fas fa-home me-2"></i> Dashboard
                </a>
            </li>
            <li class="mb-2">
                <a href="<?= BASE_URL; ?>admin/products/list.php" class="text-white text-decoration-none d-block p-2 rounded hover-menu">
                    <i class="fas fa-box me-2"></i> Produk
                </a>
            </li>
            <li class="mb-2">
                <a href="<?= BASE_URL; ?>/admin/orders/list.php" class="text-white text-decoration-none d-block p-2 rounded hover-menu">
                    <i class="fas fa-shopping-bag me-2"></i> Pesanan
                </a>
            </li>
            <li class="mb-2">
                <a href="<?= BASE_URL; ?>/admin/user/list.php" class="text-white text-decoration-none d-block p-2 rounded hover-menu">
                    <i class="fas fa-users me-2"></i> User
                </a>
            </li>
            <li class="mb-2">
                <a href="<?= BASE_URL; ?>/admin/reports/sales.php" class="text-white text-decoration-none d-block p-2 rounded hover-menu">
                    <i class="fas fa-chart-bar me-2"></i> Laporan
                </a>
            </li>
            <li class="mb-2">
                <a href="<?= BASE_URL; ?>/admin/settings.php" class="text-white text-decoration-none d-block p-2 rounded hover-menu">
                    <i class="fas fa-cog me-2"></i> Pengaturan
                </a>
            </li>
            
            <li class="mt-5 border-top pt-3">
                <a href="<?= BASE_URL; ?>/backend/auth.php?action=logout" class="text-danger text-decoration-none d-block p-2 rounded hover-menu" onclick="return confirm('Yakin ingin keluar?')">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
            </li>
        </ul>
    </nav>
</div>

<style>
    /* Tambahkan class hover-menu yang tadi kamu buat ke elemen <a> */
    .hover-menu:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #0dcaf0 !important; /* Warna cyan khas Pixel Part */
        transition: 0.3s;
    }
    
    /* Menandai menu yang sedang aktif secara otomatis */
    .hover-menu.active {
        background-color: #0dcaf0;
        color: #000 !important;
        font-weight: bold;
    }
</style>